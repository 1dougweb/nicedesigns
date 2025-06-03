<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\PagarMeService;
use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class PagarMeWebhookController extends Controller
{
    private PagarMeService $pagarmeService;

    public function __construct(PagarMeService $pagarmeService)
    {
        $this->pagarmeService = $pagarmeService;
    }

    /**
     * Receber webhook do PagarMe
     */
    public function receive(Request $request): JsonResponse
    {
        try {
            Log::info('Webhook PagarMe recebido', [
                'payload' => $request->all(),
                'headers' => $request->headers->all(),
                'ip' => $request->ip()
            ]);

            // Verificar se é uma requisição válida do PagarMe
            if (!$this->isValidPagarMeRequest($request)) {
                Log::warning('Webhook PagarMe rejeitado - IP ou signature inválida', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $payload = $request->all();

            // Verificar se o payload tem os dados necessários
            if (empty($payload['object']) || empty($payload['id'])) {
                Log::warning('Webhook PagarMe com payload incompleto', $payload);
                return response()->json(['error' => 'Invalid payload'], 400);
            }

            // Processar diferentes tipos de eventos
            $eventType = $payload['object'] ?? 'unknown';
            $processed = false;

            switch ($eventType) {
                case 'transaction':
                    $processed = $this->processTransactionWebhook($payload);
                    break;

                case 'charge':
                    $processed = $this->processChargeWebhook($payload);
                    break;

                case 'subscription':
                    $processed = $this->processSubscriptionWebhook($payload);
                    break;

                default:
                    Log::info('Tipo de webhook PagarMe não tratado', [
                        'object' => $eventType,
                        'id' => $payload['id'] ?? 'N/A'
                    ]);
                    break;
            }

            if ($processed) {
                return response()->json(['status' => 'processed']);
            } else {
                return response()->json(['status' => 'ignored']);
            }

        } catch (Exception $e) {
            Log::error('Erro ao processar webhook PagarMe', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            return response()->json(['error' => 'Internal error'], 500);
        }
    }

    /**
     * Processar webhook de transação
     */
    private function processTransactionWebhook(array $payload): bool
    {
        try {
            $transactionId = $payload['id'];
            $status = $payload['status'] ?? null;
            $metadata = $payload['metadata'] ?? [];

            Log::info('Processando webhook de transação', [
                'transaction_id' => $transactionId,
                'status' => $status,
                'metadata' => $metadata
            ]);

            // Buscar fatura relacionada
            $invoiceId = $metadata['invoice_id'] ?? null;
            if (!$invoiceId) {
                Log::warning('Webhook de transação sem invoice_id', $payload);
                return false;
            }

            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                Log::warning('Fatura não encontrada para webhook de transação', ['invoice_id' => $invoiceId]);
                return false;
            }

            // Atualizar fatura com dados da transação
            $this->updateInvoiceFromTransaction($invoice, $payload);

            return true;

        } catch (Exception $e) {
            Log::error('Erro ao processar webhook de transação', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);

            return false;
        }
    }

    /**
     * Processar webhook de cobrança
     */
    private function processChargeWebhook(array $payload): bool
    {
        try {
            $chargeId = $payload['id'];
            $status = $payload['status'] ?? null;
            $metadata = $payload['metadata'] ?? [];

            Log::info('Processando webhook de cobrança', [
                'charge_id' => $chargeId,
                'status' => $status,
                'metadata' => $metadata
            ]);

            // Usar o serviço PagarMe para processar
            return $this->pagarmeService->processWebhook($payload);

        } catch (Exception $e) {
            Log::error('Erro ao processar webhook de cobrança', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);

            return false;
        }
    }

    /**
     * Processar webhook de assinatura (para futuras implementações)
     */
    private function processSubscriptionWebhook(array $payload): bool
    {
        Log::info('Webhook de assinatura recebido (não implementado)', $payload);
        return true;
    }

    /**
     * Atualizar fatura com dados da transação
     */
    private function updateInvoiceFromTransaction(Invoice $invoice, array $transaction): void
    {
        $status = $transaction['status'] ?? 'processing';
        $paymentMethod = $transaction['payment_method'] ?? 'outro';

        // Mapear status da transação para status da fatura
        $invoiceStatus = $this->mapTransactionStatusToInvoiceStatus($status);

        $updateData = [
            'pagarme_transaction_id' => $transaction['id'],
            'pagarme_status' => $status,
            'pagarme_data' => $transaction,
            'webhook_received_at' => now(),
        ];

        // Adicionar URLs específicas baseadas no método de pagamento
        if ($paymentMethod === 'boleto') {
            $updateData['boleto_url'] = $transaction['boleto_url'] ?? null;
            $updateData['boleto_barcode'] = $transaction['boleto_barcode'] ?? null;
        }

        if ($paymentMethod === 'pix') {
            $updateData['pix_qr_code'] = $transaction['pix_qr_code'] ?? null;
            $updateData['pix_code'] = $transaction['pix_code'] ?? null;
        }

        // Atualizar status se necessário
        if ($invoiceStatus !== $invoice->status) {
            $updateData['status'] = $invoiceStatus;
        }

        $invoice->update($updateData);

        // Se foi pago, marcar como pago
        if ($status === 'paid') {
            $invoice->markAsPaid(
                $this->mapPagarMePaymentMethod($paymentMethod),
                $transaction['id']
            );
        }

        Log::info('Fatura atualizada via webhook', [
            'invoice_id' => $invoice->id,
            'old_status' => $invoice->status,
            'new_status' => $invoiceStatus,
            'pagarme_status' => $status
        ]);
    }

    /**
     * Mapear status da transação para status da fatura
     */
    private function mapTransactionStatusToInvoiceStatus(string $transactionStatus): string
    {
        return match($transactionStatus) {
            'paid' => 'paga',
            'pending', 'processing', 'waiting_payment', 'analyzing' => 'pendente',
            'authorized' => 'pendente',
            'refused', 'chargedback', 'canceled' => 'cancelada',
            'refunded' => 'cancelada',
            default => 'pendente'
        };
    }

    /**
     * Mapear método de pagamento do PagarMe
     */
    private function mapPagarMePaymentMethod(string $paymentMethod): string
    {
        return match($paymentMethod) {
            'boleto' => 'boleto',
            'pix' => 'pix',
            'credit_card' => 'cartao',
            'debit_card' => 'cartao',
            'bank_transfer' => 'transferencia',
            default => 'outro'
        };
    }

    /**
     * Verificar se é uma requisição válida do PagarMe
     */
    private function isValidPagarMeRequest(Request $request): bool
    {
        // Lista de IPs do PagarMe (você deve verificar a documentação atual)
        $pagarmeIPs = [
            '18.229.117.86',
            '18.230.46.115', 
            '18.230.34.20',
            '3.89.124.111',
            '3.80.88.217'
        ];

        $clientIP = $request->ip();

        // Verificar IP (opcional - pode ser removido se houver problemas)
        if (!in_array($clientIP, $pagarmeIPs) && !app()->environment('local')) {
            // Permitir em desenvolvimento local
            return false;
        }

        // Verificar User-Agent (opcional)
        $userAgent = $request->userAgent();
        if ($userAgent && !str_contains(strtolower($userAgent), 'pagarme')) {
            // Log para debugging mas não rejeitar automaticamente
            Log::info('Webhook sem User-Agent PagarMe', [
                'user_agent' => $userAgent,
                'ip' => $clientIP
            ]);
        }

        // Verificar signature (se configurada)
        $webhookSecret = Setting::get('pagarme_webhook_secret');
        if ($webhookSecret) {
            return $this->verifyWebhookSignature($request, $webhookSecret);
        }

        return true;
    }

    /**
     * Verificar assinatura do webhook
     */
    private function verifyWebhookSignature(Request $request, string $secret): bool
    {
        $signature = $request->header('X-Hub-Signature-256');
        if (!$signature) {
            return false;
        }

        $expectedSignature = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);
        
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Endpoint de teste para validar webhook
     */
    public function test(Request $request): JsonResponse
    {
        Log::info('Teste de webhook PagarMe', [
            'payload' => $request->all(),
            'ip' => $request->ip()
        ]);

        return response()->json([
            'status' => 'test_received',
            'timestamp' => now()->toISOString(),
            'ip' => $request->ip()
        ]);
    }
} 