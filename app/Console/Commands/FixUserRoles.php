<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:fix-roles {--create-admin : Criar usuário admin se não existir}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corrige roles de usuários e garante que admin tenha role correta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Corrigindo roles de usuários...');

        // Garantir que o admin principal existe e tem role admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@nicedesigns.com.br'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->info('✅ Usuário admin criado: admin@nicedesigns.com.br');
        } else {
            $this->info('✅ Usuário admin atualizado: admin@nicedesigns.com.br');
        }

        // Atualizar usuários que deveriam ser admin
        $adminEmails = [
            'admin@nicedesigns.com.br',
            'admin@nicedesigns.com',
            'administrador@nicedesigns.com.br',
            'admin@example.com'
        ];

        $updated = User::whereIn('email', $adminEmails)
                      ->where('role', '!=', 'admin')
                      ->update(['role' => 'admin']);

        if ($updated > 0) {
            $this->info("✅ {$updated} usuário(s) admin corrigido(s)");
        }

        // Criar cliente de exemplo se solicitado
        if ($this->option('create-admin') || $this->confirm('Criar usuário cliente de exemplo?')) {
            $client = User::firstOrCreate(
                ['email' => 'cliente@exemplo.com'],
                [
                    'name' => 'Cliente Exemplo',
                    'password' => Hash::make('password'),
                    'role' => 'client'
                ]
            );

            if ($client->wasRecentlyCreated) {
                $this->info('✅ Usuário cliente criado: cliente@exemplo.com');
            }
        }

        // Mostrar estatísticas
        $adminCount = User::where('role', 'admin')->count();
        $clientCount = User::where('role', 'client')->count();

        $this->info("\n📊 Estatísticas de usuários:");
        $this->line("👨‍💼 Admins: {$adminCount}");
        $this->line("👤 Clientes: {$clientCount}");

        $this->info("\n🔑 Credenciais de acesso:");
        $this->line("Admin: admin@nicedesigns.com.br (senha: password)");
        if (User::where('email', 'cliente@exemplo.com')->exists()) {
            $this->line("Cliente: cliente@exemplo.com (senha: password)");
        }

        $this->info("\n✅ Roles corrigidas com sucesso!");
        
        return Command::SUCCESS;
    }
}
