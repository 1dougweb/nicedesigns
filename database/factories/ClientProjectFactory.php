<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientProject>
 */
class ClientProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $projectTypes = [
            'Site Institucional',
            'E-commerce',
            'Landing Page',
            'Blog Corporativo',
            'Sistema Web',
            'Aplicativo Mobile',
            'Identidade Visual',
            'Redesign de Site',
            'Portal Corporativo',
            'Marketplace'
        ];

        $descriptions = [
            'Desenvolvimento de site moderno e responsivo',
            'Criação de loja virtual completa com sistema de pagamento',
            'Landing page otimizada para conversão',
            'Blog corporativo com CMS personalizado',
            'Sistema web customizado para gestão interna',
            'Aplicativo mobile nativo para iOS e Android',
            'Criação de identidade visual completa',
            'Modernização e reestruturação do site existente',
            'Portal corporativo com área restrita',
            'Marketplace B2B com múltiplos vendedores'
        ];

        $status = fake()->randomElement(['aguardando_aprovacao', 'em_andamento', 'em_revisao', 'concluido', 'pausado']);
        
        // Generate dates ensuring proper order using Carbon
        $startDate = fake()->dateTimeBetween('-6 months', 'now');
        
        // Add random days to start_date for estimated_completion (30-120 days)
        $estimatedCompletion = (clone $startDate)->modify('+' . fake()->numberBetween(30, 120) . ' days');
        
        // Add random days to estimated_completion for deadline (7-30 days)
        $deadline = (clone $estimatedCompletion)->modify('+' . fake()->numberBetween(7, 30) . ' days');

        return [
            'user_id' => User::factory()->client(),
            'name' => fake()->randomElement($projectTypes) . ' - ' . fake('pt_BR')->company(),
            'description' => fake()->randomElement($descriptions),
            'requirements' => fake()->optional(0.8)->paragraph(),
            'budget' => fake()->randomFloat(2, 2000, 50000),
            'currency' => 'BRL',
            'status' => $status,
            'priority' => fake()->randomElement(['baixa', 'normal', 'alta', 'urgente']),
            'start_date' => $startDate,
            'estimated_completion' => $estimatedCompletion,
            'deadline' => fake()->optional(0.7)->passthrough($deadline),
            'progress_percentage' => $this->calculateProgress($status),
            'current_stage' => $this->getCurrentStage($status),
            'stages' => $this->generateStages($status),
            'last_update' => fake()->optional(0.7)->paragraph(),
            'last_activity_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'technologies' => fake()->randomElements([
                'Laravel', 'Vue.js', 'React', 'WordPress', 'WooCommerce',
                'Tailwind CSS', 'Bootstrap', 'MySQL', 'PostgreSQL',
                'JavaScript', 'TypeScript', 'PHP', 'Node.js', 'Flutter'
            ], fake()->numberBetween(2, 5)),
            'tags' => fake()->optional(0.6)->randomElements([
                'responsivo', 'seo', 'cms', 'e-commerce', 'mobile-first',
                'performance', 'segurança', 'api', 'dashboard', 'admin'
            ], fake()->numberBetween(1, 3)),
        ];
    }

    /**
     * Calculate progress based on status
     */
    private function calculateProgress(string $status): int
    {
        return match($status) {
            'aguardando_aprovacao' => fake()->numberBetween(0, 5),
            'em_andamento' => fake()->numberBetween(20, 80),
            'em_revisao' => fake()->numberBetween(85, 95),
            'concluido' => 100,
            'pausado' => fake()->numberBetween(10, 60),
            'aguardando_cliente' => fake()->numberBetween(30, 70),
            'cancelado' => fake()->numberBetween(0, 50),
            default => 0
        };
    }

    /**
     * Get current stage based on status
     */
    private function getCurrentStage(string $status): string
    {
        return match($status) {
            'aguardando_aprovacao' => 'Planejamento',
            'em_andamento' => fake()->randomElement(['Design', 'Desenvolvimento', 'Testes']),
            'em_revisao' => 'Testes',
            'concluido' => 'Deploy',
            'pausado' => fake()->randomElement(['Planejamento', 'Design', 'Desenvolvimento']),
            'aguardando_cliente' => fake()->randomElement(['Design', 'Testes']),
            'cancelado' => fake()->randomElement(['Planejamento', 'Design']),
            default => 'Planejamento'
        };
    }

    /**
     * Generate project stages
     */
    private function generateStages(string $status): array
    {
        $stages = [
            [
                'name' => 'Planejamento',
                'description' => 'Definição de requisitos e planejamento do projeto',
                'progress' => $status === 'aguardando_aprovacao' ? fake()->numberBetween(0, 100) : 100,
                'estimated_hours' => 20,
                'completed_at' => $status !== 'aguardando_aprovacao' ? fake()->dateTimeBetween('-2 months', '-1 month') : null,
            ],
            [
                'name' => 'Design',
                'description' => 'Criação do design e protótipo',
                'progress' => in_array($status, ['em_andamento', 'em_revisao', 'concluido']) ? fake()->numberBetween(50, 100) : 0,
                'estimated_hours' => 30,
                'completed_at' => in_array($status, ['em_revisao', 'concluido']) ? fake()->dateTimeBetween('-1 month', '-2 weeks') : null,
            ],
            [
                'name' => 'Desenvolvimento',
                'description' => 'Desenvolvimento da solução',
                'progress' => in_array($status, ['em_andamento', 'em_revisao', 'concluido']) ? fake()->numberBetween(0, 100) : 0,
                'estimated_hours' => 80,
                'completed_at' => $status === 'concluido' ? fake()->dateTimeBetween('-2 weeks', '-1 week') : null,
            ],
            [
                'name' => 'Testes',
                'description' => 'Testes e correções',
                'progress' => in_array($status, ['em_revisao', 'concluido']) ? fake()->numberBetween(50, 100) : 0,
                'estimated_hours' => 20,
                'completed_at' => $status === 'concluido' ? fake()->dateTimeBetween('-1 week', '-3 days') : null,
            ],
            [
                'name' => 'Deploy',
                'description' => 'Publicação e entrega',
                'progress' => $status === 'concluido' ? 100 : 0,
                'estimated_hours' => 10,
                'completed_at' => $status === 'concluido' ? fake()->dateTimeBetween('-3 days', 'now') : null,
            ],
        ];

        return $stages;
    }

    /**
     * Create a project in planning status
     */
    public function planning(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'aguardando_aprovacao',
            'progress_percentage' => fake()->numberBetween(0, 15),
            'current_stage' => 'Planejamento',
        ]);
    }

    /**
     * Create a project in progress
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'em_andamento',
            'progress_percentage' => fake()->numberBetween(20, 80),
            'current_stage' => fake()->randomElement(['Design', 'Desenvolvimento']),
        ]);
    }

    /**
     * Create a completed project
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'concluido',
            'progress_percentage' => 100,
            'current_stage' => 'Deploy',
            'actual_completion' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create a high priority project
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'alta',
        ]);
    }

    /**
     * Create a large budget project
     */
    public function largeBudget(): static
    {
        return $this->state(fn (array $attributes) => [
            'budget' => fake()->randomFloat(2, 20000, 100000),
        ]);
    }

    /**
     * Create an overdue project
     */
    public function overdue(): static
    {
        $startDate = fake()->dateTimeBetween('-4 months', '-2 months');
        $estimatedCompletion = (clone $startDate)->modify('+' . fake()->numberBetween(30, 90) . ' days');
        $deadline = (clone $estimatedCompletion)->modify('-' . fake()->numberBetween(7, 30) . ' days'); // deadline before estimated completion to make it overdue
        
        return $this->state(fn (array $attributes) => [
            'start_date' => $startDate,
            'estimated_completion' => $estimatedCompletion,
            'deadline' => $deadline,
            'status' => fake()->randomElement(['em_andamento', 'pausado', 'aguardando_cliente']),
            'priority' => fake()->randomElement(['alta', 'urgente']),
        ]);
    }
} 