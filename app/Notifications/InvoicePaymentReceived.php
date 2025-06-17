<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected Invoice $invoice
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
        return (new MailMessage)
            ->subject("Pagamento Recebido - Fatura #{$this->invoice->invoice_number}")
            ->greeting("Olá {$notifiable->full_name},")
            ->line("Confirmamos o recebimento do pagamento da fatura #{$this->invoice->invoice_number}.")
            ->line("Valor: {$this->invoice->formatted_total_amount}")
            ->line("Data do pagamento: {$this->invoice->formatted_paid_date}")
            ->line("Método de pagamento: {$this->invoice->payment_method_label}")
            ->action('Ver Fatura', url("/client/invoices/{$this->invoice->id}"))
            ->line('Agradecemos pela confiança e preferência!');
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
            'payment_method' => $this->invoice->payment_method,
            'payment_reference' => $this->invoice->payment_reference,
            'paid_date' => $this->invoice->paid_date ? $this->invoice->paid_date->format('Y-m-d') : null,
        ];
    }
}
