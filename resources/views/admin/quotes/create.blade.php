@extends('layouts.admin')

@section('title', 'Criar Orçamento')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Criar Orçamento</h1>
            <p class="text-gray-400">Crie uma nova proposta de orçamento para um cliente</p>
        </div>
        <a href="{{ route('admin.quotes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.quotes.store') }}" method="POST" class="space-y-8">
        @csrf

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
                            <option value="{{ $client->id }}" {{ old('user_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->full_name }} - {{ $client->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
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
                           value="{{ old('title') }}"
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
                               value="{{ old('budget') }}"
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
                        <option value="BRL" {{ old('currency', 'BRL') == 'BRL' ? 'selected' : '' }}>Real (BRL)</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>Dólar (USD)</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
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
                           value="{{ old('timeline') }}"
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
                           value="{{ old('valid_until') }}"
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
                          class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                          class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('requirements') border-red-500 @enderror">{{ old('requirements') }}</textarea>
                @error('requirements')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Services -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Serviços Incluídos</h3>
            
            <div id="services-container">
                @if(old('services'))
                    @foreach(old('services') as $index => $service)
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
            
            <button type="button" onclick="addService()" class="bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 px-4 py-2 rounded-xl font-medium transition-colors border border-blue-500/30 hover:border-blue-500/50 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Adicionar Serviço
            </button>
        </div>

        <!-- Deliverables -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Entregáveis</h3>
            
            <div id="deliverables-container">
                @if(old('deliverables'))
                    @foreach(old('deliverables') as $index => $deliverable)
                        <div class="deliverable-item flex gap-3 mb-3">
                            <input type="text" 
                                   name="deliverables[]" 
                                   value="{{ $deliverable }}"
                                   placeholder="Ex: Site completo em produção"
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
                               placeholder="Ex: Site completo em produção"
                               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeDeliverable(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            
            <button type="button" onclick="addDeliverable()" class="bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 px-4 py-2 rounded-xl font-medium transition-colors border border-purple-500/30 hover:border-purple-500/50 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Adicionar Entregável
            </button>
        </div>

        <!-- Payment Terms -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Termos de Pagamento</h3>
            
            <div id="payment-terms-container">
                @if(old('payment_terms'))
                    @foreach(old('payment_terms') as $index => $term)
                        <div class="payment-term-item flex gap-3 mb-3">
                            <input type="text" 
                                   name="payment_terms[]" 
                                   value="{{ $term }}"
                                   placeholder="Ex: 50% no início, 50% na entrega"
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
                               placeholder="Ex: 50% no início, 50% na entrega"
                               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removePaymentTerm(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            
            <button type="button" onclick="addPaymentTerm()" class="bg-green-600/20 hover:bg-green-600/30 text-green-400 px-4 py-2 rounded-xl font-medium transition-colors border border-green-500/30 hover:border-green-500/50 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Adicionar Termo
            </button>
        </div>

        <!-- Discounts & Notes -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6">Descontos e Observações</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Discount Amount -->
                <div>
                    <label for="discount_amount" class="block text-sm font-medium text-gray-300 mb-2">
                        Desconto (Valor Fixo)
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">R$</span>
                        <input type="number" 
                               name="discount_amount" 
                               id="discount_amount" 
                               value="{{ old('discount_amount') }}"
                               step="0.01"
                               min="0"
                               placeholder="0,00"
                               class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_amount') border-red-500 @enderror">
                    </div>
                    @error('discount_amount')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Percentage -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-300 mb-2">
                        Desconto (Percentual)
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="discount_percentage" 
                               id="discount_percentage" 
                               value="{{ old('discount_percentage') }}"
                               step="0.01"
                               min="0"
                               max="100"
                               placeholder="0"
                               class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl pl-4 pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror">
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">%</span>
                    </div>
                    @error('discount_percentage')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="mt-6">
                <label for="admin_notes" class="block text-sm font-medium text-gray-300 mb-2">
                    Observações Internas
                </label>
                <textarea name="admin_notes" 
                          id="admin_notes" 
                          rows="3"
                          placeholder="Observações internas que não serão visíveis ao cliente..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admin_notes') border-red-500 @enderror">{{ old('admin_notes') }}</textarea>
                @error('admin_notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-medium transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Criar Orçamento
            </button>
            <a href="{{ route('admin.quotes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-xl font-medium transition-colors">
                Cancelar
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function addService() {
    const container = document.getElementById('services-container');
    const div = document.createElement('div');
    div.className = 'service-item flex gap-3 mb-3';
    div.innerHTML = `
        <input type="text" 
               name="services[]" 
               placeholder="Ex: Design responsivo"
               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" onclick="removeService(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function removeService(button) {
    button.closest('.service-item').remove();
}

function addDeliverable() {
    const container = document.getElementById('deliverables-container');
    const div = document.createElement('div');
    div.className = 'deliverable-item flex gap-3 mb-3';
    div.innerHTML = `
        <input type="text" 
               name="deliverables[]" 
               placeholder="Ex: Site completo em produção"
               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" onclick="removeDeliverable(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function removeDeliverable(button) {
    button.closest('.deliverable-item').remove();
}

function addPaymentTerm() {
    const container = document.getElementById('payment-terms-container');
    const div = document.createElement('div');
    div.className = 'payment-term-item flex gap-3 mb-3';
    div.innerHTML = `
        <input type="text" 
               name="payment_terms[]" 
               placeholder="Ex: 50% no início, 50% na entrega"
               class="flex-1 bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" onclick="removePaymentTerm(this)" class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-4 py-3 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function removePaymentTerm(button) {
    button.closest('.payment-term-item').remove();
}

// Prevent both discount fields from being filled
document.getElementById('discount_amount').addEventListener('input', function() {
    if (this.value) {
        document.getElementById('discount_percentage').value = '';
    }
});

document.getElementById('discount_percentage').addEventListener('input', function() {
    if (this.value) {
        document.getElementById('discount_amount').value = '';
    }
});
</script>
@endpush
@endsection