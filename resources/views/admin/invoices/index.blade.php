@extends('layouts.admin')

@section('title', '- Faturas')
@section('page-title', 'Faturas')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Invoices -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-emerald-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <i class="fi fi-rr-calculator text-white text-2xl mt-2"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-400">Total</p>
            </div>
        </div>
    </div>

    <!-- Pending Invoices -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <i class="fi fi-rr-pending text-white text-2xl mt-2"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['pending'] }}</p>
                <p class="text-sm text-gray-400">Pendentes</p>
            </div>
        </div>
    </div>

    <!-- Paid Invoices -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <i class="fi fi-rr-comment-check text-white text-2xl mt-2"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['paid'] }}</p>
                <p class="text-sm text-gray-400">Pagas</p>
            </div>
        </div>
    </div>

    <!-- Overdue Invoices -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-red-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <i class="fi fi-rr-comment-info text-white text-2xl mt-2"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['overdue'] }}</p>
                <p class="text-sm text-gray-400">Vencidas</p>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Total Amount -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
        <i class="fi fi-rr-usd-circle text-green-400 text-2xl mt-2 mr-3"></i>
            Total Faturado
        </h3>
        <p class="text-3xl font-bold text-green-400">R$ {{ number_format($stats['total_amount'], 2, ',', '.') }}</p>
    </div>

    <!-- Pending Amount -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
        <i class="fi fi-rr-pending text-yellow-400 text-2xl mt-2 mr-3"></i>
            Aguardando Pagamento
        </h3>
        <p class="text-3xl font-bold text-yellow-400">R$ {{ number_format($stats['pending_amount'], 2, ',', '.') }}</p>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 mb-8">
    <form method="GET" action="{{ route('admin.invoices.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Buscar por título ou número..."
                       class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Todos os status</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Client Filter -->
            <div>
                <select name="client" 
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
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
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl transition-colors font-medium">
                    Filtrar
                </button>
                <a href="{{ route('admin.invoices.index') }}" 
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
        <h2 class="text-2xl font-bold text-white mb-2">Faturas</h2>
        <p class="text-gray-400">Gerencie todas as faturas emitidas para clientes</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('admin.invoices.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
           <i class="fi fi-rr-plus-small text-white text-2xl mt-2 mr-2"></i>
            Nova Fatura
        </a>
    </div>
</div>

<!-- Invoices Table -->
@if($invoices->count() > 0)
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Fatura</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Cliente</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Projeto</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Status</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Valor</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Vencimento</th>
                        <th class="text-right py-4 px-6 text-gray-300 font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr class="border-t border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                            <!-- Invoice Info -->
                            <td class="py-4 px-6">
                                <div>
                                    <h3 class="text-white font-medium">{{ $invoice->title }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $invoice->invoice_number }}</p>
                                    <p class="text-gray-500 text-xs">{{ $invoice->issue_date->format('d/m/Y') }}</p>
                                </div>
                            </td>

                            <!-- Client -->
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ substr($invoice->user->full_name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $invoice->user->full_name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $invoice->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Project -->
                            <td class="py-4 px-6">
                                @if($invoice->clientProject)
                                    <div>
                                        <p class="text-white">{{ Str::limit($invoice->clientProject->name, 30) }}</p>
                                        <p class="text-gray-400 text-sm">Projeto do cliente</p>
                                    </div>
                                @else
                                    <span class="text-gray-500">Sem projeto</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                @php
                                    $statusColors = [
                                        'pendente' => 'yellow',
                                        'paga' => 'green',
                                        'vencida' => 'red',
                                        'cancelada' => 'gray'
                                    ];
                                    $statusColor = $statusColors[$invoice->status] ?? 'gray';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                                    {{ $statusOptions[$invoice->status] ?? $invoice->status }}
                                </span>
                            </td>

                            <!-- Amount -->
                            <td class="py-4 px-6">
                                <div class="text-sm">
                                    <p class="text-white font-bold text-lg">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2, ',', '.') }}</p>
                                    @if($invoice->discount > 0)
                                        <p class="text-gray-400 text-xs">Desconto: {{ $invoice->currency }} {{ number_format($invoice->discount, 2, ',', '.') }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Due Date -->
                            <td class="py-4 px-6">
                                <div class="text-sm">
                                    <p class="text-white">{{ $invoice->due_date->format('d/m/Y') }}</p>
                                    @if($invoice->due_date->isPast() && $invoice->status !== 'paga')
                                        <p class="text-red-400">Vencida há {{ $invoice->due_date->diffForHumans() }}</p>
                                    @elseif($invoice->status === 'paga' && $invoice->paid_date)
                                        <p class="text-green-400">Paga em {{ $invoice->paid_date->format('d/m/Y') }}</p>
                                    @else
                                        <p class="text-gray-400">{{ $invoice->due_date->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                       class="p-2 text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/10 rounded-lg transition-colors" 
                                       title="Visualizar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.invoices.edit', $invoice) }}" 
                                       class="p-2 text-yellow-400 hover:text-yellow-300 hover:bg-yellow-500/10 rounded-lg transition-colors" 
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    @if($invoice->status === 'pendente')
                                        <button onclick="markAsPaid({{ $invoice->id }})" 
                                                class="p-2 text-green-400 hover:text-green-300 hover:bg-green-500/10 rounded-lg transition-colors" 
                                                title="Marcar como paga">
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
    @if($invoices->hasPages())
        <div class="mt-8">
            {{ $invoices->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
        <i class="fi fi-rr-calculator text-white text-4xl mt-2"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-4">Nenhuma fatura encontrada</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            @if(request()->hasAny(['search', 'status', 'client']))
                Não foram encontradas faturas com os filtros aplicados. Tente ajustar os critérios de busca.
            @else
                Você ainda não criou nenhuma fatura. Que tal começar criando a primeira?
            @endif
        </p>
        
        @if(request()->hasAny(['search', 'status', 'client']))
            <a href="{{ route('admin.invoices.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors mr-4">
                Limpar Filtros
            </a>
        @endif
        
        <a href="{{ route('admin.invoices.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105">
           <i class="fi fi-rr-plus-small text-white text-2xl mt-2 mr-2"></i>
            Criar Primeira Fatura
        </a>
    </div>
@endif

<!-- Mark as Paid Modal -->
<div id="markAsPaidModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-6">Marcar como Paga</h3>
        <form id="markAsPaidForm" action="" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">
                        Método de Pagamento <span class="text-red-400">*</span>
                    </label>
                    <select name="payment_method" id="payment_method" required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <option value="">Selecione o método</option>
                        <option value="pix">PIX</option>
                        <option value="transferencia">Transferência Bancária</option>
                        <option value="boleto">Boleto</option>
                        <option value="cartao_credito">Cartão de Crédito</option>
                        <option value="cartao_debito">Cartão de Débito</option>
                        <option value="dinheiro">Dinheiro</option>
                    </select>
                </div>

                <div>
                    <label for="payment_reference" class="block text-sm font-medium text-gray-300 mb-2">
                        Referência do Pagamento
                    </label>
                    <input type="text" name="payment_reference" id="payment_reference"
                           placeholder="ID da transação, comprovante, etc."
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>

                <div>
                    <label for="payment_notes" class="block text-sm font-medium text-gray-300 mb-2">
                        Observações
                    </label>
                    <textarea name="payment_notes" id="payment_notes" rows="3"
                              placeholder="Observações sobre o pagamento..."
                              class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-8">
                <button type="button" onclick="closeMarkAsPaidModal()" 
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-xl transition-all duration-300">
                    Marcar como Paga
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAsPaid(invoiceId) {
    const modal = document.getElementById('markAsPaidModal');
    const form = document.getElementById('markAsPaidForm');
    
    form.action = `/admin/invoices/${invoiceId}/mark-as-paid`;
    modal.classList.remove('hidden');
}

function closeMarkAsPaidModal() {
    const modal = document.getElementById('markAsPaidModal');
    modal.classList.add('hidden');
    
    // Reset form
    document.getElementById('markAsPaidForm').reset();
}

// Close modal when clicking outside
document.getElementById('markAsPaidModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMarkAsPaidModal();
    }
});
</script>
@endpush 