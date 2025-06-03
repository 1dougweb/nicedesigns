@extends('layouts.admin')

@section('title', '- Editar Projeto')
@section('page-title', 'Editar Projeto')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Editar Projeto</h2>
        <p class="text-gray-400 mt-1">Atualize as informações do projeto "{{ $project->title }}"</p>
    </div>
    <div class="flex space-x-4">
        @if($project->project_url)
        <a href="{{ $project->project_url }}" 
           target="_blank"
           class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span>Ver Online</span>
        </a>
        @endif
        <a href="{{ route('admin.projects.index') }}" 
           class="bg-gray-600/20 text-gray-300 border border-gray-600/30 hover:bg-gray-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
<div class="bg-green-500/20 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl mb-6 backdrop-blur-md">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if($errors->any())
<div class="bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-6 backdrop-blur-md">
    <div class="flex items-center mb-2">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium">Erro(s) encontrado(s):</span>
    </div>
    <ul class="list-disc list-inside space-y-1 ml-8">
        @foreach($errors->all() as $error)
            <li class="text-sm">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.projects.update', $project) }}" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Basic Information -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Informações Básicas
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="lg:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                    Título do Projeto *
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $project->title) }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('title') border-red-500/50 @enderror"
                       placeholder="Ex: E-commerce Moderno para Loja de Roupas">
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Client Name -->
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-300 mb-2">
                    Nome do Cliente *
                </label>
                <input type="text" 
                       name="client_name" 
                       id="client_name" 
                       value="{{ old('client_name', $project->client_name) }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('client_name') border-red-500/50 @enderror"
                       placeholder="Ex: João Silva">
                @error('client_name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">
                    Categoria *
                </label>
                <select name="category_id" 
                        id="category_id" 
                        required
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('category_id') border-red-500/50 @enderror">
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Project URL -->
            <div>
                <label for="project_url" class="block text-sm font-medium text-gray-300 mb-2">
                    URL do Projeto
                </label>
                <input type="url" 
                       name="project_url" 
                       id="project_url" 
                       value="{{ old('project_url', $project->project_url) }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('project_url') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com">
                @error('project_url')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Completion Date -->
            <div>
                <label for="completion_date" class="block text-sm font-medium text-gray-300 mb-2">
                    Data de Conclusão
                </label>
                <input type="date" 
                       name="completion_date" 
                       id="completion_date" 
                       value="{{ old('completion_date', $project->completion_date?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('completion_date') border-red-500/50 @enderror">
                @error('completion_date')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição Breve *
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          required
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('description') border-red-500/50 @enderror"
                          placeholder="Breve descrição do projeto que aparecerá no portfólio...">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="lg:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    Conteúdo Detalhado
                </label>
                <textarea name="content" 
                          id="content" 
                          rows="8"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('content') border-red-500/50 @enderror"
                          placeholder="Descrição completa do projeto, desafios enfrentados, soluções implementadas...">{{ old('content', $project->content) }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Media -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Imagens do Projeto
        </h3>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Current Featured Image Preview -->
            @if($project->featured_image)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Imagem de Destaque Atual</label>
                <div class="w-full max-w-md">
                    <img src="{{ $project->featured_image }}" 
                         alt="Imagem atual" 
                         class="w-full h-48 object-cover rounded-xl border border-gray-600/50">
                </div>
            </div>
            @endif

            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-300 mb-2">
                    {{ $project->featured_image ? 'Nova URL da Imagem de Destaque' : 'URL da Imagem de Destaque' }}
                </label>
                <input type="url" 
                       name="featured_image" 
                       id="featured_image" 
                       value="{{ old('featured_image', $project->featured_image) }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('featured_image') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com/imagem-principal.jpg">
                @error('featured_image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Imagem principal que representa o projeto</p>
            </div>

            <!-- Additional Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-300 mb-2">
                    Galeria de Imagens
                </label>
                <textarea name="images" 
                          id="images" 
                          rows="4"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('images') border-red-500/50 @enderror"
                          placeholder="Cole as URLs das imagens, uma por linha:&#10;https://exemplo.com/imagem1.jpg&#10;https://exemplo.com/imagem2.jpg">{{ old('images', is_array($project->images) ? implode("\n", $project->images) : '') }}</textarea>
                @error('images')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Uma URL por linha. Serão exibidas na galeria do projeto</p>
            </div>
        </div>
    </div>

    <!-- Technologies & Status -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Tecnologias e Status
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Technologies -->
            <div>
                <label for="technologies" class="block text-sm font-medium text-gray-300 mb-2">
                    Tecnologias Utilizadas
                </label>
                <textarea name="technologies" 
                          id="technologies" 
                          rows="4"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('technologies') border-red-500/50 @enderror"
                          placeholder="Liste as tecnologias, uma por linha:&#10;Laravel&#10;Vue.js&#10;Tailwind CSS&#10;MySQL">{{ old('technologies', is_array($project->technologies) ? implode("\n", $project->technologies) : '') }}</textarea>
                @error('technologies')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Uma tecnologia por linha</p>
            </div>

            <!-- Status Options -->
            <div class="space-y-6">
                <!-- Publication Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Status de Publicação
                    </label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="is_published" 
                                   value="0" 
                                   {{ old('is_published', $project->is_published) == '0' ? 'checked' : '' }}
                                   class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500 focus:ring-2">
                            <span class="ml-2 text-gray-300">Rascunho</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="is_published" 
                                   value="1" 
                                   {{ old('is_published', $project->is_published) == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-green-600 bg-gray-700 border-gray-600 focus:ring-green-500 focus:ring-2">
                            <span class="ml-2 text-gray-300">Publicado</span>
                        </label>
                    </div>
                </div>

                <!-- Featured Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Projeto em Destaque
                    </label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="is_featured" 
                                   value="0" 
                                   {{ old('is_featured', $project->is_featured) == '0' ? 'checked' : '' }}
                                   class="w-4 h-4 text-gray-600 bg-gray-700 border-gray-600 focus:ring-gray-500 focus:ring-2">
                            <span class="ml-2 text-gray-300">Normal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured', $project->is_featured) == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-yellow-600 bg-gray-700 border-gray-600 focus:ring-yellow-500 focus:ring-2">
                            <span class="ml-2 text-gray-300">Destaque</span>
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Projetos em destaque aparecem no topo do portfólio</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Info -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informações do Projeto
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $project->created_at->format('d/m/Y') }}</div>
                <div class="text-sm text-gray-400">Data de Criação</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $project->updated_at->format('d/m/Y') }}</div>
                <div class="text-sm text-gray-400">Última Atualização</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $project->slug }}</div>
                <div class="text-sm text-gray-400">Slug (URL)</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between pt-6">
        <a href="{{ route('admin.projects.index') }}" 
           class="px-6 py-3 text-gray-400 hover:text-white transition-colors">
            Cancelar
        </a>
        
        <div class="flex space-x-4">
            <button type="submit" 
                    name="action" 
                    value="draft"
                    class="px-8 py-3 bg-gray-600/20 text-gray-300 border border-gray-600/30 rounded-xl font-medium hover:bg-gray-600/30 transition-all duration-300">
                Salvar como Rascunho
            </button>
            
            <button type="submit" 
                    name="action" 
                    value="update"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                Atualizar Projeto
            </button>
        </div>
    </div>
</form>

<script>
// Auto-generate slug from title (if needed)
document.getElementById('title').addEventListener('input', function() {
    // You can add slug generation logic here if needed
});
</script>
@endsection 