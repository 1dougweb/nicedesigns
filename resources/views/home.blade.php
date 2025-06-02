@extends('layouts.app')

@section('title', '- Agência de Web Design Moderna')
@section('meta_description', 'Nice Designs - Agência especializada em web design moderno e desenvolvimento de sites responsivos. Transformamos ideias em experiências digitais incríveis.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-black via-gray-900 to-blue-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Transformamos <span class="text-blue-400">Ideias</span> em
                <span class="text-blue-400">Experiências Digitais</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                Somos uma agência especializada em web design moderno e desenvolvimento de sites responsivos 
                que conectam marcas aos seus clientes.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('projects.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105">
                    Ver Portfolio
                </a>
                <a href="{{ route('contact') }}" 
                   class="border border-blue-400 text-blue-400 hover:bg-blue-400 hover:text-black px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105">
                    Fale Conosco
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Serviços Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Nossos Serviços
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Oferecemos soluções completas para sua presença digital
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Web Design</h3>
                <p class="text-gray-600">
                    Criamos designs modernos, responsivos e otimizados para conversão que encantam seus usuários.
                </p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Desenvolvimento</h3>
                <p class="text-gray-600">
                    Desenvolvemos sites e aplicações web robustas utilizando as tecnologias mais modernas do mercado.
                </p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">SEO & Performance</h3>
                <p class="text-gray-600">
                    Otimizamos seu site para mecanismos de busca e garantimos máxima performance e velocidade.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
@if($featuredProjects->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Projetos em Destaque
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Conheça alguns dos nossos trabalhos mais recentes
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProjects as $project)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                @if($project->featured_image)
                <img src="{{ $project->featured_image }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                    <span class="text-white text-lg font-semibold">{{ $project->title }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-blue-600 font-semibold">{{ $project->category->name }}</span>
                        @if($project->is_featured)
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Destaque</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $project->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                    @if($project->technologies)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(array_slice($project->technologies, 0, 3) as $tech)
                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('projects.show', $project->slug) }}" 
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

        <div class="text-center mt-12">
            <a href="{{ route('projects.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                Ver Todos os Projetos
            </a>
        </div>
    </div>
</section>
@endif

<!-- Blog Section -->
@if($latestPosts->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Últimas do Blog
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Fique por dentro das últimas tendências em web design e desenvolvimento
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                @if($post->featured_image)
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-gray-500 to-gray-600 flex items-center justify-center">
                    <span class="text-white text-lg font-semibold">{{ Str::limit($post->title, 30) }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-blue-600 font-semibold">{{ $post->category->name }}</span>
                        <time class="text-sm text-gray-500">{{ $post->published_at->format('d/m/Y') }}</time>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $post->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 120) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Por {{ $post->author->name }}</span>
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                            Ler Mais
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('posts.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition duration-300">
                Ver Todos os Posts
            </a>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Pronto para Transformar sua Presença Digital?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
            Entre em contato conosco e descubra como podemos ajudar sua empresa a se destacar no mundo digital.
        </p>
        <a href="{{ route('contact') }}" 
           class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105">
            Solicitar Orçamento
        </a>
    </div>
</section>
@endsection 