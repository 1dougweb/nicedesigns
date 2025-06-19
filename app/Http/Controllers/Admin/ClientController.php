<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Mail\ClientCredentials;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(Request $request): View
    {
        $query = User::clients()->with(['clientProjects', 'invoices', 'quotes']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->whereHas('clientProjects', function($q) {
                    $q->active();
                });
            } elseif ($status === 'inactive') {
                $query->whereDoesntHave('clientProjects', function($q) {
                    $q->active();
                });
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['full_name', 'email', 'created_at', 'company_name'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $clients = $query->paginate(20)->withQueryString();

        // Statistics
        $stats = [
            'total' => User::clients()->count(),
            'active' => User::clients()->whereHas('clientProjects', function($q) {
                $q->active();
            })->count(),
            'new_this_month' => User::clients()->whereMonth('created_at', now()->month)->count(),
            'with_projects' => User::clients()->whereHas('clientProjects')->count(),
        ];

        return view('admin.clients.index', compact('clients', 'stats'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'send_credentials' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Generate random password
            $password = $this->generateRandomPassword();
            
            // Create user (perfil básico - cliente completará depois)
            $client = User::create([
                'full_name' => $validated['full_name'],
                'name' => explode(' ', $validated['full_name'])[0],
                'email' => $validated['email'],
                'company_name' => $validated['company_name'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'role' => 'client',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                // Não marca profile_completed_at - cliente deve completar
            ]);

            // Send credentials email if requested
            if ($request->boolean('send_credentials')) {
                $this->sendCredentialsEmail($client, $password);
            }

            // Create welcome notification for client
            Notification::create([
                'user_id' => $client->id,
                'title' => 'Bem-vindo!',
                'message' => 'Sua conta foi criada com sucesso. Você pode acessar seu painel de cliente agora.',
                'type' => Notification::TYPE_SYSTEM,
                'url' => route('client.dashboard'),
                'data' => [
                    'action' => 'account_created',
                    'welcome' => true
                ]
            ]);

            DB::commit();

            $message = 'Cliente criado com sucesso!';
            if ($request->boolean('send_credentials')) {
                $message .= ' Email com credenciais foi enviado.';
            }

            return redirect()
                ->route('admin.clients.show', $client)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao criar cliente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified client.
     */
    public function show(User $client): View
    {
        // Ensure the user is a client
        if ($client->role !== 'client') {
            abort(404);
        }

        $client->load([
            'clientProjects.project',
            'invoices' => function($query) {
                $query->latest()->take(10);
            },
            'quotes' => function($query) {
                $query->latest()->take(10);
            },
            'supportTickets' => function($query) {
                $query->latest()->take(5);
            }
        ]);

        // Client statistics
        $stats = [
            'projects' => [
                'total' => $client->clientProjects()->count(),
                'active' => $client->clientProjects()->active()->count(),
                'completed' => $client->clientProjects()->completed()->count(),
            ],
            'invoices' => [
                'total' => $client->invoices()->count(),
                'paid' => $client->invoices()->paid()->count(),
                'pending' => $client->invoices()->pending()->count(),
                'total_amount' => $client->invoices()->sum('total_amount'),
            ],
            'quotes' => [
                'total' => $client->quotes()->count(),
                'pending' => $client->quotes()->pending()->count(),
                'accepted' => $client->quotes()->accepted()->count(),
            ],
            'tickets' => [
                'total' => $client->supportTickets()->count(),
                'open' => $client->supportTickets()->open()->count(),
            ]
        ];

        return view('admin.clients.show', compact('client', 'stats'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(User $client): View
    {
        // Ensure the user is a client
        if ($client->role !== 'client') {
            abort(404);
        }

        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, User $client): RedirectResponse
    {
        // Ensure the user is a client
        if ($client->role !== 'client') {
            abort(404);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($client->id)],
            'person_type' => 'required|in:fisica,juridica',
            'document' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($client->id)],
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'address_number' => 'nullable|string|max:20',
            'address_complement' => 'nullable|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ]);

        // Limpar documento
        $validated['document'] = preg_replace('/\D/', '', $validated['document']);

        // Validar documento (CPF ou CNPJ)
        if ($validated['person_type'] === 'fisica') {
            if (!User::validateCPF($validated['document'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['document' => 'CPF inválido.']);
            }
        } elseif ($validated['person_type'] === 'juridica') {
            if (!User::validateCNPJ($validated['document'])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['document' => 'CNPJ inválido.']);
            }
        }

        // Update name field based on full_name
        $validated['name'] = explode(' ', $validated['full_name'])[0];

        // Marcar perfil como completo se foi preenchido pelo admin
        if ($client->isProfileComplete()) {
            $validated['profile_completed_at'] = now();
        }

        $client->update($validated);

        return redirect()
            ->route('admin.clients.show', $client)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(User $client): RedirectResponse
    {
        // Ensure the user is a client
        if ($client->role !== 'client') {
            abort(404);
        }

        // Check if client has active projects or pending invoices
        if ($client->clientProjects()->active()->exists()) {
            return redirect()
                ->route('admin.clients.show', $client)
                ->with('error', 'Não é possível excluir cliente com projetos ativos.');
        }

        if ($client->invoices()->pending()->exists()) {
            return redirect()
                ->route('admin.clients.show', $client)
                ->with('error', 'Não é possível excluir cliente com faturas pendentes.');
        }

        try {
            DB::beginTransaction();

            // Delete related data
            $client->notifications()->delete();
            $client->supportTickets()->delete();
            
            // Delete client
            $client->delete();

            DB::commit();

            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Cliente excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->route('admin.clients.show', $client)
                ->with('error', 'Erro ao excluir cliente: ' . $e->getMessage());
        }
    }

    /**
     * Send password reset link to client
     */
    public function sendPasswordReset(User $client): RedirectResponse
    {
        if ($client->role !== 'client') {
            abort(404);
        }

        try {
            $token = Password::createToken($client);
            $resetUrl = route('password.reset', ['token' => $token, 'email' => $client->email]);
            
            Mail::to($client->email)->send(new \App\Mail\PasswordResetMail($client, $resetUrl));

            return redirect()
                ->back()
                ->with('success', 'Link de redefinição de senha enviado com sucesso!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao enviar link de redefinição: ' . $e->getMessage());
        }
    }

    /**
     * Resend credentials to client
     */
    public function resendCredentials(User $client): RedirectResponse
    {
        // Ensure the user is a client
        if ($client->role !== 'client') {
            abort(404);
        }

        try {
            // Generate new password
            $password = $this->generateRandomPassword();
            
            // Update client password
            $client->update([
                'password' => Hash::make($password)
            ]);

            // Send new credentials
            $this->sendCredentialsEmail($client, $password);

            return redirect()
                ->route('admin.clients.show', $client)
                ->with('success', 'Novas credenciais enviadas com sucesso!');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.clients.show', $client)
                ->with('error', 'Erro ao enviar credenciais: ' . $e->getMessage());
        }
    }

    /**
     * Generate random password
     */
    private function generateRandomPassword(): string
    {
        return Str::random(12);
    }

    /**
     * Send credentials email to client
     */
    private function sendCredentialsEmail(User $client, string $password): void
    {
        $resetToken = Password::createToken($client);
        $resetUrl = route('password.reset', ['token' => $resetToken, 'email' => $client->email]);
        
        Mail::to($client->email)->send(new ClientCredentials($client, $password, $resetUrl));
    }
} 