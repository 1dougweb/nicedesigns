<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\PagarMeService;
use App\Mail\InvoicePaymentGenerated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class ProcessInvoicePayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60; // 1 minuto entre tentativas

    private Invoice $invoice;
    private array $paymentMethods;
    private bool $sendEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(Invoice $invoice, array $paymentMethods = ['boleto', 'pix'], bool $sendEmail = true)
    {
        $this->invoice = $invoice;
        $this->paymentMethods = $paymentMethods;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Iniciando processamento automático de fatura', [
                'invoice_id' => $this->invoice->id,
                'invoice_number' => $this->invoice->invoice_number,
                'payment_methods' => $this->paymentMethods
            ]);

            // Verificar se fatura ainda é válida para processamento
            if (!$this->isInvoiceValidForProcessing()) {
                Log::warning('Fatura não é válida para processamento', [
                    'invoice_id' => $this->invoice->id,
                    'status' => $this->invoice->status,
                    'has_charge' => $this->invoice->hasPagarMeCharge()
                ]);
                return;
            }

            $pagarmeService = new PagarMeService();

            // Processar métodos de pagamento específicos
            if (count($this->paymentMethods) === 1) {
                $this->processSinglePaymentMethod($pagarmeService);
            } else {
                $this->processMultiplePaymentMethods($pagarmeService);
            }

            // Enviar email com informações de pagamento
            if ($this->sendEmail) {
                $this->sendPaymentEmail();
            }

            Log::info('Processamento de fatura concluído com sucesso', [
                'invoice_id' => $this->invoice->id,
                'has_boleto' => $this->invoice->hasBoleto(),
                'has_pix' => $this->invoice->hasPix()
            ]);

        } catch (Exception $e) {
            Log::error('Erro no processamento automático de fatura', [
                'invoice_id' => $this->invoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Verificar se fatura é válida para processamento
     */
    private function isInvoiceValidForProcessing(): bool
    {
        // Recarregar fatura do banco para garantir dados atualizados
        $this->invoice->refresh();

        return $this->invoice->status === 'pendente' && 
               !$this->invoice->hasPagarMeCharge() &&
               $this->invoice->user &&
               $this->invoice->total_amount > 0;
    }

    /**
     * Processar um único método de pagamento
     */
    private function processSinglePaymentMethod(PagarMeService $pagarmeService): void
    {
        $method = $this->paymentMethods[0];

        switch ($method) {
            case 'boleto':
                $result = $pagarmeService->createBoleto($this->invoice);
                break;

            case 'pix':
                $result = $pagarmeService->createPix($this->invoice);
                break;

            case 'both':
            default:
                $result = $pagarmeService->createCharge($this->invoice, ['boleto', 'pix']);
                break;
        }

        Log::info('Método de pagamento criado', [
            'invoice_id' => $this->invoice->id,
            'method' => $method,
            'transaction_id' => $result['id'] ?? 'N/A'
        ]);
    }

    /**
     * Processar múltiplos métodos de pagamento
     */
    private function processMultiplePaymentMethods(PagarMeService $pagarmeService): void
    {
        $result = $pagarmeService->createCharge($this->invoice, $this->paymentMethods);

        Log::info('Múltiplos métodos de pagamento criados', [
            'invoice_id' => $this->invoice->id,
            'methods' => $this->paymentMethods,
            'charge_id' => $result['id'] ?? 'N/A'
        ]);
    }

    /**
     * Enviar email com informações de pagamento
     */
    private function sendPaymentEmail(): void
    {
        try {
            // Recarregar fatura com dados atualizados
            $this->invoice->refresh();
            
            if ($this->invoice->user && $this->invoice->user->email) {
                Mail::to($this->invoice->user->email)
                    ->send(new InvoicePaymentGenerated($this->invoice));

                Log::info('Email de pagamento enviado', [
                    'invoice_id' => $this->invoice->id,
                    'recipient' => $this->invoice->user->email
                ]);
            }

        } catch (Exception $e) {
            Log::error('Erro ao enviar email de pagamento', [
                'invoice_id' => $this->invoice->id,
                'error' => $e->getMessage()
            ]);

            // Não falhar o job por causa do email
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        Log::error('Job de processamento de fatura falhou', [
            'invoice_id' => $this->invoice->id,
            'attempts' => $this->attempts(),
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);

        // Marcar fatura com erro se todas as tentativas falharam
        if ($this->attempts() >= $this->tries) {
            $this->invoice->update([
                'notes' => ($this->invoice->notes ?? '') . "\n\nErro no processamento automático: " . $exception->getMessage(),
                'auto_charge_enabled' => false
            ]);
        }
    }
} 