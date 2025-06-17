<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\AbacatePayService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AbacatePayWebhookController extends Controller
{
    public function __construct(
        private AbacatePayService $abacatePayService
    ) {}

    /**
     * Processar webhook do AbacatePay
     */
    public function handle(Request $request): Response
    {
        try {
            $payload = $request->all();
            Log::info('Webhook AbacatePay recebido', $payload);

            // Validar assinatura do webhook
            if (!$this->validateWebhookSignature($request)) {
                Log::warning('Assinatura do webhook inválida');
                return response('Assinatura inválida', 401);
            }

            $billingId = $payload['id'] ?? null;
            $status = $payload['status'] ?? null;

            if (!$billingId || !$status) {
                Log::warning('Webhook sem dados essenciais', $payload);
                return response('Dados inválidos', 400);
            }

            // Encontrar fatura pelo billing_id
            $invoice = Invoice::where('abacatepay_billing_id', $billingId)->first();

            if (!$invoice) {
                Log::warning('Fatura não encontrada para billing_id', ['billing_id' => $billingId]);
                return response('Fatura não encontrada', 404);
            }

            // Atualizar status da fatura
            $invoice->update([
                'abacatepay_status' => $status,
                'abacatepay_data' => json_encode($payload)
            ]);

            // Se foi pago, marcar fatura como paga
            if (in_array($status, ['paid', 'completed'])) {
                $invoice->markAsPaid(
                    $this->mapPaymentMethod($payload['payment_method'] ?? 'unknown'),
                    $payload['transaction_id'] ?? $billingId
                );

                Log::info('Fatura marcada como paga via webhook', [
                    'invoice_id' => $invoice->id,
                    'billing_id' => $billingId
                ]);
            }

            return response('Webhook processado com sucesso');

        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook AbacatePay', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response('Erro interno', 500);
        }
    }

    /**
     * Validar assinatura do webhook
     */
    private function validateWebhookSignature(Request $request): bool
    {
        $signature = $request->header('X-AbacatePay-Signature');
        $payload = $request->getContent();
        $secret = config('abacatepay.webhook_secret');

        if (!$signature || !$secret) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Mapear método de pagamento do AbacatePay
     */
    private function mapPaymentMethod(string $method): string
    {
        return match($method) {
            'pix' => 'pix',
            'bank_slip', 'boleto' => 'boleto',
            'credit_card' => 'cartao_credito',
            'debit_card' => 'cartao_debito',
            default => 'outro'
        };
    }
} 