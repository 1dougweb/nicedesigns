<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use App\Models\Invoice;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        
        // Estatísticas dos projetos
        $totalProjects = $user->clientProjects()->count();
        $activeProjects = $user->clientProjects()->active()->count();
        $completedProjects = $user->clientProjects()->completed()->count();
        
        // Estatísticas das faturas
        $totalInvoices = $user->invoices()->count();
        $pendingInvoices = $user->invoices()->where('status', 'pendente')->count();
        $paidInvoices = $user->invoices()->where('status', 'paga')->count();
        $overdueInvoices = $user->invoices()->where('status', 'vencida')->count();
        $totalAmountDue = $user->invoices()->whereIn('status', ['pendente', 'vencida'])->sum('total_amount');
        
        // Estatísticas do suporte
        $totalTickets = $user->supportTickets()->count();
        $openTickets = $user->supportTickets()->whereIn('status', ['aberto', 'em_andamento'])->count();
        $closedTickets = $user->supportTickets()->whereIn('status', ['resolvido', 'fechado'])->count();
        
        // Consolidar estatísticas
        $stats = [
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'completed_projects' => $completedProjects,
            
            'total_invoices' => $totalInvoices,
            'pending_invoices' => $pendingInvoices,
            'paid_invoices' => $paidInvoices,
            'overdue_invoices' => $overdueInvoices,
            'total_amount_due' => $totalAmountDue,
            
            'total_tickets' => $totalTickets,
            'open_tickets' => $openTickets,
            'closed_tickets' => $closedTickets,
        ];
        
        // Projetos recentes (em andamento)
        $recentProjects = $user->clientProjects()
            ->active()
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();
        
        // Atividades recentes (baseadas em atualizações de projetos, faturas e tickets)
        $recentActivities = collect();
        
        // Últimos projetos atualizados
        $projectUpdates = $user->clientProjects()
            ->whereNotNull('last_update')
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($project) {
                return [
                    'type' => 'project_update',
                    'title' => 'Projeto ' . $project->name . ' atualizado',
                    'description' => $project->last_update ?: 'Progresso atualizado',
                    'time' => $project->updated_at,
                    'icon' => 'project',
                    'color' => 'green'
                ];
            });
        
        // Últimas faturas criadas
        $invoiceUpdates = $user->invoices()
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($invoice) {
                return [
                    'type' => 'invoice_created',
                    'title' => 'Nova fatura gerada',
                    'description' => 'Fatura #' . ($invoice->invoice_number ?? $invoice->id) . ' - R$ ' . number_format($invoice->total_amount, 2, ',', '.'),
                    'time' => $invoice->created_at,
                    'icon' => 'invoice',
                    'color' => 'blue'
                ];
            });
        
        // Últimos tickets respondidos/criados
        $ticketUpdates = $user->supportTickets()
            ->orderBy('updated_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($ticket) {
                return [
                    'type' => 'ticket_update',
                    'title' => 'Ticket de suporte ' . ($ticket->status === 'resolvido' ? 'resolvido' : 'atualizado'),
                    'description' => $ticket->subject,
                    'time' => $ticket->updated_at,
                    'icon' => 'support',
                    'color' => $ticket->status === 'resolvido' ? 'green' : 'purple'
                ];
            });
        
        // Combinar e ordenar atividades por data
        $recentActivities = $projectUpdates
            ->merge($invoiceUpdates)
            ->merge($ticketUpdates)
            ->sortByDesc('time')
            ->take(5);
        
        return view('client.dashboard', compact('stats', 'recentProjects', 'recentActivities'));
    }

    public function projects(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        
        $query = $user->clientProjects()->with(['project']);
        
        if ($status && $status !== 'todos') {
            $query->byStatus($status);
        }
        
        $projects = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Opções de status para filtro
        $statusOptions = ClientProject::getStatusLabels();
        
        return view('client.projects.index', compact('projects', 'statusOptions', 'status'));
    }

    public function showProject(ClientProject $project): View
    {
        // Verificar se o projeto pertence ao cliente logado
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $project->load(['project', 'invoices', 'supportTickets']);
        
        return view('client.projects.show', compact('project'));
    }

    public function invoices(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        
        $query = $user->invoices()->with(['clientProject']);
        
        if ($status && $status !== 'todas') {
            $query->byStatus($status);
        }
        
        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Opções de status para filtro
        $statusOptions = Invoice::getStatusLabels();
        
        // Estatísticas das faturas
        $invoiceStats = [
            'total_amount' => $user->invoices()->sum('total_amount'),
            'paid_amount' => $user->invoices()->paid()->sum('total_amount'),
            'pending_amount' => $user->invoices()->pending()->sum('total_amount'),
            'overdue_amount' => $user->invoices()->overdue()->sum('total_amount'),
        ];
        
        return view('client.invoices.index', compact('invoices', 'statusOptions', 'status', 'invoiceStats'));
    }

    public function showInvoice(Invoice $invoice): View
    {
        // Verificar se a fatura pertence ao cliente logado
        if ($invoice->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $invoice->load(['clientProject']);
        
        return view('client.invoices.show', compact('invoice'));
    }

    public function support(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        $priority = $request->get('priority');
        
        $query = $user->supportTickets()->with(['clientProject', 'assignedUser']);
        
        if ($status && $status !== 'todos') {
            $query->byStatus($status);
        }
        
        if ($priority && $priority !== 'todas') {
            $query->byPriority($priority);
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Opções para filtros
        $statusOptions = SupportTicket::getStatusLabels();
        $priorityOptions = SupportTicket::getPriorityLabels();
        
        return view('client.support.index', compact('tickets', 'statusOptions', 'priorityOptions', 'status', 'priority'));
    }

    public function showTicket(SupportTicket $ticket): View
    {
        // Verificar se o ticket pertence ao cliente logado
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $ticket->load(['clientProject', 'assignedUser', 'replies.user']);
        
        // Marcar replies como lidas
        $ticket->replies()->whereNull('read_at')->update(['read_at' => now()]);
        
        return view('client.support.show', compact('ticket'));
    }

    public function profile(): View
    {
        $user = Auth::user();
        
        return view('client.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'person_type' => 'required|in:fisica,juridica',
            'document' => 'required|string',
            'phone' => 'required|string',
            'whatsapp' => 'nullable|string',
            'zip_code' => 'required|string|size:8',
            'address' => 'required|string|max:255',
            'address_number' => 'required|string|max:20',
            'address_complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|size:2',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        // Validar CPF ou CNPJ
        $document = preg_replace('/\D/', '', $request->document);
        if ($request->person_type === 'fisica') {
            if (!$user::validateCPF($document)) {
                return back()->withErrors(['document' => 'CPF inválido.']);
            }
        } else {
            if (!$user::validateCNPJ($document)) {
                return back()->withErrors(['document' => 'CNPJ inválido.']);
            }
        }
        
        // Atualizar dados
        $user->update($request->all());
        
        // Marcar perfil como completo se necessário
        if ($user->isProfileComplete() && !$user->profile_completed_at) {
            $user->update(['profile_completed_at' => now()]);
        }
        
        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Senha atual incorreta.']);
        }
        
        $user->update(['password' => Hash::make($request->password)]);
        
        return back()->with('success', 'Senha alterada com sucesso!');
    }
}
