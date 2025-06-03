<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ResetTestEnvironment extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:reset
                          {--quick : Reset rápido (apenas dados, não migrations)}
                          {--confirm : Pular confirmação de segurança}';

    /**
     * The console command description.
     */
    protected $description = 'Resetar ambiente de teste rapidamente';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔄 Resetando Ambiente de Teste...');
        $this->newLine();

        // Verificar confirmação
        if (!$this->option('confirm') && !$this->confirmReset()) {
            $this->warn('Operação cancelada.');
            return Command::FAILURE;
        }

        try {
            if ($this->option('quick')) {
                $this->quickReset();
            } else {
                $this->fullReset();
            }

            $this->newLine();
            $this->info('✅ Ambiente de teste resetado com sucesso!');
            $this->showQuickAccess();

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Erro durante o reset: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    /**
     * Confirmar reset
     */
    private function confirmReset(): bool
    {
        $this->warn('⚠️  Isso irá resetar todos os dados de teste!');
        return $this->confirm('Continuar?', false);
    }

    /**
     * Reset rápido (apenas dados)
     */
    private function quickReset(): void
    {
        $this->info('⚡ Executando reset rápido...');

        // Apenas repovoar dados
        Artisan::call('db:seed', [
            '--class' => 'TestDataSeeder',
            '--force' => true
        ]);

        $this->info('   ✅ Dados de teste atualizados');
    }

    /**
     * Reset completo
     */
    private function fullReset(): void
    {
        $this->info('🔄 Executando reset completo...');

        // Fresh migrations + seeders
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);
        Artisan::call('db:seed', [
            '--class' => 'TestDataSeeder',
            '--force' => true
        ]);

        // Limpar cache
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        $this->info('   ✅ Ambiente completamente resetado');
    }

    /**
     * Mostrar acesso rápido
     */
    private function showQuickAccess(): void
    {
        $this->newLine();
        $this->info('🚀 ACESSO RÁPIDO:');
        $this->line('   Admin: admin@nicedesigns.com.br / password');
        $this->line('   URL: ' . url('/admin'));
        $this->newLine();
        $this->line('📋 Comandos úteis:');
        $this->line('   php artisan pagarme:test');
        $this->line('   php artisan invoices:process-auto');
        $this->line('   php artisan queue:work');
    }
} 