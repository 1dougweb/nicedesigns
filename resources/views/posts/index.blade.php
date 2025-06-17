@extends('layouts.app')

@section('title', '- Blog')
@section('meta_description', 'Fique por dentro das tendências e novidades do mundo digital com o blog da Nice Designs. Dicas, tutoriais e insights sobre web design e desenvolvimento.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg></div>
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
                        <i class="fi fi-rr-search text-xl mt-2"></i>
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
            
            @foreach($categories as $category)
                @php
                    $categoryColors = [
                        'desenvolvimento' => 'from-purple-600 to-purple-700',
                        'design' => 'from-green-600 to-green-700',
                        'seo' => 'from-yellow-600 to-yellow-700',
                        'marketing-digital' => 'from-red-600 to-red-700',
                        'default' => 'from-blue-600 to-blue-700'
                    ];
                    
                    $borderColors = [
                        'desenvolvimento' => 'purple-500/50',
                        'design' => 'green-500/50',
                        'seo' => 'yellow-500/50',
                        'marketing-digital' => 'red-500/50',
                        'default' => 'blue-500/50'
                    ];
                    
                    $gradientClass = $categoryColors[$category->slug] ?? $categoryColors['default'];
                    $borderClass = $borderColors[$category->slug] ?? $borderColors['default'];
                @endphp
                
                <a href="{{ route('posts.index', ['category' => $category->slug]) }}" 
                   class="category-btn {{ request('category') === $category->slug ? 'active bg-gradient-to-r '.$gradientClass.' text-white' : 'bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-'.$borderClass }} px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105">
                    {{ $category->name }}
                    <span class="ml-1 text-xs opacity-70">({{ $category->posts_count }})</span>
                </a>
            @endforeach
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
                                        <i class="fi fi-rr-document text-white text-4xl mb-2"></i>
                                        <span class="text-white text-lg font-bold">{{ Str::limit($post->title, 20) }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <a href="{{ route('posts.show', $post) }}" 
                                   class="bg-white/20 backdrop-blur-md text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 inline-flex items-center">
                                    <i class="fi fi-rr-book-alt text-lg mr-2 mt-2"></i>
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
                                <i class="fi fi-rr-calendar text-lg mr-2 mt-2"></i>
                                <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                <span class="mx-2">•</span>
                                <i class="fi fi-rr-clock text-lg mr-1 mt-2"></i>
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
                    <i class="fi fi-rr-document text-white text-4xl"></i>
                </div>
                @if(request('search'))
                    <h3 class="text-2xl font-bold text-white mb-4">Nenhum resultado encontrado</h3>
                    <p class="text-gray-300 mb-8 max-w-md mx-auto">
                        Não encontramos nenhum artigo para "{{ request('search') }}". Tente outra busca.
                    </p>
                    <a href="{{ route('posts.index') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Ver Todos os Posts
                        <i class="fi fi-rr-arrow-right text-lg ml-2 mt-2"></i>
                    </a>
                @else
                    <h3 class="text-2xl font-bold text-white mb-4">Em Breve Novos Artigos</h3>
                    <p class="text-gray-300 mb-8 max-w-md mx-auto">
                        Estamos preparando conteúdos incríveis sobre web design e desenvolvimento. Volte em breve!
                    </p>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        Sugerir Tópico
                        <i class="fi fi-rr-arrow-right text-lg ml-2 mt-2"></i>
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
                <i class="fi fi-rr-envelope text-white text-2xl"></i>
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