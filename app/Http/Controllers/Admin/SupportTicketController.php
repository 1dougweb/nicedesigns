<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Models\User;
use App\Models\ClientProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = SupportTicket::with(['user', 'clientProject', 'assignedUser']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned_to')) {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }

        if ($request->filled('client')) {
            $query->where('user_id', $request->client);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('ticket_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->latest()->paginate(15);

        // Estatísticas
        $stats = [
            'total' => SupportTicket::count(),
            'open' => SupportTicket::open()->count(),
            'pending_response' => SupportTicket::where('status', 'aguardando_cliente')->count(),
            'overdue' => SupportTicket::overdue()->count(),
            'resolved_today' => SupportTicket::whereDate('resolved_at', today())->count(),
        ];

        // Opções para filtros
        $statusOptions = SupportTicket::getStatusLabels();
        $priorityOptions = SupportTicket::getPriorityLabels();
        $admins = User::admins()->get(['id', 'full_name']);
        $clients = User::clients()->get(['id', 'full_name']);

        return view('admin.support-tickets.index', compact(
            'tickets', 
            'stats', 
            'statusOptions', 
            'priorityOptions',
            'admins',
            'clients'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket): View
    {
        $supportTicket->load([
            'user', 
            'clientProject', 
            'assignedUser',
            'replies.user'
        ]);

        $admins = User::admins()->get(['id', 'full_name']);

        return view('admin.support-tickets.show', compact('supportTicket', 'admins'));
    }

    /**
     * Assign ticket to admin
     */
    public function assign(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $admin = User::find($validated['assigned_to']);
        
        if (!$admin->isAdmin()) {
            return back()->with('error', 'Usuário selecionado não é um administrador.');
        }

        $supportTicket->assignTo($admin);

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', "Ticket atribuído para {$admin->full_name}!");
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(SupportTicket::getStatusLabels())),
            'internal_notes' => 'nullable|string',
        ]);

        $oldStatus = $supportTicket->status;

        // Atualizar status
        $updateData = ['status' => $validated['status']];

        // Se tem notas internas, atualizar
        if (isset($validated['internal_notes'])) {
            $updateData['internal_notes'] = $validated['internal_notes'];
        }

        // Definir timestamps baseado no status
        if ($validated['status'] === 'resolvido' && $oldStatus !== 'resolvido') {
            $updateData['resolved_at'] = now();
        } elseif ($validated['status'] === 'fechado' && $oldStatus !== 'fechado') {
            $updateData['closed_at'] = now();
        } elseif ($validated['status'] === 'em_andamento' && !$supportTicket->first_response_at) {
            $updateData['first_response_at'] = now();
        }

        $supportTicket->update($updateData);

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', 'Status do ticket atualizado!');
    }

    /**
     * Update ticket priority
     */
    public function updatePriority(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        $validated = $request->validate([
            'priority' => 'required|in:' . implode(',', array_keys(SupportTicket::getPriorityLabels())),
        ]);

        $supportTicket->update($validated);

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', 'Prioridade do ticket atualizada!');
    }

    /**
     * Reply to ticket
     */
    public function reply(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'is_internal' => 'nullable|boolean',
            'type' => 'required|in:' . implode(',', array_keys(TicketReply::getTypeLabels())),
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

        TicketReply::create([
            'support_ticket_id' => $supportTicket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'is_internal' => $validated['is_internal'] ?? false,
            'type' => $validated['type'],
            'attachments' => $attachments,
        ]);

        // Atualizar timestamp de última resposta
        $supportTicket->update([
            'last_response_at' => now(),
            'first_response_at' => $supportTicket->first_response_at ?? now(),
        ]);

        // Se for resposta pública, mudar status se necessário
        if (!($validated['is_internal'] ?? false)) {
            if ($supportTicket->status === 'aberto') {
                $supportTicket->update(['status' => 'em_andamento']);
            } elseif ($supportTicket->status === 'aguardando_cliente') {
                $supportTicket->update(['status' => 'em_andamento']);
            }
        }

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', 'Resposta enviada com sucesso!');
    }

    /**
     * Mark ticket as resolved
     */
    public function markAsResolved(Request $request, SupportTicket $supportTicket): RedirectResponse
    {
        $validated = $request->validate([
            'resolution_message' => 'nullable|string',
        ]);

        $supportTicket->markAsResolved();

        // Se há mensagem de resolução, criar uma resposta
        if (!empty($validated['resolution_message'])) {
            TicketReply::create([
                'support_ticket_id' => $supportTicket->id,
                'user_id' => auth()->id(),
                'message' => $validated['resolution_message'],
                'is_internal' => false,
                'type' => 'resolucao',
            ]);
        }

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', 'Ticket marcado como resolvido!');
    }

    /**
     * Close ticket
     */
    public function close(SupportTicket $supportTicket): RedirectResponse
    {
        $supportTicket->close();

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', 'Ticket fechado!');
    }

    /**
     * Reopen ticket
     */
    public function reopen(SupportTicket $supportTicket): RedirectResponse
    {
        $supportTicket->reopen();

        return redirect()
            ->route('admin.support-tickets.show', $supportTicket)
            ->with('success', 'Ticket reaberto!');
    }

    /**
     * Get analytics data
     */
    public function analytics(): View
    {
        // Obter dados básicos
        $totalTickets = SupportTicket::count();
        $ticketsThisMonth = SupportTicket::whereMonth('created_at', now()->month)->count();
        $resolvedTickets = SupportTicket::where('status', 'resolvido')->count();
        $resolutionRate = $totalTickets > 0 ? ($resolvedTickets / $totalTickets) * 100 : 0;
        
        // Tempo médio de resposta
        $avgResponseTime = $this->calculateAverageResponseTime();
        
        // Satisfação do cliente
        $satisfactionScore = SupportTicket::whereNotNull('satisfaction_rating')->avg('satisfaction_rating') ?? 0;
        $totalRatings = SupportTicket::whereNotNull('satisfaction_rating')->count();
        
        // Distribuição por status
        $statusDistribution = SupportTicket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Distribuição por prioridade
        $priorityDistribution = SupportTicket::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();
        
        // Tendências mensais (últimos 6 meses)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $total = SupportTicket::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $resolved = SupportTicket::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'resolvido')
                ->count();
            
            $monthlyTrends[$monthName] = [
                'total' => $total,
                'resolved' => $resolved
            ];
        }
        
        // Distribuição por categoria
        $categoryDistribution = [
            'suporte_tecnico' => SupportTicket::where('subject', 'like', '%técnico%')->count(),
            'faturamento' => SupportTicket::where('subject', 'like', '%fatura%')->count(),
            'projeto' => SupportTicket::where('subject', 'like', '%projeto%')->count(),
            'geral' => SupportTicket::whereNotIn('id', function($query) {
                $query->select('id')->from('support_tickets')
                    ->where('subject', 'like', '%técnico%')
                    ->orWhere('subject', 'like', '%fatura%')
                    ->orWhere('subject', 'like', '%projeto%');
            })->count()
        ];
        
        // Performance dos agentes
        $agentPerformance = User::where('role', 'admin')
            ->get()
            ->map(function($user) {
                // Buscar tickets atribuídos para este usuário
                $assignedTickets = SupportTicket::where('assigned_to', $user->id)->get();
                $totalTickets = $assignedTickets->count();
                $resolvedTickets = $assignedTickets->where('status', 'resolvido')->count();
                
                // Calcular tempo médio de resposta
                $responseTime = $assignedTickets
                    ->whereNotNull('first_response_at')
                    ->avg(function($ticket) {
                        return $ticket->created_at->diffInHours($ticket->first_response_at);
                    });
                
                // Calcular satisfação média
                $satisfaction = $assignedTickets
                    ->whereNotNull('satisfaction_rating')
                    ->avg('satisfaction_rating');
                
                return [
                    'name' => $user->full_name,
                    'avatar' => $user->avatar,
                    'total_tickets' => $totalTickets,
                    'resolved_tickets' => $resolvedTickets,
                    'avg_response_time' => round($responseTime ?? 0, 1),
                    'satisfaction' => round($satisfaction ?? 0, 1),
                    'resolution_rate' => $totalTickets > 0 
                        ? round(($resolvedTickets / $totalTickets) * 100, 1) 
                        : 0
                ];
            })
            ->filter(function($agent) {
                // Apenas incluir agentes que têm tickets atribuídos
                return $agent['total_tickets'] > 0;
            });
        
        // Atividades recentes
        $recentActivity = SupportTicket::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($ticket) {
                return [
                    'type' => 'ticket_created',
                    'description' => "Ticket #{$ticket->id} criado por {$ticket->user->full_name}",
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'created_at' => $ticket->created_at,
                    'ticket_id' => $ticket->id
                ];
            });
        
        // Métricas de performance
        $slaCompliance = 85; // Exemplo - pode ser calculado baseado em metas
        $avgFirstResponse = $avgResponseTime;
        $avgResolutionTime = SupportTicket::where('status', 'resolvido')
            ->whereNotNull('resolved_at')
            ->get()
            ->avg(function($ticket) {
                return $ticket->created_at->diffInHours($ticket->resolved_at);
            }) ?? 0;
        
        // Montar array analytics
        $analytics = [
            'total_tickets' => $totalTickets,
            'tickets_this_month' => $ticketsThisMonth,
            'resolved_tickets' => $resolvedTickets,
            'resolution_rate' => round($resolutionRate, 1),
            'avg_response_time' => round($avgResponseTime, 1),
            'satisfaction_score' => round($satisfactionScore, 1),
            'total_ratings' => $totalRatings,
            'status_distribution' => $statusDistribution,
            'priority_distribution' => $priorityDistribution,
            'monthly_trends' => $monthlyTrends,
            'category_distribution' => $categoryDistribution,
            'sla_compliance' => $slaCompliance,
            'avg_first_response' => round($avgFirstResponse, 1),
            'avg_resolution_time' => round($avgResolutionTime, 1),
            'agent_performance' => $agentPerformance,
            'recent_activity' => $recentActivity
        ];

        return view('admin.support-tickets.analytics', compact('analytics'));
    }

    /**
     * Calculate average response time
     */
    private function calculateAverageResponseTime(): float
    {
        $tickets = SupportTicket::whereNotNull('first_response_at')->get();
        
        if ($tickets->isEmpty()) {
            return 0;
        }

        $totalHours = $tickets->sum(function ($ticket) {
            return $ticket->created_at->diffInHours($ticket->first_response_at);
        });

        return $totalHours / $tickets->count();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $supportTicket): RedirectResponse
    {
        $supportTicket->delete();

        return redirect()
            ->route('admin.support-tickets.index')
            ->with('success', 'Ticket removido com sucesso!');
    }
} 