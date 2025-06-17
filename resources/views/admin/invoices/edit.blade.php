@extends('layouts.admin')

@section('title', '- Editar Fatura #' . $invoice->invoice_number)
@section('page-title', 'Editar Fatura #' . $invoice->invoice_number)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">Editar Fatura</h2>
        <p class="text-gray-400">Atualize as informações da fatura #{{ $invoice->invoice_number }}</p>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('admin.invoices.show', $invoice) }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
           <i class="fi fi-rr-arrow-small-left text-white text-2xl mt-2 mr-2"></i>
            Voltar
        </a>
        <a href="{{ route('admin.invoices.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl transition-colors">
            Lista de Faturas
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
    <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Informações Básicas</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                        Título da Fatura <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title', $invoice->title) }}"
                           required
                           placeholder="Ex: Desenvolvimento de Site Institucional"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Client -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Cliente <span class="text-red-400">*</span>
                    </label>
                    <select name="user_id" 
                            id="user_id" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('user_id') border-red-500 @enderror">
                        <option value="">Selecione um cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('user_id', $invoice->user_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->full_name }} - {{ $client->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Project -->
            <div>
                <label for="client_project_id" class="block text-sm font-medium text-gray-300 mb-2">
                    Projeto Relacionado (Opcional)
                </label>
                <select name="client_project_id" 
                        id="client_project_id"
                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('client_project_id') border-red-500 @enderror">
                    <option value="">Nenhum projeto selecionado</option>
                    @foreach($clientProjects as $project)
                        <option value="{{ $project->id }}" {{ old('client_project_id', $invoice->client_project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_project_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição dos Serviços
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          placeholder="Descreva os serviços prestados ou itens da fatura..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $invoice->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Financial Information -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Informações Financeiras</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Subtotal -->
                <div>
                    <label for="subtotal" class="block text-sm font-medium text-gray-300 mb-2">
                        Subtotal <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">{{ $invoice->currency }}</span>
                        <input type="number" 
                               name="subtotal" 
                               id="subtotal"
                               value="{{ old('subtotal', $invoice->subtotal) }}"
                               min="0"
                               step="0.01"
                               required
                               placeholder="0,00"
                               class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('subtotal') border-red-500 @enderror">
                    </div>
                    @error('subtotal')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount -->
                <div>
                    <label for="discount" class="block text-sm font-medium text-gray-300 mb-2">
                        Desconto
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">{{ $invoice->currency }}</span>
                        <input type="number" 
                               name="discount" 
                               id="discount"
                               value="{{ old('discount', $invoice->discount) }}"
                               min="0"
                               step="0.01"
                               placeholder="0,00"
                               class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('discount') border-red-500 @enderror">
                    </div>
                    @error('discount')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tax -->
                <div>
                    <label for="tax" class="block text-sm font-medium text-gray-300 mb-2">
                        Imposto/Taxa
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">{{ $invoice->currency }}</span>
                        <input type="number" 
                               name="tax" 
                               id="tax"
                               value="{{ old('tax', $invoice->tax) }}"
                               min="0"
                               step="0.01"
                               placeholder="0,00"
                               class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tax') border-red-500 @enderror">
                    </div>
                    @error('tax')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Total Amount (Calculated) -->
            <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-emerald-400 font-bold text-lg">Total da Fatura</h4>
                    <span id="total-amount" class="text-emerald-400 font-bold text-2xl">{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
                </div>
                <p class="text-emerald-400/80 text-sm mt-1">O valor total será calculado automaticamente</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Detalhes da Fatura</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Issue Date -->
                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Data de Emissão <span class="text-red-400">*</span>
                    </label>
                    <input type="date" 
                           name="issue_date" 
                           id="issue_date"
                           value="{{ old('issue_date', $invoice->issue_date->format('Y-m-d')) }}"
                           required
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('issue_date') border-red-500 @enderror">
                    @error('issue_date')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Data de Vencimento <span class="text-red-400">*</span>
                    </label>
                    <input type="date" 
                           name="due_date" 
                           id="due_date"
                           value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                           required
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                    @error('due_date')
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
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="pendente" {{ old('status', $invoice->status) === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="paga" {{ old('status', $invoice->status) === 'paga' ? 'selected' : '' }}>Paga</option>
                        <option value="vencida" {{ old('status', $invoice->status) === 'vencida' ? 'selected' : '' }}>Vencida</option>
                        <option value="cancelada" {{ old('status', $invoice->status) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Currency -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-300 mb-2">
                        Moeda
                    </label>
                    <select name="currency" 
                            id="currency"
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('currency') border-red-500 @enderror">
                        <option value="R$" {{ old('currency', $invoice->currency) === 'R$' ? 'selected' : '' }}>Real (R$)</option>
                        <option value="US$" {{ old('currency', $invoice->currency) === 'US$' ? 'selected' : '' }}>Dólar (US$)</option>
                        <option value="€" {{ old('currency', $invoice->currency) === '€' ? 'selected' : '' }}>Euro (€)</option>
                    </select>
                    @error('currency')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Terms -->
                <div>
                    <label for="payment_terms" class="block text-sm font-medium text-gray-300 mb-2">
                        Condições de Pagamento
                    </label>
                    <input type="text" 
                           name="payment_terms" 
                           id="payment_terms"
                           value="{{ old('payment_terms', $invoice->payment_terms) }}"
                           placeholder="Ex: À vista, 30 dias, etc."
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_terms') border-red-500 @enderror">
                    @error('payment_terms')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Payment Information (if paid) -->
        @if($invoice->status === 'paga')
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Informações de Pagamento</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">
                            Método de Pagamento
                        </label>
                        <select name="payment_method" 
                                id="payment_method"
                                class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_method') border-red-500 @enderror">
                            <option value="">Selecione o método</option>
                            <option value="pix" {{ old('payment_method', $invoice->payment_method) === 'pix' ? 'selected' : '' }}>PIX</option>
                            <option value="transferencia" {{ old('payment_method', $invoice->payment_method) === 'transferencia' ? 'selected' : '' }}>Transferência Bancária</option>
                            <option value="boleto" {{ old('payment_method', $invoice->payment_method) === 'boleto' ? 'selected' : '' }}>Boleto</option>
                            <option value="cartao_credito" {{ old('payment_method', $invoice->payment_method) === 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                            <option value="cartao_debito" {{ old('payment_method', $invoice->payment_method) === 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                            <option value="dinheiro" {{ old('payment_method', $invoice->payment_method) === 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Reference -->
                    <div>
                        <label for="payment_reference" class="block text-sm font-medium text-gray-300 mb-2">
                            Referência do Pagamento
                        </label>
                        <input type="text" 
                               name="payment_reference" 
                               id="payment_reference"
                               value="{{ old('payment_reference', $invoice->payment_reference) }}"
                               placeholder="ID da transação, comprovante, etc."
                               class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_reference') border-red-500 @enderror">
                        @error('payment_reference')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Notes -->
                <div>
                    <label for="payment_notes" class="block text-sm font-medium text-gray-300 mb-2">
                        Observações do Pagamento
                    </label>
                    <textarea name="payment_notes" 
                              id="payment_notes" 
                              rows="3"
                              placeholder="Observações sobre o pagamento..."
                              class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_notes') border-red-500 @enderror">{{ old('payment_notes', $invoice->payment_notes) }}</textarea>
                    @error('payment_notes')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endif

        <!-- Additional Information -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Informações Adicionais</h3>
            
            <!-- Payment Instructions -->
            <div>
                <label for="payment_instructions" class="block text-sm font-medium text-gray-300 mb-2">
                    Instruções de Pagamento
                </label>
                <textarea name="payment_instructions" 
                          id="payment_instructions" 
                          rows="3"
                          placeholder="Dados bancários, PIX, ou outras instruções de pagamento..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_instructions') border-red-500 @enderror">{{ old('payment_instructions', $invoice->payment_instructions) }}</textarea>
                @error('payment_instructions')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Internal Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">
                    Observações Internas
                </label>
                <textarea name="notes" 
                          id="notes" 
                          rows="3"
                          placeholder="Observações para uso interno (não aparece na fatura)..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes', $invoice->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="border-t border-gray-700 pt-8">
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.invoices.show', $invoice) }}" 
                   class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                    Salvar Alterações
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Calculate total amount
function calculateTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax = parseFloat(document.getElementById('tax').value) || 0;
    const currency = document.getElementById('currency').value;
    
    const total = subtotal - discount + tax;
    document.getElementById('total-amount').textContent = currency + ' ' + total.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Add event listeners for calculation
document.getElementById('subtotal').addEventListener('input', calculateTotal);
document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);
document.getElementById('currency').addEventListener('change', calculateTotal);

// Filter projects by selected client
document.getElementById('user_id').addEventListener('change', function() {
    const clientId = this.value;
    const projectSelect = document.getElementById('client_project_id');
    const options = projectSelect.querySelectorAll('option');
    
    // Reset project selection
    projectSelect.value = '';
    
    // Show/hide project options based on selected client
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
            return;
        }
        
        const optionText = option.textContent;
        if (clientId && !optionText.includes(`(${this.options[this.selectedIndex].textContent.split(' - ')[0]})`)) {
            option.style.display = 'none';
        } else {
            option.style.display = 'block';
        }
    });
});

// Initialize calculation
calculateTotal();
</script>
@endpush 