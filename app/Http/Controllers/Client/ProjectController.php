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

    /**
     * Aprovar projeto
     */
    public function approve(ClientProject $project)
    {
        // Verificar se o projeto pertence ao cliente logado
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        // Verificar se o projeto está aguardando aprovação
        if ($project->status !== 'aguardando_aprovacao') {
            return redirect()->back()->with('error', 'Este projeto não pode ser aprovado no momento.');
        }
        
        try {
            $project->approve();
            
            return redirect()->back()->with('success', 'Projeto aprovado com sucesso! O desenvolvimento será iniciado em breve.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao aprovar projeto: ' . $e->getMessage());
        }
    }

    /**
     * Rejeitar projeto
     */
    public function reject(Request $request, ClientProject $project)
    {
        // Verificar se o projeto pertence ao cliente logado
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        // Verificar se o projeto está aguardando aprovação
        if ($project->status !== 'aguardando_aprovacao') {
            return redirect()->back()->with('error', 'Este projeto não pode ser rejeitado no momento.');
        }
        
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);
        
        try {
            $project->reject($request->input('reason'));
            
            return redirect()->back()->with('success', 'Projeto rejeitado. Nossa equipe entrará em contato para discutir alterações.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao rejeitar projeto: ' . $e->getMessage());
        }
    }
} 