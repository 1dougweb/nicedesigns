@extends('layouts.admin')

@section('title', '- Gerenciar Projetos')
@section('page-title', 'Projetos')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Gerenciar Projetos</h2>
        <p class="text-gray-400 mt-1">Gerencie e acompanhe todos os projetos do portfólio</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" 
       class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2 shadow-lg hover:shadow-purple-500/25">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Novo Projeto</span>
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

<!-- Projects Table -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
    @if(isset($projects) && $projects->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Projeto</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Cliente</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Categoria</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Status</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Data</th>
                        <th class="text-right py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr class="border-b border-gray-700/30 hover:bg-gray-700/20 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-white font-semibold text-lg">{{ $project->title }}</h3>
                                    @if($project->description)
                                        <p class="text-gray-400 text-sm mt-1">{{ Str::limit($project->description, 80) }}</p>
                                    @endif
                                    <p class="text-gray-500 text-xs font-mono mt-1">{{ $project->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="text-gray-300">{{ $project->client ?? 'Não informado' }}</div>
                        </td>
                        <td class="py-6 px-6">
                            @if($project->category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                    {{ $project->category->name }}
                                </span>
                            @else
                                <span class="text-gray-500 text-sm">Sem categoria</span>
                            @endif
                        </td>
                        <td class="py-6 px-6">
                            @if($project->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                                    Destaque
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                    <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                    Normal
                                </span>
                            @endif
                        </td>
                        <td class="py-6 px-6">
                            <div class="text-gray-300">{{ $project->created_at->format('d/m/Y') }}</div>
                            <div class="text-gray-500 text-xs">{{ $project->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.projects.show', $project) }}" 
                                   class="p-2 text-gray-400 hover:text-blue-400 hover:bg-blue-500/20 rounded-xl transition-all duration-200"
                                   title="Visualizar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" 
                                   class="p-2 text-gray-400 hover:text-purple-400 hover:bg-purple-500/20 rounded-xl transition-all duration-200"
                                   title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" 
                                       target="_blank"
                                       class="p-2 text-gray-400 hover:text-green-400 hover:bg-green-500/20 rounded-xl transition-all duration-200"
                                       title="Ver demo">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este projeto?')">
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
        @if($projects->hasPages())
        <div class="px-6 py-6 border-t border-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-gray-400 text-sm">
                    Mostrando {{ $projects->firstItem() }} a {{ $projects->lastItem() }} de {{ $projects->total() }} resultados
                </div>
                <div class="flex space-x-2">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Nenhum projeto encontrado</h3>
            <p class="text-gray-400 mb-8">Comece criando seu primeiro projeto para o portfólio.</p>
            <a href="{{ route('admin.projects.create') }}" 
               class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-4 rounded-2xl font-medium transition-all duration-300 inline-flex items-center space-x-2 shadow-lg hover:shadow-purple-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Criar Primeiro Projeto</span>
            </a>
        </div>
    @endif
</div>

<!-- Summary Cards -->
@if(isset($projects) && $projects->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
    <!-- Total Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $projects->total() ?? 0 }}</p>
                <p class="text-sm text-gray-400">Total de Projetos</p>
            </div>
        </div>
    </div>

    <!-- Featured Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ isset($projects) ? $projects->where('is_featured', true)->count() : 0 }}</p>
                <p class="text-sm text-gray-400">Em Destaque</p>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ isset($projects) ? $projects->where('created_at', '>=', now()->subDays(30))->count() : 0 }}</p>
                <p class="text-sm text-gray-400">Últimos 30 dias</p>
            </div>
        </div>
    </div>

    <!-- Categories Used -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ isset($projects) ? $projects->pluck('category_id')->unique()->count() : 0 }}</p>
                <p class="text-sm text-gray-400">Categorias Usadas</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection 