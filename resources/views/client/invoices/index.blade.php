@extends('layouts.client')

@section('title', '- Minhas Faturas')
@section('page-title', 'Minhas Faturas')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-green-600/20 to-emerald-600/20 backdrop-blur-md rounded-3xl border border-green-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-6 lg:mb-0">
                <h2 class="text-3xl font-bold text-white mb-2">
                    Minhas Faturas 💰
                </h2>
                <p class="text-gray-300 text-lg">
                    Acompanhe seus pagamentos e histórico financeiro.
                </p>
            </div>
            
            <!-- Invoice Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-white">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-300">Total</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-green-400">{{ $stats['paid'] }}</div>
                    <div class="text-sm text-gray-300">Pagas</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</div>
                    <div class="text-sm text-gray-300">Pendentes</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/20">
                    <div class="text-2xl font-bold text-red-400">{{ $stats['overdue'] }}</div>
                    <div class="text-sm text-gray-300">Vencidas</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
            </svg>
            Valor Total
        </h3>
        <div class="text-3xl font-bold text-green-400 mb-2">
            R$ {{ number_format($stats['total_amount'] ?? 0, 2, ',', '.') }}
        </div>
        <p class="text-gray-400">Total de todas as faturas</p>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Valor em Aberto
        </h3>
        <div class="text-3xl font-bold text-yellow-400 mb-2">
            R$ {{ number_format($stats['amount_due'] ?? 0, 2, ',', '.') }}
        </div>
        <p class="text-gray-400">Pendente de pagamento</p>
    </div>
</div>

<!-- Filters -->
<div class="mb-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <form method="GET" action="{{ route('client.invoices.index') }}" class="flex flex-col lg:flex-row gap-4">
            <!-- Status Filter -->
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" id="status" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="todos" {{ $status === 'todos' ? 'selected' : '' }}>Todos os Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                    </svg>
                    Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Invoices Grid -->
@if($invoices->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach($invoices as $invoice)
            @php
                $statusColors = [
                    'pendente' => 'yellow',
                    'paga' => 'green',
                    'vencida' => 'red',
                    'cancelada' => 'gray',
                ];
                $statusColor = $statusColors[$invoice->status] ?? 'blue';
            @endphp
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-{{ $statusColor }}-500/50 transition-all duration-300 group">
                <!-- Invoice Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-{{ $statusColor }}-400 transition-colors">
                            Fatura #{{ $invoice->number ?? $invoice->id }}
                        </h3>
                        @if($invoice->clientProject)
                            <p class="text-gray-400 text-sm">{{ $invoice->clientProject->name }}</p>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $statusOptions[$invoice->status] ?? 'Pendente' }}
                    </span>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <div class="text-3xl font-bold text-white">
                        R$ {{ number_format($invoice->amount, 2, ',', '.') }}
                    </div>
                    @if($invoice->description)
                        <p class="text-gray-400 text-sm mt-1">{{ Str::limit($invoice->description, 50) }}</p>
                    @endif
                </div>

                <!-- Invoice Info -->
                <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                    <div class="flex items-center space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $invoice->due_date ? $invoice->due_date->format('d/m/Y') : 'Sem vencimento' }}
                        </span>
                    </div>
                    <span>{{ $invoice->created_at->format('d/m/Y') }}</span>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end">
                    <a href="{{ route('client.invoices.show', $invoice) }}" class="bg-{{ $statusColor }}-600/20 hover:bg-{{ $statusColor }}-600/30 text-{{ $statusColor }}-400 px-4 py-2 rounded-xl font-medium transition-all duration-300 border border-{{ $statusColor }}-500/30 hover:border-{{ $statusColor }}-500/50 flex items-center">
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
    @if($invoices->hasPages())
        <div class="flex justify-center">
            <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-4">
                {{ $invoices->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="text-center py-12">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Nenhuma fatura encontrada</h3>
            <p class="text-gray-400 mb-6">Você ainda não possui faturas ou nenhuma fatura corresponde aos filtros aplicados.</p>
            <a href="{{ route('client.dashboard') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
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
    
    statusSelect.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush
@endsection 