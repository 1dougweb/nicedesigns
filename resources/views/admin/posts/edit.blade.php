@extends('layouts.app')

@section('title', '- Editar Post')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Post</h1>
                    <nav class="flex space-x-2 text-sm text-gray-500 mt-2">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                        <span>/</span>
                        <a href="{{ route('admin.posts.index') }}" class="hover:text-gray-700">Posts</a>
                        <span>/</span>
                        <span>Editar</span>
                    </nav>
                </div>
                <div class="flex space-x-3">
                    @if($post->is_published)
                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Ver Post
                        </a>
                    @endif
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
        
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.posts.update', $post) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Informações do Post</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Título *
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $post->title) }}" 
                                   required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('title') border-red-300 @enderror"
                                   placeholder="Digite o título do post">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                Categoria *
                            </label>
                            <select name="category_id" 
                                    id="category_id" 
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('category_id') border-red-300 @enderror">
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700">
                                Resumo
                            </label>
                            <textarea name="excerpt" 
                                      id="excerpt" 
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('excerpt') border-red-300 @enderror"
                                      placeholder="Resumo do post (opcional)">{{ old('excerpt', $post->excerpt) }}</textarea>
                            @error('excerpt')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">
                                Conteúdo *
                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="15"
                                      required
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('content') border-red-300 @enderror"
                                      placeholder="Conteúdo completo do post...">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <label for="featured_image" class="block text-sm font-medium text-gray-700">
                                Imagem de Destaque (URL)
                            </label>
                            <input type="url" 
                                   name="featured_image" 
                                   id="featured_image" 
                                   value="{{ old('featured_image', $post->featured_image) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('featured_image') border-red-300 @enderror"
                                   placeholder="https://exemplo.com/imagem.jpg">
                            @error('featured_image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($post->featured_image)
                                <div class="mt-2">
                                    <img src="{{ $post->featured_image }}" alt="Imagem atual" class="h-20 w-20 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">SEO</h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Meta Title -->
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">
                                Meta Title
                            </label>
                            <input type="text" 
                                   name="meta_title" 
                                   id="meta_title" 
                                   value="{{ old('meta_title', $post->meta_title) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('meta_title') border-red-300 @enderror"
                                   placeholder="Título para mecanismos de busca">
                            @error('meta_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700">
                                Meta Description
                            </label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('meta_description') border-red-300 @enderror"
                                      placeholder="Descrição para mecanismos de busca">{{ old('meta_description', $post->meta_description) }}</textarea>
                            @error('meta_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publishing Options -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Opções de Publicação</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Publication Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input id="draft" 
                                           name="is_published" 
                                           type="radio" 
                                           value="0" 
                                           {{ old('is_published', $post->is_published) == '0' ? 'checked' : '' }}
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <label for="draft" class="ml-3 block text-sm font-medium text-gray-700">
                                        Salvar como rascunho
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="published" 
                                           name="is_published" 
                                           type="radio" 
                                           value="1" 
                                           {{ old('is_published', $post->is_published) == '1' ? 'checked' : '' }}
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                    <label for="published" class="ml-3 block text-sm font-medium text-gray-700">
                                        Publicar
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Publication Date -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700">
                                Data de Publicação
                            </label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   id="published_at" 
                                   value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('published_at') border-red-300 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Deixe em branco para usar a data atual quando publicar</p>
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.posts.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Atualizar Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 