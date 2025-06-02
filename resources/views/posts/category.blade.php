@extends('layouts.app')

@section('title', "- {$category->name}")
@section('meta_description', "Posts da categoria {$category->name} - {$category->description}")

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $category->name }}</h1>
            <p class="text-xl text-gray-300">{{ $category->description }}</p>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar ao Blog
            </a>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
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
                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </h3>
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
                <p class="mt-2 text-gray-500">Ainda não temos posts nesta categoria.</p>
            </div>
        @endif
    </div>
</section>
@endsection 