@extends('layouts.admin')

@section('title', '- Gerenciar Categorias')
@section('page-title', 'Categorias')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Gerenciar Categorias</h2>
        <p class="text-gray-400 mt-1">Organize e gerencie as categorias do blog e portfólio</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" 
       class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2 shadow-lg hover:shadow-green-500/25">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Nova Categoria</span>
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

<!-- Categories Table -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
    @if(isset($categories) && $categories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Categoria</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Posts</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Projetos</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Data</th>
                        <th class="text-right py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="border-b border-gray-700/30 hover:bg-gray-700/20 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-white font-semibold text-lg">{{ $category->name }}</h3>
                                    @if($category->description)
                                        <p class="text-gray-400 text-sm mt-1">{{ Str::limit($category->description, 60) }}</p>
                                    @endif
                                    <p class="text-gray-500 text-xs font-mono mt-1">{{ $category->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    {{ $category->posts_count ?? 0 }} posts
                                </span>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                    {{ $category->projects_count ?? 0 }} projetos
                                </span>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="text-gray-300">{{ $category->created_at->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">{{ $category->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="p-2 text-gray-400 hover:text-green-400 hover:bg-green-500/20 rounded-xl transition-all duration-200"
                                   title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                @if(($category->posts_count ?? 0) > 0 || ($category->projects_count ?? 0) > 0)
                                    <div class="p-2 text-gray-500 cursor-not-allowed" title="Não é possível excluir categoria com conteúdo">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
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
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Nenhuma categoria encontrada</h3>
            <p class="text-gray-400 mb-8">Comece criando sua primeira categoria para organizar o conteúdo.</p>
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-8 py-4 rounded-2xl font-medium transition-all duration-300 inline-flex items-center space-x-2 shadow-lg hover:shadow-green-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Criar Primeira Categoria</span>
            </a>
        </div>
    @endif
</div>

<!-- Summary Cards -->
@if(isset($categories) && $categories->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
    <!-- Total Categories -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $categories->count() }}</p>
                <p class="text-sm text-gray-400">Total de Categorias</p>
            </div>
        </div>
    </div>

    <!-- Categories with Posts -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $categories->where('posts_count', '>', 0)->count() }}</p>
                <p class="text-sm text-gray-400">Com Posts</p>
            </div>
        </div>
    </div>

    <!-- Categories with Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $categories->where('projects_count', '>', 0)->count() }}</p>
                <p class="text-sm text-gray-400">Com Projetos</p>
            </div>
        </div>
    </div>

    <!-- Recent Categories -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $categories->where('created_at', '>=', now()->subDays(30))->count() }}</p>
                <p class="text-sm text-gray-400">Últimos 30 dias</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection 