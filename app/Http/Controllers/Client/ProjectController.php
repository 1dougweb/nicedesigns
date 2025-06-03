<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        $priority = $request->get('priority');
        
        $query = $user->clientProjects()->with(['project']);
        
        if ($status && $status !== 'todos') {
            $query->byStatus($status);
        }
        
        if ($priority && $priority !== 'todas') {
            $query->byPriority($priority);
        }
        
        $projects = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Opções para filtros
        $statusOptions = ClientProject::getStatusLabels();
        $priorityOptions = ClientProject::getPriorityLabels();
        
        // Estatísticas dos projetos
        $stats = [
            'total' => $user->clientProjects()->count(),
            'active' => $user->clientProjects()->active()->count(),
            'completed' => $user->clientProjects()->completed()->count(),
            'overdue' => $user->clientProjects()->overdue()->count(),
        ];
        
        return view('client.projects.index', compact(
            'projects', 
            'statusOptions', 
            'priorityOptions', 
            'status', 
            'priority', 
            'stats'
        ));
    }

    public function show(ClientProject $project): View
    {
        // Verificar se o projeto pertence ao cliente logado
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $project->load(['project', 'invoices.invoice', 'supportTickets']);
        
        return view('client.projects.show', compact('project'));
    }
} 