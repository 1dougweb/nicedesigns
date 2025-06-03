@extends('layouts.client')

@section('title', '- Meus Projetos')
@section('page-title', 'Meus Projetos')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl border border-blue-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h2 class="text-3xl font-bold text-white mb-2">
                    Meus Projetos 📋
                </h2>
                <p class="text-gray-300 text-lg">
                    Acompanhe o progresso e status dos seus projetos em desenvolvimento.
                </p>
            </div>
            
            <!-- Project Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-white">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-300">Total</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-green-400">{{ $stats['active'] }}</div>
                    <div class="text-sm text-gray-300">Ativos</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-blue-400">{{ $stats['completed'] }}</div>
                    <div class="text-sm text-gray-300">Concluídos</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-red-400">{{ $stats['overdue'] }}</div>
                    <div class="text-sm text-gray-300">Atrasados</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="mb-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <form method="GET" action="{{ route('client.projects.index') }}" class="flex flex-col lg:flex-row gap-4">
            <!-- Status Filter -->
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" id="status" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="todos" {{ $status === 'todos' ? 'selected' : '' }}>Todos os Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Priority Filter -->
            <div class="flex-1">
                <label for="priority" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                <select name="priority" id="priority" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="todas" {{ $priority === 'todas' ? 'selected' : '' }}>Todas as Prioridades</option>
                    @foreach($priorityOptions as $key => $label)
                        <option value="{{ $key }}" {{ $priority === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                    </svg>
                    Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Projects Grid -->
@if($projects->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach($projects as $project)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-{{ $project->status_color ?? 'blue' }}-500/50 transition-all duration-300 group">
                <!-- Project Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-{{ $project->status_color ?? 'blue' }}-400 transition-colors">
                            {{ $project->name }}
                        </h3>
                        @if($project->description)
                            <p class="text-gray-400 text-sm line-clamp-2">{{ $project->description }}</p>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $project->status_color ?? 'blue' }}-500/20 text-{{ $project->status_color ?? 'blue' }}-400 border border-{{ $project->status_color ?? 'blue' }}-500/30">
                        {{ $project->status_label ?? 'Em andamento' }}
                    </span>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-300 mb-2">
                        <span>Progresso</span>
                        <span>{{ $project->progress_percentage ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-3">
                        <div class="bg-gradient-to-r from-{{ $project->status_color ?? 'blue' }}-500 to-{{ $project->status_color ?? 'blue' }}-400 h-3 rounded-full transition-all duration-500" style="width: {{ $project->progress_percentage ?? 0 }}%"></div>
                    </div>
                </div>

                <!-- Technologies -->
                @if($project->technologies && count($project->technologies) > 0)
                    <div class="mb-4">
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-700/50 text-gray-300 border border-gray-600/50">
                                    {{ $tech }}
                                </span>
                            @endforeach
                            @if(count($project->technologies) > 3)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-700/50 text-gray-400 border border-gray-600/50">
                                    +{{ count($project->technologies) - 3 }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Project Info -->
                <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                    <div class="flex items-center space-x-4">
                        @if($project->priority)
                            <span class="flex items-center">
                                <div class="w-2 h-2 bg-{{ $project->priority_color ?? 'gray' }}-400 rounded-full mr-2"></div>
                                {{ $project->priority_label ?? 'Normal' }}
                            </span>
                        @endif
                        @if($project->deadline)
                            <span>{{ $project->deadline->format('d/m/Y') }}</span>
                        @endif
                    </div>
                    @if($project->last_activity_at)
                        <span>{{ $project->last_activity_at->diffForHumans() }}</span>
                    @endif
                </div>

                <!-- Action Button -->
                <div class="flex justify-end">
                    <a href="{{ route('client.projects.show', $project) }}" class="bg-{{ $project->status_color ?? 'blue' }}-600/20 hover:bg-{{ $project->status_color ?? 'blue' }}-600/30 text-{{ $project->status_color ?? 'blue' }}-400 px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-{{ $project->status_color ?? 'blue' }}-500/30 hover:border-{{ $project->status_color ?? 'blue' }}-500/50 flex items-center">
                        Ver Detalhes
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
        <div class="flex justify-center">
            <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-4">
                {{ $projects->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="text-center py-12">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Nenhum projeto encontrado</h3>
            <p class="text-gray-400 mb-6">Você ainda não possui projetos ou nenhum projeto corresponde aos filtros aplicados.</p>
            <a href="{{ route('client.dashboard') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>
@endif

@push('scripts')
<script>
// Auto-submit form when filters change
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const prioritySelect = document.getElementById('priority');
    
    statusSelect.addEventListener('change', function() {
        this.form.submit();
    });
    
    prioritySelect.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush
@endsection 