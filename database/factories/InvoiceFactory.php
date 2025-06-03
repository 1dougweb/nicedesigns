<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ClientProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $serviceTypes = [
            'Desenvolvimento de Website',
            'Design de Interface (UI/UX)',
            'Criação de Loja Virtual',
            'Manutenção de Sistema',
            'Consultoria Digital',
            'Identidade Visual',
            'Otimização SEO',
            'Marketing Digital',
            'Aplicativo Mobile',
            'Sistema Personalizado'
        ];

        $descriptions = [
            'Desenvolvimento completo de website responsivo com CMS',
            'Design de interface moderna e intuitiva para aplicação web',
            'Criação de e-commerce completo com integração de pagamentos',
            'Manutenção mensal do sistema e correções de bugs',
            'Consultoria em transformação digital e estratégia online',
            'Criação de identidade visual completa incluindo logotipo',
            'Otimização SEO completa para melhor posicionamento',
            'Gestão de campanhas de marketing digital e redes sociais',
            'Desenvolvimento de aplicativo mobile nativo',
            'Desenvolvimento de sistema personalizado para gestão'
        ];

        $subtotal = fake()->randomFloat(2, 500, 25000);
        $discount = fake()->optional(0.4)->randomFloat(2, 0, $subtotal * 0.2);
        $taxRate = fake()->optional(0.6)->randomFloat(2, 0, 10);
        $taxAmount = ($subtotal - ($discount ?? 0)) * (($taxRate ?? 0) / 100);
        $totalAmount = $subtotal - ($discount ?? 0) + $taxAmount;

        $issueDate = fake()->dateTimeBetween('-3 months', 'now');
        
        $status = fake()->randomElement(['pendente', 'paga', 'vencida', 'cancelada']);
        
        // Generate due_date based on status to avoid date conflicts
        if ($status === 'vencida') {
            // For overdue invoices, due_date should be in the past
            $dueDate = fake()->dateTimeBetween('-1 month', '-1 day');
            // Adjust issue_date to be before due_date
            $issueDate = fake()->dateTimeBetween('-2 months', $dueDate);
        } else {
            // For other statuses, due_date is after issue_date
            $dueDate = (clone $issueDate)->modify('+' . fake()->numberBetween(7, 60) . ' days');
        }

        $paidDate = null;
        $paymentMethod = null;
        $paymentReference = null;

        if ($status === 'paga') {
            // Ensure paid_date is between issue_date and due_date, or up to now if due_date is in future
            $maxPaidDate = $dueDate > now() ? now() : $dueDate;
            $paidDate = fake()->dateTimeBetween($issueDate, $maxPaidDate);
            $paymentMethod = fake()->randomElement(['pix', 'boleto', 'transferencia', 'cartao']);
            $paymentReference = $this->generatePaymentReference($paymentMethod);
        }

        return [
            'user_id' => User::factory()->client(),
            'client_project_id' => fake()->optional(0.7)->randomElement([
                null,
                fn() => ClientProject::factory()->create()->id
            ]),
            'invoice_number' => $this->generateInvoiceNumber(),
            'title' => fake()->randomElement($serviceTypes),
            'description' => fake()->randomElement($descriptions),
            'subtotal' => $subtotal,
            'discount' => $discount ?? 0,
            'tax_rate' => $taxRate ?? 0,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'BRL',
            'status' => $status,
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'paid_date' => $paidDate,
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
            'payment_instructions' => $this->generatePaymentInstructions(),
            'notes' => fake()->optional(0.5)->paragraph(),
            'auto_charge_enabled' => fake()->boolean(30),
            'auto_charge_date' => fake()->optional(0.3)->passthrough(
                fake()->dateTimeBetween($issueDate, $dueDate > now() ? $dueDate : now())
            ),
        ];
    }

    /**
     * Generate realistic invoice number
     */
    private function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $unique = strtoupper(substr(uniqid(), -6));
        
        return "NV{$year}{$month}{$unique}";
    }

    /**
     * Generate payment reference based on method
     */
    private function generatePaymentReference(string $method): string
    {
        return match($method) {
            'pix' => 'PIX-' . fake()->uuid(),
            'boleto' => 'BOL-' . fake()->numerify('##############'),
            'transferencia' => 'TED-' . fake()->numerify('########'),
            'cartao' => 'CARD-' . fake()->numerify('############'),
            default => 'REF-' . fake()->uuid()
        };
    }

    /**
     * Generate payment instructions
     */
    private function generatePaymentInstructions(): string
    {
        $instructions = [
            'Pagamento via PIX: utilize a chave PIX disponível no boleto ou entre em contato conosco.',
            'Boleto bancário: pode ser pago em qualquer banco, casa lotérica ou internet banking.',
            'Transferência bancária: solicite nossos dados bancários por email ou WhatsApp.',
            'Cartão de crédito: entre em contato para processar o pagamento via link seguro.',
        ];

        return fake()->randomElement($instructions);
    }

    /**
     * Create a pending invoice
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pendente',
            'paid_date' => null,
            'payment_method' => null,
            'payment_reference' => null,
        ]);
    }

    /**
     * Create a paid invoice
     */
    public function paid(): static
    {
        return $this->state(function (array $attributes) {
            $paymentMethod = fake()->randomElement(['pix', 'boleto', 'transferencia', 'cartao']);
            
            return [
                'status' => 'paga',
                'paid_date' => fake()->dateTimeBetween($attributes['issue_date'], 'now'),
                'payment_method' => $paymentMethod,
                'payment_reference' => $this->generatePaymentReference($paymentMethod),
            ];
        });
    }

    /**
     * Create an overdue invoice
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'vencida',
            'due_date' => fake()->dateTimeBetween('-1 month', '-1 day'),
            'paid_date' => null,
            'payment_method' => null,
            'payment_reference' => null,
        ]);
    }

    /**
     * Create a high value invoice
     */
    public function highValue(): static
    {
        return $this->state(function (array $attributes) {
            $subtotal = fake()->randomFloat(2, 10000, 50000);
            $discount = fake()->optional(0.3)->randomFloat(2, 0, $subtotal * 0.15);
            $taxRate = fake()->optional(0.8)->randomFloat(2, 5, 15);
            $taxAmount = ($subtotal - ($discount ?? 0)) * (($taxRate ?? 0) / 100);
            $totalAmount = $subtotal - ($discount ?? 0) + $taxAmount;

            return [
                'subtotal' => $subtotal,
                'discount' => $discount ?? 0,
                'tax_rate' => $taxRate ?? 0,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ];
        });
    }

    /**
     * Create invoice with auto charge enabled
     */
    public function autoCharge(): static
    {
        return $this->state(fn (array $attributes) => [
            'auto_charge_enabled' => true,
            'auto_charge_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => 'pendente',
        ]);
    }

    /**
     * Create invoice with PagarMe data
     */
    public function withPagarMe(): static
    {
        return $this->state(fn (array $attributes) => [
            'pagarme_charge_id' => 'ch_' . fake()->uuid(),
            'pagarme_transaction_id' => 'tran_' . fake()->uuid(),
            'pagarme_status' => fake()->randomElement(['paid', 'pending', 'waiting_payment']),
            'payment_url' => 'https://pagar.me/checkout/' . fake()->uuid(),
            'boleto_url' => fake()->optional(0.8)->url() . '/boleto.pdf',
            'pix_code' => fake()->optional(0.8)->uuid(),
            'pix_qr_code' => fake()->optional(0.8)->text(500),
        ]);
    }
} 