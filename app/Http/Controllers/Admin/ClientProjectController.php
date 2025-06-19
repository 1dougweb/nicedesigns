<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use App\Models\User;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ClientProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = ClientProject::with(['user', 'project']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('client')) {
            $query->where('user_id', $request->client);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        $clientProjects = $query->latest()->paginate(15);

        // Estatísticas
        $stats = [
            'total' => ClientProject::count(),
            'active' => ClientProject::active()->count(),
            'completed' => ClientProject::completed()->count(),
            'overdue' => ClientProject::overdue()->count(),
        ];

        // Opções para filtros
        $statusOptions = ClientProject::getStatusLabels();
        $priorityOptions = ClientProject::getPriorityLabels();
        $clients = User::clients()->get(['id', 'full_name']);

        return view('admin.client-projects.index', compact(
            'clientProjects', 
            'stats', 
            'statusOptions', 
            'priorityOptions', 
            'clients'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = User::clients()->get(['id', 'full_name']);
        $projects = Project::published()->get(['id', 'title']);
        $statusOptions = ClientProject::getStatusLabels();
        $priorityOptions = ClientProject::getPriorityLabels();

        return view('admin.client-projects.create', compact(
            'clients', 
            'projects', 
            'statusOptions', 
            'priorityOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:' . implode(',', array_keys(ClientProject::getStatusLabels())),
            'priority' => 'required|in:' . implode(',', array_keys(ClientProject::getPriorityLabels())),
            'start_date' => 'required|date',
            'estimated_completion' => 'nullable|date|after:start_date',
            'deadline' => 'nullable|date|after:start_date',
            'technologies' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        // Processar tecnologias e tags
        if ($validated['technologies']) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }
        if ($validated['tags']) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Configurar stages padrão
        $validated['stages'] = [
            [
                'name' => 'Planejamento',
                'description' => 'Definição de requisitos e planejamento do projeto',
                'progress' => 0,
                'estimated_hours' => 20,
                'completed_at' => null,
            ],
            [
                'name' => 'Design',
                'description' => 'Criação do design e protótipo',
                'progress' => 0,
                'estimated_hours' => 30,
                'completed_at' => null,
            ],
            [
                'name' => 'Desenvolvimento',
                'description' => 'Desenvolvimento da solução',
                'progress' => 0,
                'estimated_hours' => 80,
                'completed_at' => null,
            ],
            [
                'name' => 'Testes',
                'description' => 'Testes e correções',
                'progress' => 0,
                'estimated_hours' => 20,
                'completed_at' => null,
            ],
            [
                'name' => 'Deploy',
                'description' => 'Publicação e entrega',
                'progress' => 0,
                'estimated_hours' => 10,
                'completed_at' => null,
            ],
        ];

        $validated['last_activity_at'] = now();

        $clientProject = ClientProject::create($validated);

        // Notificar o cliente sobre o novo projeto
        $client = User::find($validated['user_id']);
        if ($client && $clientProject->status === 'aguardando_aprovacao') {
            Notification::create([
                'user_id' => $client->id,
                'title' => 'Novo Projeto para Aprovação',
                'message' => "Você tem um novo projeto '{$clientProject->name}' aguardando sua aprovação.",
                'type' => Notification::TYPE_NEW_PROJECT,
                'url' => route('client.projects.show', $clientProject->id),
                'data' => [
                    'project_id' => $clientProject->id,
                    'project_name' => $clientProject->name,
                    'action_required' => 'approval'
                ]
            ]);
        }

        return redirect()
            ->route('admin.client-projects.show', $clientProject)
            ->with('success', 'Projeto criado com sucesso! O cliente foi notificado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientProject $clientProject): View
    {
        $clientProject->load(['user', 'project', 'invoices', 'supportTickets.assignedUser']);

        return view('admin.client-projects.show', compact('clientProject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientProject $clientProject): View
    {
        $clients = User::clients()->get(['id', 'full_name']);
        $projects = Project::published()->get(['id', 'title']);
        $statusOptions = ClientProject::getStatusLabels();
        $priorityOptions = ClientProject::getPriorityLabels();

        return view('admin.client-projects.edit', compact(
            'clientProject',
            'clients', 
            'projects', 
            'statusOptions', 
            'priorityOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientProject $clientProject): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:' . implode(',', array_keys(ClientProject::getStatusLabels())),
            'priority' => 'required|in:' . implode(',', array_keys(ClientProject::getPriorityLabels())),
            'start_date' => 'required|date',
            'estimated_completion' => 'nullable|date|after:start_date',
            'deadline' => 'nullable|date|after:start_date',
            'technologies' => 'nullable|string',
            'tags' => 'nullable|string',
            'last_update' => 'nullable|string',
        ]);

        // Processar tecnologias e tags
        if ($validated['technologies']) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }
        if ($validated['tags']) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        $validated['last_activity_at'] = now();

        $clientProject->update($validated);

        return redirect()
            ->route('admin.client-projects.show', $clientProject)
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Update project progress
     */
    public function updateProgress(Request $request, ClientProject $clientProject): RedirectResponse
    {
        $validated = $request->validate([
            'stages' => 'required|array',
            'stages.*.progress' => 'required|integer|min:0|max:100',
            'update_message' => 'nullable|string|max:500',
        ]);

        // Atualizar stages
        $stages = $clientProject->stages;
        foreach ($validated['stages'] as $index => $stageData) {
            if (isset($stages[$index])) {
                $stages[$index]['progress'] = $stageData['progress'];
                
                // Marcar como completo se progress = 100
                if ($stageData['progress'] == 100 && !isset($stages[$index]['completed_at'])) {
                    $stages[$index]['completed_at'] = now()->toDateTimeString();
                }
            }
        }

        // Calcular progresso geral
        $totalProgress = collect($stages)->avg('progress');
        
        // Atualizar status baseado no progresso
        $newStatus = $clientProject->status;
        if ($totalProgress >= 100) {
            $newStatus = 'concluido';
        } elseif ($totalProgress > 0 && $clientProject->status === 'aguardando_aprovacao') {
            $newStatus = 'em_andamento';
        }

        $clientProject->update([
            'stages' => $stages,
            'progress_percentage' => intval($totalProgress),
            'status' => $newStatus,
            'last_update' => $validated['update_message'] ?? 'Progresso atualizado',
            'last_activity_at' => now(),
        ]);

        return redirect()
            ->route('admin.client-projects.show', $clientProject)
            ->with('success', 'Progresso atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientProject $clientProject): RedirectResponse
    {
        $clientProject->delete();

        return redirect()
            ->route('admin.client-projects.index')
            ->with('success', 'Projeto removido com sucesso!');
    }
} 