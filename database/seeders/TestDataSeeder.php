<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClientProject;
use App\Models\Invoice;
use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Criando ambiente de teste completo...');

        // Criar usuários administrativos
        $this->createAdminUsers();

        // Criar clientes de teste
        $clients = $this->createTestClients();

        // Criar projetos para os clientes
        $projects = $this->createClientProjects($clients);

        // Criar faturas realistas
        $this->createTestInvoices($clients, $projects);

        // Criar conteúdo do site
        $this->createSiteContent();

        // Configurar PagarMe para teste
        $this->setupPagarMeTestConfig();

        $this->command->info('✅ Ambiente de teste criado com sucesso!');
        $this->showTestCredentials();
    }

    /**
     * Criar usuários administrativos
     */
    private function createAdminUsers(): void
    {
        $this->command->info('👨‍💼 Criando usuários administrativos...');

        User::firstOrCreate(
            ['email' => 'admin@nicedesigns.com.br'],
            [
                'name' => 'Admin',
                'full_name' => 'Administrador Principal',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'person_type' => 'fisica',
                'document' => '12345678901',
                'phone' => '11999999999',
                'address' => 'Rua dos Desenvolvedores, 123',
                'address_number' => '123',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01234-567',
            ]
        );

        User::firstOrCreate(
            ['email' => 'suporte@nicedesigns.com.br'],
            [
                'name' => 'Suporte',
                'full_name' => 'Equipe de Suporte',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'person_type' => 'fisica',
                'document' => '12345678902',
                'phone' => '11999999998',
                'address' => 'Rua dos Desenvolvedores, 123',
                'address_number' => '123',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01234-567',
            ]
        );
    }

    /**
     * Criar clientes de teste
     */
    private function createTestClients(): array
    {
        $this->command->info('👥 Criando clientes de teste...');

        $clients = [];

        // Cliente pessoa física VIP
        $clients[] = User::firstOrCreate(
            ['email' => 'joao.silva@email.com'],
            [
                'name' => 'João',
                'full_name' => 'João Silva Santos',
                'person_type' => 'fisica',
                'document' => '12345678909',
                'phone' => '11987654321',
                'address' => 'Rua das Flores, 456',
                'address_number' => '456',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01234-567',
                'role' => 'client',
                'password' => Hash::make('password'),
            ]
        );

        // Cliente empresa importante
        $clients[] = User::firstOrCreate(
            ['email' => 'contato@techcorp.com.br'],
            [
                'name' => 'TechCorp',
                'full_name' => 'TechCorp Soluções Digitais Ltda',
                'person_type' => 'juridica',
                'document' => '12345678000195',
                'phone' => '11987654322',
                'address' => 'Av. Paulista, 1000',
                'address_number' => '1000',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01310-100',
                'role' => 'client',
                'password' => Hash::make('password'),
            ]
        );

        // Cliente E-commerce
        $clients[] = User::firstOrCreate(
            ['email' => 'vendas@lojasa.com.br'],
            [
                'name' => 'LojaSA',
                'full_name' => 'Loja SA Comércio Online',
                'person_type' => 'juridica',
                'document' => '98765432000123',
                'phone' => '11987654323',
                'address' => 'Rua do Comércio, 789',
                'address_number' => '789',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
                'zip_code' => '20040-020',
                'role' => 'client',
                'password' => Hash::make('password'),
            ]
        );

        // Mais clientes aleatórios (verificar se já existem)
        $existingClientsCount = User::where('role', 'client')->count();
        $additionalNeeded = max(0, 10 - $existingClientsCount + 3); // +3 pelos já criados acima
        
        if ($additionalNeeded > 0) {
            $additionalClients = User::factory()
                ->client()
                ->count($additionalNeeded)
                ->create();
            
            $clients = array_merge($clients, $additionalClients->toArray());
        }

        return $clients;
    }

    /**
     * Criar projetos para os clientes
     */
    private function createClientProjects(array $clients): array
    {
        $this->command->info('📋 Criando projetos de clientes...');

        $projects = [];

        foreach ($clients as $client) {
            // Cada cliente pode ter 1-4 projetos
            $projectCount = fake()->numberBetween(1, 4);
            
            for ($i = 0; $i < $projectCount; $i++) {
                $projects[] = ClientProject::factory()->create([
                    'user_id' => $client['id'] ?? $client->id,
                ]);
            }
        }

        // Alguns projetos específicos para demonstração
        $demoProjects = [
            [
                'user_id' => $clients[0]['id'] ?? $clients[0]->id,
                'name' => 'Site Institucional - João Silva',
                'description' => 'Desenvolvimento de site institucional moderno e responsivo',
                'status' => 'em_andamento',
                'priority' => 'alta',
                'budget' => 8500.00,
                'currency' => 'BRL',
                'progress_percentage' => 60,
                'start_date' => '2024-10-01',
                'estimated_completion' => '2024-12-15',
                'deadline' => '2024-12-31',
            ],
            [
                'user_id' => $clients[1]['id'] ?? $clients[1]->id,
                'name' => 'E-commerce - TechCorp',
                'description' => 'Loja virtual completa com sistema de gestão',
                'status' => 'em_revisao',
                'priority' => 'urgente',
                'budget' => 25000.00,
                'currency' => 'BRL',
                'progress_percentage' => 90,
                'start_date' => '2024-09-01',
                'estimated_completion' => '2024-12-01',
                'deadline' => '2024-12-15',
            ],
            [
                'user_id' => $clients[2]['id'] ?? $clients[2]->id,
                'name' => 'Marketplace - LojaSA',
                'description' => 'Plataforma marketplace B2B personalizada',
                'status' => 'aguardando_aprovacao',
                'priority' => 'normal',
                'budget' => 45000.00,
                'currency' => 'BRL',
                'progress_percentage' => 15,
                'start_date' => '2024-12-01',
                'estimated_completion' => '2025-03-01',
                'deadline' => '2025-03-15',
            ],
        ];

        foreach ($demoProjects as $projectData) {
            $projects[] = ClientProject::factory()->create($projectData);
        }

        return $projects;
    }

    /**
     * Criar faturas de teste
     */
    private function createTestInvoices(array $clients, array $projects): void
    {
        $this->command->info('💰 Criando faturas de teste...');

        // Faturas específicas para demonstração
        $demoInvoices = [
            [
                'user_id' => $clients[0]['id'] ?? $clients[0]->id,
                'client_project_id' => $projects[0]->id,
                'title' => 'Desenvolvimento Site Institucional - Primeira Parcela',
                'status' => 'pendente',
                'total_amount' => 4250.00,
                'auto_charge_enabled' => true,
                'auto_charge_date' => now()->addDays(2),
            ],
            [
                'user_id' => $clients[1]['id'] ?? $clients[1]->id,
                'client_project_id' => $projects[1]->id,
                'title' => 'E-commerce TechCorp - Sinal',
                'status' => 'paga',
                'total_amount' => 12500.00,
                'payment_method' => 'pix',
                'paid_date' => now()->subDays(10),
            ],
            [
                'user_id' => $clients[0]['id'] ?? $clients[0]->id,
                'title' => 'Manutenção Mensal - Janeiro',
                'status' => 'vencida',
                'total_amount' => 800.00,
                'due_date' => now()->subDays(15),
            ],
            [
                'user_id' => $clients[2]['id'] ?? $clients[2]->id,
                'title' => 'Consultoria Digital - Pacote Premium',
                'status' => 'pendente',
                'total_amount' => 5500.00,
                'auto_charge_enabled' => true,
                'auto_charge_date' => now()->addDays(7),
            ],
        ];

        foreach ($demoInvoices as $invoiceData) {
            Invoice::factory()->create($invoiceData);
        }

        // Faturas aleatórias
        Invoice::factory()->pending()->count(15)->create();
        Invoice::factory()->paid()->count(20)->create();
        Invoice::factory()->overdue()->count(5)->create();
        Invoice::factory()->autoCharge()->count(8)->create();
        Invoice::factory()->withPagarMe()->count(10)->create();
        Invoice::factory()->highValue()->count(3)->create();
    }

    /**
     * Criar conteúdo do site
     */
    private function createSiteContent(): void
    {
        $this->command->info('📝 Criando conteúdo do site...');

        // Categorias
        $webDesign = Category::firstOrCreate(
            ['slug' => 'web-design'],
            [
                'name' => 'Web Design',
                'description' => 'Projetos de design para web',
                'is_active' => true,
            ]
        );

        $desenvolvimento = Category::firstOrCreate(
            ['slug' => 'desenvolvimento'],
            [
                'name' => 'Desenvolvimento',
                'description' => 'Projetos de desenvolvimento web',
                'is_active' => true,
            ]
        );

        // Posts do blog
        $admin = User::where('role', 'admin')->first();

        Post::factory()->count(10)->create([
            'user_id' => $admin->id,
            'category_id' => $webDesign->id,
        ]);

        Post::factory()->count(8)->create([
            'user_id' => $admin->id,
            'category_id' => $desenvolvimento->id,
        ]);

        // Projetos do portfólio
        Project::factory()->count(15)->create([
            'user_id' => $admin->id,
            'category_id' => $webDesign->id,
        ]);

        Project::factory()->count(12)->create([
            'user_id' => $admin->id,
            'category_id' => $desenvolvimento->id,
        ]);
    }

    /**
     * Configurar PagarMe para teste
     */
    private function setupPagarMeTestConfig(): void
    {
        $this->command->info('🔧 Configurando PagarMe para testes...');

        Setting::set('pagarme_environment', 'sandbox', 'string', 'pagarme');
        Setting::set('pagarme_api_key', 'ak_test_...', 'string', 'pagarme');
        Setting::set('pagarme_encryption_key', 'ek_test_...', 'string', 'pagarme');
        Setting::set('pagarme_webhook_secret', 'test_webhook_secret', 'string', 'pagarme');
        Setting::set('pagarme_send_email_on_generation', false, 'boolean', 'pagarme');
    }

    /**
     * Mostrar credenciais de teste
     */
    private function showTestCredentials(): void
    {
        $this->command->newLine();
        $this->command->info('🔑 CREDENCIAIS DE TESTE:');
        $this->command->line('');
        $this->command->line('👨‍💼 ADMIN:');
        $this->command->line('   Email: admin@nicedesigns.com.br');
        $this->command->line('   Senha: password');
        $this->command->line('');
        $this->command->line('👥 CLIENTES DE TESTE:');
        $this->command->line('   Email: joao.silva@email.com');
        $this->command->line('   Email: contato@techcorp.com.br');
        $this->command->line('   Email: vendas@lojasa.com.br');
        $this->command->line('   Senha: password (para todos)');
        $this->command->line('');
        $this->command->line('💡 DICAS:');
        $this->command->line('   • Configure as chaves reais do PagarMe nas configurações');
        $this->command->line('   • Execute: php artisan queue:work para processar jobs');
        $this->command->line('   • Execute: php artisan pagarme:test para testar integração');
        $this->command->newLine();
    }
} 