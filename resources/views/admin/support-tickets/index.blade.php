@extends('layouts.admin')

@section('title', '- Tickets de Suporte')
@section('page-title', 'Tickets de Suporte')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Tickets -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-orange-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-400">Total</p>
            </div>
        </div>
    </div>

    <!-- Open Tickets -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-red-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['open'] }}</p>
                <p class="text-sm text-gray-400">Abertos</p>
            </div>
        </div>
    </div>

    <!-- Pending Response -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['pending_response'] }}</p>
                <p class="text-sm text-gray-400">Aguardando Cliente</p>
            </div>
        </div>
    </div>

    <!-- Resolved Today -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['resolved_today'] }}</p>
                <p class="text-sm text-gray-400">Resolvidos Hoje</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 mb-8">
    <form method="GET" action="{{ route('admin.support-tickets.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Search -->
            <div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Buscar por assunto ou número..."
                       class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
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
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Todas as prioridades</option>
                    @foreach($priorityOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('priority') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Assigned Filter -->
            <div>
                <select name="assigned_to" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Todos os responsáveis</option>
                    <option value="unassigned" {{ request('assigned_to') == 'unassigned' ? 'selected' : '' }}>
                        Não atribuídos
                    </option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ request('assigned_to') == $admin->id ? 'selected' : '' }}>
                            {{ $admin->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Client Filter -->
            <div>
                <select name="client" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
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
                        class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-xl transition-colors font-medium">
                    Filtrar
                </button>
                <a href="{{ route('admin.support-tickets.index') }}" 
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
        <h2 class="text-2xl font-bold text-white mb-2">Tickets de Suporte</h2>
        <p class="text-gray-400">Gerencie todos os tickets de suporte dos clientes</p>
    </div>
    <div class="mt-4 sm:mt-0 flex space-x-4">
        <a href="{{ route('admin.support-tickets.analytics') }}" 
           class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Analytics
        </a>
    </div>
</div>

<!-- Tickets Table -->
@if($tickets->count() > 0)
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Ticket</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Cliente</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Status</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Prioridade</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Responsável</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Criado</th>
                        <th class="text-right py-4 px-6 text-gray-300 font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="border-t border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                            <!-- Ticket Info -->
                            <td class="py-4 px-6">
                                <div>
                                    <h3 class="text-white font-medium">{{ Str::limit($ticket->subject, 40) }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $ticket->ticket_number }}</p>
                                    @if($ticket->clientProject)
                                        <p class="text-gray-500 text-xs">Projeto: {{ Str::limit($ticket->clientProject->name, 30) }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Client -->
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ substr($ticket->user->full_name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $ticket->user->full_name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $ticket->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                @php
                                    $statusColors = [
                                        'aberto' => 'red',
                                        'em_andamento' => 'blue',
                                        'aguardando_cliente' => 'yellow',
                                        'resolvido' => 'green',
                                        'fechado' => 'gray'
                                    ];
                                    $statusColor = $statusColors[$ticket->status] ?? 'gray';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                                    {{ $statusOptions[$ticket->status] ?? $ticket->status }}
                                </span>
                            </td>

                            <!-- Priority -->
                            <td class="py-4 px-6">
                                @php
                                    $priorityColors = [
                                        'baixa' => 'gray',
                                        'normal' => 'blue',
                                        'alta' => 'yellow',
                                        'urgente' => 'red'
                                    ];
                                    $priorityColor = $priorityColors[$ticket->priority] ?? 'gray';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $priorityColor }}-500/20 text-{{ $priorityColor }}-400 border border-{{ $priorityColor }}-500/30">
                                    {{ $priorityOptions[$ticket->priority] ?? $ticket->priority }}
                                </span>
                                @if($ticket->priority === 'urgente')
                                    <span class="animate-pulse inline-block w-2 h-2 bg-red-500 rounded-full ml-2"></span>
                                @endif
                            </td>

                            <!-- Assigned -->
                            <td class="py-4 px-6">
                                @if($ticket->assignedUser)
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-white font-bold text-xs">{{ substr($ticket->assignedUser->full_name, 0, 2) }}</span>
                                        </div>
                                        <span class="text-white text-sm">{{ $ticket->assignedUser->full_name }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500 text-sm">Não atribuído</span>
                                @endif
                            </td>

                            <!-- Created -->
                            <td class="py-4 px-6">
                                <div class="text-sm">
                                    <p class="text-white">{{ $ticket->created_at->format('d/m/Y') }}</p>
                                    <p class="text-gray-400">{{ $ticket->created_at->format('H:i') }}</p>
                                    <p class="text-gray-500 text-xs">{{ $ticket->created_at->diffForHumans() }}</p>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.support-tickets.show', $ticket) }}" 
                                       class="p-2 text-orange-400 hover:text-orange-300 hover:bg-orange-500/10 rounded-lg transition-colors" 
                                       title="Visualizar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    @if($ticket->status === 'aberto')
                                        <button onclick="quickAssign({{ $ticket->id }})" 
                                                class="p-2 text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 rounded-lg transition-colors" 
                                                title="Atribuir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </button>
                                    @endif

                                    @if(in_array($ticket->status, ['aberto', 'em_andamento']))
                                        <button onclick="quickResolve({{ $ticket->id }})" 
                                                class="p-2 text-green-400 hover:text-green-300 hover:bg-green-500/10 rounded-lg transition-colors" 
                                                title="Resolver">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($tickets->hasPages())
        <div class="mt-8">
            {{ $tickets->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-4">Nenhum ticket encontrado</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            @if(request()->hasAny(['search', 'status', 'priority', 'assigned_to', 'client']))
                Não foram encontrados tickets com os filtros aplicados. Tente ajustar os critérios de busca.
            @else
                Nenhum ticket de suporte foi aberto ainda. Os tickets aparecerão aqui quando os clientes precisarem de ajuda.
            @endif
        </p>
        
        @if(request()->hasAny(['search', 'status', 'priority', 'assigned_to', 'client']))
            <a href="{{ route('admin.support-tickets.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                Limpar Filtros
            </a>
        @endif
    </div>
@endif

<!-- Quick Assign Modal -->
<div id="quickAssignModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-6">Atribuir Ticket</h3>
        <form id="quickAssignForm" action="" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="quick_assigned_to" class="block text-sm font-medium text-gray-300 mb-2">
                        Responsável <span class="text-red-400">*</span>
                    </label>
                    <select name="assigned_to" id="quick_assigned_to" required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <option value="">Selecione um responsável</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->full_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-8">
                <button type="button" onclick="closeQuickAssignModal()" 
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-medium rounded-xl transition-all duration-300">
                    Atribuir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Resolve Modal -->
<div id="quickResolveModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-6">Resolver Ticket</h3>
        <form id="quickResolveForm" action="" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="resolution_message" class="block text-sm font-medium text-gray-300 mb-2">
                        Mensagem de Resolução
                    </label>
                    <textarea name="resolution_message" id="resolution_message" rows="4"
                              placeholder="Descreva como o problema foi resolvido..."
                              class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-8">
                <button type="button" onclick="closeQuickResolveModal()" 
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-xl transition-all duration-300">
                    Resolver
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function quickAssign(ticketId) {
    const modal = document.getElementById('quickAssignModal');
    const form = document.getElementById('quickAssignForm');
    
    form.action = `/admin/support-tickets/${ticketId}/assign`;
    modal.classList.remove('hidden');
}

function closeQuickAssignModal() {
    const modal = document.getElementById('quickAssignModal');
    modal.classList.add('hidden');
    
    // Reset form
    document.getElementById('quickAssignForm').reset();
}

function quickResolve(ticketId) {
    const modal = document.getElementById('quickResolveModal');
    const form = document.getElementById('quickResolveForm');
    
    form.action = `/admin/support-tickets/${ticketId}/resolve`;
    modal.classList.remove('hidden');
}

function closeQuickResolveModal() {
    const modal = document.getElementById('quickResolveModal');
    modal.classList.add('hidden');
    
    // Reset form
    document.getElementById('quickResolveForm').reset();
}

// Close modals when clicking outside
document.getElementById('quickAssignModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickAssignModal();
    }
});

document.getElementById('quickResolveModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickResolveModal();
    }
});
</script>
@endpush 