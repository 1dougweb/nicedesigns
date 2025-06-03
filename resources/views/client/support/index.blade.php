@extends('layouts.client')

@section('title', '- Suporte')
@section('page-title', 'Suporte')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-purple-600/20 to-indigo-600/20 backdrop-blur-md rounded-3xl border border-purple-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h2 class="text-3xl font-bold text-white mb-2">
                    Central de Suporte 🎧
                </h2>
                <p class="text-gray-300 text-lg">
                    Acompanhe seus tickets de suporte e obtenha ajuda da nossa equipe.
                </p>
            </div>
            
            <!-- Support Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-white">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-300">Total</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-blue-400">{{ $stats['open'] }}</div>
                    <div class="text-sm text-gray-300">Abertos</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-gray-300">Pendentes</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-green-400">{{ $stats['resolved'] }}</div>
                    <div class="text-sm text-gray-300">Resolvidos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Ticket Button -->
<div class="mb-8">
    <div class="flex justify-end">
        <a href="{{ route('client.support.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Novo Ticket
        </a>
    </div>
</div>

<!-- Filters -->
<div class="mb-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <form method="GET" action="{{ route('client.support.index') }}" class="flex flex-col lg:flex-row gap-4">
            <!-- Status Filter -->
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" id="status" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="todos" {{ $status === 'todos' ? 'selected' : '' }}>Todos os Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Priority Filter -->
            <div class="flex-1">
                <label for="priority" class="block text-sm font-medium text-gray-300 mb-2">Prioridade</label>
                <select name="priority" id="priority" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="todas" {{ $priority === 'todas' ? 'selected' : '' }}>Todas as Prioridades</option>
                    @foreach($priorityOptions as $key => $label)
                        <option value="{{ $key }}" {{ $priority === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                    </svg>
                    Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tickets Grid -->
@if($tickets->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach($tickets as $ticket)
            @php
                $statusColors = [
                    'aberto' => 'blue',
                    'em_andamento' => 'yellow',
                    'aguardando_cliente' => 'orange',
                    'resolvido' => 'green',
                    'fechado' => 'gray',
                ];
                $statusColor = $statusColors[$ticket->status] ?? 'blue';
                
                $priorityColors = [
                    'baixa' => 'green',
                    'normal' => 'blue',
                    'alta' => 'orange',
                    'urgente' => 'red',
                ];
                $priorityColor = $priorityColors[$ticket->priority] ?? 'blue';
            @endphp
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-{{ $statusColor }}-500/50 transition-all duration-300 group">
                <!-- Ticket Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-{{ $statusColor }}-400 transition-colors">
                            {{ $ticket->subject }}
                        </h3>
                        <p class="text-gray-400 text-sm line-clamp-2">{{ Str::limit($ticket->description, 80) }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $statusOptions[$ticket->status] ?? 'Aberto' }}
                    </span>
                </div>

                <!-- Ticket Info -->
                <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <div class="w-2 h-2 bg-{{ $priorityColor }}-400 rounded-full mr-2"></div>
                            {{ $priorityOptions[$ticket->priority] ?? 'Normal' }}
                        </span>
                        @if($ticket->clientProject)
                            <span class="text-blue-400">{{ Str::limit($ticket->clientProject->name, 20) }}</span>
                        @endif
                    </div>
                    <span>{{ $ticket->created_at->format('d/m/Y') }}</span>
                </div>

                <!-- Category Badge -->
                @if($ticket->category)
                    @php
                        $categoryLabels = [
                            'suporte_tecnico' => 'Suporte Técnico',
                            'bug_report' => 'Bug Report',
                            'nova_funcionalidade' => 'Nova Funcionalidade',
                            'duvida' => 'Dúvida',
                            'alteracao_projeto' => 'Alteração de Projeto',
                            'financeiro' => 'Financeiro',
                            'outro' => 'Outro',
                        ];
                        $categoryColors = [
                            'suporte_tecnico' => 'blue',
                            'bug_report' => 'red',
                            'nova_funcionalidade' => 'purple',
                            'duvida' => 'gray',
                            'alteracao_projeto' => 'orange',
                            'financeiro' => 'green',
                            'outro' => 'gray',
                        ];
                        $categoryColor = $categoryColors[$ticket->category] ?? 'gray';
                    @endphp
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-{{ $categoryColor }}-500/20 text-{{ $categoryColor }}-400 border border-{{ $categoryColor }}-500/30">
                            {{ $categoryLabels[$ticket->category] ?? 'Outro' }}
                        </span>
                    </div>
                @endif

                <!-- Last Update -->
                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <span>Ticket #{{ $ticket->id }}</span>
                    <span>{{ $ticket->updated_at->diffForHumans() }}</span>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end">
                    <a href="{{ route('client.support.show', $ticket) }}" class="bg-{{ $statusColor }}-600/20 hover:bg-{{ $statusColor }}-600/30 text-{{ $statusColor }}-400 px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-{{ $statusColor }}-500/30 hover:border-{{ $statusColor }}-500/50 flex items-center">
                        Ver Ticket
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($tickets->hasPages())
        <div class="flex justify-center">
            <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-4">
                {{ $tickets->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="text-center py-12">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Nenhum ticket encontrado</h3>
            <p class="text-gray-400 mb-6">Você ainda não possui tickets de suporte ou nenhum ticket corresponde aos filtros aplicados.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('client.support.create') }}" class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Novo Ticket
                </a>
                <a href="{{ route('client.dashboard') }}" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar ao Dashboard
                </a>
            </div>
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