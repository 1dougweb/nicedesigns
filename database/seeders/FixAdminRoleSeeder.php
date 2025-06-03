<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Corrigir role do usuário admin principal
        User::updateOrCreate(
            ['email' => 'admin@nicedesigns.com.br'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // Criar usuário cliente de exemplo (se não existir)
        User::firstOrCreate(
            ['email' => 'cliente@exemplo.com'],
            [
                'name' => 'Cliente Exemplo',
                'password' => Hash::make('password'),
                'role' => 'client'
            ]
        );

        // Atualizar qualquer usuário que deveria ser admin mas está como client
        User::whereIn('email', [
            'admin@nicedesigns.com.br',
            'admin@nicedesigns.com',
            'administrador@nicedesigns.com.br'
        ])->update(['role' => 'admin']);

        $this->command->info('✅ Roles de usuários corrigidas com sucesso!');
        $this->command->info('📧 Admin: admin@nicedesigns.com.br (senha: password)');
        $this->command->info('👤 Cliente: cliente@exemplo.com (senha: password)');
    }
}
