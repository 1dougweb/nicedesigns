<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class CheckExampleCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:example-credentials {--clean : Limpar credenciais de exemplo automaticamente}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar e limpar credenciais de exemplo no sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando credenciais de exemplo no sistema...');
        $this->newLine();

        $examplePatterns = [
            'example',
            'test_example',
            'ak_test_example',
            'ek_test_example',
            'demo',
            'sample',
            'placeholder'
        ];

        $foundExamples = [];
        $settings = Setting::all();

        // Verificar todas as configurações
        foreach ($settings as $setting) {
            foreach ($examplePatterns as $pattern) {
                if (str_contains(strtolower($setting->value), $pattern)) {
                    $foundExamples[] = [
                        'group' => $setting->group,
                        'key' => $setting->key,
                        'value' => $setting->value,
                        'pattern' => $pattern
                    ];
                }
            }
        }

        if (empty($foundExamples)) {
            $this->info('✅ Nenhuma credencial de exemplo encontrada no sistema!');
            return Command::SUCCESS;
        }

        // Mostrar credenciais encontradas
        $this->warn('⚠️  Encontradas ' . count($foundExamples) . ' credenciais de exemplo:');
        $this->newLine();

        $table = [];
        foreach ($foundExamples as $example) {
            $table[] = [
                $example['group'],
                $example['key'],
                $this->maskValue($example['value']),
                $example['pattern']
            ];
        }

        $this->table(['Grupo', 'Chave', 'Valor (mascarado)', 'Padrão'], $table);

        // Verificar se deve limpar automaticamente
        if ($this->option('clean')) {
            return $this->cleanExampleCredentials($foundExamples);
        }

        // Perguntar se quer limpar
        if ($this->confirm('Deseja limpar essas credenciais de exemplo?')) {
            return $this->cleanExampleCredentials($foundExamples);
        }

        $this->newLine();
        $this->warn('💡 Recomendações:');
        $this->line('  • Execute: php artisan check:example-credentials --clean');
        $this->line('  • Configure credenciais reais nas configurações do sistema');
        $this->line('  • Verifique as variáveis de ambiente no arquivo .env');

        return Command::SUCCESS;
    }

    /**
     * Limpar credenciais de exemplo
     */
    private function cleanExampleCredentials(array $examples): int
    {
        $this->info('🧹 Limpando credenciais de exemplo...');
        $this->newLine();

        $cleaned = 0;
        $groups = [];

        foreach ($examples as $example) {
            $setting = Setting::where('group', $example['group'])
                             ->where('key', $example['key'])
                             ->first();

            if ($setting) {
                // Determinar valor de limpeza baseado no tipo
                $cleanValue = $this->getCleanValueForSetting($example['key']);
                
                $setting->update(['value' => $cleanValue]);
                $cleaned++;
                $groups[] = $example['group'];

                $this->line("  ✅ Limpo: {$example['group']}.{$example['key']}");
            }
        }

        $uniqueGroups = array_unique($groups);

        $this->newLine();
        $this->info("🎉 {$cleaned} credenciais de exemplo foram limpas!");
        
        if (!empty($uniqueGroups)) {
            $this->newLine();
            $this->info('📝 Grupos afetados:');
            foreach ($uniqueGroups as $group) {
                $this->line("  • {$group}");
            }
        }

        $this->newLine();
        $this->warn('⚠️  Ação necessária:');
        $this->line('  Configure credenciais reais nas configurações do admin.');

        // Verificar se é ambiente de produção
        if (app()->environment('production')) {
            $this->newLine();
            $this->error('🚨 ATENÇÃO: Você está em PRODUÇÃO!');
            $this->warn('   Configure as credenciais reais imediatamente.');
        }

        return Command::SUCCESS;
    }

    /**
     * Mascarar valor para exibição
     */
    private function maskValue(string $value): string
    {
        if (strlen($value) <= 8) {
            return str_repeat('*', strlen($value));
        }

        return substr($value, 0, 4) . str_repeat('*', strlen($value) - 8) . substr($value, -4);
    }

    /**
     * Obter valor de limpeza apropriado para cada configuração
     */
    private function getCleanValueForSetting(string $key): string
    {
        // Configurações que devem ter valores padrão específicos
        $defaults = [
            'pagarme_environment' => 'sandbox',
            'pagarme_auto_charge_days' => '0',
            'pagarme_default_methods' => 'boleto,pix',
            'pagarme_max_retry_attempts' => '3',
            'pagarme_send_email_on_generation' => '1',
            'pagarme_boleto_instructions' => 'Pagar preferencialmente em bancos digitais para compensação mais rápida.',
        ];

        return $defaults[$key] ?? '';
    }
}
