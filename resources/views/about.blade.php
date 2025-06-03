@extends('layouts.app')

@section('title', '- Sobre Nós')
@section('meta_description', 'Conheça a Nice Designs, agência especializada em web design moderno e desenvolvimento web. Nossa história, missão e valores.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-indigo-900 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-indigo-600/20 border border-indigo-400/30 rounded-full text-indigo-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-indigo-400 rounded-full mr-2 animate-pulse"></span>
                Sobre Nós
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold mb-8 leading-tight">
                Transformando 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">
                    Ideias em Realidade
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                Somos uma agência de web design dedicada a criar experiências digitais únicas e impactantes para nossos clientes.
            </p>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="text-4xl font-bold text-white mb-8">
                    Nossa História
                </h2>
                <div class="space-y-6 text-gray-300 leading-relaxed">
                    <p class="text-lg">
                        Fundada em 2019, a Nice Designs nasceu da paixão por criar soluções digitais que realmente fazem a diferença. 
                        Começamos como uma pequena equipe de designers e desenvolvedores determinados a revolucionar a forma como 
                        as empresas se conectam com seus clientes online.
                    </p>
                    <p>
                        Ao longo dos anos, evoluímos para nos tornar uma agência completa, oferecendo desde design visual 
                        até desenvolvimento web avançado. Nossa abordagem sempre foi centrada no usuário, garantindo que 
                        cada projeto não apenas seja visualmente impressionante, mas também funcional e eficiente.
                    </p>
                    <p>
                        Hoje, orgulhosamente servimos clientes de diversos setores, desde startups inovadoras até 
                        grandes corporações, sempre mantendo nosso compromisso com a excelência e a inovação.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl p-8 border border-indigo-500/30">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-indigo-400 mb-2">5+</div>
                            <div class="text-gray-300">Anos de Experiência</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-purple-400 mb-2">100+</div>
                            <div class="text-gray-300">Projetos Entregues</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-blue-400 mb-2">50+</div>
                            <div class="text-gray-300">Clientes Satisfeitos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-cyan-400 mb-2">98%</div>
                            <div class="text-gray-300">Taxa de Satisfação</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission, Vision, Values -->
<section class="py-20 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-6">Nossos Pilares</h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Os valores que nos guiam em cada projeto e decisão que tomamos.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Mission -->
            <div class="bg-gray-700/50 backdrop-blur-md rounded-3xl p-8 border border-gray-600 hover:border-indigo-500/50 transition-all duration-300 hover:scale-105 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Missão</h3>
                <p class="text-gray-300 leading-relaxed">
                    Transformar ideias em experiências digitais extraordinárias, capacitando nossos clientes 
                    a alcançar seus objetivos através de soluções web inovadoras e eficientes.
                </p>
            </div>

            <!-- Vision -->
            <div class="bg-gray-700/50 backdrop-blur-md rounded-3xl p-8 border border-gray-600 hover:border-purple-500/50 transition-all duration-300 hover:scale-105 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Visão</h3>
                <p class="text-gray-300 leading-relaxed">
                    Ser reconhecida como a principal referência em web design no Brasil, conhecida pela 
                    qualidade excepcional e pela capacidade de antecipar as tendências digitais do futuro.
                </p>
            </div>

            <!-- Values -->
            <div class="bg-gray-700/50 backdrop-blur-md rounded-3xl p-8 border border-gray-600 hover:border-blue-500/50 transition-all duration-300 hover:scale-105 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Valores</h3>
                <p class="text-gray-300 leading-relaxed">
                    Inovação constante, qualidade incomparável, transparência total, colaboração genuína 
                    e comprometimento absoluto com o sucesso de nossos clientes.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-6">Nossa Equipe</h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Conheça os talentos por trás dos projetos que transformam ideias em realidade digital.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl p-8 border border-gray-700 hover:border-indigo-500/50 transition-all duration-300 hover:scale-105 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-white text-2xl font-bold">RS</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Rafael Silva</h3>
                <p class="text-indigo-400 mb-4">CEO & Design Director</p>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Especialista em UX/UI Design com mais de 8 anos de experiência. 
                    Apaixonado por criar interfaces que conectam marcas e usuários.
                </p>
            </div>

            <!-- Team Member 2 -->
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl p-8 border border-gray-700 hover:border-purple-500/50 transition-all duration-300 hover:scale-105 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-white text-2xl font-bold">MC</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Maria Costa</h3>
                <p class="text-purple-400 mb-4">Lead Developer</p>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Desenvolvedora full-stack especializada em tecnologias modernas. 
                    Transforma designs em código limpo e funcional.
                </p>
            </div>

            <!-- Team Member 3 -->
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl p-8 border border-gray-700 hover:border-blue-500/50 transition-all duration-300 hover:scale-105 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-white text-2xl font-bold">AS</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">André Santos</h3>
                <p class="text-blue-400 mb-4">Creative Designer</p>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Designer criativo com foco em branding e identidade visual. 
                    Especialista em criar experiências visuais memoráveis.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Methodology Section -->
<section class="py-20 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-6">Nossa Metodologia</h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Um processo estruturado que garante resultados excepcionais em cada projeto.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <span class="text-white text-2xl font-bold">1</span>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-indigo-400 rounded-full animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Descoberta</h3>
                <p class="text-gray-300 leading-relaxed">
                    Entendemos seu negócio, objetivos e público-alvo para criar a estratégia perfeita.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <span class="text-white text-2xl font-bold">2</span>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-400 rounded-full animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Planejamento</h3>
                <p class="text-gray-300 leading-relaxed">
                    Criamos wireframes, protótipos e definimos a arquitetura da informação ideal.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <span class="text-white text-2xl font-bold">3</span>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-400 rounded-full animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Criação</h3>
                <p class="text-gray-300 leading-relaxed">
                    Desenvolvemos o design e implementamos todas as funcionalidades com precisão.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <span class="text-white text-2xl font-bold">4</span>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-cyan-400 rounded-full animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Entrega</h3>
                <p class="text-gray-300 leading-relaxed">
                    Realizamos testes rigorosos e entregamos um produto final de excelência.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-br from-black via-gray-900 to-indigo-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <h2 class="text-4xl md:text-5xl font-bold mb-8 leading-tight">
            Pronto para 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">
                Começar Seu Projeto?
            </span>
        </h2>
        
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
            Entre em contato conosco e vamos transformar sua visão em uma experiência digital extraordinária.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('contact') }}" 
               class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/25">
                <span class="inline-flex items-center">
                    Iniciar Conversa
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
            </a>
            <a href="{{ route('projects.index') }}" 
               class="border-2 border-white/30 text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                <span class="inline-flex items-center">
                    Ver Portfolio
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
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
</style>
@endsection 