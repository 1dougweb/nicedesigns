@extends('layouts.admin')

@section('title', '- Gerenciar Posts')
@section('page-title', 'Posts')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Gerenciar Posts</h2>
        <p class="text-gray-400 mt-1">Crie, edite e gerencie todos os posts do blog</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" 
       class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2 shadow-lg hover:shadow-blue-500/25">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Novo Post</span>
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

@if(session('error'))
<div class="bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-6 backdrop-blur-md">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
</div>
@endif

<!-- Posts Table -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
    @if($posts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Post</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Categoria</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Status</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Autor</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Data</th>
                        <th class="text-right py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr class="border-b border-gray-700/30 hover:bg-gray-700/20 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-white font-semibold text-lg">{{ $post->title }}</h3>
                                    @if($post->excerpt)
                                        <p class="text-gray-400 text-sm mt-1">{{ Str::limit($post->excerpt, 80) }}</p>
                                    @endif
                                    <p class="text-gray-500 text-xs font-mono mt-1">{{ $post->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                {{ $post->category->name }}
                            </span>
                        </td>
                        <td class="py-6 px-6">
                            @if($post->is_published)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                    Rascunho
                                </span>
                            @endif
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">{{ substr($post->author->name, 0, 2) }}</span>
                                </div>
                                <span class="text-gray-300">{{ $post->author->name }}</span>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="text-gray-300">{{ $post->created_at->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.posts.show', $post) }}" 
                                   class="p-2 text-gray-400 hover:text-blue-400 hover:bg-blue-500/20 rounded-xl transition-all duration-200"
                                   title="Visualizar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                   class="p-2 text-gray-400 hover:text-purple-400 hover:bg-purple-500/20 rounded-xl transition-all duration-200"
                                   title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($post->is_published)
                                    <a href="{{ route('posts.show', $post->slug) }}" 
                                       target="_blank"
                                       class="p-2 text-gray-400 hover:text-green-400 hover:bg-green-500/20 rounded-xl transition-all duration-200"
                                       title="Ver no site">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-xl transition-all duration-200"
                                            title="Excluir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="px-6 py-6 border-t border-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-gray-400 text-sm">
                    Mostrando {{ $posts->firstItem() }} a {{ $posts->lastItem() }} de {{ $posts->total() }} resultados
                </div>
                <div class="flex space-x-2">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Nenhum post encontrado</h3>
            <p class="text-gray-400 mb-8">Comece criando seu primeiro post para o blog.</p>
            <a href="{{ route('admin.posts.create') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-2xl font-medium transition-all duration-300 inline-flex items-center space-x-2 shadow-lg hover:shadow-blue-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Criar Primeiro Post</span>
            </a>
        </div>
    @endif
</div>
@endsection 