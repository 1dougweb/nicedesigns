<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Invoice $invoice,
        protected string $oldStatus,
        protected string $newStatus
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusLabels = Invoice::getStatusLabels();
        $oldStatusLabel = $statusLabels[$this->oldStatus] ?? ucfirst($this->oldStatus);
        $newStatusLabel = $statusLabels[$this->newStatus] ?? ucfirst($this->newStatus);
        
        $message = (new MailMessage)
            ->subject("Fatura #{$this->invoice->invoice_number} - Status Atualizado")
            ->greeting("Olá {$notifiable->full_name},")
            ->line("O status da sua fatura #{$this->invoice->invoice_number} foi atualizado.");

        // Mensagem personalizada baseada no status
        if ($this->newStatus === 'paga') {
            $message->line("Agradecemos pelo pagamento! Sua fatura foi marcada como paga.");
        } elseif ($this->newStatus === 'vencida') {
            $message->line("Sua fatura está vencida. Por favor, efetue o pagamento o mais breve possível para evitar cobranças adicionais.");
        } elseif ($this->newStatus === 'pendente') {
            $message->line("Sua fatura está pendente de pagamento.");
        } elseif ($this->newStatus === 'cancelada') {
            $message->line("Sua fatura foi cancelada.");
        }

        return $message
            ->line("Status anterior: {$oldStatusLabel}")
            ->line("Novo status: {$newStatusLabel}")
            ->line("Valor total: {$this->invoice->formatted_total_amount}")
            ->action('Ver Fatura', url("/client/invoices/{$this->invoice->id}"))
            ->line('Obrigado por utilizar nossos serviços!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'total_amount' => $this->invoice->total_amount,
            'currency' => $this->invoice->currency,
            'due_date' => $this->invoice->due_date ? $this->invoice->due_date->format('Y-m-d') : null,
        ];
    }
}
