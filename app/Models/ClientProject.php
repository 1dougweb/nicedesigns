<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClientProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'description',
        'requirements',
        'budget',
        'currency',
        'status',
        'progress_percentage',
        'stages',
        'current_stage',
        'technologies',
        'tags',
        'start_date',
        'estimated_completion',
        'actual_completion',
        'deadline',
        'preview_url',
        'live_url',
        'repository_url',
        'files',
        'contract_details',
        'priority',
        'last_update',
        'last_activity_at',
        'rating',
        'client_feedback',
    ];

    protected function casts(): array
    {
        return [
            'stages' => 'array',
            'technologies' => 'array',
            'tags' => 'array',
            'files' => 'array',
            'start_date' => 'date',
            'estimated_completion' => 'date',
            'actual_completion' => 'date',
            'deadline' => 'date',
            'last_activity_at' => 'datetime',
            'budget' => 'decimal:2',
        ];
    }

    /**
     * Status labels
     */
    public static function getStatusLabels(): array
    {
        return [
            'aguardando_aprovacao' => 'Aguardando Aprovação',
            'em_andamento' => 'Em Andamento',
            'pausado' => 'Pausado',
            'aguardando_cliente' => 'Aguardando Cliente',
            'em_revisao' => 'Em Revisão',
            'concluido' => 'Concluído',
            'cancelado' => 'Cancelado',
        ];
    }

    /**
     * Status colors
     */
    public static function getStatusColors(): array
    {
        return [
            'aguardando_aprovacao' => 'yellow',
            'em_andamento' => 'blue',
            'pausado' => 'gray',
            'aguardando_cliente' => 'orange',
            'em_revisao' => 'purple',
            'concluido' => 'green',
            'cancelado' => 'red',
        ];
    }

    /**
     * Priority labels
     */
    public static function getPriorityLabels(): array
    {
        return [
            'baixa' => 'Baixa',
            'normal' => 'Normal',
            'alta' => 'Alta',
            'urgente' => 'Urgente',
        ];
    }

    /**
     * Priority colors
     */
    public static function getPriorityColors(): array
    {
        return [
            'baixa' => 'gray',
            'normal' => 'blue',
            'alta' => 'orange',
            'urgente' => 'red',
        ];
    }

    /**
     * Default stages for new projects
     */
    public static function getDefaultStages(): array
    {
        return [
            [
                'name' => 'Planejamento',
                'description' => 'Análise de requisitos e planejamento do projeto',
                'status' => 'pending',
                'progress' => 0,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'name' => 'Design',
                'description' => 'Criação do design e protótipos',
                'status' => 'pending',
                'progress' => 0,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'name' => 'Desenvolvimento',
                'description' => 'Desenvolvimento das funcionalidades',
                'status' => 'pending',
                'progress' => 0,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'name' => 'Testes',
                'description' => 'Testes e correções',
                'status' => 'pending',
                'progress' => 0,
                'start_date' => null,
                'end_date' => null,
            ],
            [
                'name' => 'Deploy',
                'description' => 'Deploy e entrega final',
                'status' => 'pending',
                'progress' => 0,
                'start_date' => null,
                'end_date' => null,
            ],
        ];
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? $this->status;
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'gray';
    }

    /**
     * Get status color (method alias for view compatibility)
     */
    public function getStatusColor(): string
    {
        return $this->getStatusColorAttribute();
    }

    /**
     * Get priority label
     */
    public function getPriorityLabelAttribute(): string
    {
        return self::getPriorityLabels()[$this->priority] ?? $this->priority;
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute(): string
    {
        return self::getPriorityColors()[$this->priority] ?? 'gray';
    }

    /**
     * Get priority color (method alias for view compatibility)
     */
    public function getPriorityColor(): string
    {
        return $this->getPriorityColorAttribute();
    }

    /**
     * Get formatted budget
     */
    public function getFormattedBudgetAttribute(): string
    {
        if (!$this->budget) return 'Não informado';

        $currencies = [
            'BRL' => 'R$',
            'USD' => '$',
            'EUR' => '€',
        ];

        $symbol = $currencies[$this->currency] ?? $this->currency;
        
        return $symbol . ' ' . number_format($this->budget, 2, ',', '.');
    }

    /**
     * Get days until deadline
     */
    public function getDaysUntilDeadlineAttribute(): ?int
    {
        if (!$this->deadline) return null;

        return Carbon::now()->diffInDays($this->deadline, false);
    }

    /**
     * Check if project is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->deadline && Carbon::now()->isAfter($this->deadline) && $this->status !== 'concluido';
    }

    /**
     * Get current stage info
     */
    public function getCurrentStageInfoAttribute(): ?array
    {
        if (!$this->stages || !$this->current_stage) return null;

        foreach ($this->stages as $stage) {
            if ($stage['name'] === $this->current_stage) {
                return $stage;
            }
        }

        return null;
    }

    /**
     * Get technology badges HTML
     */
    public function getTechnologyBadgesAttribute(): string
    {
        if (!$this->technologies) return '';

        $badges = [];
        $colors = ['blue', 'green', 'purple', 'orange', 'red', 'pink', 'indigo', 'cyan'];

        foreach ($this->technologies as $index => $tech) {
            $color = $colors[$index % count($colors)];
            $badges[] = "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800\">{$tech}</span>";
        }

        return implode(' ', $badges);
    }

    /**
     * Calculate progress based on stages
     */
    public function calculateProgress(): int
    {
        if (!$this->stages) return 0;

        $totalStages = count($this->stages);
        if ($totalStages === 0) return 0;

        $completedStages = 0;
        $totalProgress = 0;

        foreach ($this->stages as $stage) {
            $stageProgress = $stage['progress'] ?? 0;
            $totalProgress += $stageProgress;
            
            if ($stageProgress >= 100) {
                $completedStages++;
            }
        }

        return intval($totalProgress / $totalStages);
    }

    /**
     * Update project activity
     */
    public function updateActivity(string $message = null): void
    {
        $this->update([
            'last_update' => $message,
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelado', 'concluido']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'concluido');
    }

    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
                    ->whereNotIn('status', ['concluido', 'cancelado']);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope para projetos aguardando aprovação
     */
    public function scopeAwaitingApproval($query)
    {
        return $query->where('status', 'aguardando_aprovacao');
    }

    /**
     * Aprovar projeto
     */
    public function approve(): void
    {
        $this->update([
            'status' => 'em_andamento',
            'last_activity_at' => now(),
        ]);
        
        $this->updateActivity('Projeto aprovado pelo cliente');
        
        // Notificar administradores
        Notification::createForAdmins([
            'title' => 'Projeto Aprovado',
            'message' => "O cliente aprovou o projeto: {$this->name}",
            'type' => Notification::TYPE_SUCCESS,
            'url' => route('admin.client-projects.show', $this->id),
            'data' => [
                'project_id' => $this->id,
                'client_id' => $this->user_id,
                'action' => 'approved'
            ]
        ]);
    }

    /**
     * Rejeitar projeto
     */
    public function reject(string $reason = null): void
    {
        $this->update([
            'status' => 'cancelado',
            'last_activity_at' => now(),
        ]);
        
        $message = 'Projeto rejeitado pelo cliente';
        if ($reason) {
            $message .= ". Motivo: {$reason}";
        }
        
        $this->updateActivity($message);
        
        // Notificar administradores
        Notification::createForAdmins([
            'title' => 'Projeto Rejeitado',
            'message' => "O cliente rejeitou o projeto: {$this->name}",
            'type' => Notification::TYPE_WARNING,
            'url' => route('admin.client-projects.show', $this->id),
            'data' => [
                'project_id' => $this->id,
                'client_id' => $this->user_id,
                'action' => 'rejected',
                'reason' => $reason
            ]
        ]);
    }
}
