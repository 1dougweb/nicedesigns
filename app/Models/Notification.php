<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'color',
        'url',
        'data',
        'read_at',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Tipos de notificação
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';
    const TYPE_NEW_CONTACT = 'new_contact';
    const TYPE_NEW_PROJECT = 'new_project';
    const TYPE_PROJECT_APPROVED = 'project_approved';
    const TYPE_PROJECT_REJECTED = 'project_rejected';
    const TYPE_INVOICE_PAID = 'invoice_paid';
    const TYPE_SUPPORT_TICKET = 'support_ticket';

    /**
     * Relacionamento com usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marcar notificação como lida
     */
    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Verificar se a notificação foi lida
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Verificar se a notificação está expirada
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Scope para notificações não lidas
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope para notificações não expiradas
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope para notificações do usuário
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para notificações de administradores
     */
    public function scopeForAdmins($query)
    {
        return $query->where(function($q) {
            $q->whereNull('user_id') // Notificações globais
              ->orWhereHas('user', function($userQuery) {
                  $userQuery->where('role', 'admin');
              });
        });
    }

    /**
     * Scope para notificações de um tipo específico
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Obter ícone padrão baseado no tipo
     */
    public function getDefaultIcon(): string
    {
        return match ($this->type) {
            self::TYPE_SUCCESS => 'fi-rr-check-circle',
            self::TYPE_WARNING => 'fi-rr-exclamation-triangle',
            self::TYPE_ERROR => 'fi-rr-cross-circle',
            self::TYPE_NEW_CONTACT => 'fi-rr-envelope',
            self::TYPE_NEW_PROJECT => 'fi-rr-briefcase',
            self::TYPE_PROJECT_APPROVED => 'fi-rr-check-circle',
            self::TYPE_PROJECT_REJECTED => 'fi-rr-cross-circle',
            self::TYPE_INVOICE_PAID => 'fi-rr-money',
            self::TYPE_SUPPORT_TICKET => 'fi-rr-headset',
            default => 'fi-rr-info',
        };
    }

    /**
     * Obter cor padrão baseada no tipo
     */
    public function getDefaultColor(): string
    {
        return match ($this->type) {
            self::TYPE_SUCCESS => 'green',
            self::TYPE_WARNING => 'yellow',
            self::TYPE_ERROR => 'red',
            self::TYPE_NEW_CONTACT => 'blue',
            self::TYPE_NEW_PROJECT => 'purple',
            self::TYPE_PROJECT_APPROVED => 'green',
            self::TYPE_PROJECT_REJECTED => 'red',
            self::TYPE_INVOICE_PAID => 'emerald',
            self::TYPE_SUPPORT_TICKET => 'orange',
            default => 'gray',
        };
    }

    /**
     * Obter ícone (personalizado ou padrão)
     */
    public function getIconAttribute($value): string
    {
        if ($value) {
            return $value;
        }
        
        return $this->getDefaultIcon();
    }

    /**
     * Obter cor (personalizada ou padrão)
     */
    public function getColorAttribute($value): string
    {
        if ($value) {
            return $value;
        }
        
        return $this->getDefaultColor();
    }



    /**
     * Obter ícone para um tipo específico (método estático)
     */
    public static function getIconForType(string $type): string
    {
        return match ($type) {
            self::TYPE_SUCCESS => 'fi-rr-check-circle',
            self::TYPE_WARNING => 'fi-rr-exclamation-triangle',
            self::TYPE_ERROR => 'fi-rr-cross-circle',
            self::TYPE_NEW_CONTACT => 'fi-rr-envelope',
            self::TYPE_NEW_PROJECT => 'fi-rr-briefcase',
            self::TYPE_PROJECT_APPROVED => 'fi-rr-check-circle',
            self::TYPE_PROJECT_REJECTED => 'fi-rr-cross-circle',
            self::TYPE_INVOICE_PAID => 'fi-rr-money',
            self::TYPE_SUPPORT_TICKET => 'fi-rr-headset',
            default => 'fi-rr-info',
        };
    }

    /**
     * Obter cor para um tipo específico (método estático)
     */
    public static function getColorForType(string $type): string
    {
        return match ($type) {
            self::TYPE_SUCCESS => 'green',
            self::TYPE_WARNING => 'yellow',
            self::TYPE_ERROR => 'red',
            self::TYPE_NEW_CONTACT => 'blue',
            self::TYPE_NEW_PROJECT => 'purple',
            self::TYPE_PROJECT_APPROVED => 'green',
            self::TYPE_PROJECT_REJECTED => 'red',
            self::TYPE_INVOICE_PAID => 'emerald',
            self::TYPE_SUPPORT_TICKET => 'orange',
            default => 'gray',
        };
    }

    /**
     * Criar notificação para todos os administradores
     */
    public static function createForAdmins(array $data): void
    {
        $admins = User::where('role', 'admin')->get();

        // Auto-definir ícone e cor se não fornecidos
        if (!isset($data['icon']) && isset($data['type'])) {
            $data['icon'] = static::getIconForType($data['type']);
        }

        if (!isset($data['color']) && isset($data['type'])) {
            $data['color'] = static::getColorForType($data['type']);
        }

        foreach ($admins as $admin) {
            static::create(array_merge($data, ['user_id' => $admin->id]));
        }
    }

    /**
     * Limpar notificações expiradas
     */
    public static function cleanExpired(): int
    {
        return static::where('expires_at', '<', now())->delete();
    }
} 