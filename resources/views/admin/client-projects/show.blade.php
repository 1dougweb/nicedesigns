@extends('layouts.admin')

@section('title', '- ' . $clientProject->name)
@section('page-title', 'Projeto: ' . $clientProject->name)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">{{ $clientProject->name }}</h2>
        <p class="text-gray-400">Cliente: {{ $clientProject->user->full_name }}</p>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('admin.client-projects.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
        <a href="{{ route('admin.client-projects.edit', $clientProject) }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Editar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Project Overview -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Visão Geral
            </h3>

            <!-- Status and Priority -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="text-gray-300 font-medium mb-2">Status</h4>
                    @php
                        $statusColor = $clientProject->getStatusColor();
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $clientProject->status_label }}
                    </span>
                </div>
                <div>
                    <h4 class="text-gray-300 font-medium mb-2">Prioridade</h4>
                    @php
                        $priorityColor = $clientProject->getPriorityColor();
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-{{ $priorityColor }}-500/20 text-{{ $priorityColor }}-400 border border-{{ $priorityColor }}-500/30">
                        {{ $clientProject->priority_label }}
                    </span>
                </div>
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-gray-300 font-medium">Progresso</h4>
                    <span class="text-cyan-400 font-bold">{{ $clientProject->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-3 rounded-full transition-all duration-300" 
                         style="width: {{ $clientProject->progress_percentage }}%"></div>
                </div>
                @if($clientProject->current_stage)
                    <p class="text-gray-400 text-sm mt-2">Etapa atual: {{ $clientProject->current_stage }}</p>
                @endif
            </div>

            <!-- Description -->
            <div>
                <h4 class="text-gray-300 font-medium mb-3">Descrição</h4>
                <div class="text-gray-300 leading-relaxed">
                    {!! nl2br(e($clientProject->description)) !!}
                </div>
            </div>

            <!-- Requirements -->
            @if($clientProject->requirements)
                <div class="mt-6">
                    <h4 class="text-gray-300 font-medium mb-3">Requisitos</h4>
                    <div class="text-gray-300 leading-relaxed">
                        {!! nl2br(e($clientProject->requirements)) !!}
                    </div>
                </div>
            @endif

            <!-- Technologies -->
            @if($clientProject->technologies)
                <div class="mt-6">
                    <h4 class="text-gray-300 font-medium mb-3">Tecnologias</h4>
                    <div class="flex flex-wrap gap-2">
                        @if(is_string($clientProject->technologies))
                            @foreach(explode(',', $clientProject->technologies) as $tech)
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-lg text-sm">
                                    {{ trim($tech) }}
                                </span>
                            @endforeach
                        @elseif(is_array($clientProject->technologies))
                            @foreach($clientProject->technologies as $tech)
                                <span class="px-3 py-1 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-lg text-sm">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            <!-- Links -->
            @if($clientProject->project_url || $clientProject->repository_url)
                <div class="mt-6">
                    <h4 class="text-gray-300 font-medium mb-3">Links</h4>
                    <div class="flex flex-wrap gap-3">
                        @if($clientProject->project_url)
                            <a href="{{ $clientProject->project_url }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Ver Projeto
                            </a>
                        @endif
                        @if($clientProject->repository_url)
                            <a href="{{ $clientProject->repository_url }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                </svg>
                                Repositório
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Project Stages -->
        @if($clientProject->stages && is_array($clientProject->stages))
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Etapas do Projeto
                </h3>

                <div class="space-y-4">
                    @foreach($clientProject->stages as $index => $stage)
                        @php
                            $isActive = $stage['name'] === $clientProject->current_stage;
                            $isCompleted = isset($stage['status']) && $stage['status'] === 'completed';
                        @endphp
                        <div class="flex items-center p-4 rounded-xl {{ $isActive ? 'bg-cyan-500/10 border border-cyan-500/30' : ($isCompleted ? 'bg-green-500/10 border border-green-500/30' : 'bg-gray-700/30 border border-gray-600/30') }}">
                            <div class="flex-shrink-0 w-8 h-8 mr-4 rounded-full flex items-center justify-center {{ $isActive ? 'bg-cyan-500' : ($isCompleted ? 'bg-green-500' : 'bg-gray-600') }}">
                                @if($isCompleted)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <span class="text-white text-sm font-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium {{ $isActive ? 'text-cyan-400' : ($isCompleted ? 'text-green-400' : 'text-white') }}">
                                    {{ $stage['name'] }}
                                </h4>
                                @if(isset($stage['description']))
                                    <p class="text-gray-400 text-sm mt-1">{{ $stage['description'] }}</p>
                                @endif
                                @if(isset($stage['progress']) && $stage['progress'] > 0)
                                    <div class="w-full bg-gray-600 rounded-full h-1 mt-2">
                                        <div class="h-1 rounded-full {{ $isCompleted ? 'bg-green-500' : 'bg-cyan-500' }}" 
                                             style="width: {{ $stage['progress'] }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Notes -->
        @if($clientProject->notes)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Observações Internas
                </h3>
                <div class="text-gray-300 leading-relaxed">
                    {!! nl2br(e($clientProject->notes)) !!}
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Project Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Informações do Projeto</h3>
            
            <div class="space-y-4">
                <!-- Client -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Cliente</h4>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">{{ substr($clientProject->user->full_name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $clientProject->user->full_name }}</p>
                            <p class="text-gray-400 text-sm">{{ $clientProject->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Budget -->
                @if($clientProject->budget)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Orçamento</h4>
                        <p class="text-white font-bold text-lg">{{ $clientProject->currency ?? 'R$' }} {{ number_format($clientProject->budget, 2, ',', '.') }}</p>
                    </div>
                @endif

                <!-- Dates -->
                @if($clientProject->start_date)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Data de Início</h4>
                        <p class="text-white">{{ $clientProject->start_date->format('d/m/Y') }}</p>
                    </div>
                @endif

                @if($clientProject->due_date)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Data de Entrega</h4>
                        <p class="text-white">{{ $clientProject->due_date->format('d/m/Y') }}</p>
                        @if($clientProject->due_date->isPast() && $clientProject->status !== 'concluido')
                            <p class="text-red-400 text-sm">Atrasado há {{ $clientProject->due_date->diffForHumans() }}</p>
                        @else
                            <p class="text-gray-400 text-sm">{{ $clientProject->due_date->diffForHumans() }}</p>
                        @endif
                    </div>
                @endif

                <!-- Creation Date -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Criado em</h4>
                    <p class="text-white">{{ $clientProject->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Last Update -->
                @if($clientProject->last_activity_at)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Última Atividade</h4>
                        <p class="text-white">{{ $clientProject->last_activity_at->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-400 text-sm">{{ $clientProject->last_activity_at->diffForHumans() }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Ações Rápidas</h3>
            
            <div class="space-y-3">
                <button onclick="updateProgress()" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Atualizar Progresso
                </button>
                
                <a href="{{ route('admin.invoices.create', ['client_project_id' => $clientProject->id]) }}" 
                   class="w-full flex items-center justify-center px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Criar Fatura
                </a>

                <a href="{{ route('admin.client-projects.edit', $clientProject) }}" 
                   class="w-full flex items-center justify-center px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Editar Projeto
                </a>
            </div>
        </div>

        <!-- Related Content -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Conteúdo Relacionado</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.invoices.index', ['client' => $clientProject->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Faturas do Cliente</span>
                        <span class="text-gray-400 text-sm">{{ $clientProject->invoices->count() }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.support-tickets.index', ['client' => $clientProject->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Tickets de Suporte</span>
                        <span class="text-gray-400 text-sm">{{ $clientProject->supportTickets->count() }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.client-projects.index', ['client' => $clientProject->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Outros Projetos</span>
                        <span class="text-gray-400 text-sm">{{ $clientProject->user->clientProjects->where('id', '!=', $clientProject->id)->count() }}</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div id="updateProgressModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-6">Atualizar Progresso</h3>
        <form action="{{ route('admin.client-projects.update-progress', $clientProject) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="progress" class="block text-sm font-medium text-gray-300 mb-2">
                        Progresso (%)
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="range" 
                               name="progress" 
                               id="progress"
                               value="{{ $clientProject->progress_percentage }}"
                               min="0"
                               max="100"
                               step="5"
                               class="flex-1 h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                        <span id="progress-value" class="text-cyan-400 font-bold min-w-[3rem]">{{ $clientProject->progress_percentage }}%</span>
                    </div>
                </div>

                <div>
                    <label for="current_stage" class="block text-sm font-medium text-gray-300 mb-2">
                        Etapa Atual
                    </label>
                    <select name="current_stage" id="current_stage"
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        @if($clientProject->stages && is_array($clientProject->stages))
                            @foreach($clientProject->stages as $stage)
                                <option value="{{ $stage['name'] }}" {{ $clientProject->current_stage === $stage['name'] ? 'selected' : '' }}>
                                    {{ $stage['name'] }}
                                </option>
                            @endforeach
                        @else
                            <option value="Planejamento" {{ $clientProject->current_stage === 'Planejamento' ? 'selected' : '' }}>Planejamento</option>
                            <option value="Design" {{ $clientProject->current_stage === 'Design' ? 'selected' : '' }}>Design</option>
                            <option value="Desenvolvimento" {{ $clientProject->current_stage === 'Desenvolvimento' ? 'selected' : '' }}>Desenvolvimento</option>
                            <option value="Testes" {{ $clientProject->current_stage === 'Testes' ? 'selected' : '' }}>Testes</option>
                            <option value="Deploy" {{ $clientProject->current_stage === 'Deploy' ? 'selected' : '' }}>Deploy</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label for="update_message" class="block text-sm font-medium text-gray-300 mb-2">
                        Mensagem de Atualização
                    </label>
                    <textarea name="update_message" id="update_message" rows="3"
                              placeholder="Descreva as atualizações realizadas..."
                              class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-8">
                <button type="button" onclick="closeUpdateProgressModal()" 
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300">
                    Atualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateProgress() {
    const modal = document.getElementById('updateProgressModal');
    modal.classList.remove('hidden');
}

function closeUpdateProgressModal() {
    const modal = document.getElementById('updateProgressModal');
    modal.classList.add('hidden');
}

// Progress slider update
document.getElementById('progress').addEventListener('input', function() {
    document.getElementById('progress-value').textContent = this.value + '%';
});

// Close modal when clicking outside
document.getElementById('updateProgressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateProgressModal();
    }
});
</script>
@endpush 