@extends('layouts.client')

@section('title', '- Novo Ticket de Suporte')
@section('page-title', 'Novo Ticket de Suporte')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-purple-600/20 to-indigo-600/20 backdrop-blur-md rounded-3xl border border-purple-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center mb-4">
                    <a href="{{ route('client.support.index') }}" class="text-gray-300 hover:text-white mr-4 p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h2 class="text-3xl font-bold text-white">
                        Novo Ticket de Suporte 🎫
                    </h2>
                </div>
                <p class="text-gray-300 text-lg">
                    Descreva sua dúvida ou problema e nossa equipe responderá em breve.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Messages -->
@if($errors->any())
    <div class="mb-6 bg-red-500/20 border border-red-500/30 rounded-2xl p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-red-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-red-300 font-medium mb-2">Existem erros no formulário:</h4>
                <ul class="text-red-200 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<!-- Ticket Form -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
    <form method="POST" action="{{ route('client.support.store') }}" class="space-y-6">
        @csrf

        <!-- Subject -->
        <div>
            <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Assunto *</label>
            <input type="text" name="subject" id="subject" 
                   value="{{ old('subject') }}"
                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                   placeholder="Descreva brevemente o problema ou dúvida" required>
            @error('subject')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category and Priority -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-300 mb-2">Categoria *</label>
                <select name="category" id="category" 
                        class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('category') border-red-500 @enderror"
                        required>
                    <option value="">Selecione uma categoria...</option>
                    <option value="suporte_tecnico" {{ old('category') === 'suporte_tecnico' ? 'selected' : '' }}>Suporte Técnico</option>
                    <option value="financeiro" {{ old('category') === 'financeiro' ? 'selected' : '' }}>Financeiro/Pagamento</option>
                    <option value="duvida" {{ old('category') === 'duvida' ? 'selected' : '' }}>Dúvida Geral</option>
                    <option value="nova_funcionalidade" {{ old('category') === 'nova_funcionalidade' ? 'selected' : '' }}>Nova Funcionalidade</option>
                    <option value="bug_report" {{ old('category') === 'bug_report' ? 'selected' : '' }}>Relatório de Bug</option>
                    <option value="alteracao_projeto" {{ old('category') === 'alteracao_projeto' ? 'selected' : '' }}>Alteração de Projeto</option>
                    <option value="outro" {{ old('category') === 'outro' ? 'selected' : '' }}>Outro</option>
                </select>
                @error('category')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-300 mb-2">Prioridade *</label>
                
                <select name="priority" id="priority" required
                        class="w-full p-4 bg-gray-700/50 border border-gray-600 text-white rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                    <option value="">Selecione a prioridade</option>
                    <option value="baixa" {{ old('priority') === 'baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="normal" {{ old('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="alta" {{ old('priority') === 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="urgente" {{ old('priority') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
                @error('priority')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Related Project -->
        @if($projects->count() > 0)
            <div>
                <label for="client_project_id" class="block text-sm font-medium text-gray-300 mb-2">
                    Projeto Relacionado (Opcional)
                </label>
                
                <select name="client_project_id" id="client_project_id"
                        class="w-full p-4 bg-gray-700/50 border border-gray-600 text-white rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('client_project_id') border-red-500 @enderror">
                    <option value="">Selecione um projeto (opcional)</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('client_project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_project_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Descrição *</label>
            <textarea name="description" id="description" rows="8" 
                      class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror"
                      placeholder="Descreva detalhadamente o problema, dúvida ou solicitação. Inclua informações como:
                      
• Quando o problema ocorreu
• Passos para reproduzir (se aplicável)
• Mensagens de erro (se houver)
• O que você esperava que acontecesse
• Qualquer informação adicional relevante" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-400 text-sm mt-2">
                Quanto mais detalhes você fornecer, mais rápido poderemos ajudá-lo.
            </p>
        </div>

        <!-- Priority Guide -->
        <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-2xl p-6">
            <h4 class="text-white font-semibold mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Guia de Prioridades
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                <div class="flex items-start space-x-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full mt-1 flex-shrink-0"></div>
                    <div>
                        <div class="text-green-400 font-medium">Baixa</div>
                        <div class="text-gray-400">Dúvidas gerais, sugestões</div>
                    </div>
                </div>
                <div class="flex items-start space-x-2">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full mt-1 flex-shrink-0"></div>
                    <div>
                        <div class="text-yellow-400 font-medium">Média</div>
                        <div class="text-gray-400">Problemas que não impedem o uso</div>
                    </div>
                </div>
                <div class="flex items-start space-x-2">
                    <div class="w-3 h-3 bg-orange-400 rounded-full mt-1 flex-shrink-0"></div>
                    <div>
                        <div class="text-orange-400 font-medium">Alta</div>
                        <div class="text-gray-400">Problemas que afetam funcionalidades</div>
                    </div>
                </div>
                <div class="flex items-start space-x-2">
                    <div class="w-3 h-3 bg-red-400 rounded-full mt-1 flex-shrink-0"></div>
                    <div>
                        <div class="text-red-400 font-medium">Urgente</div>
                        <div class="text-gray-400">Sistema inoperante, emergências</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Enviar Ticket
            </button>
            
            <a href="{{ route('client.support.index') }}" 
               class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-xl font-medium transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Cancelar
            </a>
        </div>
    </form>
</div>

<!-- Help Section -->
<div class="mt-8 bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
    <h3 class="text-xl font-bold text-white mb-4 flex items-center">
        <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Dicas para um Atendimento Mais Rápido
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-300">
        <div>
            <h4 class="font-semibold text-white mb-2">📝 Seja Específico</h4>
            <p>Forneça detalhes claros sobre o problema, incluindo quando ocorreu e em qual contexto.</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-2">📸 Anexe Evidências</h4>
            <p>Screenshots, mensagens de erro ou vídeos ajudam nossa equipe a entender melhor o problema.</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-2">🎯 Escolha a Categoria Correta</h4>
            <p>Isso ajuda a direcionar seu ticket para o especialista adequado.</p>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-2">⏰ Defina a Prioridade Adequada</h4>
            <p>Use urgente apenas para emergências reais que impedem completamente o uso do sistema.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any form validation or enhancement scripts here
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Add loading state to submit button
        submitButton.innerHTML = `
            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Enviando...
        `;
        submitButton.disabled = true;
    });
});
</script>
@endpush
@endsection 