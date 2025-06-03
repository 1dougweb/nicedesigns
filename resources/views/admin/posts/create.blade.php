@extends('layouts.admin')

@section('title', '- Criar Post')
@section('page-title', 'Criar Post')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Criar Novo Post</h2>
        <p class="text-gray-400 mt-1">Adicione um novo artigo ao blog da agência</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" 
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

<form method="POST" action="{{ route('admin.posts.store') }}" class="space-y-8">
    @csrf

    <!-- Basic Information -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Informações do Post
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="lg:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                    Título do Post *
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title') }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('title') border-red-500/50 @enderror"
                       placeholder="Ex: Como Criar um Site Responsivo">
                @error('title')
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

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
                               {{ old('is_published', '0') == '0' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Rascunho</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_published" 
                               value="1" 
                               {{ old('is_published') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 bg-gray-700 border-gray-600 focus:ring-green-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Publicado</span>
                    </label>
                </div>
            </div>

            <!-- Excerpt -->
            <div class="lg:col-span-2">
                <label for="excerpt" class="block text-sm font-medium text-gray-300 mb-2">
                    Resumo
                </label>
                <textarea name="excerpt" 
                          id="excerpt" 
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('excerpt') border-red-500/50 @enderror"
                          placeholder="Breve resumo do post (aparecerá na listagem do blog)">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="lg:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    Conteúdo *
                </label>
                <textarea name="content" 
                          id="content" 
                          rows="15"
                          required
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('content') border-red-500/50 @enderror"
                          placeholder="Conteúdo completo do post em HTML ou Markdown...">{{ old('content') }}</textarea>
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
            Imagem de Destaque
        </h3>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-300 mb-2">
                    URL da Imagem de Destaque
                </label>
                <input type="url" 
                       name="featured_image" 
                       id="featured_image" 
                       value="{{ old('featured_image') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('featured_image') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com/imagem.jpg">
                @error('featured_image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Recomendado: 1200x630px para melhor compartilhamento em redes sociais</p>
            </div>
        </div>
    </div>

    <!-- SEO -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            SEO e Meta Tags
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
                       placeholder="Título para mecanismos de busca (se diferente do título principal)">
                @error('meta_title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe vazio para usar o título principal. Máximo: 60 caracteres</p>
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
                          placeholder="Descrição do post para aparecer nos resultados de busca...">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Recomendado: 150-160 caracteres</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between pt-6">
        <a href="{{ route('admin.posts.index') }}" 
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
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                Criar Post
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