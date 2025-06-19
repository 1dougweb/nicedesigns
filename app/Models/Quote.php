<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'requirements',
        'budget',
        'currency',
        'status',
        'services',
        'deliverables',
        'timeline',
        'payment_terms',
        'valid_until',
        'accepted_at',
        'rejected_at',
        'rejection_reason',
        'admin_notes',
        'client_notes',
        'discount_amount',
        'discount_percentage',
        'total_amount',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'deliverables' => 'array',
            'payment_terms' => 'array',
            'valid_until' => 'date',
            'accepted_at' => 'datetime',
            'rejected_at' => 'datetime',
            'budget' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Status labels
     */
    public static function getStatusLabels(): array
    {
        return [
            'pendente' => 'Pendente de Aprovação',
            'aceito' => 'Aceito pelo Cliente',
            'rejeitado' => 'Rejeitado pelo Cliente',
            'expirado' => 'Expirado',
            'cancelado' => 'Cancelado',
        ];
    }

    /**
     * Status colors
     */
    public static function getStatusColors(): array
    {
        return [
            'pendente' => 'yellow',
            'aceito' => 'green',
            'rejeitado' => 'red',
            'expirado' => 'gray',
            'cancelado' => 'red',
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
     * Get formatted budget
     */
    public function getFormattedBudgetAttribute(): string
    {
        $currency = $this->currency ?? 'BRL';
        $symbol = match($currency) {
            'BRL' => 'R$',
            'USD' => '$',
            'EUR' => '€',
            default => $currency
        };
        
        return $symbol . ' ' . number_format($this->budget, 2, ',', '.');
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        $currency = $this->currency ?? 'BRL';
        $symbol = match($currency) {
            'BRL' => 'R$',
            'USD' => '$',
            'EUR' => '€',
            default => $currency
        };
        
        return $symbol . ' ' . number_format($this->total_amount, 2, ',', '.');
    }

    /**
     * Check if quote is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->valid_until && $this->valid_until->isPast() && $this->status === 'pendente';
    }

    /**
     * Check if quote is pending
     */
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pendente' && !$this->is_expired;
    }

    /**
     * Accept quote
     */
    public function accept(): void
    {
        $this->update([
            'status' => 'aceito',
            'accepted_at' => now(),
            'rejected_at' => null,
            'rejection_reason' => null,
        ]);
    }

    /**
     * Reject quote
     */
    public function reject(string $reason = null): void
    {
        $this->update([
            'status' => 'rejeitado',
            'rejected_at' => now(),
            'rejection_reason' => $reason,
            'accepted_at' => null,
        ]);
    }

    /**
     * Calculate total amount
     */
    public function calculateTotalAmount(): float
    {
        $total = $this->budget;
        
        if ($this->discount_amount) {
            $total -= $this->discount_amount;
        } elseif ($this->discount_percentage) {
            $total -= ($total * ($this->discount_percentage / 100));
        }
        
        return max(0, $total);
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clientProjects()
    {
        return $this->hasMany(ClientProject::class, 'quote_id');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pendente')
                    ->where(function($q) {
                        $q->whereNull('valid_until')
                          ->orWhere('valid_until', '>=', now());
                    });
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'aceito');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejeitado');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'pendente')
                    ->where('valid_until', '<', now());
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Boot method to auto-update status for expired quotes
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($quote) {
            // Auto-calculate total amount
            $quote->total_amount = $quote->calculateTotalAmount();
            
            // Auto-expire quotes
            if ($quote->status === 'pendente' && $quote->valid_until && $quote->valid_until->isPast()) {
                $quote->status = 'expirado';
            }
        });
    }
} 