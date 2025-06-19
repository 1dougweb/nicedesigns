@extends('layouts.client')

@section('title', '- Orçamentos')
@section('page-title', 'Meus Orçamentos')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-600/20 to-blue-800/20 backdrop-blur-md rounded-3xl border border-blue-500/30 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-400 text-sm font-medium">Total</p>
                <p class="text-white text-2xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <div class="p-3 bg-blue-500/20 rounded-2xl">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-600/20 to-yellow-800/20 backdrop-blur-md rounded-3xl border border-yellow-500/30 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-400 text-sm font-medium">Pendentes</p>
                <p class="text-white text-2xl font-bold">{{ $stats['pending'] }}</p>
            </div>
            <div class="p-3 bg-yellow-500/20 rounded-2xl">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-600/20 to-green-800/20 backdrop-blur-md rounded-3xl border border-green-500/30 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-400 text-sm font-medium">Aceitos</p>
                <p class="text-white text-2xl font-bold">{{ $stats['accepted'] }}</p>
            </div>
            <div class="p-3 bg-green-500/20 rounded-2xl">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-red-600/20 to-red-800/20 backdrop-blur-md rounded-3xl border border-red-500/30 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-400 text-sm font-medium">Rejeitados</p>
                <p class="text-white text-2xl font-bold">{{ $stats['rejected'] }}</p>
            </div>
            <div class="p-3 bg-red-500/20 rounded-2xl">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-600/20 to-gray-800/20 backdrop-blur-md rounded-3xl border border-gray-500/30 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm font-medium">Expirados</p>
                <p class="text-white text-2xl font-bold">{{ $stats['expired'] }}</p>
            </div>
            <div class="p-3 bg-gray-500/20 rounded-2xl">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 mb-8">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[200px]">
            <select name="status" 
                    class="w-full bg-gray-700/50 border border-gray-600/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    onchange="this.form.submit()">
                <option value="">Todos os Status</option>
                @foreach($statusOptions as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        
        @if(request()->hasAny(['status']))
            <a href="{{ route('client.quotes.index') }}" 
               class="bg-gray-600/20 hover:bg-gray-600/30 text-gray-300 px-4 py-3 rounded-xl border border-gray-500/30 transition-colors">
                Limpar Filtros
            </a>
        @endif
    </form>
</div>

<!-- Quotes Grid -->
@if($quotes->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
        @foreach($quotes as $quote)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-gray-600/50 transition-all duration-300 group">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">
                            {{ $quote->title }}
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $quote->status_color }}-500/20 text-{{ $quote->status_color }}-400 border border-{{ $quote->status_color }}-500/30">
                            {{ $quote->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-gray-300 text-sm mb-4 line-clamp-2">{{ $quote->description }}</p>

                <!-- Quote Info -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-sm">Valor:</span>
                        <span class="text-white font-semibold">{{ $quote->formatted_total_amount }}</span>
                    </div>
                    @if($quote->timeline)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm">Prazo:</span>
                            <span class="text-white">{{ $quote->timeline }} dias</span>
                        </div>
                    @endif
                    @if($quote->valid_until)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-sm">Válido até:</span>
                            <span class="text-white text-sm">{{ $quote->valid_until->format('d/m/Y') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Services Preview -->
                @if($quote->services && count($quote->services) > 0)
                    <div class="mb-4">
                        <p class="text-gray-400 text-sm mb-2">Serviços incluídos:</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice($quote->services, 0, 3) as $service)
                                <span class="inline-block bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-lg border border-blue-500/30">
                                    {{ Str::limit($service, 20) }}
                                </span>
                            @endforeach
                            @if(count($quote->services) > 3)
                                <span class="inline-block bg-gray-500/20 text-gray-400 text-xs px-2 py-1 rounded-lg border border-gray-500/30">
                                    +{{ count($quote->services) - 3 }} mais
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col gap-2 pt-4 border-t border-gray-600/30">
                    <a href="{{ route('client.quotes.show', $quote) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-colors text-center">
                        Ver Detalhes
                    </a>
                    
                    @if($quote->is_pending)
                        <div class="grid grid-cols-2 gap-2">
                            <form action="{{ route('client.quotes.accept', $quote) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                        onclick="return confirm('Tem certeza que deseja aceitar este orçamento?')">
                                    Aceitar
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $quote->id }})" 
                                    class="w-full bg-red-600/20 hover:bg-red-600/30 text-red-400 px-3 py-2 rounded-lg text-sm font-medium transition-colors border border-red-500/30">
                                Rejeitar
                            </button>
                        </div>
                    @endif

                    <!-- PDF Actions -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('client.quotes.pdf.view', $quote) }}" target="_blank"
                           class="w-full bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 px-3 py-2 rounded-lg text-sm font-medium transition-colors border border-purple-500/30 text-center">
                            Ver PDF
                        </a>
                        <a href="{{ route('client.quotes.pdf.download', $quote) }}"
                           class="w-full bg-orange-600/20 hover:bg-orange-600/30 text-orange-400 px-3 py-2 rounded-lg text-sm font-medium transition-colors border border-orange-500/30 text-center">
                            Baixar PDF
                        </a>
                    </div>
                </div>

                <!-- Quote Meta -->
                <div class="flex items-center justify-between text-xs text-gray-500 mt-3 pt-3 border-t border-gray-600/30">
                    <span>Criado em {{ $quote->created_at->format('d/m/Y') }}</span>
                    @if($quote->creator)
                        <span>por {{ $quote->creator->display_name }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $quotes->appends(request()->query())->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12 max-w-md mx-auto">
            <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-white mb-2">Nenhum orçamento encontrado</h3>
            <p class="text-gray-400 mb-6">
                @if(request('status'))
                    Não há orçamentos com o status selecionado.
                @else
                    Você ainda não possui orçamentos. Nossa equipe entrará em contato em breve!
                @endif
            </p>
            @if(request()->hasAny(['status']))
                <a href="{{ route('client.quotes.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors">
                    Ver Todos os Orçamentos
                </a>
            @endif
        </div>
    </div>
@endif

<!-- Reject Quote Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50" onclick="closeRejectModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-gray-800 rounded-3xl border border-gray-700 p-6 w-full max-w-md" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-white">Rejeitar Orçamento</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-300 mb-2">
                        Motivo da rejeição (opcional)
                    </label>
                    <textarea id="reason" 
                              name="reason" 
                              rows="4" 
                              class="w-full bg-gray-700/50 border border-gray-600/50 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                              placeholder="Explique o motivo da rejeição para que possamos melhorar nossa proposta..."></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="closeRejectModal()" 
                            class="flex-1 bg-gray-600/20 hover:bg-gray-600/30 text-gray-300 px-4 py-2 rounded-xl border border-gray-500/30 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl transition-colors">
                        Rejeitar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openRejectModal(quoteId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/client/quotes/${quoteId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    document.getElementById('rejectForm').reset();
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRejectModal();
    }
});
</script>
@endpush
@endsection 