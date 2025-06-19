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
use App\Models\Notification;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
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
            $emailSent = false;
            try {
                $this->configureEmail();
                $adminEmail = Setting::get('contact_email', 'admin@nicedesigns.com.br');
                Mail::to($adminEmail)->send(new ContactReceived($contact));
                $emailSent = true;
            } catch (\Exception $e) {
                // Log do erro mas não falha o processo de contato
                \Log::error('Erro ao enviar email de contato: ' . $e->getMessage());
            }

            // Criar notificação para todos os administradores
            try {
                Notification::createForAdmins([
                    'title' => 'Nova Mensagem de Contato',
                    'message' => "Nova mensagem de {$contact->name} ({$contact->email}): {$contact->subject}",
                    'type' => Notification::TYPE_NEW_CONTACT,
                    'url' => route('admin.contacts.show', $contact->id),
                    'data' => [
                        'contact_id' => $contact->id,
                        'contact_name' => $contact->name,
                        'contact_email' => $contact->email,
                        'subject' => $contact->subject
                    ]
                ]);
            } catch (\Exception $e) {
                \Log::error('Erro ao criar notificação de contato: ' . $e->getMessage());
            }

            // Determinar mensagem de sucesso baseada no envio do email
            $successMessage = $emailSent 
                ? 'Mensagem enviada com sucesso! Entraremos em contato em breve.'
                : 'Mensagem recebida! Entraremos em contato em breve. (Email temporariamente indisponível)';

            return redirect()->back()
                ->with('success', $successMessage);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to show proper error messages
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Erro geral no formulário de contato: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocorreu um erro ao enviar sua mensagem. Tente novamente ou entre em contato através dos outros canais.');
        }
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
