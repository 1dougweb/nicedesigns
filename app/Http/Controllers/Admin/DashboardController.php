<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Page;
use App\Models\ClientProject;
use App\Models\Invoice;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Estatísticas gerais
        $stats = [
            'posts' => [
                'total' => Post::count(),
                'published' => Post::published()->count(),
                'drafts' => Post::where('is_published', false)->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'published' => Project::published()->count(),
                'featured' => Project::featured()->count(),
            ],
            'contacts' => [
                'total' => Contact::count(),
                'new' => Contact::where('status', 'new')->count(),
                'in_progress' => Contact::where('status', 'in_progress')->count(),
                'completed' => Contact::where('status', 'completed')->count(),
            ],
            'categories' => [
                'total' => Category::count(),
                'active' => Category::where('is_active', true)->count(),
            ],
            'pages' => Page::count(),
            // Novas estatísticas de cliente
            'client_projects' => [
                'total' => ClientProject::count(),
                'active' => ClientProject::active()->count(),
                'completed' => ClientProject::completed()->count(),
                'overdue' => ClientProject::overdue()->count(),
            ],
            'invoices' => [
                'total' => Invoice::count(),
                'pending' => Invoice::pending()->count(),
                'paid' => Invoice::paid()->count(),
                'overdue' => Invoice::overdue()->count(),
                'total_amount' => Invoice::sum('total_amount'),
                'pending_amount' => Invoice::pending()->sum('total_amount'),
            ],
            'support_tickets' => [
                'total' => SupportTicket::count(),
                'open' => SupportTicket::open()->count(),
                'pending_response' => SupportTicket::where('status', 'aguardando_cliente')->count(),
                'resolved_today' => SupportTicket::whereDate('resolved_at', today())->count(),
            ],
            'clients' => [
                'total' => User::clients()->count(),
                'active' => User::clients()->whereHas('clientProjects', function($q) {
                    $q->active();
                })->count(),
            ],
        ];

        // Atividades recentes
        $recentPosts = Post::with(['category', 'author'])
            ->latest()
            ->take(5)
            ->get();

        $recentProjects = Project::with(['category', 'creator'])
            ->latest()
            ->take(5)
            ->get();

        $recentContacts = Contact::latest()
            ->take(5)
            ->get();

        // Novas atividades de cliente
        $recentClientProjects = ClientProject::with(['user', 'project'])
            ->latest()
            ->take(5)
            ->get();

        $recentInvoices = Invoice::with(['user', 'clientProject'])
            ->latest()
            ->take(5)
            ->get();

        $recentTickets = SupportTicket::with(['user', 'assignedUser'])
            ->latest()
            ->take(5)
            ->get();

        // Tickets que precisam de atenção
        $urgentTickets = SupportTicket::with(['user'])
            ->where('priority', 'urgente')
            ->open()
            ->latest()
            ->take(3)
            ->get();

        // Faturas vencendo em breve
        $upcomingInvoices = Invoice::with(['user'])
            ->where('status', 'pendente')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'recentProjects',
            'recentContacts',
            'recentClientProjects',
            'recentInvoices',
            'recentTickets',
            'urgentTickets',
            'upcomingInvoices'
        ));
    }
}
