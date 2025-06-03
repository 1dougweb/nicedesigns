@extends('layouts.admin')

@section('title', '- Criar Fatura')
@section('page-title', 'Criar Fatura')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">Nova Fatura</h2>
        <p class="text-gray-400">Crie uma nova fatura para um cliente</p>
    </div>
    <div>
        <a href="{{ route('admin.invoices.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
    <form action="{{ route('admin.invoices.store') }}" method="POST" class="space-y-8">
        @csrf

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
                           value="{{ old('title') }}"
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
                            <option value="{{ $client->id }}" {{ old('user_id', request('client_id')) == $client->id ? 'selected' : '' }}>
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
                        <option value="{{ $project->id }}" {{ old('client_project_id', request('client_project_id')) == $project->id ? 'selected' : '' }}>
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
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">R$</span>
                        <input type="number" 
                               name="subtotal" 
                               id="subtotal"
                               value="{{ old('subtotal') }}"
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
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">R$</span>
                        <input type="number" 
                               name="discount" 
                               id="discount"
                               value="{{ old('discount', 0) }}"
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
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">R$</span>
                        <input type="number" 
                               name="tax" 
                               id="tax"
                               value="{{ old('tax', 0) }}"
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
                    <span id="total-amount" class="text-emerald-400 font-bold text-2xl">R$ 0,00</span>
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
                           value="{{ old('issue_date', date('Y-m-d')) }}"
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
                           value="{{ old('due_date') }}"
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
                        <option value="pendente" {{ old('status', 'pendente') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="paga" {{ old('status') === 'paga' ? 'selected' : '' }}>Paga</option>
                        <option value="vencida" {{ old('status') === 'vencida' ? 'selected' : '' }}>Vencida</option>
                        <option value="cancelada" {{ old('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
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
                        <option value="R$" {{ old('currency', 'R$') === 'R$' ? 'selected' : '' }}>Real (R$)</option>
                        <option value="US$" {{ old('currency') === 'US$' ? 'selected' : '' }}>Dólar (US$)</option>
                        <option value="€" {{ old('currency') === '€' ? 'selected' : '' }}>Euro (€)</option>
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
                           value="{{ old('payment_terms', 'Pagamento à vista') }}"
                           placeholder="Ex: À vista, 30 dias, etc."
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_terms') border-red-500 @enderror">
                    @error('payment_terms')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

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
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('payment_instructions') border-red-500 @enderror">{{ old('payment_instructions') }}</textarea>
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
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="border-t border-gray-700 pt-8">
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.invoices.index') }}" 
                   class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                    Criar Fatura
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
    
    const total = subtotal - discount + tax;
    document.getElementById('total-amount').textContent = 'R$ ' + total.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Add event listeners for calculation
document.getElementById('subtotal').addEventListener('input', calculateTotal);
document.getElementById('discount').addEventListener('input', calculateTotal);
document.getElementById('tax').addEventListener('input', calculateTotal);

// Auto-set due date based on issue date (add 30 days by default)
document.getElementById('issue_date').addEventListener('change', function() {
    const issueDate = new Date(this.value);
    const dueDate = new Date(issueDate);
    dueDate.setDate(dueDate.getDate() + 30);
    
    const dueDateInput = document.getElementById('due_date');
    if (!dueDateInput.value) {
        dueDateInput.value = dueDate.toISOString().split('T')[0];
    }
});

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