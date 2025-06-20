@extends('layouts.client')

@section('title', '- Meus Projetos')
@section('page-title', 'Meus Projetos')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl border border-blue-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Meus Projetos 📂
                </h2>
                <p class="text-gray-300 text-lg">
                    Acompanhe o progresso de todos os seus projetos em desenvolvimento.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($projects) && $projects->count() > 0)
<!-- Filtros -->
<div class="mb-6">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('client.projects.index') }}" class="px-4 py-2 {{ !request('status') || request('status') == 'todos' ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-gray-400 border border-gray-700/50' }} rounded-xl text-sm font-medium hover:bg-blue-600/30 transition-colors">
                Todos ({{ $projects->total() }})
            </a>
            <a href="{{ route('client.projects.index', ['status' => 'em_andamento']) }}" class="px-4 py-2 {{ request('status') == 'em_andamento' ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-gray-400 border border-gray-700/50' }} rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Em Andamento
            </a>
            <a href="{{ route('client.projects.index', ['status' => 'concluido']) }}" class="px-4 py-2 {{ request('status') == 'concluido' ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-gray-400 border border-gray-700/50' }} rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Concluídos
            </a>
            <a href="{{ route('client.projects.index', ['status' => 'pausado']) }}" class="px-4 py-2 {{ request('status') == 'pausado' ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : 'text-gray-400 border border-gray-700/50' }} rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Pausados
            </a>
        </div>
    </div>
</div>

<!-- Lista de Projetos -->
<div class="space-y-6">
    @foreach($projects as $project)
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-{{ $project->status_color ?? 'blue' }}-500/50 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-{{ $project->status_color ?? 'blue' }}-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-{{ $project->status_color ?? 'blue' }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $project->name }}</h3>
                    <p class="text-gray-400">{{ $project->description }}</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-{{ $project->status_color ?? 'blue' }}-400">
                            <span class="w-2 h-2 bg-{{ $project->status_color ?? 'blue' }}-400 rounded-full mr-2 {{ $project->status === 'em_andamento' ? 'animate-pulse' : '' }}"></span>
                            {{ $project->status_label }}
                        </span>
                        @if($project->start_date)
                        <span class="text-gray-500">Iniciado em {{ $project->start_date->format('d/m/Y') }}</span>
                        @endif
                        @if($project->deadline)
                        <span class="text-gray-500">Prazo: {{ $project->deadline->format('d/m/Y') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-{{ $project->status_color ?? 'blue' }}-600/20 text-{{ $project->status_color ?? 'blue' }}-400 border border-{{ $project->status_color ?? 'blue' }}-500/30 rounded-full text-sm font-medium">
                    {{ $project->status_label }}
                </span>
            </div>
        </div>

        <!-- Progresso -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-300">Progresso do Projeto</span>
                <span class="text-sm font-medium text-{{ $project->status_color ?? 'blue' }}-400">{{ $project->progress_percentage }}%</span>
            </div>
            <div class="w-full bg-gray-700/50 rounded-full h-3">
                <div class="bg-gradient-to-r from-{{ $project->status_color ?? 'blue' }}-500 to-{{ $project->status_color ?? 'blue' }}-600 h-3 rounded-full transition-all duration-300" style="width: {{ $project->progress_percentage }}%"></div>
            </div>
        </div>

        <!-- Etapas -->
        @if($project->stages)
        <div class="grid grid-cols-1 md:grid-cols-{{ count($project->stages) > 4 ? '5' : count($project->stages) }} gap-4 mb-6">
            @foreach($project->stages as $stage)
            @php
                $isCompleted = $stage['progress'] >= 100;
                $isActive = $stage['progress'] > 0 && $stage['progress'] < 100;
            @endphp
            <div class="text-center">
                <div class="w-8 h-8 bg-{{ $isCompleted ? 'green' : ($isActive ? $project->status_color ?? 'blue' : 'gray') }}-500 rounded-full flex items-center justify-center mx-auto mb-2 {{ $isActive ? 'animate-pulse' : '' }}">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($isCompleted)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        @endif
                    </svg>
                </div>
                <p class="text-xs text-{{ $isCompleted ? 'green' : ($isActive ? $project->status_color ?? 'blue' : 'gray') }}-400 font-medium">{{ $stage['name'] }}</p>
                <p class="text-xs text-gray-500">{{ $isCompleted ? 'Concluído' : ($isActive ? 'Em andamento' : 'Aguardando') }}</p>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Tecnologias -->
        @if($project->technologies)
        <div class="mb-6">
            <p class="text-sm text-gray-300 mb-2">Tecnologias:</p>
            <div class="flex flex-wrap gap-2">
                @foreach($project->technologies as $tech)
                <span class="px-3 py-1 bg-{{ $project->status_color ?? 'blue' }}-600/20 text-{{ $project->status_color ?? 'blue' }}-400 border border-{{ $project->status_color ?? 'blue' }}-500/30 rounded-full text-xs">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('client.projects.show', $project) }}" class="text-{{ $project->status_color ?? 'blue' }}-400 hover:text-{{ $project->status_color ?? 'blue' }}-300 text-sm font-medium transition-colors">
                    Ver Detalhes
                </a>
                @if($project->preview_url)
                <a href="{{ $project->preview_url }}" target="_blank" class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Visualizar
                </a>
                @endif
            </div>
            <div class="text-sm text-gray-400">
                Última atualização: {{ $project->updated_at->diffForHumans() }}
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Paginação -->
@if($projects->hasPages())
<div class="mt-8">
    {{ $projects->links() }}
</div>
@endif

@else
<!-- Estado vazio -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12 text-center">
    <div class="w-20 h-20 bg-gray-700/50 rounded-3xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-400 mb-4">Nenhum projeto encontrado</h3>
    <p class="text-gray-500 mb-8 max-w-md mx-auto">
        Você ainda não possui projetos. Entre em contato conosco para começar seu primeiro projeto.
    </p>
    <div class="flex justify-center space-x-4">
        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Solicitar Projeto
        </a>
        <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-300 rounded-xl text-sm font-medium transition-colors">
            Voltar ao Dashboard
        </a>
    </div>
</div>
@endif
@endsection 
</div>
@endsection 