<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ClientSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test client user
        $client = User::firstOrCreate(
            ['email' => 'cliente@teste.com'],
            [
                'name' => 'João Silva',
                'password' => Hash::make('password'),
                'role' => 'client',
                'full_name' => 'João Silva Santos',
                'person_type' => 'fisica',
                'document' => '12345678901',
                'phone' => '11987654321',
                'whatsapp' => '11987654321',
                'zip_code' => '01234567',
                'address' => 'Rua das Flores',
                'address_number' => '123',
                'address_complement' => 'Apto 45',
                'neighborhood' => 'Centro',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'Brasil',
                'profile_completed_at' => now(),
            ]
        );

        // Create another test client (company)
        $clientCompany = User::firstOrCreate(
            ['email' => 'empresa@teste.com'],
            [
                'name' => 'Tech Solutions',
                'password' => Hash::make('password'),
                'role' => 'client',
                'full_name' => 'Tech Solutions Ltda',
                'person_type' => 'juridica',
                'document' => '12345678000195',
                'phone' => '1133334444',
                'zip_code' => '04567890',
                'address' => 'Av. Paulista',
                'address_number' => '1000',
                'neighborhood' => 'Bela Vista',
                'city' => 'São Paulo',
                'state' => 'SP',
                'country' => 'Brasil',
                'company_name' => 'Tech Solutions Ltda',
                'profile_completed_at' => now(),
            ]
        );
    }
}
