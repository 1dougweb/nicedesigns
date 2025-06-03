<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\PagarMeService;
use App\Models\Setting;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Console\Command;
use Exception;

class TestPagarMeConnection extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'pagarme:test
                          {--create-test-charge : Criar cobrança de teste}
                          {--invoice-id= : ID da fatura para teste}
                          {--show-config : Mostrar configurações atuais}';

    /**
     * The console command description.
     */
    protected $description = 'Testar conexão e configurações do PagarMe';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧪 Testando integração com PagarMe...');
        $this->newLine();

        if ($this->option('show-config')) {
            $this->showConfiguration();
            return Command::SUCCESS;
        }

        try {
            // Teste básico de conexão
            $this->testBasicConnection();

            // Teste de criação de cobrança (se solicitado)
            if ($this->option('create-test-charge')) {
                $this->testCreateCharge();
            }

            $this->newLine();
            $this->info('✅ Todos os testes passaram com sucesso!');
            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error("❌ Erro durante os testes: {$e->getMessage()}");
            $this->line("   Trace: {$e->getTraceAsString()}");
            return Command::FAILURE;
        }
    }

    /**
     * Testar conexão básica
     */
    private function testBasicConnection(): void
    {
        $this->info('🔌 Testando conexão básica...');

        try {
            $pagarmeService = new PagarMeService();
            $result = $pagarmeService->testConnection();

            if ($result['success']) {
                $this->info("   ✅ Conexão estabelecida");
                $this->line("   📡 API Version: {$result['api_version']}");
            } else {
                $this->error("   ❌ Falha na conexão: {$result['message']}");
            }

        } catch (Exception $e) {
            $this->error("   ❌ Erro na conexão: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Testar criação de cobrança
     */
    private function testCreateCharge(): void
    {
        $this->info('💳 Testando criação de cobrança...');

        $invoiceId = $this->option('invoice-id');
        
        if ($invoiceId) {
            $invoice = Invoice::find($invoiceId);
            if (!$invoice) {
                $this->error("   ❌ Fatura ID {$invoiceId} não encontrada");
                return;
            }
        } else {
            // Buscar uma fatura de teste ou criar uma
            $invoice = $this->getOrCreateTestInvoice();
        }

        $this->line("   📋 Usando fatura: #{$invoice->invoice_number}");
        $this->line("   👤 Cliente: {$invoice->user->full_name}");
        $this->line("   💰 Valor: {$invoice->formatted_total_amount}");

        try {
            $pagarmeService = new PagarMeService();
            
            // Testar criação de PIX
            $this->info('   🔄 Criando PIX de teste...');
            $pixResult = $pagarmeService->createPix($invoice);
            $this->info("   ✅ PIX criado: ID {$pixResult['id']}");

            // Testar criação de boleto
            $this->info('   🔄 Criando boleto de teste...');
            $boletoResult = $pagarmeService->createBoleto($invoice);
            $this->info("   ✅ Boleto criado: ID {$boletoResult['id']}");

            $this->showChargeDetails($invoice);

        } catch (Exception $e) {
            $this->error("   ❌ Erro ao criar cobrança: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Obter ou criar fatura de teste
     */
    private function getOrCreateTestInvoice(): Invoice
    {
        // Buscar fatura de teste existente
        $invoice = Invoice::where('title', 'LIKE', '%TESTE%')
                         ->where('status', 'pendente')
                         ->first();

        if ($invoice) {
            return $invoice;
        }

        // Buscar cliente de teste
        $user = User::where('role', 'client')->first();
        if (!$user) {
            throw new Exception('Nenhum cliente encontrado para teste');
        }

        // Criar fatura de teste
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_number' => 'TESTE-' . now()->format('YmdHis'),
            'title' => 'TESTE - Fatura de Teste PagarMe',
            'description' => 'Fatura criada automaticamente para teste da integração PagarMe',
            'subtotal' => 100.00,
            'discount' => 0,
            'tax_rate' => 0,
            'tax_amount' => 0,
            'total_amount' => 100.00,
            'currency' => 'BRL',
            'status' => 'pendente',
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'payment_instructions' => 'Fatura de teste - NÃO PAGAR',
        ]);

        $this->warn("   ⚠️  Fatura de teste criada automaticamente");

        return $invoice;
    }

    /**
     * Mostrar detalhes da cobrança criada
     */
    private function showChargeDetails(Invoice $invoice): void
    {
        $this->newLine();
        $this->info('📊 Detalhes da cobrança criada:');

        if ($invoice->pix_code) {
            $this->line("   📱 PIX Code: {$invoice->pix_code}");
        }

        if ($invoice->boleto_url) {
            $this->line("   🏛️  Boleto URL: {$invoice->boleto_url}");
        }

        if ($invoice->pagarme_status) {
            $this->line("   📈 Status PagarMe: {$invoice->pagarme_status}");
        }
    }

    /**
     * Mostrar configurações atuais
     */
    private function showConfiguration(): void
    {
        $this->info('⚙️  Configurações PagarMe Atuais:');
        $this->newLine();

        $configs = [
            'API Key' => Setting::get('pagarme_api_key') ? 'Configurada (oculta)' : 'NÃO CONFIGURADA',
            'Encryption Key' => Setting::get('pagarme_encryption_key') ? 'Configurada (oculta)' : 'NÃO CONFIGURADA',
            'Webhook Secret' => Setting::get('pagarme_webhook_secret') ? 'Configurado (oculto)' : 'Não configurado',
            'Environment' => Setting::get('pagarme_environment', 'sandbox'),
        ];

        foreach ($configs as $key => $value) {
            $status = str_contains($value, 'NÃO') ? '❌' : '✅';
            $this->line("   {$status} {$key}: {$value}");
        }

        $this->newLine();
        $this->info('📊 Estatísticas do Sistema:');

        $stats = [
            'Total de faturas' => Invoice::count(),
            'Faturas com PagarMe' => Invoice::withPagarMeCharge()->count(),
            'Clientes cadastrados' => User::where('role', 'client')->count(),
        ];

        foreach ($stats as $key => $value) {
            $this->line("   📈 {$key}: {$value}");
        }

        $this->newLine();
        $this->info('🔗 URLs importantes:');
        $this->line('   • Webhook URL: ' . route('pagarme.webhook'));
        $this->line('   • Test Webhook URL: ' . route('pagarme.webhook.test'));
    }
} 