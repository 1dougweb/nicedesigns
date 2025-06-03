@extends('layouts.app')

@section('title', '- Blog')
@section('meta_description', 'Fique por dentro das tendências e novidades do mundo digital com o blog da Nice Designs. Dicas, tutoriais e insights sobre web design e desenvolvimento.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg>')"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                Blog
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold mb-8 leading-tight">
                Insights & 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                    Tendências
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                Fique por dentro das novidades do mundo digital, dicas práticas e insights sobre web design e desenvolvimento.
            </p>

            <!-- Search Bar -->
            <div class="max-w-xl mx-auto">
                <form action="{{ route('posts.index') }}" method="GET" class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Buscar artigos..." 
                           class="w-full px-6 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-16">
                    <button type="submit" 
                            class="absolute right-2 top-2 bottom-2 px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-12 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('posts.index') }}" 
               class="category-btn {{ !request('category') ? 'active bg-gradient-to-r from-blue-600 to-blue-700 text-white' : 'bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-blue-500/50' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                Todos os Posts
            </a>
            <a href="{{ route('posts.index', ['category' => 'desenvolvimento']) }}" 
               class="category-btn {{ request('category') === 'desenvolvimento' ? 'active bg-gradient-to-r from-purple-600 to-purple-700 text-white' : 'bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-purple-500/50' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                Desenvolvimento
            </a>
            <a href="{{ route('posts.index', ['category' => 'design']) }}" 
               class="category-btn {{ request('category') === 'design' ? 'active bg-gradient-to-r from-green-600 to-green-700 text-white' : 'bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-green-500/50' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                Design
            </a>
            <a href="{{ route('posts.index', ['category' => 'seo']) }}" 
               class="category-btn {{ request('category') === 'seo' ? 'active bg-gradient-to-r from-yellow-600 to-yellow-700 text-white' : 'bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-yellow-500/50' }} px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                SEO
            </a>
        </div>
    </div>
</section>

<!-- Posts Grid -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="group bg-gray-800/50 backdrop-blur-md rounded-3xl overflow-hidden border border-gray-700 hover:border-blue-500/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-blue-500/25">
                        <!-- Post Image -->
                        <div class="relative overflow-hidden h-64">
                            @if($post->featured_image)
                                <img src="{{ Storage::url($post->featured_image) }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-white text-lg font-bold">{{ Str::limit($post->title, 20) }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <a href="{{ route('posts.show', $post) }}" 
                                   class="bg-white/20 backdrop-blur-md text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Ler Artigo
                                </a>
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                @php
                                    $categoryColors = [
                                        'desenvolvimento' => 'bg-purple-500',
                                        'design' => 'bg-green-500',
                                        'seo' => 'bg-yellow-500',
                                        'default' => 'bg-blue-500'
                                    ];
                                    
                                    $categoryName = $post->category ? $post->category->name : 'default';
                                    $categorySlug = $post->category ? $post->category->slug : 'default';
                                    $color = $categoryColors[$categorySlug] ?? $categoryColors['default'];
                                @endphp
                                <span class="{{ $color }} text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">
                                    {{ $categoryName ?? 'Artigo' }}
                                </span>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="p-8">
                            <!-- Meta Info -->
                            <div class="flex items-center text-gray-400 text-sm mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                <span class="mx-2">•</span>
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $post->read_time ?? '5' }} min de leitura</span>
                            </div>

                            <h2 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h2>

                            <p class="text-gray-300 mb-6 leading-relaxed line-clamp-3">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <!-- Tags -->
                            @if($post->tags)
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @php
                                        $tags = is_array($post->tags) 
                                            ? $post->tags 
                                            : explode(',', $post->tags);
                                    @endphp
                                    @foreach($tags as $tag)
                                        <span class="bg-gray-700/50 text-gray-300 px-2 py-1 rounded-lg text-xs">
                                            #{{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Author & Read More -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    @php
                                        $authorName = $post->author ? $post->author->name : 'NiceDesigns Team';
                                        $authorInitials = substr($authorName, 0, 2);
                                    @endphp
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ $authorInitials }}</span>
                                    </div>
                                    <span class="text-gray-400 text-sm">{{ $authorName }}</span>
                                </div>
                                <a href="{{ route('posts.show', $post) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors font-semibold">
                                    Ler mais →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-16 flex justify-center">
                    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl p-2 border border-gray-700">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                @if(request('search'))
                    <h3 class="text-2xl font-bold text-white mb-4">Nenhum resultado encontrado</h3>
                    <p class="text-gray-300 mb-8 max-w-md mx-auto">
                        Não encontramos nenhum artigo para "{{ request('search') }}". Tente outra busca.
                    </p>
                    <a href="{{ route('posts.index') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Ver Todos os Posts
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                @else
                    <h3 class="text-2xl font-bold text-white mb-4">Em Breve Novos Artigos</h3>
                    <p class="text-gray-300 mb-8 max-w-md mx-auto">
                        Estamos preparando conteúdos incríveis sobre web design e desenvolvimento. Volte em breve!
                    </p>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Sugerir Tópico
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl p-12 border border-blue-500/30 text-center">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-white mb-4">
                Receba as Novidades em Primeira Mão
            </h2>
            
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Inscreva-se em nossa newsletter e seja o primeiro a saber sobre novos artigos, dicas e tendências do mundo digital.
            </p>
            
            <form class="max-w-lg mx-auto flex gap-4">
                <input type="email" 
                       placeholder="Seu melhor e-mail" 
                       class="flex-1 px-6 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" 
                        class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 whitespace-nowrap">
                    Inscrever-se
                </button>
            </form>
            
            <p class="text-gray-400 text-sm mt-4">
                Sem spam. Apenas conteúdo de qualidade. Cancele a qualquer momento.
            </p>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}
</style>
@endsection 