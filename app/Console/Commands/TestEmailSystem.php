<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\TestEmail;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class TestEmailSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email?} {--config : Mostrar configurações de email atuais}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa o sistema de email SMTP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('config')) {
            $this->showEmailConfig();
            return;
        }

        $email = $this->argument('email');
        
        if (!$email) {
            $this->error('❌ Email é obrigatório quando não usar --config');
            $this->line('Uso: php artisan email:test seuemail@exemplo.com');
            $this->line('Ou: php artisan email:test --config');
            return Command::FAILURE;
        }

        $this->info('🔧 Testando sistema de email...');
        
        try {
            // Atualizar configurações de email
            $this->updateEmailConfig();
            
            // Enviar email de teste
            Mail::to($email)->send(new TestEmail());
            
            $this->info("✅ Email de teste enviado com sucesso para: {$email}");
            $this->line('📧 Verifique sua caixa de entrada (e spam).');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("❌ Erro ao enviar email: " . $e->getMessage());
            $this->line('');
            $this->warn('💡 Dicas para solucionar problemas:');
            $this->line('1. Verifique as configurações SMTP no painel admin');
            $this->line('2. Confirme se o usuário/senha estão corretos');
            $this->line('3. Para Gmail, use uma "senha de app" ao invés da senha normal');
            $this->line('4. Verifique se a porta e criptografia estão corretas');
            
            return Command::FAILURE;
        }
    }

    /**
     * Update email configuration from settings
     */
    private function updateEmailConfig()
    {
        $emailSettings = Setting::where('group', 'email')->get()->keyBy('key');
        
        if ($emailSettings->isNotEmpty()) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings->get('smtp_host')->value ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $emailSettings->get('smtp_port')->value ?? 587,
                'mail.mailers.smtp.username' => $emailSettings->get('smtp_username')->value ?? '',
                'mail.mailers.smtp.password' => $emailSettings->get('smtp_password')->value ?? '',
                'mail.mailers.smtp.encryption' => $emailSettings->get('smtp_encryption')->value ?? 'tls',
                'mail.from.address' => $emailSettings->get('mail_from_address')->value ?? 'noreply@nicedesigns.com.br',
                'mail.from.name' => $emailSettings->get('mail_from_name')->value ?? 'Nice Designs',
            ]);
        }
    }

    /**
     * Show current email configuration
     */
    private function showEmailConfig()
    {
        $this->info('📧 Configurações de Email Atuais:');
        $this->line('');

        $emailSettings = Setting::where('group', 'email')->get()->keyBy('key');
        
        if ($emailSettings->isEmpty()) {
            $this->warn('❌ Nenhuma configuração de email encontrada.');
            $this->line('Execute: php artisan db:seed para criar configurações padrão.');
            return;
        }

        $this->table(['Configuração', 'Valor'], [
            ['Host SMTP', $emailSettings->get('smtp_host')->value ?? 'Não configurado'],
            ['Porta SMTP', $emailSettings->get('smtp_port')->value ?? 'Não configurado'],
            ['Usuário SMTP', $emailSettings->get('smtp_username')->value ? 'Configurado' : 'Não configurado'],
            ['Senha SMTP', $emailSettings->get('smtp_password')->value ? 'Configurado (oculto)' : 'Não configurado'],
            ['Criptografia', $emailSettings->get('smtp_encryption')->value ?? 'Não configurado'],
            ['Email Remetente', $emailSettings->get('mail_from_address')->value ?? 'Não configurado'],
            ['Nome Remetente', $emailSettings->get('mail_from_name')->value ?? 'Não configurado'],
        ]);

        $this->line('');
        $this->info('Para testar: php artisan email:test seuemail@exemplo.com');
    }
}
