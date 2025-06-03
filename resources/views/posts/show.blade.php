@extends('layouts.app')

@section('title', "- {$post->title}")
@section('meta_description', $post->meta_description ?: Str::limit($post->excerpt, 160))

@section('content')
<!-- Header -->
<section class="bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white py-24 overflow-hidden relative">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            @if($post->category)
                <a href="{{ route('posts.category', $post->category->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm hover:bg-blue-600/30 transition-all duration-300">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                    {{ $post->category->name }}
                </a>
            @endif
            
            <h1 class="text-3xl md:text-5xl font-bold mb-8 leading-tight">{{ $post->title }}</h1>
            
            <div class="flex flex-wrap items-center justify-center gap-6 text-gray-300">
                @if($post->author)
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">{{ substr($post->author->name, 0, 2) }}</span>
                        </div>
                        <span>{{ $post->author->name }}</span>
                    </div>
                @endif
                <span class="text-gray-500">•</span>
                <time class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $post->published_at->format('d/m/Y') }}
                </time>
                <span class="text-gray-500">•</span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $post->read_time ?? '5' }} min de leitura
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<article class="py-20 bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="mb-12">
            <img src="{{ Storage::url($post->featured_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-96 object-cover rounded-3xl shadow-2xl">
        </div>
        @endif

        <!-- Post Content -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700 p-8 mb-12 shadow-2xl">
            <div class="prose prose-lg prose-invert max-w-none text-gray-300 leading-relaxed">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        <!-- Share Buttons -->
        <div class="bg-gray-800/30 backdrop-blur-md rounded-3xl border border-gray-700 p-8 mb-12">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                </svg>
                Compartilhe este post
            </h3>
            <div class="flex flex-wrap gap-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" 
                   target="_blank"
                   class="bg-sky-500 hover:bg-sky-600 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                   target="_blank"
                   class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </a>
                <button onclick="copyToClipboard()" 
                        class="bg-gray-600 hover:bg-gray-500 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copiar Link
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12 space-y-4 sm:space-y-0">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center text-blue-400 hover:text-blue-300 font-semibold transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar ao Blog
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                Entre em Contato
            </a>
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="py-20 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-white text-center mb-16">Posts Relacionados</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPosts as $relatedPost)
            <article class="group bg-gray-700/50 backdrop-blur-md rounded-3xl overflow-hidden border border-gray-600 hover:border-blue-500/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-blue-500/25">
                <div class="relative overflow-hidden h-48">
                    @if($relatedPost->featured_image)
                        <img src="{{ Storage::url($relatedPost->featured_image) }}" 
                             alt="{{ $relatedPost->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-lg font-bold">{{ Str::limit($relatedPost->title, 30) }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        @if($relatedPost->category)
                            <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $relatedPost->category->name }}
                            </span>
                        @endif
                        <time class="text-sm text-gray-400">{{ $relatedPost->published_at->format('d/m/Y') }}</time>
                    </div>
                    
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">
                        <a href="{{ route('posts.show', $relatedPost->slug) }}">
                            {{ $relatedPost->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-300 mb-4 leading-relaxed">{{ Str::limit($relatedPost->excerpt, 120) }}</p>
                    
                    <a href="{{ route('posts.show', $relatedPost->slug) }}" 
                       class="text-blue-400 hover:text-blue-300 font-semibold inline-flex items-center transition-colors">
                        Ler Mais
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        // Create a temporary notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 transition-all duration-300';
        notification.textContent = 'Link copiado para a área de transferência!';
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    });
}
</script>
@endpush
@endsection 