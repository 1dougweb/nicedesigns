@extends('layouts.admin')

@section('title', '- Editar Categoria')
@section('page-title', 'Editar Categoria')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Editar Categoria</h2>
        <p class="text-gray-400 mt-1">Atualize as informações da categoria "{{ $category->name }}"</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" 
       class="bg-gray-600/20 text-gray-300 border border-gray-600/30 hover:bg-gray-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Voltar</span>
    </a>
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

<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Basic Information -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Informações da Categoria
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                    Nome da Categoria *
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $category->name) }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('name') border-red-500/50 @enderror"
                       placeholder="Ex: Desenvolvimento Web">
                @error('name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-300 mb-2">
                    Slug (URL) *
                </label>
                <input type="text" 
                       name="slug" 
                       id="slug" 
                       value="{{ old('slug', $category->slug) }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('slug') border-red-500/50 @enderror"
                       placeholder="Ex: desenvolvimento-web">
                @error('slug')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">URL amigável para a categoria</p>
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('description') border-red-500/50 @enderror"
                          placeholder="Breve descrição sobre esta categoria (opcional)">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Category Configuration -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Configurações
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Usage -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Esta categoria é usada para:
                </label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="used_for_posts" 
                               value="1" 
                               {{ old('used_for_posts', $category->posts()->count() > 0 ? true : false) ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 bg-gray-700 border-gray-600 rounded focus:ring-green-500 focus:ring-2">
                        <span class="ml-3 text-gray-300">
                            Posts do Blog
                            @if($category->posts()->count() > 0)
                                <span class="text-xs text-blue-400">({{ $category->posts()->count() }} posts)</span>
                            @endif
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="used_for_projects" 
                               value="1" 
                               {{ old('used_for_projects', $category->projects()->count() > 0 ? true : false) ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 bg-gray-700 border-gray-600 rounded focus:ring-green-500 focus:ring-2">
                        <span class="ml-3 text-gray-300">
                            Projetos do Portfólio
                            @if($category->projects()->count() > 0)
                                <span class="text-xs text-purple-400">({{ $category->projects()->count() }} projetos)</span>
                            @endif
                        </span>
                    </label>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Status da Categoria
                </label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $category->is_active) == '1' ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 bg-gray-700 border-gray-600 focus:ring-green-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Ativa</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" 
                               name="is_active" 
                               value="0" 
                               {{ old('is_active', $category->is_active) == '0' ? 'checked' : '' }}
                               class="w-4 h-4 text-gray-600 bg-gray-700 border-gray-600 focus:ring-gray-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Inativa</span>
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-400">Categorias inativas não aparecerão nas listagens públicas</p>
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
                       value="{{ old('meta_title', $category->meta_title ?? '') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-500/50 focus:ring-2 focus:ring-yellow-500/20 transition-all @error('meta_title') border-red-500/50 @enderror"
                       placeholder="Título para mecanismos de busca (se diferente do nome)">
                @error('meta_title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe vazio para usar o nome da categoria. Máximo: 60 caracteres</p>
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
                          placeholder="Descrição da categoria para aparecer nos resultados de busca...">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                @error('meta_description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Recomendado: 150-160 caracteres</p>
            </div>
        </div>
    </div>

    <!-- Category Info -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informações da Categoria
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $category->created_at->format('d/m/Y') }}</div>
                <div class="text-sm text-gray-400">Data de Criação</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-white">{{ $category->updated_at->format('d/m/Y') }}</div>
                <div class="text-sm text-gray-400">Última Atualização</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-blue-400">{{ $category->posts()->count() }}</div>
                <div class="text-sm text-gray-400">Posts Vinculados</div>
            </div>
            <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                <div class="text-2xl font-bold text-purple-400">{{ $category->projects()->count() }}</div>
                <div class="text-sm text-gray-400">Projetos Vinculados</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between pt-6">
        <a href="{{ route('admin.categories.index') }}" 
           class="px-6 py-3 text-gray-400 hover:text-white transition-colors">
            Cancelar
        </a>
        
        <button type="submit" 
                class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl font-medium transition-all duration-300 shadow-lg hover:shadow-green-500/25">
            Atualizar Categoria
        </button>
    </div>
</form>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove caracteres especiais
        .replace(/\s+/g, '-')         // Substitui espaços por hífens
        .replace(/-+/g, '-')          // Remove hífens duplicados
        .trim('-');                   // Remove hífens do início e fim
    
    document.getElementById('slug').value = slug;
});
</script>
@endsection 