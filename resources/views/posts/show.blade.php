@extends('layouts.app')

@section('title', "- {$post->title}")
@section('meta_description', $post->meta_description ?: Str::limit($post->excerpt, 160))

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <a href="{{ route('posts.category', $post->category->slug) }}" 
               class="inline-block text-blue-400 hover:text-blue-300 text-sm font-semibold mb-4">
                {{ $post->category->name }}
            </a>
            <h1 class="text-3xl md:text-5xl font-bold mb-6">{{ $post->title }}</h1>
            <div class="flex items-center justify-center space-x-6 text-gray-300">
                <span>Por {{ $post->author->name }}</span>
                <span>•</span>
                <time>{{ $post->published_at->format('d/m/Y') }}</time>
                <span>•</span>
                <span>{{ Str::readingTime($post->content) }} min de leitura</span>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<article class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="mb-12">
            <img src="{{ $post->featured_image }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-96 object-cover rounded-lg shadow-lg">
        </div>
        @endif

        <!-- Post Content -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <div class="prose prose-lg prose-blue max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        <!-- Share Buttons -->
        <div class="bg-gray-50 rounded-lg p-6 mb-12">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Compartilhe este post</h3>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" 
                   target="_blank"
                   class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                    Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                    LinkedIn
                </a>
                <button onclick="copyToClipboard()" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300">
                    Copiar Link
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 space-y-4 sm:space-y-0">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar ao Blog
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300">
                Entre em Contato
            </a>
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Posts Relacionados</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPosts as $relatedPost)
            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                @if($relatedPost->featured_image)
                <img src="{{ $relatedPost->featured_image }}" alt="{{ $relatedPost->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-r from-gray-500 to-gray-600 flex items-center justify-center">
                    <span class="text-white text-lg font-semibold">{{ Str::limit($relatedPost->title, 30) }}</span>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-blue-600 font-semibold">{{ $relatedPost->category->name }}</span>
                        <time class="text-sm text-gray-500">{{ $relatedPost->published_at->format('d/m/Y') }}</time>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                        <a href="{{ route('posts.show', $relatedPost->slug) }}" class="hover:text-blue-600">
                            {{ $relatedPost->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($relatedPost->excerpt, 120) }}</p>
                    <a href="{{ route('posts.show', $relatedPost->slug) }}" 
                       class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center">
                        Ler Mais
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('Link copiado para a área de transferência!');
    });
}
</script>
@endpush
@endsection 