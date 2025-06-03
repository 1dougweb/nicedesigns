<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactReceived;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $contact = Contact::create($validated);

        // Enviar email de notificação para o admin
        try {
            $this->configureEmail();
            $adminEmail = Setting::get('contact_email', 'admin@nicedesigns.com.br');
            Mail::to($adminEmail)->send(new ContactReceived($contact));
        } catch (\Exception $e) {
            // Log do erro mas não falha o processo de contato
            \Log::error('Erro ao enviar email de contato: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }

    /**
     * Configure email settings from database
     */
    private function configureEmail()
    {
        $emailSettings = Setting::where('group', 'email')->get()->keyBy('key');
        
        if ($emailSettings->isNotEmpty() && $emailSettings->get('smtp_username')?->value) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings->get('smtp_host')->value ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $emailSettings->get('smtp_port')->value ?? 587,
                'mail.mailers.smtp.username' => $emailSettings->get('smtp_username')->value,
                'mail.mailers.smtp.password' => $emailSettings->get('smtp_password')->value,
                'mail.mailers.smtp.encryption' => $emailSettings->get('smtp_encryption')->value ?? 'tls',
                'mail.from.address' => $emailSettings->get('mail_from_address')->value ?? 'noreply@nicedesigns.com.br',
                'mail.from.name' => $emailSettings->get('mail_from_name')->value ?? 'Nice Designs',
            ]);
        }
    }
}
