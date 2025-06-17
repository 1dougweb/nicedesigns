<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceDueReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Invoice $invoice,
        protected int $daysUntilDue
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
        $mailMessage = (new MailMessage)
            ->subject("Lembrete de Vencimento - Fatura #{$this->invoice->invoice_number}")
            ->greeting("Olá {$notifiable->full_name},");

        if ($this->daysUntilDue === 0) {
            $mailMessage->line("Sua fatura vence hoje!");
        } else {
            $mailMessage->line("Sua fatura vence em {$this->daysUntilDue} " . ($this->daysUntilDue === 1 ? 'dia' : 'dias') . ".");
        }

        return $mailMessage
            ->line("Número da fatura: {$this->invoice->invoice_number}")
            ->line("Valor: {$this->invoice->formatted_total_amount}")
            ->line("Data de vencimento: {$this->invoice->formatted_due_date}")
            ->action('Ver e Pagar Fatura', url("/client/invoices/{$this->invoice->id}"))
            ->line('Para evitar atrasos, pedimos que realize o pagamento até a data de vencimento.');
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
            'total_amount' => $this->invoice->total_amount,
            'currency' => $this->invoice->currency,
            'due_date' => $this->invoice->due_date ? $this->invoice->due_date->format('Y-m-d') : null,
            'days_until_due' => $this->daysUntilDue,
        ];
    }
}
