@extends('layouts.app')

@section('title', "- {$project->title}")
@section('meta_description', Str::limit($project->description, 160))

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-block text-blue-400 text-sm font-semibold mb-4">{{ $project->category->name }}</span>
            <h1 class="text-3xl md:text-5xl font-bold mb-6">{{ $project->title }}</h1>
            @if($project->client_name)
            <p class="text-xl text-gray-300">Cliente: {{ $project->client_name }}</p>
            @endif
        </div>
    </div>
</section>

<!-- Content -->
<article class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Featured Image -->
        @if($project->featured_image)
        <div class="mb-12">
            <img src="{{ $project->featured_image }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-96 object-cover rounded-lg shadow-lg">
        </div>
        @endif

        <!-- Project Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-12">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Sobre o Projeto</h2>
                <div class="prose prose-lg max-w-none text-gray-600">
                    <p class="text-lg">{{ $project->description }}</p>
                    @if($project->content)
                        {!! nl2br(e($project->content)) !!}
                    @endif
                </div>
            </div>

            <div>
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalhes do Projeto</h3>
                    
                    @if($project->client_name)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700">Cliente</h4>
                        <p class="text-gray-600">{{ $project->client_name }}</p>
                    </div>
                    @endif

                    @if($project->completion_date)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700">Data de Conclusão</h4>
                        <p class="text-gray-600">{{ $project->completion_date->format('m/Y') }}</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700">Categoria</h4>
                        <p class="text-gray-600">{{ $project->category->name }}</p>
                    </div>

                    @if($project->technologies)
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700 mb-2">Tecnologias</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($project->technologies as $tech)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($project->project_url)
                    <div class="mt-6">
                        <a href="{{ $project->project_url }}" 
                           target="_blank"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300 inline-flex items-center justify-center">
                            Ver Site
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Gallery -->
        @if($project->images)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Galeria</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($project->images as $image)
                <img src="{{ $image }}" alt="{{ $project->title }}" class="w-full h-64 object-cover rounded-lg shadow-lg">
                @endforeach
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <a href="{{ route('projects.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar ao Portfolio
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                Solicitar Orçamento
            </a>
        </div>
    </div>
</article>

<!-- Related Projects -->
@if($relatedProjects->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Projetos Relacionados</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedProjects as $relatedProject)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                @if($relatedProject->featured_image)
                <img src="{{ $relatedProject->featured_image }}" alt="{{ $relatedProject->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-lg font-semibold">{{ $relatedProject->title }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        <a href="{{ route('projects.show', $relatedProject->slug) }}" class="hover:text-blue-600">
                            {{ $relatedProject->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($relatedProject->description, 120) }}</p>
                    <a href="{{ route('projects.show', $relatedProject->slug) }}" 
                       class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                        Ver Projeto
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection 