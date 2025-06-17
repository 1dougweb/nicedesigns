@extends('layouts.admin')

@section('title', '- Fatura #' . $invoice->invoice_number)
@section('page-title', 'Fatura #' . $invoice->invoice_number)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">{{ $invoice->title }}</h2>
        <p class="text-gray-400">Fatura #{{ $invoice->invoice_number }} - {{ $invoice->user->full_name }}</p>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('admin.invoices.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
        <a href="{{ route('admin.invoices.edit', $invoice) }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Editar
        </a>
    </div>
</div>

<!-- Status Alert -->
@if($invoice->status === 'vencida')
    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-red-400 font-bold">Fatura Vencida</h3>
                <p class="text-red-400/80">Esta fatura venceu em {{ $invoice->due_date->format('d/m/Y') }} ({{ $invoice->due_date->diffForHumans() }})</p>
            </div>
        </div>
    </div>
@elseif($invoice->status === 'paga')
    <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-green-400 font-bold">Fatura Paga</h3>
                <p class="text-green-400/80">
                    Paga em {{ $invoice->paid_date ? $invoice->paid_date->format('d/m/Y') : 'Data não informada' }}
                    @if($invoice->payment_method)
                        via {{ ucfirst(str_replace('_', ' ', $invoice->payment_method)) }}
                    @endif
                </p>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Invoice Overview -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Detalhes da Fatura
            </h3>

            <!-- Invoice Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="text-gray-300 font-medium mb-2">Número da Fatura</h4>
                    <p class="text-white font-mono">{{ $invoice->invoice_number }}</p>
                </div>

                <div>
                    <h4 class="text-gray-300 font-medium mb-2">Status</h4>
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
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            @if($invoice->description)
                <div class="mb-6">
                    <h4 class="text-gray-300 font-medium mb-3">Descrição dos Serviços</h4>
                    <div class="text-gray-300 leading-relaxed">
                        {!! nl2br(e($invoice->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Financial Breakdown -->
            <div class="bg-gray-700/30 rounded-xl p-6">
                <h4 class="text-gray-300 font-medium mb-4">Breakdown Financeiro</h4>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Subtotal:</span>
                        <span class="text-white font-medium">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
                    </div>
                    
                    @if($invoice->discount > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Desconto:</span>
                            <span class="text-red-400 font-medium">- {{ $invoice->currency }} {{ number_format($invoice->discount, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    
                    @if($invoice->tax > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Imposto/Taxa:</span>
                            <span class="text-white font-medium">+ {{ $invoice->currency }} {{ number_format($invoice->tax, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    
                    <hr class="border-gray-600">
                    
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-white">Total:</span>
                        <span class="text-2xl font-bold text-emerald-400">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            @if($invoice->payment_instructions)
                <div class="mt-6">
                    <h4 class="text-gray-300 font-medium mb-3">Instruções de Pagamento</h4>
                    <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4">
                        <div class="text-blue-300 leading-relaxed">
                            {!! nl2br(e($invoice->payment_instructions)) !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Payment Terms -->
            @if($invoice->payment_terms)
                <div class="mt-6">
                    <h4 class="text-gray-300 font-medium mb-2">Condições de Pagamento</h4>
                    <p class="text-gray-300">{{ $invoice->payment_terms }}</p>
                </div>
            @endif
        </div>

        <!-- Related Project -->
        @if($invoice->clientProject)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Projeto Relacionado
                </h3>

                <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                    <div>
                        <h4 class="text-white font-medium">{{ $invoice->clientProject->name }}</h4>
                        <p class="text-gray-400 text-sm">{{ $invoice->clientProject->status_label }}</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-700 rounded-full h-2 mr-3" style="width: 200px;">
                                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-2 rounded-full" 
                                     style="width: {{ $invoice->clientProject->progress_percentage }}%"></div>
                            </div>
                            <span class="text-cyan-400 text-sm font-medium">{{ $invoice->clientProject->progress_percentage }}%</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.client-projects.show', $invoice->clientProject) }}" 
                       class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-colors">
                        Ver Projeto
                    </a>
                </div>
            </div>
        @endif

        <!-- Payment History -->
        @if($invoice->payment_method || $invoice->payment_reference || $invoice->payment_notes)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informações de Pagamento
                </h3>

                <div class="space-y-4">
                    @if($invoice->payment_method)
                        <div>
                            <h4 class="text-gray-300 font-medium mb-2">Método de Pagamento</h4>
                            <p class="text-white">{{ $invoice->payment_method_label }}</p>
                        </div>
                    @endif

                    @if($invoice->payment_reference)
                        <div>
                            <h4 class="text-gray-300 font-medium mb-2">Referência do Pagamento</h4>
                            <p class="text-white font-mono">{{ $invoice->payment_reference }}</p>
                        </div>
                    @endif

                    @if($invoice->paid_date)
                        <div>
                            <h4 class="text-gray-300 font-medium mb-2">Data do Pagamento</h4>
                            <p class="text-white">{{ $invoice->paid_date->format('d/m/Y') }}</p>
                        </div>
                    @endif

                    @if($invoice->payment_notes)
                        <div>
                            <h4 class="text-gray-300 font-medium mb-2">Observações do Pagamento</h4>
                            <div class="text-gray-300 leading-relaxed">
                                {!! nl2br(e($invoice->payment_notes)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Invoice PDF Document -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Documento da Fatura
            </h3>

            @if($invoice->has_pdf)
                <div class="bg-gray-700/30 rounded-xl p-6 mb-6">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Ver PDF
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-gray-700/30 rounded-xl p-6 mb-6 text-center">
                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-400 mb-2">Nenhum documento PDF foi anexado a esta fatura</p>
                </div>
            @endif

            <!-- Upload PDF Form -->
            <form action="{{ route('admin.invoices.upload-pdf', $invoice) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                <h4 class="text-white font-medium mb-4">Fazer Upload de PDF</h4>
                
                <div class="flex items-center space-x-4">
                    <div class="relative flex-1">
                        <input type="file" name="invoice_pdf" id="invoice_pdf_upload" accept=".pdf" class="sr-only">
                        <label for="invoice_pdf_upload" class="cursor-pointer bg-gray-700/50 border border-gray-600 text-white rounded-xl py-3 px-4 w-full flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span id="file_name_display">Selecionar Arquivo PDF</span>
                        </label>
                    </div>
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Upload
                    </button>
                </div>
                @error('invoice_pdf')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <!-- Internal Notes -->
        @if($invoice->notes)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Observações Internas
                </h3>
                <div class="text-gray-300 leading-relaxed">
                    {!! nl2br(e($invoice->notes)) !!}
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Invoice Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Informações da Fatura</h3>
            
            <div class="space-y-4">
                <!-- Client -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Cliente</h4>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">{{ substr($invoice->user->full_name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $invoice->user->full_name }}</p>
                            <p class="text-gray-400 text-sm">{{ $invoice->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Data de Emissão</h4>
                    <p class="text-white">{{ $invoice->issue_date->format('d/m/Y') }}</p>
                </div>

                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Data de Vencimento</h4>
                    <p class="text-white">{{ $invoice->due_date->format('d/m/Y') }}</p>
                    @if($invoice->due_date->isPast() && $invoice->status !== 'paga')
                        <p class="text-red-400 text-sm">Vencida há {{ $invoice->due_date->diffForHumans() }}</p>
                    @else
                        <p class="text-gray-400 text-sm">{{ $invoice->due_date->diffForHumans() }}</p>
                    @endif
                </div>

                <!-- Creation Date -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Criada em</h4>
                    <p class="text-white">{{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Last Update -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Última Atualização</h4>
                    <p class="text-white">{{ $invoice->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Ações Rápidas</h3>
            
            <div class="space-y-3">
                @if($invoice->status === 'pendente')
                    <button onclick="markAsPaid({{ $invoice->id }})" 
                            class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Marcar como Paga
                    </button>
                @endif
                
                <button onclick="generatePDF()" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Baixar PDF
                </button>

                <a href="{{ route('admin.invoices.edit', $invoice) }}" 
                   class="w-full flex items-center justify-center px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Editar Fatura
                </a>

                <button onclick="sendInvoice()" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Enviar por Email
                </button>
            </div>
        </div>

        <!-- Related Content -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Conteúdo Relacionado</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.invoices.index', ['client' => $invoice->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Outras Faturas</span>
                        <span class="text-gray-400 text-sm">{{ $invoice->user->invoices->where('id', '!=', $invoice->id)->count() }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.client-projects.index', ['client' => $invoice->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Projetos do Cliente</span>
                        <span class="text-gray-400 text-sm">{{ $invoice->user->clientProjects->count() }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.support-tickets.index', ['client' => $invoice->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Tickets de Suporte</span>
                        <span class="text-gray-400 text-sm">{{ $invoice->user->supportTickets->count() }}</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Mark as Paid Modal -->
<div id="markAsPaidModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-6">Marcar como Paga</h3>
        <form action="{{ route('admin.invoices.mark-as-paid', $invoice) }}" method="POST">
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
    modal.classList.remove('hidden');
}

function closeMarkAsPaidModal() {
    const modal = document.getElementById('markAsPaidModal');
    modal.classList.add('hidden');
    
    // Reset form
    modal.querySelector('form').reset();
}

function generatePDF() {
    // Implement PDF generation
    window.open(`/admin/invoices/{{ $invoice->id }}/pdf`, '_blank');
}

function sendInvoice() {
    // Implement email sending
    if (confirm('Enviar esta fatura por email para o cliente?')) {
        fetch(`/admin/invoices/{{ $invoice->id }}/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Fatura enviada com sucesso!');
            } else {
                alert('Erro ao enviar fatura: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao enviar fatura');
        });
    }
}

// Close modal when clicking outside
document.getElementById('markAsPaidModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMarkAsPaidModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Mark as Paid Form
    const markAsPaidForm = document.getElementById('mark-as-paid-form');
    if (markAsPaidForm) {
        markAsPaidForm.addEventListener('submit', function(e) {
            if (!confirm('Tem certeza que deseja marcar esta fatura como paga?')) {
                e.preventDefault();
            }
        });
    }
    
    // Delete Form
    const deleteForm = document.getElementById('delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            if (!confirm('Tem certeza que deseja excluir esta fatura? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
            }
        });
    }
    
    // File Upload Display
    const fileInput = document.getElementById('invoice_pdf_upload');
    const fileNameDisplay = document.getElementById('file_name_display');
    
    if (fileInput && fileNameDisplay) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Selecionar Arquivo PDF';
            }
        });
    }
});
</script>
@endpush 