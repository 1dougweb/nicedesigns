<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use PagarMe\Client;
use Exception;

class PagarMeService
{
    private Client $client;
    private string $apiKey;
    private string $encryptionKey;

    public function __construct()
    {
        $this->apiKey = Setting::get('pagarme_api_key', config('services.pagarme.api_key'));
        $this->encryptionKey = Setting::get('pagarme_encryption_key', config('services.pagarme.encryption_key'));
        
        if (!$this->apiKey) {
            throw new Exception('PagarMe API Key não configurada');
        }

        $this->client = new Client($this->apiKey);
    }

    /**
     * Criar cobrança para uma fatura
     */
    public function createCharge(Invoice $invoice, array $paymentMethods = ['boleto', 'pix']): array
    {
        try {
            $customer = $this->createOrUpdateCustomer($invoice->user);
            
            $chargeData = [
                'amount' => (int) ($invoice->total_amount * 100), // Converter para centavos
                'customer' => [
                    'id' => $customer['id']
                ],
                'payment_method' => 'multi_payment_method',
                'payment_method_data' => $this->buildPaymentMethodData($paymentMethods, $invoice),
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'system' => 'nicedesigns'
                ],
                'due_date' => $invoice->due_date->format('Y-m-d'),
                'instructions' => $invoice->payment_instructions ?? 'Fatura Nice Designs - ' . $invoice->title,
                'postback_url' => route('pagarme.webhook'),
            ];

            $charge = $this->client->charges()->create($chargeData);

            // Salvar dados da cobrança na fatura
            $invoice->update([
                'pagarme_charge_id' => $charge['id'],
                'pagarme_status' => $charge['status'],
                'pagarme_data' => $charge,
                'payment_url' => $charge['checkout_url'] ?? null,
                'boleto_url' => $this->extractBoletoUrl($charge),
                'pix_qr_code' => $this->extractPixQrCode($charge),
                'pix_code' => $this->extractPixCode($charge),
            ]);

            Log::info('Cobrança PagarMe criada', [
                'invoice_id' => $invoice->id,
                'charge_id' => $charge['id'],
                'amount' => $charge['amount']
            ]);

            return $charge;

        } catch (Exception $e) {
            Log::error('Erro ao criar cobrança PagarMe', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Criar apenas boleto
     */
    public function createBoleto(Invoice $invoice): array
    {
        try {
            $customer = $this->createOrUpdateCustomer($invoice->user);
            
            $boletoData = [
                'amount' => (int) ($invoice->total_amount * 100),
                'payment_method' => 'boleto',
                'customer' => [
                    'id' => $customer['id']
                ],
                'boleto_instructions' => $invoice->payment_instructions ?? 'Fatura Nice Designs - ' . $invoice->title,
                'boleto_due_date' => $invoice->due_date->format('Y-m-d'),
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'payment_type' => 'boleto'
                ],
                'postback_url' => route('pagarme.webhook'),
            ];

            $transaction = $this->client->transactions()->create($boletoData);

            $invoice->update([
                'pagarme_transaction_id' => $transaction['id'],
                'pagarme_status' => $transaction['status'],
                'boleto_url' => $transaction['boleto_url'],
                'boleto_barcode' => $transaction['boleto_barcode'],
                'pagarme_data' => $transaction,
            ]);

            return $transaction;

        } catch (Exception $e) {
            Log::error('Erro ao criar boleto PagarMe', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Criar PIX
     */
    public function createPix(Invoice $invoice): array
    {
        try {
            $customer = $this->createOrUpdateCustomer($invoice->user);
            
            $pixData = [
                'amount' => (int) ($invoice->total_amount * 100),
                'payment_method' => 'pix',
                'customer' => [
                    'id' => $customer['id']
                ],
                'pix_expiration_date' => $invoice->due_date->format('Y-m-d\TH:i:s'),
                'metadata' => [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'payment_type' => 'pix'
                ],
                'postback_url' => route('pagarme.webhook'),
            ];

            $transaction = $this->client->transactions()->create($pixData);

            $invoice->update([
                'pagarme_transaction_id' => $transaction['id'],
                'pagarme_status' => $transaction['status'],
                'pix_qr_code' => $transaction['pix_qr_code'],
                'pix_code' => $transaction['pix_code'],
                'pagarme_data' => $transaction,
            ]);

            return $transaction;

        } catch (Exception $e) {
            Log::error('Erro ao criar PIX PagarMe', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Criar ou atualizar cliente no PagarMe
     */
    private function createOrUpdateCustomer($user): array
    {
        $cacheKey = "pagarme_customer_{$user->id}";
        
        return Cache::remember($cacheKey, 3600, function () use ($user) {
            try {
                // Buscar cliente existente
                $customers = $this->client->customers()->getList([
                    'email' => $user->email
                ]);

                if (!empty($customers['data'])) {
                    return $customers['data'][0];
                }

                // Criar novo cliente
                $customerData = [
                    'external_id' => (string) $user->id,
                    'name' => $user->full_name,
                    'type' => $user->person_type === 'juridica' ? 'corporation' : 'individual',
                    'country' => 'br',
                    'email' => $user->email,
                    'documents' => [
                        [
                            'type' => $user->person_type === 'juridica' ? 'cnpj' : 'cpf',
                            'number' => preg_replace('/\D/', '', $user->document)
                        ]
                    ],
                    'phone_numbers' => [
                        '+55' . preg_replace('/\D/', '', $user->phone)
                    ],
                ];

                // Adicionar endereço se disponível
                if ($user->address) {
                    $customerData['address'] = [
                        'country' => 'br',
                        'state' => $user->state,
                        'city' => $user->city,
                        'neighborhood' => $user->neighborhood,
                        'street' => $user->address,
                        'street_number' => $user->address_number ?? 'S/N',
                        'zipcode' => preg_replace('/\D/', '', $user->postal_code)
                    ];
                }

                return $this->client->customers()->create($customerData);

            } catch (Exception $e) {
                Log::error('Erro ao criar/buscar cliente PagarMe', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);

                // Retornar estrutura mínima para não quebrar o fluxo
                return [
                    'id' => null,
                    'external_id' => (string) $user->id,
                    'name' => $user->full_name,
                    'email' => $user->email
                ];
            }
        });
    }

    /**
     * Construir dados dos métodos de pagamento
     */
    private function buildPaymentMethodData(array $methods, Invoice $invoice): array
    {
        $data = [];

        if (in_array('boleto', $methods)) {
            $data['boleto'] = [
                'due_date' => $invoice->due_date->format('Y-m-d'),
                'instructions' => $invoice->payment_instructions ?? 'Fatura Nice Designs - ' . $invoice->title,
            ];
        }

        if (in_array('pix', $methods)) {
            $data['pix'] = [
                'expiration_date' => $invoice->due_date->format('Y-m-d\TH:i:s'),
            ];
        }

        if (in_array('credit_card', $methods)) {
            $data['credit_card'] = [
                'installments' => [
                    [
                        'number' => 1,
                        'total' => (int) ($invoice->total_amount * 100)
                    ]
                ]
            ];
        }

        return $data;
    }

    /**
     * Extrair URL do boleto da resposta
     */
    private function extractBoletoUrl(array $charge): ?string
    {
        return $charge['last_transaction']['boleto_url'] ?? 
               $charge['boleto_url'] ?? null;
    }

    /**
     * Extrair QR Code PIX da resposta
     */
    private function extractPixQrCode(array $charge): ?string
    {
        return $charge['last_transaction']['pix_qr_code'] ?? 
               $charge['pix_qr_code'] ?? null;
    }

    /**
     * Extrair código PIX da resposta
     */
    private function extractPixCode(array $charge): ?string
    {
        return $charge['last_transaction']['pix_code'] ?? 
               $charge['pix_code'] ?? null;
    }

    /**
     * Consultar status de uma cobrança
     */
    public function getChargeStatus(string $chargeId): array
    {
        try {
            return $this->client->charges()->get($chargeId);
        } catch (Exception $e) {
            Log::error('Erro ao consultar status da cobrança', [
                'charge_id' => $chargeId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Cancelar cobrança
     */
    public function cancelCharge(string $chargeId): array
    {
        try {
            return $this->client->charges()->cancel($chargeId);
        } catch (Exception $e) {
            Log::error('Erro ao cancelar cobrança', [
                'charge_id' => $chargeId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Processar webhook do PagarMe
     */
    public function processWebhook(array $payload): bool
    {
        try {
            $chargeId = $payload['id'] ?? null;
            $status = $payload['status'] ?? null;
            $metadata = $payload['metadata'] ?? [];

            if (!$chargeId || !$status) {
                Log::warning('Webhook PagarMe com dados incompletos', $payload);
                return false;
            }

            // Buscar fatura relacionada
            $invoiceId = $metadata['invoice_id'] ?? null;
            if (!$invoiceId) {
                Log::warning('Webhook PagarMe sem invoice_id', $payload);
                return false;
            }

            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                Log::warning('Fatura não encontrada para webhook', ['invoice_id' => $invoiceId]);
                return false;
            }

            // Atualizar status da fatura
            $oldStatus = $invoice->status;
            $newStatus = $this->mapPagarMeStatusToInvoiceStatus($status);

            $invoice->update([
                'pagarme_status' => $status,
                'status' => $newStatus,
                'pagarme_data' => $payload,
            ]);

            // Se foi pago, marcar como pago
            if ($status === 'paid') {
                $invoice->markAsPaid(
                    $this->mapPagarMePaymentMethod($payload),
                    $chargeId
                );
            }

            Log::info('Webhook PagarMe processado', [
                'invoice_id' => $invoiceId,
                'charge_id' => $chargeId,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'pagarme_status' => $status
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('Erro ao processar webhook PagarMe', [
                'payload' => $payload,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return false;
        }
    }

    /**
     * Mapear status do PagarMe para status da fatura
     */
    private function mapPagarMeStatusToInvoiceStatus(string $pagarmeStatus): string
    {
        return match($pagarmeStatus) {
            'paid' => 'paga',
            'pending', 'processing', 'waiting_payment' => 'pendente',
            'canceled', 'failed' => 'cancelada',
            'refunded' => 'cancelada',
            default => 'pendente'
        };
    }

    /**
     * Mapear método de pagamento do PagarMe
     */
    private function mapPagarMePaymentMethod(array $payload): string
    {
        $paymentMethod = $payload['payment_method'] ?? 
                        $payload['last_transaction']['payment_method'] ?? 'outro';

        return match($paymentMethod) {
            'boleto' => 'boleto',
            'pix' => 'pix',
            'credit_card' => 'cartao',
            default => 'outro'
        };
    }

    /**
     * Testar conexão com PagarMe
     */
    public function testConnection(): array
    {
        try {
            $customers = $this->client->customers()->getList(['count' => 1]);
            
            return [
                'success' => true,
                'message' => 'Conexão com PagarMe estabelecida com sucesso',
                'api_version' => $customers['meta']['api_version'] ?? 'N/A'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erro na conexão: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }
} 