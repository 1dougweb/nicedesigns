<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePaymentGenerated extends Mailable
{
    use Queueable, SerializesModels;

    private Invoice $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $siteName = Setting::get('site_name', 'Nice Designs');
        
        return new Envelope(
            from: [
                'address' => Setting::get('smtp_from_email', config('mail.from.address')),
                'name' => Setting::get('smtp_from_name', $siteName)
            ],
            replyTo: [
                'address' => Setting::get('contact_email', Setting::get('smtp_from_email')),
                'name' => $siteName
            ],
            subject: "Fatura {$this->invoice->invoice_number} - Formas de Pagamento Disponíveis"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-payment-generated',
            with: [
                'invoice' => $this->invoice,
                'client' => $this->invoice->user,
                'siteName' => Setting::get('site_name', 'Nice Designs'),
                'siteUrl' => Setting::get('site_url', url('/')),
                'contactEmail' => Setting::get('contact_email'),
                'contactPhone' => Setting::get('contact_phone'),
                'contactWhatsapp' => Setting::get('contact_whatsapp'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
} 