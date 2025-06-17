@extends('layouts.client')

@section('title', '- Fatura #' . ($invoice->number ?? $invoice->id))
@section('page-title', 'Fatura #' . ($invoice->number ?? $invoice->id))

@section('content')
@php
    $statusColors = [
        'pendente' => 'yellow',
        'paga' => 'green',
        'vencida' => 'red',
        'cancelada' => 'gray',
    ];
    $statusColor = $statusColors[$invoice->status] ?? 'blue';
    
    $statusLabels = [
        'pendente' => 'Pendente',
        'paga' => 'Paga',
        'vencida' => 'Vencida',
        'cancelada' => 'Cancelada',
    ];
@endphp

<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-{{ $statusColor }}-600/20 to-emerald-600/20 backdrop-blur-md rounded-3xl border border-{{ $statusColor }}-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
            <div class="mb-6 lg:mb-0 flex-1">
                <div class="flex items-center mb-4">
                    <a href="{{ route('client.invoices.index') }}" class="text-gray-300 hover:text-white mr-4 p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-white">Fatura #{{ $invoice->number ?? $invoice->id }}</h1>
                </div>
                
                @if($invoice->description)
                    <p class="text-gray-300 text-lg mb-4">{{ $invoice->description }}</p>
                @endif
                
                <div class="flex flex-wrap items-center gap-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $statusLabels[$invoice->status] ?? 'Pendente' }}
                    </span>
                    @if($invoice->clientProject)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            {{ $invoice->clientProject->name }}
                        </span>
                    @endif
                    @if($invoice->due_date)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-500/20 text-gray-300 border border-gray-500/30">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Vence em {{ $invoice->due_date->format('d/m/Y') }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Amount Display -->
            <div class="flex-shrink-0 text-right">
                <div class="text-4xl font-bold text-{{ $statusColor }}-400 mb-2">
                    {{ $invoice->formatted_total_amount }}
                </div>
                <div class="text-gray-300">Valor Total</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Invoice Details -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Invoice Description -->
        @if($invoice->description)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Descrição dos Serviços
                </h3>
                <div class="bg-gray-700/30 rounded-2xl p-4">
                    <p class="text-gray-300">{{ $invoice->description }}</p>
                </div>
                
                <!-- Total -->
                <div class="border-t border-gray-700/50 mt-6 pt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-bold text-white">Valor Total</span>
                        <span class="text-2xl font-bold text-{{ $statusColor }}-400">{{ $invoice->formatted_total_amount }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Payment Information -->
        @if($invoice->status === 'paga' && $invoice->paid_date)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informações do Pagamento
                </h3>
                <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-green-400 font-semibold">Pagamento Confirmado</div>
                            <div class="text-gray-300 text-sm">Pago em {{ $invoice->paid_date->format('d/m/Y \à\s H:i') }}</div>
                            @if($invoice->payment_method)
                                <div class="text-gray-400 text-sm">Método: {{ $invoice->payment_method_label }}</div>
                            @endif
                        </div>
                        <div class="text-green-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Notes -->
        @if($invoice->notes)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Observações
                </h3>
                <div class="bg-gray-700/30 rounded-2xl p-4">
                    <p class="text-gray-300">{{ $invoice->notes }}</p>
                </div>
            </div>
        @endif

        @if($invoice->pix_qr_code)
            <div class="mt-6">
                <h4 class="text-gray-300 font-medium mb-3">Pague com PIX</h4>
                <div class="bg-gray-700/30 rounded-xl p-6 text-center">
                    <div class="flex justify-center mb-4">
                        <img src="{{ $invoice->pix_qr_code_url }}" alt="QR Code PIX" class="max-w-full h-48 bg-white p-2 rounded-lg">
                    </div>
                    <p class="text-sm text-gray-400 mb-4">Escaneie o QR Code acima com o seu aplicativo de banco para pagar via PIX</p>
                    
                    @if($invoice->pix_code)
                        <div class="mt-4">
                            <label for="pix-code" class="block text-sm font-medium text-gray-300 mb-2">Código PIX Copia e Cola</label>
                            <div class="relative">
                                <textarea id="pix-code" rows="2" readonly class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-2 font-mono text-sm">{{ $invoice->pix_code }}</textarea>
                                <button type="button" onclick="copyToClipboard('pix-code')" class="absolute right-2 top-2 bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 p-2 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Invoice PDF Document -->
        @if($invoice->has_pdf)
        <div class="mt-6">
            <h4 class="text-gray-300 font-medium mb-3">Documento da Fatura</h4>
            <div class="bg-gray-700/30 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-12 h-12 text-pink-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <h4 class="text-white font-medium">Fatura #{{ $invoice->invoice_number }}.pdf</h4>
                            <p class="text-gray-400 text-sm">PDF da fatura</p>
                        </div>
                    </div>
                    <a href="{{ $invoice->invoice_file_url }}" target="_blank" 
                        class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Ver PDF
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Invoice Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Detalhes
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                    <span class="text-gray-400">Número</span>
                    <span class="text-white font-medium">#{{ $invoice->invoice_number ?? $invoice->id }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                    <span class="text-gray-400">Data de Emissão</span>
                    <span class="text-white font-medium">{{ $invoice->issue_date ? $invoice->issue_date->format('d/m/Y') : $invoice->created_at->format('d/m/Y') }}</span>
                </div>
                @if($invoice->due_date)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Vencimento</span>
                        <span class="text-white font-medium">{{ $invoice->due_date->format('d/m/Y') }}</span>
                    </div>
                @endif
                @if($invoice->paid_date)
                    <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                        <span class="text-gray-400">Data do Pagamento</span>
                        <span class="text-white font-medium">{{ $invoice->paid_date->format('d/m/Y') }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-400">Status</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $statusLabels[$invoice->status] ?? 'Pendente' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Ações
            </h3>
            <div class="space-y-3">
                @if($invoice->status === 'pendente')
                    <button class="w-full flex items-center justify-center p-3 bg-green-600/20 rounded-xl hover:bg-green-600/30 transition-colors group border border-green-500/30">
                        <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 002 2zm8-8V9a2 2 0 00-2-2H9a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-1"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="text-white font-medium">Pagar Agora</div>
                            <div class="text-green-300 text-sm">PIX, Cartão ou Boleto</div>
                        </div>
                    </button>
                @endif
                
                <button class="w-full flex items-center justify-center p-3 bg-blue-600/20 rounded-xl hover:bg-blue-600/30 transition-colors group border border-blue-500/30">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-white font-medium">Baixar PDF</div>
                        <div class="text-blue-300 text-sm">Salvar fatura</div>
                    </div>
                </button>
                
                <a href="{{ route('client.support.create') }}" class="w-full flex items-center justify-center p-3 bg-purple-600/20 rounded-xl hover:bg-purple-600/30 transition-colors group border border-purple-500/30">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-white font-medium">Reportar Problema</div>
                        <div class="text-purple-300 text-sm">Abrir ticket</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Related Project -->
        @if($invoice->clientProject)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Projeto Relacionado
                </h3>
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-2xl p-4">
                    <h4 class="text-white font-semibold mb-2">{{ $invoice->clientProject->name }}</h4>
                    @if($invoice->clientProject->description)
                        <p class="text-gray-300 text-sm mb-3">{{ Str::limit($invoice->clientProject->description, 100) }}</p>
                    @endif
                    <a href="{{ route('client.projects.show', $invoice->clientProject) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                        Ver Projeto
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 