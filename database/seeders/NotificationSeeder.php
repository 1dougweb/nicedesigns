<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar usuário admin para criar notificações
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $this->command->warn('Nenhum usuário admin encontrado. Criando notificações para o primeiro usuário.');
            $admin = User::first();
        }

        if (!$admin) {
            $this->command->error('Nenhum usuário encontrado. Execute o seeder de usuários primeiro.');
            return;
        }

        $notifications = [
            [
                'user_id' => $admin->id,
                'title' => 'Bem-vindo ao sistema!',
                'message' => 'Seu perfil administrativo foi configurado com sucesso. Complete suas informações de perfil para uma melhor experiência.',
                'type' => Notification::TYPE_SUCCESS,
                'url' => route('admin.profile.index'),
                'created_at' => now()->subDays(2),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Novo contato recebido',
                'message' => 'João Silva enviou uma mensagem através do formulário de contato do site.',
                'type' => Notification::TYPE_NEW_CONTACT,
                'url' => route('admin.contacts.index'),
                'created_at' => now()->subHours(6),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Sistema atualizado',
                'message' => 'O sistema foi atualizado com sucesso para a versão mais recente. Confira as novas funcionalidades.',
                'type' => Notification::TYPE_INFO,
                'created_at' => now()->subHours(12),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Projeto aprovado',
                'message' => 'O projeto "Website Corporativo" foi aprovado pelo cliente e está pronto para desenvolvimento.',
                'type' => Notification::TYPE_NEW_PROJECT,
                'url' => route('admin.projects.index'),
                'created_at' => now()->subHours(18),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Fatura paga',
                'message' => 'A fatura #001 no valor de R$ 2.500,00 foi paga com sucesso pelo cliente.',
                'type' => Notification::TYPE_INVOICE_PAID,
                'url' => route('admin.invoices.index'),
                'read_at' => now()->subHours(2),
                'created_at' => now()->subDay(),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Ticket de suporte aberto',
                'message' => 'Novo ticket de suporte criado: "Problema com login no sistema".',
                'type' => Notification::TYPE_SUPPORT_TICKET,
                'url' => route('admin.support-tickets.index'),
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Backup realizado',
                'message' => 'Backup automático do sistema foi realizado com sucesso. Todos os dados estão seguros.',
                'type' => Notification::TYPE_SUCCESS,
                'read_at' => now()->subHours(1),
                'created_at' => now()->subDays(1),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Nova mensagem de contato',
                'message' => 'Maria Santos enviou uma solicitação de orçamento para desenvolvimento de e-commerce.',
                'type' => Notification::TYPE_NEW_CONTACT,
                'url' => route('admin.contacts.index'),
                'created_at' => now()->subMinutes(30),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Configuração recomendada',
                'message' => 'Recomendamos configurar as chaves da API do Pagar.me para processar pagamentos.',
                'type' => Notification::TYPE_WARNING,
                'url' => route('admin.settings.index'),
                'created_at' => now()->subMinutes(45),
            ],
            [
                'user_id' => $admin->id,
                'title' => 'Cliente ativo',
                'message' => 'Cliente Tech Solutions está ativo no sistema e pode acessar seus projetos.',
                'type' => Notification::TYPE_INFO,
                'read_at' => now()->subMinutes(20),
                'created_at' => now()->subHours(3),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        $this->command->info('Notificações criadas com sucesso!');
        $this->command->info('Total: ' . count($notifications) . ' notificações');
        $this->command->info('Não lidas: ' . collect($notifications)->whereNull('read_at')->count());
    }
}
