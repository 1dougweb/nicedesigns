@extends('layouts.admin')

@section('title', '- Ver Post')
@section('page-title', 'Ver Post')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">{{ $post->title }}</h2>
        <p class="text-gray-400 mt-1">Visualizando detalhes do post</p>
    </div>
    <div class="flex space-x-4">
        @if($post->is_published)
        <a href="{{ route('posts.show', $post->slug) }}" 
           target="_blank"
           class="bg-green-600/20 text-green-300 border border-green-600/30 hover:bg-green-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span>Ver no Site</span>
        </a>
        @endif
        <a href="{{ route('admin.posts.edit', $post) }}" 
           class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
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

<!-- Post Status -->
<div class="flex items-center space-x-4 mb-8">
    @if($post->is_published)
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 8 8">
                <circle cx="4" cy="4" r="3"/>
            </svg>
            Publicado
        </span>
    @else
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 8 8">
                <circle cx="4" cy="4" r="3"/>
            </svg>
            Rascunho
        </span>
    @endif
    
    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
        {{ $post->category->name }}
    </span>
</div>

<!-- Post Information -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Post Details -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Basic Information -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informações do Post
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Autor</dt>
                    <dd class="text-white font-semibold text-lg">{{ $post->author->name }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Slug</dt>
                    <dd class="text-gray-300 font-mono text-sm">{{ $post->slug }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Criado em</dt>
                    <dd class="text-white">{{ $post->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Atualizado em</dt>
                    <dd class="text-white">{{ $post->updated_at->format('d/m/Y H:i') }}</dd>
                </div>
            </div>
        </div>

        <!-- Excerpt -->
        @if($post->excerpt)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Resumo
            </h3>
            <p class="text-gray-300 leading-relaxed">{{ $post->excerpt }}</p>
        </div>
        @endif

        <!-- Content -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 011 1l4 4v9a2 2 0 01-2 2z"/>
                </svg>
                Conteúdo
            </h3>
            <div class="text-gray-300 leading-relaxed prose prose-invert max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        <!-- SEO -->
        @if($post->meta_title || $post->meta_description)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                SEO e Meta Tags
            </h3>
            
            <div class="space-y-4">
                @if($post->meta_title)
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Meta Title</dt>
                    <dd class="text-white">{{ $post->meta_title }}</dd>
                </div>
                @endif
                
                @if($post->meta_description)
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Meta Description</dt>
                    <dd class="text-gray-300">{{ $post->meta_description }}</dd>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        
        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Imagem de Destaque
            </h3>
            <img src="{{ $post->featured_image }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-48 object-cover rounded-xl border border-gray-600/50">
        </div>
        @endif

        <!-- Post Stats -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Estatísticas
            </h3>
            
            <div class="space-y-4">
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-white">{{ $post->created_at->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-400">Data de Criação</div>
                </div>
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-white">{{ $post->updated_at->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-400">Última Atualização</div>
                </div>
                @if($post->published_at)
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-green-400">{{ $post->published_at->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-400">Data de Publicação</div>
                </div>
                @endif
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-blue-400">{{ strlen(strip_tags($post->content)) }}</div>
                    <div class="text-sm text-gray-400">Caracteres</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Ações
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.posts.edit', $post) }}" 
                   class="w-full bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Editar Post</span>
                </a>
                
                @if($post->is_published)
                <a href="{{ route('posts.show', $post->slug) }}" 
                   target="_blank"
                   class="w-full bg-green-600/20 text-green-300 border border-green-600/30 hover:bg-green-600/30 px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Ver no Site</span>
                </a>
                @endif
                
                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" 
                      onsubmit="return confirm('Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600/20 text-red-300 border border-red-600/30 hover:bg-red-600/30 px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>Excluir Post</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 