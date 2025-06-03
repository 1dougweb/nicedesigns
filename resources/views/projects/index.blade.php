@extends('layouts.app')

@section('title', '- Portfolio')
@section('meta_description', 'Conheça nosso portfolio com projetos inovadores de web design e desenvolvimento. Veja como transformamos ideias em experiências digitais incríveis.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-purple-900 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg>')"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-purple-600/20 border border-purple-400/30 rounded-full text-purple-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-purple-400 rounded-full mr-2 animate-pulse"></span>
                Portfolio
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold mb-8 leading-tight">
                Nossos 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">
                    Projetos
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                Conheça alguns dos projetos que desenvolvemos com excelência, inovação e resultados comprovados.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-purple-400 mb-2">{{ $projects->count() }}+</div>
                    <div class="text-gray-300">Projetos</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-pink-400 mb-2">100%</div>
                    <div class="text-gray-300">Entregues</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-blue-400 mb-2">98%</div>
                    <div class="text-gray-300">Satisfação</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-cyan-400 mb-2">5+</div>
                    <div class="text-gray-300">Anos</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-12 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-btn active bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105" data-filter="all">
                Todos os Projetos
            </button>
            <button class="filter-btn bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-blue-500/50 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105" data-filter="web">
                Web Design
            </button>
            <button class="filter-btn bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-green-500/50 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105" data-filter="ecommerce">
                E-commerce
            </button>
            <button class="filter-btn bg-gray-800/50 border border-gray-700 text-gray-300 hover:text-white hover:border-pink-500/50 px-6 py-3 rounded-xl font-semibold transition-all duration-300 hover:scale-105" data-filter="mobile">
                Mobile
            </button>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="projects-grid">
                @foreach($projects as $project)
                    <div class="project-card group bg-gray-800/50 backdrop-blur-md rounded-3xl overflow-hidden border border-gray-700 hover:border-purple-500/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-purple-500/25" data-category="{{ strtolower($project->category ? $project->category->name : 'web') }}">
                        <!-- Project Image -->
                        <div class="relative overflow-hidden h-64">
                            @if($project->image)
                                <img src="{{ Storage::url($project->image) }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-16 h-16 text-white mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-white text-lg font-bold">{{ $project->title }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <div class="text-center">
                                    <a href="{{ route('projects.show', $project) }}" 
                                       class="bg-white/20 backdrop-blur-md text-white px-6 py-3 rounded-xl font-semibold hover:bg-white/30 transition-all duration-300 inline-flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver Projeto
                                    </a>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-4 right-4">
                                @if($project->status === 'completed')
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Concluído</span>
                                @elseif($project->status === 'in_progress')
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Em Desenvolvimento</span>
                                @else
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Planejamento</span>
                                @endif
                            </div>
                        </div>

                        <!-- Project Info -->
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-purple-600/20 text-purple-400 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $project->category ? $project->category->name : 'Web Design' }}
                                </span>
                                @if($project->client)
                                    <span class="text-gray-400 text-sm">{{ $project->client }}</span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                                {{ $project->title }}
                            </h3>

                            <p class="text-gray-300 mb-6 leading-relaxed line-clamp-3">
                                {{ $project->description }}
                            </p>

                            <!-- Technologies -->
                            @if($project->technologies)
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @php
                                        $technologies = is_array($project->technologies) 
                                            ? $project->technologies 
                                            : explode(',', $project->technologies);
                                    @endphp
                                    @foreach($technologies as $tech)
                                        <span class="bg-gray-700/50 text-gray-300 px-2 py-1 rounded-lg text-xs">
                                            {{ trim($tech) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Project Links -->
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-3">
                                    @if($project->demo_url)
                                        <a href="{{ $project->demo_url }}" 
                                           target="_blank"
                                           class="text-purple-400 hover:text-purple-300 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" 
                                           target="_blank"
                                           class="text-gray-400 hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                                <a href="{{ route('projects.show', $project) }}" 
                                   class="text-purple-400 hover:text-purple-300 transition-colors font-semibold">
                                    Detalhes →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $projects->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Em Breve Novos Projetos</h3>
                <p class="text-gray-300 mb-8 max-w-md mx-auto">
                    Estamos trabalhando em projetos incríveis que serão adicionados ao nosso portfolio em breve.
                </p>
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                    Solicitar Orçamento
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-black via-gray-900 to-purple-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <h2 class="text-4xl md:text-5xl font-bold mb-8 leading-tight">
            Pronto para o 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">
                Próximo Projeto?
            </span>
        </h2>
        
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
            Vamos conversar sobre como podemos transformar sua visão em uma realidade digital incrível.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('contact') }}" 
               class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/25">
                <span class="inline-flex items-center">
                    Iniciar Projeto
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
            </a>
            <a href="{{ route('home') }}" 
               class="border-2 border-white/30 text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                <span class="inline-flex items-center">
                    Voltar ao Início
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Custom Styles and Scripts -->
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-gradient-to-r', 'from-purple-600', 'to-purple-700', 'text-white');
                btn.classList.add('bg-gray-800/50', 'border', 'border-gray-700', 'text-gray-300');
            });

            this.classList.add('active', 'bg-gradient-to-r', 'from-purple-600', 'to-purple-700', 'text-white');
            this.classList.remove('bg-gray-800/50', 'border', 'border-gray-700', 'text-gray-300');

            // Filter projects
            projectCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
});
</script>
@endsection 