<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClientProject;
use App\Models\Invoice;
use App\Models\SupportTicket;

class ClientTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pegar ou criar um usuário cliente
        $client = User::where('role', 'client')->first();
        
        if (!$client) {
            $client = User::create([
                'full_name' => 'Douglas Rodrigues',
                'email' => 'cliente@teste.com',
                'email_verified_at' => now(),
                'password' => bcrypt('123456789'),
                'role' => 'client',
                'person_type' => 'fisica',
                'document' => '12345678901',
                'phone' => '11999999999',
                'zip_code' => '01234567',
                'address' => 'Rua Teste',
                'address_number' => '123',
                'neighborhood' => 'Centro',
                'city' => 'São Paulo',
                'state' => 'SP',
            ]);
        }

        // Criar projetos de teste
        $projects = [
            [
                'name' => 'Site Corporativo',
                'description' => 'Desenvolvimento de site institucional moderno',
                'status' => 'em_andamento',
                'priority' => 'alta',
                'progress_percentage' => 75,
                'budget' => 5000.00,
                'deadline' => now()->addDays(30),
                'last_update' => 'Finalizada a estrutura do frontend',
                'last_activity_at' => now()->subHours(2),
                'technologies' => ['Laravel', 'Vue.js', 'TailwindCSS'],
            ],
            [
                'name' => 'App Mobile',
                'description' => 'Aplicativo mobile para iOS e Android',
                'status' => 'aguardando_aprovacao',
                'priority' => 'normal',
                'progress_percentage' => 25,
                'budget' => 15000.00,
                'deadline' => now()->addDays(60),
                'last_update' => 'Definição da arquitetura do projeto',
                'last_activity_at' => now()->subDays(1),
                'technologies' => ['React Native', 'Node.js', 'MongoDB'],
            ],
            [
                'name' => 'Sistema de Gestão',
                'description' => 'ERP personalizado para controle de estoque',
                'status' => 'concluido',
                'priority' => 'alta',
                'progress_percentage' => 100,
                'budget' => 25000.00,
                'deadline' => now()->subDays(10),
                'last_update' => 'Projeto entregue com sucesso',
                'last_activity_at' => now()->subDays(5),
                'technologies' => ['Laravel', 'MySQL', 'Bootstrap'],
            ],
        ];

        foreach ($projects as $projectData) {
            ClientProject::updateOrCreate(
                ['name' => $projectData['name'], 'user_id' => $client->id],
                array_merge($projectData, ['user_id' => $client->id])
            );
        }

        // Criar faturas de teste
        $invoices = [
            [
                'invoice_number' => 'NV' . date('Ym') . '001',
                'title' => 'Desenvolvimento Site Corporativo - Primeira Parcela',
                'description' => 'Pagamento referente ao desenvolvimento do site corporativo',
                'subtotal' => 2500.00,
                'total_amount' => 2500.00,
                'status' => 'pendente',
                'issue_date' => now(),
                'due_date' => now()->addDays(15),
            ],
            [
                'invoice_number' => 'NV' . date('Ym') . '002',
                'title' => 'Sistema de Gestão - Pagamento Final',
                'description' => 'Pagamento final do sistema de gestão',
                'subtotal' => 5000.00,
                'total_amount' => 5000.00,
                'status' => 'paga',
                'issue_date' => now()->subDays(20),
                'due_date' => now()->subDays(10),
                'paid_date' => now()->subDays(5),
            ],
            [
                'invoice_number' => 'NV' . date('Ym') . '003',
                'title' => 'Consultoria Técnica',
                'description' => 'Horas de consultoria técnica',
                'subtotal' => 1200.00,
                'total_amount' => 1200.00,
                'status' => 'vencida',
                'issue_date' => now()->subDays(30),
                'due_date' => now()->subDays(5),
            ],
        ];

        foreach ($invoices as $invoiceData) {
            Invoice::updateOrCreate(
                ['invoice_number' => $invoiceData['invoice_number']],
                array_merge($invoiceData, ['user_id' => $client->id])
            );
        }

        // Criar tickets de teste
        $tickets = [
            [
                'ticket_number' => 'TK' . date('Y') . '00001',
                'subject' => 'Dúvida sobre funcionalidade do sistema',
                'description' => 'Gostaria de saber como configurar as permissões de usuário no novo sistema.',
                'status' => 'aberto',
                'priority' => 'normal',
                'category' => 'suporte_tecnico',
            ],
            [
                'ticket_number' => 'TK' . date('Y') . '00002',
                'subject' => 'Problema com acesso ao painel',
                'description' => 'Não consigo fazer login no painel administrativo. A página retorna erro 500.',
                'status' => 'resolvido',
                'priority' => 'alta',
                'category' => 'bug_report',
            ],
            [
                'ticket_number' => 'TK' . date('Y') . '00003',
                'subject' => 'Solicitação de nova funcionalidade',
                'description' => 'Gostaria de solicitar a implementação de relatórios em PDF no sistema.',
                'status' => 'aberto',
                'priority' => 'baixa',
                'category' => 'nova_funcionalidade',
            ],
        ];

        foreach ($tickets as $ticketData) {
            SupportTicket::updateOrCreate(
                ['ticket_number' => $ticketData['ticket_number']],
                array_merge($ticketData, ['user_id' => $client->id])
            );
        }

        $this->command->info('Dados de teste criados com sucesso!');
    }
}
