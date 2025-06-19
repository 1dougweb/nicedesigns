@extends('layouts.admin')

@section('title', $quote->title)

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">{{ $quote->title }}</h1>
            <p class="text-gray-400">Orçamento para {{ $quote->user->display_name }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if($quote->status === 'pendente')
                <button onclick="cancelQuote()" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-2 rounded-xl border border-red-500/30 transition-colors">
                    Cancelar Orçamento
                </button>
            @endif
            
            <form action="{{ route('admin.quotes.duplicate', $quote) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 px-4 py-2 rounded-xl border border-blue-500/30 transition-colors">
                    Duplicar
                </button>
            </form>

            <!-- PDF Actions -->
            <a href="{{ route('admin.quotes.pdf.view', $quote) }}" target="_blank" class="bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 px-4 py-2 rounded-xl border border-purple-500/30 transition-colors">
                Ver PDF
            </a>
            
            <a href="{{ route('admin.quotes.pdf.download', $quote) }}" class="bg-orange-600/20 hover:bg-orange-600/30 text-orange-400 px-4 py-2 rounded-xl border border-orange-500/30 transition-colors">
                Baixar PDF
            </a>
            
            <a href="{{ route('admin.quotes.edit', $quote) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-xl transition-colors">
                Editar
            </a>
            
            <a href="{{ route('admin.quotes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl transition-colors">
                Voltar
            </a>
        </div>
    </div>

    <!-- Status Card -->
    <div class="bg-gradient-to-r from-{{ $quote->status_color ?? 'orange' }}-600/20 to-{{ $quote->status_color ?? 'orange' }}-800/20 backdrop-blur-md rounded-3xl border border-{{ $quote->status_color ?? 'orange' }}-500/30 p-8 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="mb-4 lg:mb-0">
                <div class="flex items-center gap-3 mb-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-{{ $quote->status_color ?? 'orange' }}-500/20 text-{{ $quote->status_color ?? 'orange' }}-400 border border-{{ $quote->status_color ?? 'orange' }}-500/30">
                        {{ $quote->status_label }}
                    </span>
                    @if($quote->is_expired)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                            Expirado
                        </span>
                    @endif
                </div>
                <div class="flex items-center gap-6 text-sm text-gray-300">
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
                    @if($quote->accepted_at)
                        <span class="flex items-center text-green-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Aceito em {{ $quote->accepted_at->format('d/m/Y \à\s H:i') }}
                        </span>
                    @endif
                    @if($quote->rejected_at)
                        <span class="flex items-center text-red-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Rejeitado em {{ $quote->rejected_at->format('d/m/Y \à\s H:i') }}
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
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column -->
        <div class="space-y-8">
            <!-- Client Information -->
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informações do Cliente
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Nome:</span>
                        <span class="text-white">{{ $quote->user->display_name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Email:</span>
                        <span class="text-white">{{ $quote->user->email }}</span>
                    </div>
                    @if($quote->user->phone)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Telefone:</span>
                            <span class="text-white">{{ $quote->user->formatted_phone }}</span>
                        </div>
                    @endif
                    @if($quote->user->company_name)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Empresa:</span>
                            <span class="text-white">{{ $quote->user->company_name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Services -->
            @if($quote->services && count($quote->services) > 0)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Description & Requirements -->
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Descrição do Projeto
                </h3>
                <div class="bg-gray-700/30 rounded-xl p-4 mb-4">
                    <p class="text-gray-300 whitespace-pre-line">{{ $quote->description }}</p>
                </div>
                
                @if($quote->requirements)
                    <h4 class="text-lg font-semibold text-white mb-3">Requisitos Específicos</h4>
                    <div class="bg-gray-700/30 rounded-xl p-4">
                        <p class="text-gray-300 whitespace-pre-line">{{ $quote->requirements }}</p>
                    </div>
                @endif
            </div>

            <!-- Payment Terms -->
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

            <!-- Notes Section -->
            @if($quote->client_notes || $quote->admin_notes || $quote->rejection_reason)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
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
                                <h4 class="text-blue-400 font-semibold mb-2">Comentários do Cliente:</h4>
                                <p class="text-gray-300 whitespace-pre-line">{{ $quote->client_notes }}</p>
                            </div>
                        @endif
                        @if($quote->admin_notes)
                            <div class="bg-gray-600/10 border border-gray-500/30 rounded-xl p-4">
                                <h4 class="text-gray-400 font-semibold mb-2">Observações Internas:</h4>
                                <p class="text-gray-300 whitespace-pre-line">{{ $quote->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Related Projects -->
            @if($quote->clientProjects->count() > 0)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Projetos Relacionados
                    </h3>
                    <div class="space-y-3">
                        @foreach($quote->clientProjects as $project)
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <div>
                                    <h4 class="text-white font-medium">{{ $project->title }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $project->status_label }}</p>
                                </div>
                                <a href="{{ route('admin.client-projects.show', $project) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                                    Ver Projeto
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Quote Modal -->
@if($quote->status === 'pendente')
    <div id="cancelModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50" onclick="closeCancelModal()">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-800 rounded-3xl border border-gray-700 p-6 w-full max-w-md" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Cancelar Orçamento</h3>
                    <button onclick="closeCancelModal()" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <p class="text-gray-300 mb-4">Tem certeza que deseja cancelar este orçamento? Esta ação não pode ser desfeita.</p>
                
                <form action="{{ route('admin.quotes.cancel', $quote) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-3">
                        <button type="button" 
                                onclick="closeCancelModal()" 
                                class="flex-1 bg-gray-600/20 hover:bg-gray-600/30 text-gray-300 px-4 py-2 rounded-xl border border-gray-500/30 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl transition-colors">
                            Sim, Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
function cancelQuote() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCancelModal();
    }
});
</script>
@endpush
@endsection 