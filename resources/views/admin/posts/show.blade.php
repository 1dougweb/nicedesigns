@extends('layouts.app')

@section('title', '- Ver Post')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                    <nav class="flex space-x-2 text-sm text-gray-500 mt-2">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        <span>/</span>
                        <a href="{{ route('admin.posts.index') }}" class="hover:text-gray-700">Posts</a>
                        <span>/</span>
                        <span>Ver</span>
                    </nav>
                </div>
                <div class="flex space-x-3">
                    @if($post->is_published)
                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Ver no Site
                        </a>
                    @endif
                    <a href="{{ route('admin.posts.edit', $post) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        
        <!-- Post Info -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informações do Post</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($post->is_published)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-2 h-2 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Publicado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-2 h-2 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Rascunho
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Categoria</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $post->category->name }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Autor</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->author->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $post->slug }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Datas</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Atualizado em</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->updated_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @if($post->published_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Publicado em</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $post->published_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Imagem de Destaque</h3>
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg">
            </div>
        </div>
        @endif

        <!-- Excerpt -->
        @if($post->excerpt)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Resumo</h3>
                <p class="text-gray-700">{{ $post->excerpt }}</p>
            </div>
        </div>
        @endif

        <!-- Content -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Conteúdo</h3>
                <div class="prose max-w-none">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </div>

        <!-- SEO -->
        @if($post->meta_title || $post->meta_description)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">SEO</h3>
                <dl class="space-y-3">
                    @if($post->meta_title)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Meta Title</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $post->meta_title }}</dd>
                    </div>
                    @endif
                    @if($post->meta_description)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $post->meta_description }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ações</h3>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Post
                    </a>
                    @if($post->is_published)
                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Ver no Site
                        </a>
                    @endif
                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline" 
                          onsubmit="return confirm('Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Excluir Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 