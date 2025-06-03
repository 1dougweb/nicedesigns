<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'client_project_id',
        'assigned_to',
        'subject',
        'description',
        'category',
        'status',
        'priority',
        'first_response_at',
        'last_response_at',
        'resolved_at',
        'closed_at',
        'satisfaction_rating',
        'feedback',
        'attachments',
        'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'first_response_at' => 'datetime',
            'last_response_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    /**
     * Status labels
     */
    public static function getStatusLabels(): array
    {
        return [
            'aberto' => 'Aberto',
            'em_andamento' => 'Em Andamento',
            'aguardando_cliente' => 'Aguardando Cliente',
            'resolvido' => 'Resolvido',
            'fechado' => 'Fechado',
        ];
    }

    /**
     * Status colors
     */
    public static function getStatusColors(): array
    {
        return [
            'aberto' => 'red',
            'em_andamento' => 'blue',
            'aguardando_cliente' => 'yellow',
            'resolvido' => 'green',
            'fechado' => 'gray',
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
     * Category labels
     */
    public static function getCategoryLabels(): array
    {
        return [
            'suporte_tecnico' => 'Suporte Técnico',
            'bug_report' => 'Relatório de Bug',
            'nova_funcionalidade' => 'Nova Funcionalidade',
            'duvida' => 'Dúvida',
            'alteracao_projeto' => 'Alteração de Projeto',
            'financeiro' => 'Financeiro',
            'outro' => 'Outro',
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
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::getCategoryLabels()[$this->category] ?? $this->category;
    }

    /**
     * Generate ticket number
     */
    public static function generateTicketNumber(): string
    {
        $year = date('Y');
        $sequence = self::whereRaw('YEAR(created_at) = ?', [$year])->count() + 1;
        
        return sprintf('TK%s%05d', $year, $sequence);
    }

    /**
     * Get response time in hours
     */
    public function getResponseTimeAttribute(): ?int
    {
        if (!$this->first_response_at) return null;

        return $this->created_at->diffInHours($this->first_response_at);
    }

    /**
     * Get resolution time in hours
     */
    public function getResolutionTimeAttribute(): ?int
    {
        if (!$this->resolved_at) return null;

        return $this->created_at->diffInHours($this->resolved_at);
    }

    /**
     * Check if ticket is overdue (no response in 24h for urgent, 48h for others)
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'fechado' || $this->first_response_at) return false;

        $maxHours = $this->priority === 'urgente' ? 24 : 48;
        
        return $this->created_at->diffInHours(now()) > $maxHours;
    }

    /**
     * Get SLA status
     */
    public function getSlaStatusAttribute(): string
    {
        if ($this->status === 'fechado') return 'completed';
        if ($this->is_overdue) return 'breached';
        
        $maxHours = $this->priority === 'urgente' ? 24 : 48;
        $elapsed = $this->created_at->diffInHours(now());
        
        if ($elapsed > $maxHours * 0.8) return 'warning';
        
        return 'on_track';
    }

    /**
     * Add reply to ticket
     */
    public function addReply(User $user, string $message, array $attachments = [], bool $isInternal = false): TicketReply
    {
        $reply = $this->replies()->create([
            'user_id' => $user->id,
            'message' => $message,
            'attachments' => $attachments,
            'is_internal' => $isInternal,
        ]);

        // Update first response time if this is the first response from admin
        if (!$this->first_response_at && $user->isAdmin()) {
            $this->update(['first_response_at' => now()]);
        }

        // Update last response time
        $this->update(['last_response_at' => now()]);

        return $reply;
    }

    /**
     * Assign ticket to user
     */
    public function assignTo(User $user): void
    {
        $this->update([
            'assigned_to' => $user->id,
            'status' => 'em_andamento',
        ]);
    }

    /**
     * Mark as resolved
     */
    public function markAsResolved(): void
    {
        $this->update([
            'status' => 'resolvido',
            'resolved_at' => now(),
        ]);
    }

    /**
     * Close ticket
     */
    public function close(): void
    {
        $this->update([
            'status' => 'fechado',
            'closed_at' => now(),
        ]);
    }

    /**
     * Reopen ticket
     */
    public function reopen(): void
    {
        $this->update([
            'status' => 'aberto',
            'resolved_at' => null,
            'closed_at' => null,
        ]);
    }

    /**
     * Rate satisfaction
     */
    public function rateSatisfaction(int $rating, string $feedback = null): void
    {
        $this->update([
            'satisfaction_rating' => $rating,
            'feedback' => $feedback,
        ]);
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clientProject()
    {
        return $this->belongsTo(ClientProject::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function publicReplies()
    {
        return $this->hasMany(TicketReply::class)->where('is_internal', false);
    }

    /**
     * Scopes
     */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['aberto', 'em_andamento', 'aguardando_cliente']);
    }

    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['resolvido', 'fechado']);
    }

    public function scopeOverdue($query)
    {
        return $query->where(function($q) {
            $q->where('priority', 'urgente')
              ->where('created_at', '<', now()->subHours(24));
        })->orWhere(function($q) {
            $q->where('priority', '!=', 'urgente')
              ->where('created_at', '<', now()->subHours(48));
        })->whereNull('first_response_at')
          ->whereNotIn('status', ['resolvido', 'fechado']);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }
}
