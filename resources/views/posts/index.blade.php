@extends('layouts.app')

@section('title', '- Blog')
@section('meta_description', 'Confira os últimos artigos sobre web design, desenvolvimento e marketing digital no blog da Nice Designs.')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Blog</h1>
            <p class="text-xl text-gray-300">
                Fique por dentro das últimas tendências em web design e desenvolvimento
            </p>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Posts -->
            <div class="lg:w-2/3">
                @if($posts->count() > 0)
                    <div class="space-y-8">
                        @foreach($posts as $post)
                        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                            @else
                            <div class="w-full h-64 bg-gradient-to-r from-gray-500 to-gray-600 flex items-center justify-center">
                                <span class="text-white text-xl font-semibold">{{ Str::limit($post->title, 50) }}</span>
                            </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <a href="{{ route('posts.category', $post->category->slug) }}" 
                                       class="text-sm text-blue-600 font-semibold hover:text-blue-800">
                                        {{ $post->category->name }}
                                    </a>
                                    <time class="text-sm text-gray-500">{{ $post->published_at->format('d/m/Y') }}</time>
                                </div>
                                
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt, 200) }}</p>
                                
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

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Nenhum post encontrado</h3>
                        <p class="mt-2 text-gray-500">Ainda não temos posts publicados. Volte em breve!</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- Categorias -->
                @if($categories->count() > 0)
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Categorias</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('posts.category', $category->slug) }}" 
                               class="flex items-center justify-between text-gray-600 hover:text-blue-600 py-2 border-b border-gray-100">
                                <span>{{ $category->name }}</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                    {{ $category->posts_count }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Newsletter -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                    <p class="text-blue-100 mb-4">
                        Receba nossas novidades e dicas exclusivas diretamente no seu email.
                    </p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Seu melhor email" 
                               class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <button type="submit" 
                                class="w-full bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                            Inscrever-se
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 