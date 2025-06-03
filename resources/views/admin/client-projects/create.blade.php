@extends('layouts.admin')

@section('title', '- Criar Projeto de Cliente')
@section('page-title', 'Criar Projeto de Cliente')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">Novo Projeto de Cliente</h2>
        <p class="text-gray-400">Crie um novo projeto personalizado para um cliente</p>
    </div>
    <div>
        <a href="{{ route('admin.client-projects.index') }}" 
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
    <form action="{{ route('admin.client-projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Informações Básicas</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Project Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Nome do Projeto <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Ex: Site Institucional da Empresa ABC"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
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
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('user_id') border-red-500 @enderror">
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
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição do Projeto <span class="text-red-400">*</span>
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          required
                          placeholder="Descreva detalhadamente o que será desenvolvido no projeto..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status and Priority -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Status e Prioridade</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        @foreach(\App\Models\ClientProject::getStatusLabels() as $value => $label)
                            <option value="{{ $value }}" {{ old('status', 'aguardando_aprovacao') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-300 mb-2">
                        Prioridade <span class="text-red-400">*</span>
                    </label>
                    <select name="priority" 
                            id="priority" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                        @foreach(\App\Models\ClientProject::getPriorityLabels() as $value => $label)
                            <option value="{{ $value }}" {{ old('priority', 'normal') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('priority')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Timeline and Budget -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Cronograma e Orçamento</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Data de Início <span class="text-red-400">*</span>
                    </label>
                    <input type="date" 
                           name="start_date" 
                           id="start_date"
                           value="{{ old('start_date', date('Y-m-d')) }}"
                           required
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Data de Entrega <span class="text-red-400">*</span>
                    </label>
                    <input type="date" 
                           name="due_date" 
                           id="due_date"
                           value="{{ old('due_date') }}"
                           required
                           class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-300 mb-2">
                        Orçamento (R$)
                    </label>
                    <input type="number" 
                           name="budget" 
                           id="budget"
                           value="{{ old('budget') }}"
                           min="0"
                           step="0.01"
                           placeholder="0,00"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('budget') border-red-500 @enderror">
                    @error('budget')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Progress and Stages -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Progresso e Etapas</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Progress -->
                <div>
                    <label for="progress" class="block text-sm font-medium text-gray-300 mb-2">
                        Progresso (%) <span class="text-red-400">*</span>
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="range" 
                               name="progress" 
                               id="progress"
                               value="{{ old('progress', 0) }}"
                               min="0"
                               max="100"
                               step="5"
                               class="flex-1 h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                        <span id="progress-value" class="text-cyan-400 font-bold min-w-[3rem]">{{ old('progress', 0) }}%</span>
                    </div>
                    @error('progress')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Stage -->
                <div>
                    <label for="current_stage" class="block text-sm font-medium text-gray-300 mb-2">
                        Etapa Atual <span class="text-red-400">*</span>
                    </label>
                    <select name="current_stage" 
                            id="current_stage" 
                            required
                            class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('current_stage') border-red-500 @enderror">
                        <option value="Planejamento" {{ old('current_stage', 'Planejamento') === 'Planejamento' ? 'selected' : '' }}>Planejamento</option>
                        <option value="Design" {{ old('current_stage') === 'Design' ? 'selected' : '' }}>Design</option>
                        <option value="Desenvolvimento" {{ old('current_stage') === 'Desenvolvimento' ? 'selected' : '' }}>Desenvolvimento</option>
                        <option value="Testes" {{ old('current_stage') === 'Testes' ? 'selected' : '' }}>Testes</option>
                        <option value="Deploy" {{ old('current_stage') === 'Deploy' ? 'selected' : '' }}>Deploy</option>
                    </select>
                    @error('current_stage')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Custom Stages -->
            <div>
                <label for="stages" class="block text-sm font-medium text-gray-300 mb-2">
                    Etapas Personalizadas
                </label>
                <textarea name="stages" 
                          id="stages" 
                          rows="3"
                          placeholder="Liste as etapas do projeto, uma por linha (opcional - se não informado, usará as etapas padrão)"
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('stages') border-red-500 @enderror">{{ old('stages') }}</textarea>
                <p class="text-gray-500 text-sm mt-1">
                    Etapas padrão: Planejamento, Design, Desenvolvimento, Testes, Deploy
                </p>
                @error('stages')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Additional Information -->
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-white border-b border-gray-700 pb-3">Informações Adicionais</h3>
            
            <!-- Requirements -->
            <div>
                <label for="requirements" class="block text-sm font-medium text-gray-300 mb-2">
                    Requisitos e Especificações
                </label>
                <textarea name="requirements" 
                          id="requirements" 
                          rows="4"
                          placeholder="Descreva os requisitos técnicos, funcionalidades específicas, integrações necessárias..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('requirements') border-red-500 @enderror">{{ old('requirements') }}</textarea>
                @error('requirements')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Technologies -->
            <div>
                <label for="technologies" class="block text-sm font-medium text-gray-300 mb-2">
                    Tecnologias Utilizadas
                </label>
                <input type="text" 
                       name="technologies" 
                       id="technologies"
                       value="{{ old('technologies') }}"
                       placeholder="Ex: Laravel, Vue.js, MySQL, AWS..."
                       class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('technologies') border-red-500 @enderror">
                @error('technologies')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Project URL -->
                <div>
                    <label for="project_url" class="block text-sm font-medium text-gray-300 mb-2">
                        URL do Projeto
                    </label>
                    <input type="url" 
                           name="project_url" 
                           id="project_url"
                           value="{{ old('project_url') }}"
                           placeholder="https://exemplo.com"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('project_url') border-red-500 @enderror">
                    @error('project_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Repository URL -->
                <div>
                    <label for="repository_url" class="block text-sm font-medium text-gray-300 mb-2">
                        URL do Repositório
                    </label>
                    <input type="url" 
                           name="repository_url" 
                           id="repository_url"
                           value="{{ old('repository_url') }}"
                           placeholder="https://github.com/user/repo"
                           class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('repository_url') border-red-500 @enderror">
                    @error('repository_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">
                    Observações Internas
                </label>
                <textarea name="notes" 
                          id="notes" 
                          rows="3"
                          placeholder="Observações para a equipe, lembretes, considerações especiais..."
                          class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="border-t border-gray-700 pt-8">
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.client-projects.index') }}" 
                   class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-cyan-500/25">
                    Criar Projeto
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Progress slider update
document.getElementById('progress').addEventListener('input', function() {
    document.getElementById('progress-value').textContent = this.value + '%';
});

// Auto-set due date based on start date (add 30 days by default)
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const dueDate = new Date(startDate);
    dueDate.setDate(dueDate.getDate() + 30);
    
    const dueDateInput = document.getElementById('due_date');
    if (!dueDateInput.value) {
        dueDateInput.value = dueDate.toISOString().split('T')[0];
    }
});

// Update current stage based on progress
document.getElementById('progress').addEventListener('input', function() {
    const progress = parseInt(this.value);
    const currentStageSelect = document.getElementById('current_stage');
    
    if (progress < 20) {
        currentStageSelect.value = 'Planejamento';
    } else if (progress < 40) {
        currentStageSelect.value = 'Design';
    } else if (progress < 70) {
        currentStageSelect.value = 'Desenvolvimento';
    } else if (progress < 90) {
        currentStageSelect.value = 'Testes';
    } else if (progress >= 90) {
        currentStageSelect.value = 'Deploy';
    }
});

// Format budget input
document.getElementById('budget').addEventListener('input', function() {
    let value = this.value.replace(/[^\d.,]/g, '');
    this.value = value;
});
</script>
@endpush 