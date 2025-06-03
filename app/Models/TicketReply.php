<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'message',
        'attachments',
        'type',
        'is_internal',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'is_internal' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Type labels
     */
    public static function getTypeLabels(): array
    {
        return [
            'reply' => 'Resposta',
            'resposta' => 'Resposta',
            'pergunta' => 'Pergunta',
            'atualizacao' => 'Atualização',
            'resolucao' => 'Resolução',
            'internal_note' => 'Nota Interna',
            'status_change' => 'Mudança de Status',
        ];
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute(): string
    {
        return self::getTypeLabels()[$this->type] ?? $this->type;
    }

    /**
     * Check if reply is from admin
     */
    public function getIsFromAdminAttribute(): bool
    {
        return $this->user->isAdmin();
    }

    /**
     * Check if reply is from client
     */
    public function getIsFromClientAttribute(): bool
    {
        return $this->user->isClient();
    }

    /**
     * Get formatted created time
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Mark as read
     */
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Check if reply is read
     */
    public function getIsReadAttribute(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Get formatted message with line breaks
     */
    public function getFormattedMessageAttribute(): string
    {
        return nl2br(e($this->message));
    }

    /**
     * Relationships
     */
    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    public function scopeFromAdmin($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('role', 'admin');
        });
    }

    public function scopeFromClient($query)
    {
        return $query->whereHas('user', function($q) {
            $q->where('role', 'client');
        });
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
