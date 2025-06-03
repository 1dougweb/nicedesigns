<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário cliente de teste
        User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@nicedesigns.com.br',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);
        
        $this->command->info('Usuário cliente de teste criado com sucesso!');
        $this->command->info('Email: cliente@nicedesigns.com.br');
        $this->command->info('Senha: password');
    }
}
