@extends('layouts.admin')

@section('title', '- Ver Projeto')
@section('page-title', 'Ver Projeto')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">{{ $project->title }}</h2>
        <p class="text-gray-400 mt-1">Visualizando detalhes do projeto</p>
    </div>
    <div class="flex space-x-4">
        @if($project->project_url)
        <a href="{{ $project->project_url }}" 
           target="_blank"
           class="bg-green-600/20 text-green-300 border border-green-600/30 hover:bg-green-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span>Ver Online</span>
        </a>
        @endif
        <a href="{{ route('admin.projects.edit', $project) }}" 
           class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Editar</span>
        </a>
        <a href="{{ route('admin.projects.index') }}" 
           class="bg-gray-600/20 text-gray-300 border border-gray-600/30 hover:bg-gray-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Voltar</span>
        </a>
    </div>
</div>

<!-- Project Status -->
<div class="flex items-center space-x-4 mb-8">
    @if($project->is_published)
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
    
    @if($project->is_featured)
        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            Projeto em Destaque
        </span>
    @endif
    
    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
        {{ $project->category->name }}
    </span>
</div>

<!-- Project Information -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Project Details -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Basic Information -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informações do Projeto
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Cliente</dt>
                    <dd class="text-white font-semibold text-lg">{{ $project->client_name }}</dd>
                </div>
                
                @if($project->project_url)
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">URL do Projeto</dt>
                    <dd>
                        <a href="{{ $project->project_url }}" target="_blank" 
                           class="text-blue-400 hover:text-blue-300 transition-colors flex items-center">
                            {{ $project->project_url }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </dd>
                </div>
                @endif
                
                @if($project->completion_date)
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Data de Conclusão</dt>
                    <dd class="text-white">{{ $project->completion_date->format('d/m/Y') }}</dd>
                </div>
                @endif
                
                <div>
                    <dt class="text-sm font-medium text-gray-400 mb-1">Slug</dt>
                    <dd class="text-gray-300 font-mono text-sm">{{ $project->slug }}</dd>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Descrição
            </h3>
            <p class="text-gray-300 leading-relaxed">{{ $project->description }}</p>
        </div>

        <!-- Content -->
        @if($project->content)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 011 1l4 4v9a2 2 0 01-2 2z"/>
                </svg>
                Conteúdo Detalhado
            </h3>
            <div class="text-gray-300 leading-relaxed prose prose-invert max-w-none">
                {!! nl2br(e($project->content)) !!}
            </div>
        </div>
        @endif

        <!-- Technologies -->
        @if($project->technologies && count($project->technologies) > 0)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Tecnologias Utilizadas
            </h3>
            <div class="flex flex-wrap gap-3">
                @foreach($project->technologies as $technology)
                    <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-orange-500/20 text-orange-400 border border-orange-500/30">
                        {{ $technology }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Images Gallery -->
        @if($project->images && count($project->images) > 0)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Galeria de Imagens
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($project->images as $image)
                    <div class="relative group overflow-hidden rounded-xl">
                        <img src="{{ $image }}" 
                             alt="Imagem do projeto" 
                             class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="{{ $image }}" target="_blank" 
                               class="text-white hover:text-blue-400 transition-colors">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        
        <!-- Featured Image -->
        @if($project->featured_image)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Imagem de Destaque
            </h3>
            <img src="{{ $project->featured_image }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-48 object-cover rounded-xl border border-gray-600/50">
        </div>
        @endif

        <!-- Project Stats -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Estatísticas
            </h3>
            
            <div class="space-y-4">
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-white">{{ $project->created_at->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-400">Data de Criação</div>
                </div>
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-white">{{ $project->updated_at->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-400">Última Atualização</div>
                </div>
                @if($project->technologies)
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-orange-400">{{ count($project->technologies) }}</div>
                    <div class="text-sm text-gray-400">Tecnologias</div>
                </div>
                @endif
                @if($project->images)
                <div class="text-center p-4 bg-gray-700/30 rounded-xl">
                    <div class="text-2xl font-bold text-pink-400">{{ count($project->images) }}</div>
                    <div class="text-sm text-gray-400">Imagens</div>
                </div>
                @endif
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
                <a href="{{ route('admin.projects.edit', $project) }}" 
                   class="w-full bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Editar Projeto</span>
                </a>
                
                @if($project->project_url)
                <a href="{{ $project->project_url }}" 
                   target="_blank"
                   class="w-full bg-green-600/20 text-green-300 border border-green-600/30 hover:bg-green-600/30 px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Ver Online</span>
                </a>
                @endif
                
                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" 
                      onsubmit="return confirm('Tem certeza que deseja excluir este projeto? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600/20 text-red-300 border border-red-600/30 hover:bg-red-600/30 px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        <span>Excluir Projeto</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 