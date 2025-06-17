<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Notifications\InvoiceStatusChanged;
use App\Notifications\InvoicePaymentReceived;
use Illuminate\Support\Facades\Notification;

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

        'auto_charge_enabled',
        'auto_charge_date',
        'webhook_received_at',

        // AbacatePay fields
        'abacatepay_billing_id',
        'abacatepay_customer_id',
        'abacatepay_status',
        'abacatepay_data',
        'payment_url',
        'pix_qr_code',
        'pix_qr_code_url',
        'boleto_url',
        'boleto_barcode',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'abacatepay_data' => 'array',

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
     * Verificar se pode gerar cobrança automática
     */
    public function canAutoCharge(): bool
    {
        return $this->auto_charge_enabled && 
               $this->auto_charge_date &&
               $this->auto_charge_date->isToday() &&
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

    public function scopeAutoChargeReady($query)
    {
        return $query->where('auto_charge_enabled', true)
                    ->whereDate('auto_charge_date', '<=', now())
                    ->where('status', 'pendente');
    }

    /**
     * AbacatePay Methods
     */
    
    /**
     * Verificar se tem cobrança AbacatePay ativa
     */
    public function hasAbacatePayCharge(): bool
    {
        return !empty($this->abacatepay_billing_id);
    }

    /**
     * Obter status da cobrança AbacatePay formatado
     */
    public function getAbacatePayStatusLabelAttribute(): string
    {
        if (!$this->abacatepay_status) {
            return 'Sem cobrança';
        }

        $statusLabels = [
            'pending' => 'Pendente',
            'waiting_payment' => 'Aguardando pagamento',
            'paid' => 'Pago',
            'completed' => 'Completo',
            'cancelled' => 'Cancelado',
            'expired' => 'Expirado',
            'failed' => 'Falhou',
        ];

        return $statusLabels[$this->abacatepay_status] ?? ucfirst($this->abacatepay_status);
    }

    /**
     * Obter cor do status AbacatePay
     */
    public function getAbacatePayStatusColorAttribute(): string
    {
        if (!$this->abacatepay_status) {
            return 'gray';
        }

        $statusColors = [
            'pending' => 'yellow',
            'waiting_payment' => 'blue',
            'paid' => 'green',
            'completed' => 'green',
            'cancelled' => 'gray',
            'expired' => 'red',
            'failed' => 'red',
        ];

        return $statusColors[$this->abacatepay_status] ?? 'gray';
    }

    /**
     * Verificar se pode gerar cobrança AbacatePay
     */
    public function canGenerateAbacatePayCharge(): bool
    {
        return in_array($this->status, ['pendente', 'vencida']) && 
               $this->total_amount > 0;
    }

    /**
     * Verificar se a cobrança AbacatePay está pendente
     */
    public function isAbacatePayPending(): bool
    {
        return $this->hasAbacatePayCharge() && 
               in_array($this->abacatepay_status, ['pending', 'waiting_payment']);
    }

    /**
     * Verificar se a cobrança AbacatePay foi paga
     */
    public function isAbacatePayPaid(): bool
    {
        return $this->hasAbacatePayCharge() && 
               in_array($this->abacatepay_status, ['paid', 'completed']);
    }

    /**
     * Obter URL do PIX QR Code se disponível
     */
    public function getPixQrCodeUrlAttribute(): ?string
    {
        return $this->pix_qr_code_url;
    }

    /**
     * Obter código PIX se disponível
     */
    public function getPixCodeAttribute(): ?string
    {
        return $this->pix_qr_code;
    }

    /**
     * Obter URL do boleto se disponível
     */
    public function getBoletoUrlAttribute(): ?string
    {
        return $this->boleto_url;
    }

    /**
     * Obter código de barras do boleto se disponível
     */
    public function getBoletoCodeAttribute(): ?string
    {
        return $this->boleto_barcode;
    }

    /**
     * Verificar se tem PIX disponível
     */
    public function hasPixAvailable(): bool
    {
        return !empty($this->pix_qr_code) || !empty($this->pix_qr_code_url);
    }

    /**
     * Verificar se tem boleto disponível
     */
    public function hasBoletoAvailable(): bool
    {
        return !empty($this->boleto_url);
    }

    /**
     * Get file URL for PDF attachment
     */
    public function getInvoiceFileUrlAttribute(): ?string
    {
        if (!$this->pdf_path) {
            return null;
        }
        
        if (filter_var($this->pdf_path, FILTER_VALIDATE_URL)) {
            return $this->pdf_path;
        }
        
        return asset('storage/' . $this->pdf_path);
    }

    /**
     * Check if the invoice has a PDF attached
     */
    public function getHasPdfAttribute(): bool
    {
        return !empty($this->pdf_path);
    }

    /**
     * Get formatted due date
     */
    public function getFormattedDueDateAttribute(): string
    {
        return $this->due_date ? $this->due_date->format('d/m/Y') : 'N/A';
    }

    /**
     * Get formatted issue date
     */
    public function getFormattedIssueDateAttribute(): string
    {
        return $this->issue_date ? $this->issue_date->format('d/m/Y') : 'N/A';
    }

    /**
     * Get formatted paid date
     */
    public function getFormattedPaidDateAttribute(): string
    {
        return $this->paid_date ? $this->paid_date->format('d/m/Y') : 'N/A';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::updating(function(Invoice $invoice) {
            // Se o status mudou, enviar notificação
            if ($invoice->isDirty('status') && $invoice->getOriginal('status') !== $invoice->status) {
                $oldStatus = $invoice->getOriginal('status');
                
                // Notificar cliente sobre mudança de status
                if ($invoice->user) {
                    $invoice->user->notify(new InvoiceStatusChanged(
                        $invoice,
                        $oldStatus,
                        $invoice->status
                    ));
                }
                
                // Notificar administrador quando o pagamento é recebido
                if ($invoice->status === 'paga' && $oldStatus !== 'paga') {
                    // Encontrar admins para notificar
                    $admins = User::where('is_admin', true)->get();
                    
                    // Notificar cliente que pagamento foi recebido
                    if ($invoice->user) {
                        $invoice->user->notify(new InvoicePaymentReceived($invoice));
                    }
                    
                    // Notificar admins
                    Notification::send($admins, new InvoicePaymentReceived($invoice));
                }
            }
        });
    }

    /**
     * Enviar lembrete de vencimento
     */
    public function sendDueReminder(int $daysUntilDue): void
    {
        if ($this->user) {
            $this->user->notify(new \App\Notifications\InvoiceDueReminder($this, $daysUntilDue));
        }
    }
}
