<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_project_id',
        'invoice_number',
        'title',
        'description',
        'subtotal',
        'discount',
        'tax_rate',
        'tax_amount',
        'total_amount',
        'currency',
        'status',
        'issue_date',
        'due_date',
        'paid_date',
        'payment_method',
        'payment_reference',
        'payment_notes',
        'pdf_path',
        'attachments',
        'notes',
        'payment_instructions',
        // Campos PagarMe
        'pagarme_charge_id',
        'pagarme_transaction_id',
        'pagarme_status',
        'pagarme_data',
        'payment_url',
        'boleto_url',
        'boleto_barcode',
        'pix_qr_code',
        'pix_code',
        'auto_charge_enabled',
        'auto_charge_date',
        'webhook_received_at',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'pagarme_data' => 'array',
            'issue_date' => 'date',
            'due_date' => 'date',
            'paid_date' => 'date',
            'auto_charge_date' => 'date',
            'webhook_received_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'auto_charge_enabled' => 'boolean',
        ];
    }

    /**
     * Status labels
     */
    public static function getStatusLabels(): array
    {
        return [
            'pendente' => 'Pendente',
            'paga' => 'Paga',
            'vencida' => 'Vencida',
            'cancelada' => 'Cancelada',
            'parcial' => 'Parcialmente Paga',
        ];
    }

    /**
     * Status colors
     */
    public static function getStatusColors(): array
    {
        return [
            'pendente' => 'yellow',
            'paga' => 'green',
            'vencida' => 'red',
            'cancelada' => 'gray',
            'parcial' => 'orange',
        ];
    }

    /**
     * Payment method labels
     */
    public static function getPaymentMethodLabels(): array
    {
        return [
            'pix' => 'PIX',
            'boleto' => 'Boleto',
            'transferencia' => 'Transferência',
            'cartao' => 'Cartão',
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
     * Get payment method label
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        if (!$this->payment_method) return 'Não informado';
        return self::getPaymentMethodLabels()[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Get formatted amounts
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return $this->formatCurrency($this->subtotal);
    }

    public function getFormattedDiscountAttribute(): string
    {
        return $this->formatCurrency($this->discount);
    }

    public function getFormattedTaxAmountAttribute(): string
    {
        return $this->formatCurrency($this->tax_amount);
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return $this->formatCurrency($this->total_amount);
    }

    /**
     * Format currency value
     */
    private function formatCurrency($amount): string
    {
        $currencies = [
            'BRL' => 'R$',
            'USD' => '$',
            'EUR' => '€',
        ];

        $symbol = $currencies[$this->currency] ?? $this->currency;
        
        return $symbol . ' ' . number_format($amount, 2, ',', '.');
    }

    /**
     * Get days until due date
     */
    public function getDaysUntilDueAttribute(): ?int
    {
        if (!$this->due_date || $this->status === 'paga') return null;

        return Carbon::now()->diffInDays($this->due_date, false);
    }

    /**
     * Check if invoice is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && 
               Carbon::now()->isAfter($this->due_date) && 
               !in_array($this->status, ['paga', 'cancelada']);
    }

    /**
     * Get due status
     */
    public function getDueStatusAttribute(): string
    {
        if ($this->status === 'paga') return 'paid';
        if ($this->is_overdue) return 'overdue';
        
        $daysUntilDue = $this->days_until_due;
        if ($daysUntilDue !== null && $daysUntilDue <= 3) return 'due_soon';
        
        return 'pending';
    }

    /**
     * Calculate totals
     */
    public function calculateTotals(): void
    {
        // Calculate tax amount
        $this->tax_amount = ($this->subtotal - $this->discount) * ($this->tax_rate / 100);
        
        // Calculate total
        $this->total_amount = $this->subtotal - $this->discount + $this->tax_amount;
    }

    /**
     * Generate invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        
        $lastInvoice = self::whereRaw('YEAR(created_at) = ?', [$year])
                          ->whereRaw('MONTH(created_at) = ?', [$month])
                          ->orderBy('id', 'desc')
                          ->first();

        $sequence = $lastInvoice ? 
                   (int) substr($lastInvoice->invoice_number, -4) + 1 : 1;

        return sprintf('NV%s%s%04d', $year, $month, $sequence);
    }

    /**
     * Mark as paid
     */
    public function markAsPaid(string $paymentMethod = null, string $reference = null): void
    {
        $this->update([
            'status' => 'paga',
            'paid_date' => now(),
            'payment_method' => $paymentMethod,
            'payment_reference' => $reference,
        ]);
    }

    /**
     * Update status based on due date
     */
    public function updateStatus(): void
    {
        if ($this->status !== 'pendente') return;

        if ($this->is_overdue) {
            $this->update(['status' => 'vencida']);
        }
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

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paga');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'vencida')
                    ->orWhere(function($q) {
                        $q->where('status', 'pendente')
                          ->where('due_date', '<', now());
                    });
    }

    public function scopeDueSoon($query)
    {
        return $query->where('status', 'pendente')
                    ->whereBetween('due_date', [now(), now()->addDays(3)]);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Métodos PagarMe
     */

    /**
     * Verificar se tem cobrança PagarMe ativa
     */
    public function hasPagarMeCharge(): bool
    {
        return !empty($this->pagarme_charge_id) || !empty($this->pagarme_transaction_id);
    }

    /**
     * Verificar se pode gerar cobrança automática
     */
    public function canAutoCharge(): bool
    {
        return $this->auto_charge_enabled && 
               $this->auto_charge_date &&
               $this->auto_charge_date->isToday() &&
               !$this->hasPagarMeCharge() &&
               in_array($this->status, ['pendente']);
    }

    /**
     * Marcar para cobrança automática
     */
    public function enableAutoCharge(\DateTime $chargeDate = null): void
    {
        $this->update([
            'auto_charge_enabled' => true,
            'auto_charge_date' => $chargeDate ?? $this->due_date,
        ]);
    }

    /**
     * Desabilitar cobrança automática
     */
    public function disableAutoCharge(): void
    {
        $this->update([
            'auto_charge_enabled' => false,
            'auto_charge_date' => null,
        ]);
    }

    /**
     * Tem boleto disponível
     */
    public function hasBoleto(): bool
    {
        return !empty($this->boleto_url);
    }

    /**
     * Tem PIX disponível
     */
    public function hasPix(): bool
    {
        return !empty($this->pix_qr_code) || !empty($this->pix_code);
    }

    /**
     * Status da cobrança PagarMe
     */
    public function getPagarMeStatusLabelAttribute(): string
    {
        if (!$this->pagarme_status) return 'Não enviado';

        return match($this->pagarme_status) {
            'paid' => 'Pago',
            'pending' => 'Pendente',
            'processing' => 'Processando',
            'waiting_payment' => 'Aguardando Pagamento',
            'canceled' => 'Cancelado',
            'failed' => 'Falhou',
            'refunded' => 'Estornado',
            default => ucfirst($this->pagarme_status)
        };
    }

    /**
     * Cor do status PagarMe
     */
    public function getPagarMeStatusColorAttribute(): string
    {
        if (!$this->pagarme_status) return 'gray';

        return match($this->pagarme_status) {
            'paid' => 'green',
            'pending', 'processing', 'waiting_payment' => 'yellow',
            'canceled', 'failed' => 'red',
            'refunded' => 'orange',
            default => 'gray'
        };
    }

    /**
     * Scopes para PagarMe
     */
    public function scopeWithPagarMeCharge($query)
    {
        return $query->whereNotNull('pagarme_charge_id')
                    ->orWhereNotNull('pagarme_transaction_id');
    }

    public function scopeAutoChargeReady($query)
    {
        return $query->where('auto_charge_enabled', true)
                    ->whereDate('auto_charge_date', '<=', now())
                    ->whereNull('pagarme_charge_id')
                    ->whereNull('pagarme_transaction_id')
                    ->where('status', 'pendente');
    }

    public function scopeNeedsBoleto($query)
    {
        return $query->where('status', 'pendente')
                    ->whereNull('boleto_url');
    }

    public function scopeNeedsPix($query)
    {
        return $query->where('status', 'pendente')
                    ->whereNull('pix_qr_code');
    }
}
