<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public User $client;
    public string $password;
    public string $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $client, string $password, string $resetUrl)
    {
        $this->client = $client;
        $this->password = $password;
        $this->resetUrl = $resetUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Suas credenciais de acesso - ' . (site_setting('name') ?? config('app.name')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.client-credentials',
            with: [
                'client' => $this->client,
                'password' => $this->password,
                'resetUrl' => $this->resetUrl,
                'loginUrl' => route('login'),
                'siteName' => site_setting('name') ?? config('app.name'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
} 