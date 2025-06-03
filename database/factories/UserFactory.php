<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake('pt_BR')->firstName();
        $lastName = fake('pt_BR')->lastName();
        $fullName = $firstName . ' ' . $lastName;

        return [
            'name' => $firstName,
            'full_name' => $fullName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'client',
            'person_type' => fake()->randomElement(['fisica', 'juridica']),
            'document' => $this->generateDocument(),
            'phone' => $this->generatePhone(),
            'address' => fake('pt_BR')->streetAddress(),
            'address_number' => fake()->numberBetween(1, 9999),
            'address_complement' => fake()->optional(0.3)->randomElement(['Apt 101', 'Sala 202', 'Casa 2', 'Bloco A']),
            'neighborhood' => fake('pt_BR')->word() . ' ' . fake('pt_BR')->word(),
            'city' => fake('pt_BR')->city(),
            'state' => fake('pt_BR')->stateAbbr(),
            'zip_code' => fake('pt_BR')->postcode(),
            'country' => 'Brasil',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'name' => 'Admin',
            'full_name' => 'Administrador do Sistema',
            'email' => 'admin@nicedesigns.com.br',
        ]);
    }

    /**
     * Create a client user
     */
    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'client',
        ]);
    }

    /**
     * Create a company client
     */
    public function company(): static
    {
        $companyName = fake('pt_BR')->company();
        
        return $this->state(fn (array $attributes) => [
            'role' => 'client',
            'person_type' => 'juridica',
            'full_name' => $companyName,
            'document' => $this->generateCNPJ(),
        ]);
    }

    /**
     * Generate a valid CPF
     */
    private function generateDocument(): string
    {
        if (fake()->boolean(70)) { // 70% chance of CPF
            return $this->generateCPF();
        } else {
            return $this->generateCNPJ();
        }
    }

    /**
     * Generate a valid CPF
     */
    private function generateCPF(): string
    {
        $cpf = '';
        for ($i = 0; $i < 9; $i++) {
            $cpf .= fake()->numberBetween(0, 9);
        }

        // Calculate first check digit
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $remainder = $sum % 11;
        $firstDigit = $remainder < 2 ? 0 : 11 - $remainder;
        $cpf .= $firstDigit;

        // Calculate second check digit
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $remainder = $sum % 11;
        $secondDigit = $remainder < 2 ? 0 : 11 - $remainder;
        $cpf .= $secondDigit;

        return $cpf;
    }

    /**
     * Generate a valid CNPJ
     */
    private function generateCNPJ(): string
    {
        $cnpj = '';
        for ($i = 0; $i < 12; $i++) {
            $cnpj .= fake()->numberBetween(0, 9);
        }

        // Calculate first check digit
        $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += intval($cnpj[$i]) * $weights[$i];
        }
        $remainder = $sum % 11;
        $firstDigit = $remainder < 2 ? 0 : 11 - $remainder;
        $cnpj .= $firstDigit;

        // Calculate second check digit
        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += intval($cnpj[$i]) * $weights[$i];
        }
        $remainder = $sum % 11;
        $secondDigit = $remainder < 2 ? 0 : 11 - $remainder;
        $cnpj .= $secondDigit;

        return $cnpj;
    }

    /**
     * Generate a Brazilian phone number
     */
    private function generatePhone(): string
    {
        $ddd = fake()->randomElement([
            '11', '12', '13', '14', '15', '16', '17', '18', '19', // SP
            '21', '22', '24', // RJ
            '27', '28', // ES
            '31', '32', '33', '34', '35', '37', '38', // MG
            '41', '42', '43', '44', '45', '46', // PR
            '47', '48', '49', // SC
            '51', '53', '54', '55', // RS
        ]);
        
        $number = '9' . fake()->numberBetween(1000, 9999) . fake()->numberBetween(1000, 9999);
        
        return $ddd . $number;
    }
}
