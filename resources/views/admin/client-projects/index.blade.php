@extends('layouts.admin')

@section('title', '- Projetos de Clientes')
@section('page-title', 'Projetos de Clientes')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-cyan-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-400">Total</p>
            </div>
        </div>
    </div>

    <!-- Active Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['active'] }}</p>
                <p class="text-sm text-gray-400">Ativos</p>
            </div>
        </div>
    </div>

    <!-- Completed Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['completed'] }}</p>
                <p class="text-sm text-gray-400">Concluídos</p>
            </div>
        </div>
    </div>

    <!-- Overdue Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-red-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['overdue'] }}</p>
                <p class="text-sm text-gray-400">Atrasados</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 mb-8">
    <form method="GET" action="{{ route('admin.client-projects.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Buscar por nome ou cliente..."
                       class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                    <option value="">Todos os status</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <select name="priority" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                    <option value="">Todas as prioridades</option>
                    @foreach($priorityOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('priority') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Client Filter -->
            <div>
                <select name="client" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                    <option value="">Todos os clientes</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                            {{ $client->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="flex space-x-2">
                <button type="submit" 
                        class="flex-1 bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-3 rounded-xl transition-colors font-medium">
                    Filtrar
                </button>
                <a href="{{ route('admin.client-projects.index') }}" 
                   class="px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors">
                    Limpar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Header with Actions -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">Projetos de Clientes</h2>
        <p class="text-gray-400">Gerencie todos os projetos desenvolvidos para clientes</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('admin.client-projects.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-cyan-500/25">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Projeto
        </a>
    </div>
</div>

<!-- Projects Table -->
@if($clientProjects->count() > 0)
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Projeto</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Cliente</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Status</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Prioridade</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Progresso</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Prazo</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Orçamento</th>
                        <th class="text-right py-4 px-6 text-gray-300 font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientProjects as $project)
                        <tr class="border-t border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                            <!-- Project Name -->
                            <td class="py-4 px-6">
                                <div>
                                    <h3 class="text-white font-medium">{{ $project->name }}</h3>
                                    @if($project->project)
                                        <p class="text-gray-400 text-sm">Baseado em: {{ $project->project->title }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Client -->
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ substr($project->user->full_name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $project->user->full_name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $project->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                @php
                                    $statusColor = $project->getStatusColor();
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                                    {{ $statusOptions[$project->status] ?? $project->status }}
                                </span>
                            </td>

                            <!-- Priority -->
                            <td class="py-4 px-6">
                                @php
                                    $priorityColor = $project->getPriorityColor();
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $priorityColor }}-500/20 text-{{ $priorityColor }}-400 border border-{{ $priorityColor }}-500/30">
                                    {{ $priorityOptions[$project->priority] ?? $project->priority }}
                                </span>
                            </td>

                            <!-- Progress -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-1">
                                        <div class="w-full bg-gray-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-2 rounded-full transition-all duration-300" 
                                                 style="width: {{ $project->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                    <span class="text-white text-sm font-medium">{{ $project->progress_percentage }}%</span>
                                </div>
                            </td>

                            <!-- Deadline -->
                            <td class="py-4 px-6">
                                @if($project->deadline)
                                    <div class="text-sm">
                                        <p class="text-white">{{ $project->deadline->format('d/m/Y') }}</p>
                                        @if($project->deadline->isPast() && $project->status !== 'concluido')
                                            <p class="text-red-400">Atrasado</p>
                                        @else
                                            <p class="text-gray-400">{{ $project->deadline->diffForHumans() }}</p>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-500">Sem prazo</span>
                                @endif
                            </td>

                            <!-- Budget -->
                            <td class="py-4 px-6">
                                <div class="text-sm">
                                    <p class="text-white font-medium">{{ $project->currency }} {{ number_format($project->budget, 2, ',', '.') }}</p>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.client-projects.show', $project) }}" 
                                       class="p-2 text-cyan-400 hover:text-cyan-300 hover:bg-cyan-500/10 rounded-lg transition-colors" 
                                       title="Visualizar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.client-projects.edit', $project) }}" 
                                       class="p-2 text-yellow-400 hover:text-yellow-300 hover:bg-yellow-500/10 rounded-lg transition-colors" 
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($clientProjects->hasPages())
        <div class="mt-8">
            {{ $clientProjects->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-4">Nenhum projeto encontrado</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            @if(request()->hasAny(['search', 'status', 'priority', 'client']))
                Não foram encontrados projetos com os filtros aplicados. Tente ajustar os critérios de busca.
            @else
                Você ainda não criou nenhum projeto para clientes. Que tal começar criando o primeiro?
            @endif
        </p>
        
        @if(request()->hasAny(['search', 'status', 'priority', 'client']))
            <a href="{{ route('admin.client-projects.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors mr-4">
                Limpar Filtros
            </a>
        @endif
        
        <a href="{{ route('admin.client-projects.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Criar Primeiro Projeto
        </a>
    </div>
@endif
@endsection 