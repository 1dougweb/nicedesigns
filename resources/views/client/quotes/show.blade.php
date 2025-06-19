@extends('layouts.client')

@section('title', '- ' . $quote->title)
@section('page-title', 'Detalhes do Orçamento')

@section('content')
<!-- Quote Header -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-{{ $quote->status_color ?? 'orange' }}-600/20 to-{{ $quote->status_color ?? 'orange' }}-800/20 backdrop-blur-md rounded-3xl border border-{{ $quote->status_color ?? 'orange' }}-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
            <div class="mb-4 lg:mb-0">
                <div class="flex items-center gap-3 mb-3">
                    <h1 class="text-3xl font-bold text-white">{{ $quote->title }}</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $quote->status_color ?? 'orange' }}-500/20 text-{{ $quote->status_color ?? 'orange' }}-400 border border-{{ $quote->status_color ?? 'orange' }}-500/30">
                        {{ $quote->status_label }}
                    </span>
                </div>
                <p class="text-gray-300 text-lg">{{ $quote->description }}</p>
                <div class="flex items-center gap-4 mt-4 text-sm text-gray-400">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Criado em {{ $quote->created_at->format('d/m/Y \à\s H:i') }}
                    </span>
                    @if($quote->valid_until)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Válido até {{ $quote->valid_until->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Budget Summary -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 lg:min-w-[280px]">
                <div class="text-center">
                    <p class="text-gray-300 text-sm mb-2">Valor Total</p>
                    <p class="text-3xl font-bold text-white mb-2">{{ $quote->formatted_total_amount }}</p>
                    @if($quote->discount_amount || $quote->discount_percentage)
                        <div class="text-sm text-gray-400">
                            <span class="line-through">{{ $quote->formatted_budget }}</span>
                            @if($quote->discount_percentage)
                                <span class="text-green-400 ml-2">{{ $quote->discount_percentage }}% OFF</span>
                            @endif
                        </div>
                    @endif
                    @if($quote->timeline)
                        <div class="mt-3 pt-3 border-t border-white/20">
                            <p class="text-gray-300 text-sm">Prazo de Entrega</p>
                            <p class="text-white font-semibold">{{ $quote->timeline }} dias</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            @if($quote->is_pending)
                <button onclick="acceptQuote()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Aceitar Orçamento
                </button>
                <button onclick="rejectQuote()" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-6 py-3 rounded-xl font-medium transition-colors border border-red-500/30 hover:border-red-500/50 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Rejeitar Orçamento
                </button>
                <button onclick="addNotes()" class="bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 px-6 py-3 rounded-xl font-medium transition-colors border border-blue-500/30 hover:border-blue-500/50 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 0v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Adicionar Comentários
                </button>
            @endif
            
            <!-- PDF Actions -->
            <div class="flex gap-2">
                <a href="{{ route('client.quotes.pdf.view', $quote) }}" target="_blank" class="bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 px-4 py-3 rounded-xl font-medium transition-colors border border-purple-500/30 hover:border-purple-500/50 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Ver PDF
                </a>
                <a href="{{ route('client.quotes.pdf.download', $quote) }}" class="bg-orange-600/20 hover:bg-orange-600/30 text-orange-400 px-4 py-3 rounded-xl font-medium transition-colors border border-orange-500/30 hover:border-orange-500/50 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    </svg>
                    Baixar PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quote Details -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Services -->
    @if($quote->services && count($quote->services) > 0)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Serviços Incluídos
            </h3>
            <div class="space-y-3">
                @foreach($quote->services as $service)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl">
                        <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-white">{{ $service }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Deliverables -->
    @if($quote->deliverables && count($quote->deliverables) > 0)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Entregáveis
            </h3>
            <div class="space-y-3">
                @foreach($quote->deliverables as $deliverable)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl">
                        <svg class="w-5 h-5 text-purple-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-white">{{ $deliverable }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Requirements & Payment Terms -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    @if($quote->requirements)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Requisitos
            </h3>
            <div class="bg-gray-700/30 rounded-xl p-4">
                <p class="text-gray-300 whitespace-pre-line">{{ $quote->requirements }}</p>
            </div>
        </div>
    @endif

    @if($quote->payment_terms && count($quote->payment_terms) > 0)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
                Termos de Pagamento
            </h3>
            <div class="space-y-2">
                @foreach($quote->payment_terms as $term)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl">
                        <svg class="w-5 h-5 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span class="text-gray-300">{{ $term }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Notes Section -->
@if($quote->client_notes || $quote->admin_notes || $quote->rejection_reason)
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 mb-8">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 0v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Observações
        </h3>
        <div class="space-y-4">
            @if($quote->rejection_reason)
                <div class="bg-red-600/10 border border-red-500/30 rounded-xl p-4">
                    <h4 class="text-red-400 font-semibold mb-2">Motivo da Rejeição:</h4>
                    <p class="text-gray-300">{{ $quote->rejection_reason }}</p>
                </div>
            @endif
            @if($quote->client_notes)
                <div class="bg-blue-600/10 border border-blue-500/30 rounded-xl p-4">
                    <h4 class="text-blue-400 font-semibold mb-2">Seus Comentários:</h4>
                    <p class="text-gray-300 whitespace-pre-line">{{ $quote->client_notes }}</p>
                </div>
            @endif
            @if($quote->admin_notes)
                <div class="bg-gray-600/10 border border-gray-500/30 rounded-xl p-4">
                    <h4 class="text-gray-400 font-semibold mb-2">Observações da Equipe:</h4>
                    <p class="text-gray-300 whitespace-pre-line">{{ $quote->admin_notes }}</p>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Back Button -->
<div class="flex justify-start">
    <a href="{{ route('client.quotes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar aos Orçamentos
    </a>
</div>

<!-- Accept Quote Modal -->
<div id="acceptQuoteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-white mb-4">Aceitar Orçamento</h3>
        <p class="text-gray-300 mb-6">Tem certeza de que deseja aceitar este orçamento? Esta ação não pode ser desfeita e habilitará o acesso aos seus projetos.</p>
        <div class="flex gap-3">
            <form action="{{ route('client.quotes.accept', $quote) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    Sim, Aceitar
                </button>
            </form>
            <button onclick="closeAcceptModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                Cancelar
            </button>
        </div>
    </div>
</div>

<!-- Reject Quote Modal -->
<div id="rejectQuoteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-white mb-4">Rejeitar Orçamento</h3>
        <form action="{{ route('client.quotes.reject', $quote) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-300 mb-2">Motivo da rejeição (opcional):</label>
                <textarea name="reason" id="reason" rows="3" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Descreva o motivo da rejeição..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    Rejeitar
                </button>
                <button type="button" onclick="closeRejectModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Notes Modal -->
<div id="addNotesModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-white mb-4">Adicionar Comentários</h3>
        <form action="{{ route('client.quotes.notes', $quote) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="client_notes" class="block text-sm font-medium text-gray-300 mb-2">Seus comentários:</label>
                <textarea name="client_notes" id="client_notes" rows="4" required class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Adicione seus comentários sobre o orçamento...">{{ $quote->client_notes }}</textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    Salvar Comentários
                </button>
                <button type="button" onclick="closeNotesModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function acceptQuote() {
    document.getElementById('acceptQuoteModal').classList.remove('hidden');
}

function rejectQuote() {
    document.getElementById('rejectQuoteModal').classList.remove('hidden');
}

function addNotes() {
    document.getElementById('addNotesModal').classList.remove('hidden');
}

function closeAcceptModal() {
    document.getElementById('acceptQuoteModal').classList.add('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectQuoteModal').classList.add('hidden');
}

function closeNotesModal() {
    document.getElementById('addNotesModal').classList.add('hidden');
}

// Close modals when clicking outside
document.querySelectorAll('[id$="Modal"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection 