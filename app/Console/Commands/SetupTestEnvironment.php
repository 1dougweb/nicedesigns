<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Exception;

class SetupTestEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:setup
                          {--fresh : Executar fresh migrations (apaga todos os dados)}
                          {--seed-only : Apenas executar seeders (não migrar)}
                          {--with-pagarme : Configurar com dados PagarMe de teste}';

    /**
     * The console command description.
     */
    protected $description = 'Configurar ambiente completo de teste com dados realistas';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧪 Configurando Ambiente de Teste - Nice Designs');
        $this->newLine();

        try {
            // Verificar confirmação para fresh
            if ($this->option('fresh') && !$this->confirmFreshSetup()) {
                $this->warn('Operação cancelada pelo usuário.');
                return Command::FAILURE;
            }

            // Executar migrations
            if (!$this->option('seed-only')) {
                $this->runMigrations();
            }

            // Executar seeders
            $this->runSeeders();

            // Configurar queue para testes
            $this->setupQueueTesting();

            // Configurar cache
            $this->setupCache();

            // Configurar PagarMe se solicitado
            if ($this->option('with-pagarme')) {
                $this->setupPagarMeTestKeys();
            }

            // Mostrar resumo
            $this->showTestSummary();

            $this->newLine();
            $this->info('✅ Ambiente de teste configurado com sucesso!');
            
            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error("❌ Erro durante a configuração: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    /**
     * Confirmar fresh setup
     */
    private function confirmFreshSetup(): bool
    {
        $this->warn('⚠️  ATENÇÃO: Isso irá apagar TODOS os dados existentes!');
        $this->line('   • Todas as tabelas serão recriadas');
        $this->line('   • Todos os dados atuais serão perdidos');
        $this->line('   • Esta operação é IRREVERSÍVEL');
        $this->newLine();

        return $this->confirm('Tem certeza de que deseja continuar?', false);
    }

    /**
     * Executar migrations
     */
    private function runMigrations(): void
    {
        $this->info('🗄️  Configurando banco de dados...');

        if ($this->option('fresh')) {
            $this->line('   Executando fresh migrations...');
            Artisan::call('migrate:fresh', ['--force' => true]);
        } else {
            $this->line('   Executando migrations...');
            Artisan::call('migrate', ['--force' => true]);
        }

        $this->info('   ✅ Banco de dados configurado');
    }

    /**
     * Executar seeders
     */
    private function runSeeders(): void
    {
        $this->info('🌱 Populando banco com dados de teste...');

        // Seeder básico
        $this->line('   Executando seeder principal...');
        Artisan::call('db:seed', [
            '--class' => 'DatabaseSeeder',
            '--force' => true
        ]);

        // Seeder de teste
        $this->line('   Executando seeder de teste...');
        Artisan::call('db:seed', [
            '--class' => 'TestDataSeeder',
            '--force' => true
        ]);

        $this->info('   ✅ Dados de teste criados');
    }

    /**
     * Configurar queue para testes
     */
    private function setupQueueTesting(): void
    {
        $this->info('⚡ Configurando sistema de filas...');

        // Limpar jobs pendentes
        try {
            Artisan::call('queue:clear');
            $this->line('   Filas limpas');
        } catch (Exception $e) {
            $this->line('   Aviso: Não foi possível limpar as filas');
        }

        // Criar tabela de jobs se não existir
        try {
            if (!DB::getSchemaBuilder()->hasTable('jobs')) {
                Artisan::call('queue:table');
                Artisan::call('migrate', ['--force' => true]);
                $this->line('   Tabela de jobs criada');
            }
        } catch (Exception $e) {
            $this->line('   Aviso: Erro ao configurar tabela de jobs');
        }

        $this->info('   ✅ Sistema de filas configurado');
    }

    /**
     * Configurar cache
     */
    private function setupCache(): void
    {
        $this->info('💾 Configurando cache...');

        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        $this->info('   ✅ Cache limpo e configurado');
    }

    /**
     * Configurar chaves de teste do PagarMe
     */
    private function setupPagarMeTestKeys(): void
    {
        $this->info('🔐 Configurando PagarMe para testes...');

        $this->line('   Para usar o PagarMe, você precisará:');
        $this->line('   1. Criar uma conta no PagarMe Dashboard');
        $this->line('   2. Obter as chaves de teste (sandbox)');
        $this->line('   3. Configurar webhook URL');
        $this->newLine();

        if ($this->confirm('Deseja configurar as chaves do PagarMe agora?')) {
            $apiKey = $this->ask('API Key de teste (ak_test_...)');
            $encryptionKey = $this->ask('Encryption Key de teste (ek_test_...)');
            $webhookSecret = $this->ask('Webhook Secret (opcional)', 'test_secret');

            if ($apiKey && $encryptionKey) {
                // Atualizar .env
                $this->updateEnvFile([
                    'PAGARME_API_KEY' => $apiKey,
                    'PAGARME_ENCRYPTION_KEY' => $encryptionKey,
                    'PAGARME_WEBHOOK_SECRET' => $webhookSecret,
                    'PAGARME_ENVIRONMENT' => 'sandbox'
                ]);

                $this->info('   ✅ Chaves PagarMe configuradas no .env');
                
                // Testar conexão
                $this->line('   Testando conexão...');
                Artisan::call('pagarme:test');
                $this->line(Artisan::output());
            }
        }

        $this->info('   📋 URLs importantes:');
        $this->line('      • Webhook URL: ' . url('/pagarme/webhook'));
        $this->line('      • Test URL: ' . url('/pagarme/webhook/test'));
    }

    /**
     * Atualizar arquivo .env
     */
    private function updateEnvFile(array $values): void
    {
        $envFile = base_path('.env');
        
        if (!file_exists($envFile)) {
            $this->warn('   Arquivo .env não encontrado');
            return;
        }

        $content = file_get_contents($envFile);

        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*$/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $replacement, $content);
            } else {
                $content .= "\n{$replacement}";
            }
        }

        file_put_contents($envFile, $content);
    }

    /**
     * Mostrar resumo do teste
     */
    private function showTestSummary(): void
    {
        $this->newLine();
        $this->info('📊 RESUMO DO AMBIENTE DE TESTE:');
        
        try {
            $userCount = DB::table('users')->count();
            $clientCount = DB::table('users')->where('role', 'client')->count();
            $projectCount = DB::table('client_projects')->count();
            $invoiceCount = DB::table('invoices')->count();
            $pendingInvoices = DB::table('invoices')->where('status', 'pendente')->count();

            $this->line("   👥 Usuários criados: {$userCount}");
            $this->line("   🏢 Clientes: {$clientCount}");
            $this->line("   📋 Projetos: {$projectCount}");
            $this->line("   💰 Faturas: {$invoiceCount}");
            $this->line("   ⏳ Faturas pendentes: {$pendingInvoices}");
            
        } catch (Exception $e) {
            $this->line('   Não foi possível obter estatísticas');
        }

        $this->newLine();
        $this->info('🚀 PRÓXIMOS PASSOS:');
        $this->line('   1. Acesse: ' . url('/admin'));
        $this->line('   2. Login: admin@nicedesigns.com.br / password');
        $this->line('   3. Configure as chaves reais do PagarMe');
        $this->line('   4. Execute: php artisan queue:work');
        $this->line('   5. Teste: php artisan pagarme:test');
        $this->newLine();
        $this->line('💡 Para testar faturas automáticas:');
        $this->line('   php artisan invoices:process-auto');
    }
} 