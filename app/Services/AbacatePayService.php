<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AbacatePayService
{
    private string $baseUrl;
    private string $token;
    private string $environment;

    public function __construct()
    {
        $this->token = config('abacatepay.token');
        $this->environment = config('abacatepay.environment');
        $this->baseUrl = config('abacatepay.urls.' . $this->environment);
    }

    /**
     * Criar ou atualizar cliente no AbacatePay
     */
    public function createOrUpdateCustomer(User $user): array
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->baseUrl}/customers", [
                    'name' => $user->name,
                    'email' => $user->email,
                    'document' => $user->document,
                    'phone' => $user->phone,
                    'address' => [
                        'street' => $user->address,
                        'number' => $user->address_number,
                        'complement' => $user->address_complement,
                        'neighborhood' => $user->address_neighborhood,
                        'city' => $user->address_city,
                        'state' => $user->address_state,
                        'zipcode' => $user->address_zipcode,
                    ]
                ]);

            if (!$response->successful()) {
                throw new Exception('Erro ao criar/atualizar cliente: ' . $response->body());
            }

            $data = $response->json();
            
            // Atualizar ID do cliente no usuário
            $user->update([
                'abacatepay_customer_id' => $data['id']
            ]);

            return $data;

        } catch (Exception $e) {
            Log::error('Erro ao criar/atualizar cliente no AbacatePay', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Criar cobrança PIX
     */
    public function createPix(Invoice $invoice): array
    {
        try {
            // Garantir que o cliente existe no AbacatePay
            if (!$invoice->user->abacatepay_customer_id) {
                $this->createOrUpdateCustomer($invoice->user);
            }

            $response = Http::withToken($this->token)
                ->post("{$this->baseUrl}/charges", [
                    'customer_id' => $invoice->user->abacatepay_customer_id,
                    'amount' => $invoice->total * 100, // Converter para centavos
                    'description' => "Fatura #{$invoice->id} - {$invoice->description}",
                    'payment_method' => 'pix',
                    'due_date' => $invoice->due_date->format('Y-m-d'),
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'project_id' => $invoice->project_id
                    ]
                ]);

            if (!$response->successful()) {
                throw new Exception('Erro ao criar cobrança PIX: ' . $response->body());
            }

            $data = $response->json();

            // Atualizar dados da cobrança na fatura
            $invoice->update([
                'abacatepay_billing_id' => $data['id'],
                'abacatepay_status' => 'pending',
                'abacatepay_data' => json_encode($data),
                'pix_qr_code' => $data['pix']['qr_code'],
                'pix_qr_code_url' => $data['pix']['qr_code_url']
            ]);

            return $data;

        } catch (Exception $e) {
            Log::error('Erro ao criar cobrança PIX no AbacatePay', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Criar cobrança Boleto
     */
    public function createBoleto(Invoice $invoice): array
    {
        try {
            // Garantir que o cliente existe no AbacatePay
            if (!$invoice->user->abacatepay_customer_id) {
                $this->createOrUpdateCustomer($invoice->user);
            }

            $response = Http::withToken($this->token)
                ->post("{$this->baseUrl}/charges", [
                    'customer_id' => $invoice->user->abacatepay_customer_id,
                    'amount' => $invoice->total * 100, // Converter para centavos
                    'description' => "Fatura #{$invoice->id} - {$invoice->description}",
                    'payment_method' => 'boleto',
                    'due_date' => $invoice->due_date->format('Y-m-d'),
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'project_id' => $invoice->project_id
                    ]
                ]);

            if (!$response->successful()) {
                throw new Exception('Erro ao criar cobrança Boleto: ' . $response->body());
            }

            $data = $response->json();

            // Atualizar dados da cobrança na fatura
            $invoice->update([
                'abacatepay_billing_id' => $data['id'],
                'abacatepay_status' => 'pending',
                'abacatepay_data' => json_encode($data),
                'boleto_url' => $data['boleto']['url'],
                'boleto_barcode' => $data['boleto']['barcode']
            ]);

            return $data;

        } catch (Exception $e) {
            Log::error('Erro ao criar cobrança Boleto no AbacatePay', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Criar cobrança com múltiplos métodos de pagamento
     */
    public function createCharge(Invoice $invoice): array
    {
        try {
            // Garantir que o cliente existe no AbacatePay
            if (!$invoice->user->abacatepay_customer_id) {
                $this->createOrUpdateCustomer($invoice->user);
            }

            $response = Http::withToken($this->token)
                ->post("{$this->baseUrl}/charges", [
                    'customer_id' => $invoice->user->abacatepay_customer_id,
                    'amount' => $invoice->total * 100, // Converter para centavos
                    'description' => "Fatura #{$invoice->id} - {$invoice->description}",
                    'payment_method' => 'all', // Permite todos os métodos
                    'due_date' => $invoice->due_date->format('Y-m-d'),
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'project_id' => $invoice->project_id
                    ]
                ]);

            if (!$response->successful()) {
                throw new Exception('Erro ao criar cobrança: ' . $response->body());
            }

            $data = $response->json();

            // Atualizar dados da cobrança na fatura
            $invoice->update([
                'abacatepay_billing_id' => $data['id'],
                'abacatepay_status' => 'pending',
                'abacatepay_data' => json_encode($data)
            ]);

            return $data;

        } catch (Exception $e) {
            Log::error('Erro ao criar cobrança no AbacatePay', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Verificar status da cobrança
     */
    public function getChargeStatus(string $billingId): array
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->baseUrl}/charges/{$billingId}");

            if (!$response->successful()) {
                throw new Exception('Erro ao verificar status da cobrança: ' . $response->body());
            }

            $data = $response->json();

            return [
                'status' => $data['status'],
                'data' => $data,
                'paid_at' => $data['paid_at'] ?? null
            ];

        } catch (Exception $e) {
            Log::error('Erro ao verificar status da cobrança no AbacatePay', [
                'billing_id' => $billingId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Cancelar cobrança
     */
    public function cancelCharge(string $billingId): array
    {
        try {
            $response = Http::withToken($this->token)
                ->delete("{$this->baseUrl}/charges/{$billingId}");

            if (!$response->successful()) {
                throw new Exception('Erro ao cancelar cobrança: ' . $response->body());
            }

            return $response->json();

        } catch (Exception $e) {
            Log::error('Erro ao cancelar cobrança no AbacatePay', [
                'billing_id' => $billingId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Testar conexão com o AbacatePay
     */
    public function testConnection(): bool
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->baseUrl}/test-connection");

            return $response->successful();

        } catch (Exception $e) {
            Log::error('Erro ao testar conexão com AbacatePay', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
} 