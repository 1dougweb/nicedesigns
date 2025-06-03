@extends('layouts.admin')

@section('title', '- Criar Projeto')
@section('page-title', 'Criar Projeto')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Criar Novo Projeto</h2>
        <p class="text-gray-400 mt-1">Adicione um novo projeto ao portfólio da agência</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" 
       class="bg-gray-600/20 text-gray-300 border border-gray-600/30 hover:bg-gray-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar</span>
    </a>
</div>

<!-- Alerts -->
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

<form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-8">
    @csrf

    <!-- Basic Information -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                       value="{{ old('title') }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('title') border-red-500/50 @enderror"
                       placeholder="Ex: Sistema de E-commerce Completo">
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Client -->
            <div>
                <label for="client" class="block text-sm font-medium text-gray-300 mb-2">
                    Cliente
                </label>
                <input type="text" 
                       name="client" 
                       id="client" 
                       value="{{ old('client') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('client') border-red-500/50 @enderror"
                       placeholder="Nome do cliente">
                @error('client')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">
                    Categoria
                </label>
                <select name="category_id" 
                        id="category_id"
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('category_id') border-red-500/50 @enderror">
                    <option value="">Selecione uma categoria</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição *
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          required
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('description') border-red-500/50 @enderror"
                          placeholder="Descreva o projeto, seus objetivos e principais funcionalidades...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Detalhes do Projeto
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Technologies -->
            <div>
                <label for="technologies" class="block text-sm font-medium text-gray-300 mb-2">
                    Tecnologias Utilizadas
                </label>
                <input type="text" 
                       name="technologies" 
                       id="technologies" 
                       value="{{ old('technologies') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('technologies') border-red-500/50 @enderror"
                       placeholder="Ex: Laravel, Vue.js, MySQL, Tailwind CSS">
                @error('technologies')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Separe as tecnologias por vírgula</p>
            </div>

            <!-- Status/Featured -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Status do Projeto
                </label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_featured" 
                               value="0" 
                               {{ old('is_featured', '0') == '0' ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 focus:ring-purple-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Normal</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 text-yellow-600 bg-gray-700 border-gray-600 focus:ring-yellow-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Destaque</span>
                    </label>
                </div>
            </div>

            <!-- Demo URL -->
            <div>
                <label for="demo_url" class="block text-sm font-medium text-gray-300 mb-2">
                    URL da Demo
                </label>
                <input type="url" 
                       name="demo_url" 
                       id="demo_url" 
                       value="{{ old('demo_url') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('demo_url') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com">
                @error('demo_url')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
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
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('repository_url') border-red-500/50 @enderror"
                       placeholder="https://github.com/usuario/projeto">
                @error('repository_url')
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
            Imagens e Mídia
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-300 mb-2">
                    Imagem Principal (URL)
                </label>
                <input type="url" 
                       name="featured_image" 
                       id="featured_image" 
                       value="{{ old('featured_image') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('featured_image') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com/imagem-principal.jpg">
                @error('featured_image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gallery Images -->
            <div>
                <label for="gallery_images" class="block text-sm font-medium text-gray-300 mb-2">
                    Galeria de Imagens (URLs)
                </label>
                <textarea name="gallery_images" 
                          id="gallery_images" 
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('gallery_images') border-red-500/50 @enderror"
                          placeholder="https://exemplo.com/img1.jpg&#10;https://exemplo.com/img2.jpg&#10;https://exemplo.com/img3.jpg">{{ old('gallery_images') }}</textarea>
                @error('gallery_images')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Uma URL por linha</p>
            </div>
        </div>
    </div>

    <!-- SEO -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            SEO e Otimização
        </h3>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Meta Title -->
            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-300 mb-2">
                    Meta Title
                </label>
                <input type="text" 
                       name="meta_title" 
                       id="meta_title" 
                       value="{{ old('meta_title') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-500/50 focus:ring-2 focus:ring-yellow-500/20 transition-all @error('meta_title') border-red-500/50 @enderror"
                       placeholder="Título para mecanismos de busca">
                @error('meta_title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Description -->
            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-300 mb-2">
                    Meta Description
                </label>
                <textarea name="meta_description" 
                          id="meta_description" 
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-500/50 focus:ring-2 focus:ring-yellow-500/20 transition-all @error('meta_description') border-red-500/50 @enderror"
                          placeholder="Descrição do projeto para aparecer nos resultados de busca...">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Recomendado: 150-160 caracteres</p>
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
                    value="publish"
                    class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-purple-500/25">
                Criar Projeto
            </button>
        </div>
    </div>
</form>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    // You can add slug generation logic here if needed
});
</script>
@endsection 