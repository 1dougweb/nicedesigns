@extends('layouts.admin')

@section('title', 'Editar Orçamento')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Editar Orçamento</h1>
            <p class="text-gray-400">Editando orçamento: {{ $quote->title }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.quotes.show', $quote) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                Cancelar
            </a>
        </div>
    </div>

    <!-- Current Status -->
    <div class="bg-{{ $quote->status_color ?? 'orange' }}-600/20 backdrop-blur-md rounded-2xl border border-{{ $quote->status_color ?? 'orange' }}-500/30 p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $quote->status_color ?? 'orange' }}-500/20 text-{{ $quote->status_color ?? 'orange' }}-400 border border-{{ $quote->status_color ?? 'orange' }}-500/30">
                    {{ $quote->status_label }}
                </span>
                <span class="text-gray-300">Cliente: {{ $quote->user->display_name }}</span>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-sm">Criado em</p>
                <p class="text-white">{{ $quote->created_at->format('d/m/Y \à\s H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.quotes.update', $quote) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Informações Básicas</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Client -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Cliente <span class="text-red-400">*</span>
                    </label>
                    <select name="user_id" 
                            id="user_id" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('user_id') border-red-500 @enderror">
                        <option value="">Selecione um cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ (old('user_id', $quote->user_id) == $client->id) ? 'selected' : '' }}>
                                {{ $client->full_name }} - {{ $client->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ (old('status', $quote->status) == $key) ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                        Título do Orçamento <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $quote->title) }}"
                           required
                           placeholder="Ex: Desenvolvimento de Site Corporativo"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-300 mb-2">
                        Valor Base <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">R$</span>
                        <input type="number" 
                               name="budget" 
                               id="budget" 
                               value="{{ old('budget', $quote->budget) }}"
                               step="0.01"
                               min="0"
                               required
                               placeholder="0,00"
                               class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('budget') border-red-500 @enderror">
                    </div>
                    @error('budget')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency -->
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-300 mb-2">
                        Moeda <span class="text-red-400">*</span>
                    </label>
                    <select name="currency" 
                            id="currency" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('currency') border-red-500 @enderror">
                        <option value="BRL" {{ old('currency', $quote->currency) == 'BRL' ? 'selected' : '' }}>Real (BRL)</option>
                        <option value="USD" {{ old('currency', $quote->currency) == 'USD' ? 'selected' : '' }}>Dólar (USD)</option>
                        <option value="EUR" {{ old('currency', $quote->currency) == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                    </select>
                    @error('currency')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Timeline -->
                <div>
                    <label for="timeline" class="block text-sm font-medium text-gray-300 mb-2">
                        Prazo de Entrega (dias)
                    </label>
                    <input type="number" 
                           name="timeline" 
                           id="timeline" 
                           value="{{ old('timeline', $quote->timeline) }}"
                           min="1"
                           placeholder="30"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('timeline') border-red-500 @enderror">
                    @error('timeline')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Valid Until -->
                <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-300 mb-2">
                        Válido Até
                    </label>
                    <input type="date" 
                           name="valid_until" 
                           id="valid_until" 
                           value="{{ old('valid_until', $quote->valid_until?->format('Y-m-d')) }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('valid_until') border-red-500 @enderror">
                    @error('valid_until')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição <span class="text-red-400">*</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          required
                          placeholder="Descreva detalhadamente o projeto e seus objetivos..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $quote->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Requirements -->
            <div class="mt-6">
                <label for="requirements" class="block text-sm font-medium text-gray-300 mb-2">
                    Requisitos Específicos
                </label>
                <textarea name="requirements" 
                          id="requirements" 
                          rows="3"
                          placeholder="Liste requisitos técnicos, funcionais ou específicos do cliente..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('requirements') border-red-500 @enderror">{{ old('requirements', $quote->requirements) }}</textarea>
                @error('requirements')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Services -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Serviços Incluídos</h3>
            
            <div id="services-container">
                @php
                    $services = old('services', $quote->services ?? []);
                @endphp
                
                @if($services && count($services) > 0)
                    @foreach($services as $index => $service)
                        <div class="service-item flex gap-3 mb-3">
                            <input type="text" 
                                   name="services[]" 
                                   value="{{ $service }}"
                                   placeholder="Ex: Design responsivo"
                                   class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" onclick="removeService(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="service-item flex gap-3 mb-3">
                        <input type="text" 
                               name="services[]" 
                               placeholder="Ex: Design responsivo"
                               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeService(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            
            <button type="button" onclick="addService()" class="bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 px-4 py-2 rounded-xl border border-blue-500/30 transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Adicionar Serviço
            </button>
        </div>

        <!-- Deliverables -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Entregáveis</h3>
            
            <div id="deliverables-container">
                @php
                    $deliverables = old('deliverables', $quote->deliverables ?? []);
                @endphp
                
                @if($deliverables && count($deliverables) > 0)
                    @foreach($deliverables as $index => $deliverable)
                        <div class="deliverable-item flex gap-3 mb-3">
                            <input type="text" 
                                   name="deliverables[]" 
                                   value="{{ $deliverable }}"
                                   placeholder="Ex: Código fonte completo"
                                   class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" onclick="removeDeliverable(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="deliverable-item flex gap-3 mb-3">
                        <input type="text" 
                               name="deliverables[]" 
                               placeholder="Ex: Código fonte completo"
                               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeDeliverable(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            
            <button type="button" onclick="addDeliverable()" class="bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 px-4 py-2 rounded-xl border border-purple-500/30 transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Adicionar Entregável
            </button>
        </div>

        <!-- Payment Terms -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Termos de Pagamento</h3>
            
            <div id="payment-terms-container">
                @php
                    $paymentTerms = old('payment_terms', $quote->payment_terms ?? []);
                @endphp
                
                @if($paymentTerms && count($paymentTerms) > 0)
                    @foreach($paymentTerms as $index => $term)
                        <div class="payment-term-item flex gap-3 mb-3">
                            <input type="text" 
                                   name="payment_terms[]" 
                                   value="{{ $term }}"
                                   placeholder="Ex: 30% na assinatura do contrato"
                                   class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="button" onclick="removePaymentTerm(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="payment-term-item flex gap-3 mb-3">
                        <input type="text" 
                               name="payment_terms[]" 
                               placeholder="Ex: 30% na assinatura do contrato"
                               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removePaymentTerm(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            
            <button type="button" onclick="addPaymentTerm()" class="bg-green-600/20 hover:bg-green-600/30 text-green-400 px-4 py-2 rounded-xl border border-green-500/30 transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Adicionar Termo
            </button>
        </div>

        <!-- Discounts -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Desconto (Opcional)</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Discount Amount -->
                <div>
                    <label for="discount_amount" class="block text-sm font-medium text-gray-300 mb-2">
                        Desconto em Valor (R$)
                    </label>
                    <input type="number" 
                           name="discount_amount" 
                           id="discount_amount" 
                           value="{{ old('discount_amount', $quote->discount_amount) }}"
                           step="0.01"
                           min="0"
                           placeholder="0,00"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_amount') border-red-500 @enderror">
                    @error('discount_amount')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Percentage -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-300 mb-2">
                        Desconto em Porcentagem (%)
                    </label>
                    <input type="number" 
                           name="discount_percentage" 
                           id="discount_percentage" 
                           value="{{ old('discount_percentage', $quote->discount_percentage) }}"
                           step="0.01"
                           min="0"
                           max="100"
                           placeholder="0"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror">
                    @error('discount_percentage')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4 p-4 bg-yellow-600/10 border border-yellow-500/30 rounded-xl">
                <p class="text-yellow-400 text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.768 0l-6.838 7.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    Se ambos os campos forem preenchidos, o desconto em valor terá prioridade.
                </p>
            </div>
        </div>

        <!-- Notes -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Observações</h3>
            
            <div>
                <label for="admin_notes" class="block text-sm font-medium text-gray-300 mb-2">
                    Observações Internas
                </label>
                <textarea name="admin_notes" 
                          id="admin_notes" 
                          rows="4"
                          placeholder="Notas internas sobre o orçamento..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admin_notes') border-red-500 @enderror">{{ old('admin_notes', $quote->admin_notes) }}</textarea>
                @error('admin_notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                <p class="text-gray-400 text-sm mt-2">
                    Estas observações são visíveis apenas para a equipe administrativa.
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.quotes.show', $quote) }}" 
               class="bg-gray-600/20 hover:bg-gray-600/30 text-gray-300 px-6 py-3 rounded-xl border border-gray-500/30 transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-medium transition-colors">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function addService() {
    const container = document.getElementById('services-container');
    const html = `
        <div class="service-item flex gap-3 mb-3">
            <input type="text" 
                   name="services[]" 
                   placeholder="Ex: Design responsivo"
                   class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="button" onclick="removeService(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeService(button) {
    const container = document.getElementById('services-container');
    if (container.children.length > 1) {
        button.closest('.service-item').remove();
    }
}

function addDeliverable() {
    const container = document.getElementById('deliverables-container');
    const html = `
        <div class="deliverable-item flex gap-3 mb-3">
            <input type="text" 
                   name="deliverables[]" 
                   placeholder="Ex: Código fonte completo"
                   class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="button" onclick="removeDeliverable(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removeDeliverable(button) {
    const container = document.getElementById('deliverables-container');
    if (container.children.length > 1) {
        button.closest('.deliverable-item').remove();
    }
}

function addPaymentTerm() {
    const container = document.getElementById('payment-terms-container');
    const html = `
        <div class="payment-term-item flex gap-3 mb-3">
            <input type="text" 
                   name="payment_terms[]" 
                   placeholder="Ex: 30% na assinatura do contrato"
                   class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="button" onclick="removePaymentTerm(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

function removePaymentTerm(button) {
    const container = document.getElementById('payment-terms-container');
    if (container.children.length > 1) {
        button.closest('.payment-term-item').remove();
    }
}
</script>
@endpush
@endsection 