@extends('layouts.app')

@section('title', "- {$page->title}")
@section('meta_description', $page->meta_description ?: Str::limit(strip_tags($page->content), 160))

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $page->title }}</h1>
        </div>
    </div>
</section>

<!-- Content -->
<article class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="prose prose-lg prose-blue max-w-none">
                {!! nl2br(e($page->content)) !!}
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-center mt-12">
            <a href="{{ route('contact') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300">
                Entre em Contato
            </a>
        </div>
    </div>
</article>
@endsection 