<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Jobs\ProcessInvoicePayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessAutoInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:process-auto
                          {--limit=50 : Limite de faturas a processar por execução}
                          {--methods=boleto,pix : Métodos de pagamento (separados por vírgula)}
                          {--force : Forçar processamento mesmo se já processadas}
                          {--send-email=1 : Enviar email (1 para sim, 0 para não)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processar automaticamente faturas agendadas para cobrança via PagarMe';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Iniciando processamento automático de faturas...');

        $limit = (int) $this->option('limit');
        $methods = explode(',', $this->option('methods'));
        $force = (bool) $this->option('force');
        $sendEmail = (bool) $this->option('send-email');

        $this->info("📋 Configurações:");
        $this->line("   • Limite: {$limit} faturas");
        $this->line("   • Métodos: " . implode(', ', $methods));
        $this->line("   • Forçar: " . ($force ? 'Sim' : 'Não'));
        $this->line("   • Enviar email: " . ($sendEmail ? 'Sim' : 'Não'));
        $this->newLine();

        try {
            // Buscar faturas prontas para processamento automático
            $query = Invoice::autoChargeReady()->with(['user']);

            if (!$force) {
                $query->whereNull('pagarme_charge_id')
                      ->whereNull('pagarme_transaction_id');
            }

            $invoices = $query->limit($limit)->get();

            if ($invoices->isEmpty()) {
                $this->info('✅ Nenhuma fatura encontrada para processamento automático.');
                return Command::SUCCESS;
            }

            $this->info("📊 Encontradas {$invoices->count()} faturas para processamento:");
            $this->newLine();

            $processed = 0;
            $errors = 0;

            foreach ($invoices as $invoice) {
                $this->processInvoice($invoice, $methods, $sendEmail, $processed, $errors);
            }

            $this->newLine();
            $this->info("✅ Processamento concluído!");
            $this->line("   • Processadas: {$processed}");
            $this->line("   • Erros: {$errors}");
            $this->line("   • Total: {$invoices->count()}");

            Log::info('Comando de processamento automático concluído', [
                'total' => $invoices->count(),
                'processed' => $processed,
                'errors' => $errors,
                'methods' => $methods
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Erro durante o processamento: {$e->getMessage()}");
            
            Log::error('Erro no comando de processamento automático', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Command::FAILURE;
        }
    }

    /**
     * Processar uma fatura individual
     */
    private function processInvoice(Invoice $invoice, array $methods, bool $sendEmail, int &$processed, int &$errors): void
    {
        try {
            $this->line("🔄 Processando fatura #{$invoice->invoice_number}...");
            $this->line("   • Cliente: {$invoice->user->full_name}");
            $this->line("   • Valor: {$invoice->formatted_total_amount}");
            $this->line("   • Vencimento: {$invoice->due_date->format('d/m/Y')}");

            // Verificar se cliente tem dados necessários
            if (!$this->validateInvoiceForProcessing($invoice)) {
                $this->warn("   ⚠️  Dados insuficientes para processamento");
                $errors++;
                return;
            }

            // Disparar job para processamento
            ProcessInvoicePayment::dispatch($invoice, $methods, $sendEmail);

            $this->info("   ✅ Job de processamento enviado para fila");
            $processed++;

        } catch (\Exception $e) {
            $this->error("   ❌ Erro: {$e->getMessage()}");
            $errors++;

            Log::error('Erro ao processar fatura individual', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Validar se fatura pode ser processada
     */
    private function validateInvoiceForProcessing(Invoice $invoice): bool
    {
        // Verificar se tem usuário
        if (!$invoice->user) {
            $this->line("   ❌ Fatura sem cliente vinculado");
            return false;
        }

        // Verificar dados básicos do cliente
        $user = $invoice->user;
        $missingData = [];

        if (!$user->full_name) $missingData[] = 'nome';
        if (!$user->email) $missingData[] = 'email';
        if (!$user->document) $missingData[] = 'documento';
        if (!$user->phone) $missingData[] = 'telefone';

        if (!empty($missingData)) {
            $this->line("   ❌ Dados do cliente incompletos: " . implode(', ', $missingData));
            return false;
        }

        // Verificar valor da fatura
        if ($invoice->total_amount <= 0) {
            $this->line("   ❌ Valor da fatura inválido");
            return false;
        }

        return true;
    }

    /**
     * Mostrar estatísticas das faturas
     */
    public function showStats(): void
    {
        $this->info('📊 Estatísticas de Faturas:');

        $stats = [
            'Total de faturas' => Invoice::count(),
            'Faturas pendentes' => Invoice::where('status', 'pendente')->count(),
            'Com cobrança automática' => Invoice::where('auto_charge_enabled', true)->count(),
            'Prontas para processamento' => Invoice::autoChargeReady()->count(),
            'Com PagarMe ativo' => Invoice::withPagarMeCharge()->count(),
        ];

        foreach ($stats as $label => $count) {
            $this->line("   • {$label}: {$count}");
        }

        $this->newLine();
    }
} 