@extends('layouts.app')

@section('title', '- Portfolio')
@section('meta_description', 'Confira nossos projetos de web design e desenvolvimento. Portfolio da Nice Designs com cases de sucesso.')

@section('content')
<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Portfolio</h1>
            <p class="text-xl text-gray-300">
                Conheça nossos projetos e cases de sucesso
            </p>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
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

            <!-- Pagination -->
            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Nenhum projeto encontrado</h3>
                <p class="mt-2 text-gray-500">Ainda não temos projetos publicados. Volte em breve!</p>
            </div>
        @endif
    </div>
</section>
@endsection 