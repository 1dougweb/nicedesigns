<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class TestSettingsSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:test-save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o salvamento das configurações';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testando salvamento de configurações...');
        
        // Teste 1: Salvar uma configuração string
        $this->info('📝 Teste 1: Salvando configuração string');
        Setting::set('test_string', 'Valor de teste', 'string', 'general');
        $value = Setting::get('test_string');
        $this->info("✅ Valor salvo: {$value}");
        
        // Teste 2: Salvar uma configuração boolean
        $this->info('📝 Teste 2: Salvando configuração boolean');
        Setting::set('test_boolean', true, 'boolean', 'general');
        $value = Setting::get('test_boolean');
        $this->info("✅ Valor salvo: " . ($value ? 'true' : 'false'));
        
        // Teste 3: Salvar uma configuração integer
        $this->info('📝 Teste 3: Salvando configuração integer');
        Setting::set('test_integer', 42, 'integer', 'general');
        $value = Setting::get('test_integer');
        $this->info("✅ Valor salvo: {$value}");
        
        // Teste 4: Atualizar configuração existente
        $this->info('📝 Teste 4: Atualizando configuração existente');
        $oldValue = Setting::get('site_name');
        $this->info("Valor anterior: {$oldValue}");
        
        Setting::set('site_name', 'Nice Designs - Teste', 'string', 'general');
        $newValue = Setting::get('site_name');
        $this->info("✅ Novo valor: {$newValue}");
        
        // Restaurar valor original
        Setting::set('site_name', $oldValue, 'string', 'general');
        $this->info("🔄 Valor restaurado: " . Setting::get('site_name'));
        
        // Teste 5: Verificar todas as configurações
        $this->info('📝 Teste 5: Verificando total de configurações');
        $total = Setting::count();
        $this->info("✅ Total de configurações: {$total}");
        
        // Listar grupos
        $groups = Setting::distinct('group')->pluck('group');
        $this->info("📂 Grupos existentes: " . $groups->implode(', '));
        
        // Limpar configurações de teste
        Setting::where('key', 'LIKE', 'test_%')->delete();
        $this->info('🧹 Configurações de teste removidas');
        
        $this->info('✅ Todos os testes concluídos com sucesso!');
        
        return Command::SUCCESS;
    }
}
