@extends('layouts.client')

@section('title', '- ' . $project->name)
@section('page-title', $project->name)

@section('content')
<!-- Approval Section -->
@if($project->status === 'aguardando_aprovacao')
    <div class="mb-8">
        <div class="bg-gradient-to-r from-yellow-600/20 to-orange-600/20 backdrop-blur-md rounded-3xl border border-yellow-500/30 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Projeto Aguardando Aprovação</h3>
                        <p class="text-gray-300">Este projeto requer sua aprovação para iniciar o desenvolvimento.</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <form action="{{ route('client.projects.approve', $project) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Tem certeza que deseja aprovar este projeto?')"
                                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Aprovar</span>
                        </button>
                    </form>
                    <button type="button" 
                            onclick="showRejectModal()"
                            class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Rejeitar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-{{ $project->status_color ?? 'blue' }}-600/20 to-{{ $project->priority_color ?? 'purple' }}-600/20 backdrop-blur-md rounded-3xl border border-{{ $project->status_color ?? 'blue' }}-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
            <div class="mb-6 lg:mb-0 flex-1">
                <div class="flex items-center mb-4">
                    <a href="{{ route('client.projects.index') }}" class="text-gray-300 hover:text-white mr-4 p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-white">{{ $project->name }}</h1>
                </div>
                
                @if($project->description)
                    <p class="text-gray-300 text-lg mb-4">{{ $project->description }}</p>
                @endif
                
                <div class="flex flex-wrap items-center gap-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $project->status_color ?? 'blue' }}-500/20 text-{{ $project->status_color ?? 'blue' }}-400 border border-{{ $project->status_color ?? 'blue' }}-500/30">
                        {{ $project->status_label ?? 'Em andamento' }}
                    </span>
                    @if($project->priority)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $project->priority_color ?? 'gray' }}-500/20 text-{{ $project->priority_color ?? 'gray' }}-400 border border-{{ $project->priority_color ?? 'gray' }}-500/30">
                            <div class="w-2 h-2 bg-{{ $project->priority_color ?? 'gray' }}-400 rounded-full mr-2"></div>
                            {{ $project->priority_label ?? 'Normal' }}
                        </span>
                    @endif
                    @if($project->deadline)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-500/20 text-gray-300 border border-gray-500/30">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $project->deadline->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Progress Circle -->
            <div class="flex-shrink-0">
                <div class="relative w-32 h-32">
                    <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" class="text-gray-700"/>
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" 
                                class="text-{{ $project->status_color ?? 'blue' }}-400" 
                                stroke-dasharray="{{ 2 * pi() * 40 }}" 
                                stroke-dashoffset="{{ 2 * pi() * 40 * (1 - ($project->progress_percentage ?? 0) / 100) }}"
                                stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $project->progress_percentage ?? 0 }}%</div>
                            <div class="text-xs text-gray-400">Progresso</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Project Details -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Technologies -->
        @if($project->technologies && count($project->technologies) > 0)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    Tecnologias
                </h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($project->technologies as $tech)
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-blue-300 border border-blue-500/30">
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Project Stages -->
        @if($project->stages && count($project->stages) > 0)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Etapas do Projeto
                </h3>
                <div class="space-y-4">
                    @foreach($project->stages as $index => $stage)
                        @php
                            $isCompleted = $stage['status'] === 'completed';
                            $isActive = $stage['status'] === 'active';
                            $isPending = $stage['status'] === 'pending';
                        @endphp
                        <div class="flex items-start space-x-4 p-4 rounded-2xl {{ $isActive ? 'bg-blue-500/10 border border-blue-500/30' : 'bg-gray-700/30' }}">
                            <div class="flex-shrink-0 mt-1">
                                @if($isCompleted)
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                @elseif($isActive)
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                        <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-white mb-1">{{ $stage['name'] }}</h4>
                                @if(isset($stage['description']))
                                    <p class="text-gray-400 text-sm mb-2">{{ $stage['description'] }}</p>
                                @endif
                                @if(isset($stage['progress']) && $stage['progress'] > 0)
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-{{ $isCompleted ? 'green' : ($isActive ? 'blue' : 'gray') }}-500 h-2 rounded-full" style="width: {{ $stage['progress'] }}%"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="text-right">
                                @if($isCompleted)
                                    <span class="text-green-400 text-sm font-medium">Concluído</span>
                                @elseif($isActive)
                                    <span class="text-blue-400 text-sm font-medium">Em andamento</span>
                                @else
                                    <span class="text-gray-500 text-sm font-medium">Pendente</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Last Update -->
        @if($project->last_update)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Última Atualização
                </h3>
                <div class="bg-gray-700/30 rounded-2xl p-4">
                    <p class="text-gray-300 mb-2">{{ $project->last_update }}</p>
                    @if($project->last_activity_at)
                        <p class="text-gray-500 text-sm">{{ $project->last_activity_at->diffForHumans() }}</p>
                    @else
                        <p class="text-gray-500 text-sm">{{ $project->updated_at->diffForHumans() }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Project Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informações
            </h3>
            <div class="space-y-4">
                @if($project->budget)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Orçamento</span>
                        <span class="text-white font-medium">{{ $project->formatted_budget }}</span>
                    </div>
                @endif
                @if($project->start_date)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Início</span>
                        <span class="text-white font-medium">{{ $project->start_date->format('d/m/Y') }}</span>
                    </div>
                @endif
                @if($project->estimated_completion)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Previsão</span>
                        <span class="text-white font-medium">{{ $project->estimated_completion->format('d/m/Y') }}</span>
                    </div>
                @endif
                @if($project->created_at)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-400">Criado em</span>
                        <span class="text-white font-medium">{{ $project->created_at->format('d/m/Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        @if($project->preview_url || $project->live_url || $project->repository_url)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Links
                </h3>
                <div class="space-y-3">
                    @if($project->preview_url)
                        <a href="{{ $project->preview_url }}" target="_blank" class="flex items-center p-3 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition-colors group">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-medium group-hover:text-blue-400 transition-colors">Preview</div>
                                <div class="text-gray-400 text-sm">Visualizar projeto</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                    
                    @if($project->live_url)
                        <a href="{{ $project->live_url }}" target="_blank" class="flex items-center p-3 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition-colors group">
                            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-medium group-hover:text-green-400 transition-colors">Site Online</div>
                                <div class="text-gray-400 text-sm">Versão publicada</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Ações
            </h3>
            <div class="space-y-3">
                <a href="{{ route('client.support.index') }}" class="flex items-center p-3 bg-blue-600/20 rounded-xl hover:bg-blue-600/30 transition-colors group border border-blue-500/30">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-white font-medium">Abrir Ticket</div>
                        <div class="text-blue-300 text-sm">Solicitar suporte</div>
                    </div>
                </a>
                
                <a href="{{ route('client.invoices.index') }}" class="flex items-center p-3 bg-green-600/20 rounded-xl hover:bg-green-600/30 transition-colors group border border-green-500/30">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="text-white font-medium">Ver Faturas</div>
                        <div class="text-green-300 text-sm">Pagamentos do projeto</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@if($project->status === 'aguardando_aprovacao')
<!-- Modal de Rejeição -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full transform transition-all">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Rejeitar Projeto</h3>
                <p class="text-gray-300">Por favor, informe o motivo da rejeição (opcional):</p>
            </div>
            
            <form action="{{ route('client.projects.reject', $project) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <textarea name="reason" 
                              rows="4" 
                              placeholder="Motivo da rejeição (opcional)"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 resize-none"></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" 
                            onclick="hideRejectModal()"
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                        Rejeitar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fechar modal ao clicar fora
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideRejectModal();
    }
});
</script>
@endif
@endsection 