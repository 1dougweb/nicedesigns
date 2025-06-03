<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UpdateAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atualizar usuário admin existente
        User::where('email', 'admin@nicedesigns.com.br')->update(['role' => 'admin']);
        
        $this->command->info('Usuário admin atualizado com sucesso!');
    }
}
