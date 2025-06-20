@extends('layouts.admin')

@section('title', '- Editar Post')
@section('page-title', 'Editar Post')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Editar Post</h2>
        <p class="text-gray-400 mt-1">Atualize as informações do artigo "{{ $post->title }}"</p>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('admin.posts.show', $post) }}" 
           class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <span>Visualizar</span>
        </a>
        <a href="{{ route('admin.posts.index') }}" 
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

<form method="POST" action="{{ route('admin.posts.update', $post) }}" class="space-y-8">
    @csrf
    @method('PUT')

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
                       value="{{ old('title', $post->title) }}" 
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
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
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
                               {{ old('is_published', $post->is_published) == '0' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Rascunho</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_published" 
                               value="1" 
                               {{ old('is_published', $post->is_published) == '1' ? 'checked' : '' }}
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
                          placeholder="Breve resumo do post (aparecerá na listagem do blog)">{{ old('excerpt', $post->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="lg:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    Conteúdo *
                </label>
                <x-tinymce-editor 
                    name="content" 
                    id="content"
                    :value="old('content', $post->content)"
                    required
                    placeholder="Digite o conteúdo completo do post..."
                    class="@error('content') border-red-500/50 @enderror"
                />
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
        
        <!-- Current Image Preview -->
        @if($post->featured_image)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Imagem Atual</label>
            <div class="w-full max-w-md">
                <img src="{{ $post->featured_image }}" 
                     alt="Imagem atual" 
                     class="w-full h-48 object-cover rounded-xl border border-gray-600/50">
            </div>
        </div>
        @endif
        
        <div class="space-y-6">
            <!-- Upload File -->
            <div>
                <label for="featured_image_file" class="block text-sm font-medium text-gray-300 mb-2">
                    {{ $post->featured_image ? 'Substituir por Nova Imagem' : 'Fazer Upload da Imagem' }}
                </label>
                <div class="relative">
                    <input type="file" 
                           name="featured_image_file" 
                           id="featured_image_file" 
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(this)">
                    <label for="featured_image_file" 
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-700/30 hover:bg-gray-700/50 transition-all">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-400">
                                <span class="font-semibold">Clique para fazer upload</span>
                            </p>
                            <p class="text-xs text-gray-400">PNG, JPG, GIF, WEBP (MAX. 2MB)</p>
                        </div>
                    </label>
                </div>
                @error('featured_image_file')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                
                <!-- Image Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="previewImg" src="" alt="Preview" class="w-full max-w-md h-48 object-cover rounded-xl border border-gray-600">
                    <button type="button" onclick="removePreview()" class="mt-2 text-sm text-red-400 hover:text-red-300">
                        Remover imagem
                    </button>
                </div>
            </div>

            <!-- URL Alternative -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-300 mb-2">
                    {{ $post->featured_image ? 'Ou Nova URL Externa' : 'Ou URL da Imagem Externa' }}
                </label>
                <input type="url" 
                       name="featured_image" 
                       id="featured_image" 
                       value="{{ old('featured_image', $post->featured_image) }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('featured_image') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com/imagem.jpg">
                @error('featured_image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Use upload local ou URL externa, não ambos</p>
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-blue-900/20 border border-blue-700/30 rounded-xl">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm text-blue-300">
                    <p class="font-medium mb-1">Dicas para melhor SEO:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-300/80">
                        <li>Tamanho recomendado: 1200x630px (proporção 1.91:1)</li>
                        <li>Formato ideal: JPG ou WebP para melhor compressão</li>
                        <li>Arquivo otimizado para rápido carregamento</li>
                        <li>Imagem representativa do conteúdo do post</li>
                    </ul>
                </div>
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
                       value="{{ old('meta_title', $post->meta_title) }}"
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
                          placeholder="Descrição do post para aparecer nos resultados de busca...">{{ old('meta_description', $post->meta_description) }}</textarea>
                @error('meta_description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Recomendado: 150-160 caracteres</p>
            </div>
        </div>
    </div>

    <!-- Post Info -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informações do Post
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $post->created_at->format('d/m/Y') }}</div>
                <div class="text-sm text-gray-400">Data de Criação</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $post->updated_at->format('d/m/Y') }}</div>
                <div class="text-sm text-gray-400">Última Atualização</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $post->slug }}</div>
                <div class="text-sm text-gray-400">Slug (URL)</div>
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
                    value="update"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                Atualizar Post
            </button>
        </div>
    </div>
</form>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    // You can add slug generation logic here if needed
});

// Image preview functionality
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            
            // Clear URL input if file is selected
            document.getElementById('featured_image').value = '';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removePreview() {
    const preview = document.getElementById('imagePreview');
    const fileInput = document.getElementById('featured_image_file');
    
    preview.classList.add('hidden');
    fileInput.value = '';
}

// Clear file input if URL is entered
document.getElementById('featured_image').addEventListener('input', function() {
    if (this.value) {
        document.getElementById('featured_image_file').value = '';
        document.getElementById('imagePreview').classList.add('hidden');
    }
});

// Character counter for meta fields
document.getElementById('meta_title').addEventListener('input', function() {
    const maxLength = 60;
    const currentLength = this.value.length;
    const color = currentLength > maxLength ? 'text-red-400' : 'text-gray-400';
    
    let counter = this.parentNode.querySelector('.char-counter');
    if (!counter) {
        counter = document.createElement('p');
        counter.className = 'mt-1 text-xs char-counter';
        this.parentNode.appendChild(counter);
    }
    
    counter.className = `mt-1 text-xs char-counter ${color}`;
    counter.textContent = `${currentLength}/${maxLength} caracteres`;
});

document.getElementById('meta_description').addEventListener('input', function() {
    const maxLength = 160;
    const currentLength = this.value.length;
    const color = currentLength > maxLength ? 'text-red-400' : 'text-gray-400';
    
    let counter = this.parentNode.querySelector('.char-counter');
    if (!counter) {
        counter = document.createElement('p');
        counter.className = 'mt-1 text-xs char-counter';
        this.parentNode.appendChild(counter);
    }
    
    counter.className = `mt-1 text-xs char-counter ${color}`;
    counter.textContent = `${currentLength}/${maxLength} caracteres`;
});
</script>
@endsection 