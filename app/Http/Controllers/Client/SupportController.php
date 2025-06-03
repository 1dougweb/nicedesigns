<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\ClientProject;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        $priority = $request->get('priority');
        
        $query = $user->supportTickets()->with(['clientProject'])->latest();
        
        if ($status && $status !== 'todos') {
            $query->where('status', $status);
        }
        
        if ($priority && $priority !== 'todas') {
            $query->where('priority', $priority);
        }
        
        $tickets = $query->paginate(12);
        
        // Estatísticas dos tickets
        $stats = [
            'total' => $user->supportTickets()->count(),
            'open' => $user->supportTickets()->where('status', 'aberto')->count(),
            'pending' => $user->supportTickets()->where('status', 'aguardando_cliente')->count(),
            'resolved' => $user->supportTickets()->where('status', 'resolvido')->count(),
            'closed' => $user->supportTickets()->where('status', 'fechado')->count(),
        ];
        
        // Opções para filtros
        $statusOptions = [
            'aberto' => 'Aberto',
            'em_andamento' => 'Em Andamento',
            'aguardando_cliente' => 'Aguardando Cliente',
            'resolvido' => 'Resolvido',
            'fechado' => 'Fechado',
        ];
        
        $priorityOptions = [
            'baixa' => 'Baixa',
            'normal' => 'Normal',
            'alta' => 'Alta',
            'urgente' => 'Urgente',
        ];
        
        return view('client.support.index', compact(
            'tickets', 
            'statusOptions', 
            'priorityOptions', 
            'status', 
            'priority', 
            'stats'
        ));
    }

    public function show(SupportTicket $ticket): View
    {
        // Verificar se o ticket pertence ao cliente logado
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $ticket->load([
            'clientProject', 
            'replies' => function($query) {
                $query->where('is_internal', false)->with('user')->orderBy('created_at', 'asc');
            }
        ]);
        
        return view('client.support.show', compact('ticket'));
    }

    public function create(): View
    {
        $user = Auth::user();
        $projects = $user->clientProjects()->get();
        
        return view('client.support.create', compact('projects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:baixa,normal,alta,urgente',
            'client_project_id' => 'nullable|exists:client_projects,id',
            'category' => 'required|in:suporte_tecnico,bug_report,nova_funcionalidade,duvida,alteracao_projeto,financeiro,outro',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'client_project_id' => $request->client_project_id,
            'category' => $request->category,
            'status' => 'aberto',
        ]);

        return redirect()->route('client.support.show', $ticket)
            ->with('success', 'Ticket criado com sucesso! Nossa equipe responderá em breve.');
    }

    public function reply(Request $request, SupportTicket $ticket): RedirectResponse
    {
        // Verificar se o ticket pertence ao cliente logado
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        // Verificar se o ticket não está fechado
        if ($ticket->status === 'fechado') {
            return back()->with('error', 'Não é possível responder a um ticket fechado.');
        }

        $validated = $request->validate([
            'message' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support-attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                ];
            }
        }

        // Criar a resposta
        $ticket->replies()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'type' => 'resposta',
            'is_internal' => false,
            'attachments' => $attachments,
        ]);

        // Atualizar o status do ticket se necessário
        if ($ticket->status === 'aguardando_cliente') {
            $ticket->update(['status' => 'em_andamento']);
        }

        // Atualizar timestamp de última resposta
        $ticket->update(['last_response_at' => now()]);

        return redirect()->route('client.support.show', $ticket)
            ->with('success', 'Sua resposta foi enviada com sucesso! Nossa equipe será notificada.');
    }
} 