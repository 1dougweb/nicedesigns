@extends('layouts.app')

@section('title', "- {$project->title}")
@section('meta_description', Str::limit($project->description, 160))

@section('content')
<!-- Header -->
<section class="relative bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white py-20 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                {{ $project->category->name }}
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                {{ $project->title }}
            </h1>
            
            @if($project->client_name)
            <p class="text-xl text-gray-300 mb-8">
                <span class="text-blue-400">Cliente:</span> {{ $project->client_name }}
            </p>
            @endif
            
            @if($project->project_url)
            <div class="flex justify-center mb-8">
                <a href="{{ $project->project_url }}" 
                   target="_blank"
                   class="group bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                    <span class="inline-flex items-center">
                        Visitar Projeto
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </span>
                </a>
            </div>
            @endif
            
            @if($project->technologies)
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                @foreach($project->technologies as $tech)
                <span class="bg-blue-600/20 text-blue-400 px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm">
                    {{ $tech }}
                </span>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Featured Image -->
@if($project->featured_image)
<section class="py-12 bg-gray-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl overflow-hidden shadow-2xl shadow-blue-500/10">
            <img src="{{ $project->featured_image }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-auto object-cover">
        </div>
    </div>
</section>
@endif

<!-- Content -->
<section class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2">
                <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700 p-8 shadow-xl">
                    <h2 class="text-3xl font-bold text-white mb-6">Sobre o Projeto</h2>
                    <div class="prose prose-lg max-w-none text-gray-300 prose-headings:text-white prose-a:text-blue-400">
                        <p class="text-xl mb-6 leading-relaxed">{{ $project->description }}</p>
                        @if($project->content)
                            <div class="mt-8">
                                {!! nl2br(e($project->content)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700 p-8 shadow-xl sticky top-24">
                    <h3 class="text-2xl font-bold text-white mb-6">Detalhes do Projeto</h3>
                    
                    @if($project->client_name)
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-400 mb-2">Cliente</h4>
                        <p class="text-white text-lg">{{ $project->client_name }}</p>
                    </div>
                    @endif

                    @if($project->completion_date)
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-400 mb-2">Data de Conclusão</h4>
                        <p class="text-white text-lg">{{ $project->completion_date->format('d/m/Y') }}</p>
                    </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="font-medium text-gray-400 mb-2">Categoria</h4>
                        <p class="text-white text-lg">{{ $project->category->name }}</p>
                    </div>

                    @if($project->technologies)
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-400 mb-2">Tecnologias</h4>
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($project->technologies as $tech)
                            <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ route('contact') }}" 
                           class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25 inline-flex items-center justify-center">
                            Solicitar Orçamento
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery -->
        @if($project->images && count($project->images) > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-white mb-8 text-center">Galeria do Projeto</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($project->images as $image)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700 overflow-hidden hover:border-blue-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                    <img src="{{ $image }}" alt="{{ $project->title }}" class="w-full h-64 object-cover">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 mt-16">
            <a href="{{ route('projects.index') }}" 
               class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar ao Portfolio
            </a>
            
            @if($project->project_url)
            <a href="{{ $project->project_url }}" 
               target="_blank"
               class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-colors">
                Visitar Projeto
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
            @endif
        </div>
    </div>
</section>

<!-- Related Projects -->
@if($relatedProjects->count() > 0)
<section class="py-20 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-green-600/20 border border-green-400/30 rounded-full text-green-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Projetos Relacionados
            </div>
            <h2 class="text-4xl font-bold text-white mb-6">
                Outros <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-400">Projetos</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Conheça outros projetos na categoria {{ $project->category->name }}
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedProjects as $relatedProject)
            <div class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-green-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    @if($relatedProject->featured_image)
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $relatedProject->featured_image }}');">
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ $relatedProject->title }}</span>
                    </div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">
                            {{ $relatedProject->category->name }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-3">{{ $relatedProject->title }}</h3>
                    <p class="text-gray-300 mb-4">{{ Str::limit($relatedProject->description, 100) }}</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if(is_array($relatedProject->technologies) && count($relatedProject->technologies) > 0)
                            @foreach(array_slice($relatedProject->technologies, 0, 3) as $tech)
                                <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm">{{ $tech }}</span>
                            @endforeach
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">
                            @if($relatedProject->completion_date)
                                {{ $relatedProject->completion_date->format('M Y') }}
                            @endif
                        </span>
                        <a href="{{ route('projects.show', $relatedProject->slug) }}" class="text-green-400 hover:text-green-300 transition-colors">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                Ver Todos os Projetos
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
            Vamos começar seu projeto
        </div>
        
        <h2 class="text-4xl font-bold mb-8 leading-tight">
            Quer um projeto como esse?
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                Entre em contato!
            </span>
        </h2>
        
        <p class="text-xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
            Entre em contato conosco e descubra como podemos ajudar sua empresa a se destacar no mundo digital 
            com soluções personalizadas e resultados comprovados.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('contact') }}" 
               class="group bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-12 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                <span class="inline-flex items-center">
                    Solicitar Orçamento
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
            </a>
            <a href="{{ route('projects.index') }}" 
               class="group border-2 border-white/30 text-white hover:bg-white hover:text-gray-900 px-12 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                <span class="inline-flex items-center">
                    Ver Portfolio
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Adicionar animações CSS customizadas -->
<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection 