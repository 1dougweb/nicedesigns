@extends('layouts.app')

@section('title', '- Desenvolvimento de Sistemas Web Profissionais')
@section('meta_description', 'Nice Designs - Especialistas em desenvolvimento de sistemas web, plataformas empresariais e soluções digitais personalizadas para seu negócio.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                Desenvolvimento de Sistemas Web
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight">
                Transformamos 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 animate-pulse">
                    Negócios
                </span> 
                com<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">
                    Sistemas Web Avançados
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                Desenvolvemos sistemas web personalizados, plataformas empresariais e soluções digitais 
                que impulsionam a produtividade e o crescimento do seu negócio.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16">
                <a href="{{ route('contact') }}" 
                   class="group bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-10 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                    <span class="inline-flex items-center">
                        Solicitar Orçamento
                        <i class="fi fi-rr-arrow-right w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
                    </span>
                </a>
                <a href="{{ route('projects.index') }}" 
                   class="group border-2 border-blue-400 text-blue-400 hover:bg-blue-400 hover:text-black px-10 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                    <span class="inline-flex items-center">
                        Ver Projetos
                        <i class="fi fi-rr-eye w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
            
            <!-- Floating Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-blue-400 mb-2">100+</div>
                    <div class="text-gray-300">Sistemas Entregues</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-cyan-400 mb-2">98%</div>
                    <div class="text-gray-300">Clientes Satisfeitos</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-blue-400 mb-2">7+</div>
                    <div class="text-gray-300">Anos de Experiência</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fi fi-rr-angle-down w-6 h-6 text-white/60" aria-hidden="true"></i>
    </div>
</section>

<!-- Anúncio em Destaque -->
<section class="py-8 bg-gradient-to-r from-blue-900 to-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6 flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center mb-4 md:mb-0">
                <div class="bg-yellow-500/20 p-3 rounded-xl mr-4">
                    <i class="fi fi-rr-megaphone text-yellow-400 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Sistema de Gestão Empresarial</h3>
                    <p class="text-gray-300">Promoção especial: 30% de desconto até o final do mês</p>
                </div>
            </div>
            <a href="{{ route('contact') }}?promo=erp30" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-black px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 transform hover:scale-105">
                Aproveitar Oferta
            </a>
        </div>
    </div>
</section>

<!-- Serviços Section -->
<section class="py-24 bg-gradient-to-b from-gray-800 to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <span class="inline-block px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-4 backdrop-blur-sm">
                Nossas Soluções
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Sistemas Web
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Sob Medida</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Desenvolvemos soluções digitais completas e personalizadas para atender às necessidades específicas do seu negócio
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- ERP & Gestão -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-blue-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-blue-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="fi fi-rr-chart-network text-white text-3xl mt-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Sistemas ERP</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Sistemas de gestão empresarial completos que integram todos os processos do seu negócio em uma única plataforma.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-blue-400 mr-2" aria-hidden="true"></i>
                        Controle Financeiro
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-blue-400 mr-2" aria-hidden="true"></i>
                        Gestão de Estoque
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-blue-400 mr-2" aria-hidden="true"></i>
                        Relatórios Gerenciais
                    </li>
                </ul>
            </div>

            <!-- E-commerce & Marketplaces -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-purple-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-purple-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="fi fi-rr-shopping-cart text-white text-3xl mt-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">E-commerce</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Plataformas de vendas online completas e personalizadas, com integração de pagamentos e gestão de produtos.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-purple-400 mr-2" aria-hidden="true"></i>
                        Checkout Otimizado
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-purple-400 mr-2" aria-hidden="true"></i>
                        Integração com Gateways
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-purple-400 mr-2" aria-hidden="true"></i>
                        Gestão de Pedidos
                    </li>
                </ul>
            </div>

            <!-- CRM & Automação -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-green-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-green-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="fi fi-rr-users text-white text-3xl mt-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">CRM & Automação</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Sistemas de relacionamento com clientes e automação de processos comerciais para aumentar suas vendas.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-green-400 mr-2" aria-hidden="true"></i>
                        Funil de Vendas
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-green-400 mr-2" aria-hidden="true"></i>
                        Automação de Marketing
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-green-400 mr-2" aria-hidden="true"></i>
                        Gestão de Leads
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Segunda linha de serviços -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
            <!-- Aplicações SaaS -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-red-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-red-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="fi fi-rr-cloud text-white text-3xl mt-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Aplicações SaaS</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Desenvolvimento de software como serviço com modelo de assinatura e acesso via web ou aplicativo.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-red-400 mr-2" aria-hidden="true"></i>
                        Modelo de Assinatura
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-red-400 mr-2" aria-hidden="true"></i>
                        Multi-tenant
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-red-400 mr-2" aria-hidden="true"></i>
                        Escalabilidade Cloud
                    </li>
                </ul>
            </div>

            <!-- Intranets & Portais -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-orange-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-orange-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="fi fi-rr-building text-white text-3xl mt-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Intranets & Portais</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Plataformas internas para empresas com gestão de documentos, comunicação e processos internos.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-orange-400 mr-2" aria-hidden="true"></i>
                        Gestão Documental
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-orange-400 mr-2" aria-hidden="true"></i>
                        Comunicação Interna
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-orange-400 mr-2" aria-hidden="true"></i>
                        Fluxos de Aprovação
                    </li>
                </ul>
            </div>

            <!-- APIs & Integrações -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-cyan-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-cyan-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                <i class="fi fi-rr-link text-white text-3xl mt-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">APIs & Integrações</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Desenvolvimento de APIs e integrações entre sistemas para automatizar processos e sincronizar dados.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-cyan-400 mr-2" aria-hidden="true"></i>
                        REST/GraphQL APIs
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-cyan-400 mr-2" aria-hidden="true"></i>
                        Webhooks
                    </li>
                    <li class="flex items-center">
                        <i class="fi fi-rr-check w-4 h-4 text-cyan-400 mr-2" aria-hidden="true"></i>
                        Microsserviços
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Anúncio Banner -->
<section class="py-12 bg-gradient-to-r from-indigo-900 to-purple-900 relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-8 md:mb-0 md:mr-8">
                <span class="inline-block px-4 py-2 bg-purple-600/30 border border-purple-400/30 rounded-full text-purple-400 text-sm font-semibold mb-4">
                    Oferta Especial
                </span>
                <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">Aplicativo Web + Mobile</h3>
                <p class="text-xl text-gray-300 mb-6 max-w-2xl">
                    Contrate o desenvolvimento do seu sistema web e ganhe o aplicativo mobile com 50% de desconto!
                </p>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <i class="fi fi-rr-check-circle text-green-400 mr-2"></i>
                        <span class="text-gray-300">Design Responsivo</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fi fi-rr-check-circle text-green-400 mr-2"></i>
                        <span class="text-gray-300">Sincronização em Tempo Real</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fi fi-rr-check-circle text-green-400 mr-2"></i>
                        <span class="text-gray-300">Notificações Push</span>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('contact') }}?promo=webmobile50" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/25">
                    Solicitar Proposta
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Código em Ação Section -->
<section class="py-20 bg-gray-900 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-600/20 border border-purple-400/30 rounded-full text-purple-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-purple-400 rounded-full mr-2 animate-pulse"></span>
                Tecnologia
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Tecnologia de <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">Ponta</span> para Sistemas Web
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Desenvolvemos com as melhores tecnologias e práticas do mercado para entregar sistemas robustos, escaláveis e modernos
            </p>
        </div>

        <!-- Tech Stack Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Laravel -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-red-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/laravel-svgrepo-com.svg') }}" alt="Laravel" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">Laravel</h3>
                <p class="text-gray-400 text-sm mt-2">Framework PHP robusto para sistemas web escaláveis</p>
            </div>

            <!-- Vue.js -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-green-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/vue-svgrepo-com.svg') }}" alt="Vue.js" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">Vue.js</h3>
                <p class="text-gray-400 text-sm mt-2">Framework JavaScript para interfaces dinâmicas</p>
            </div>

            <!-- React -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-blue-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/react-svgrepo-com.svg') }}" alt="React" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">React</h3>
                <p class="text-gray-400 text-sm mt-2">Biblioteca UI para sistemas web interativos</p>
            </div>

            <!-- Tailwind -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-cyan-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/tailwind-svgrepo-com.svg') }}" alt="Tailwind CSS" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">Tailwind</h3>
                <p class="text-gray-400 text-sm mt-2">Framework CSS para interfaces modernas</p>
            </div>

            <!-- MySQL -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-orange-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/mysql-logo-svgrepo-com.svg') }}" alt="MySQL" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">MySQL</h3>
                <p class="text-gray-400 text-sm mt-2">Banco de dados para sistemas web</p>
            </div>

            <!-- Docker -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-blue-400/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/docker-svgrepo-com.svg') }}" alt="Docker" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">Docker</h3>
                <p class="text-gray-400 text-sm mt-2">Containerização para deploy rápido</p>
            </div>

            <!-- Git -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-gray-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/icons/git-svgrepo-com.svg') }}" alt="Git" class="w-10 h-10" aria-hidden="true">
                </div>
                <h3 class="text-white font-semibold">Git</h3>
                <p class="text-gray-400 text-sm mt-2">Controle de versão seguro</p>
            </div>

            <!-- AWS -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-yellow-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10" viewBox="0 0 256 256" aria-hidden="true">
                        <path fill="#fff" d="M84.745 111.961c0 2.434.263 4.407.723 5.855a35.255 35.255 0 0 0 2.106 4.737c.329.526.46 1.052.46 1.513c0 .658-.395 1.316-1.25 1.973l-4.145 2.764c-.592.394-1.184.592-1.71.592c-.658 0-1.316-.329-1.974-.921a20.382 20.382 0 0 1-2.368-3.092a51.088 51.088 0 0 1-2.04-3.882c-5.131 6.053-11.579 9.079-19.342 9.079c-5.526 0-9.934-1.579-13.158-4.737c-3.223-3.158-4.868-7.368-4.868-12.631c0-5.593 1.974-10.132 5.987-13.553c4.013-3.421 9.342-5.132 16.118-5.132c2.237 0 4.54.198 6.974.527s4.934.855 7.566 1.447v-4.803c0-5-1.053-8.487-3.092-10.526c-2.106-2.04-5.658-3.026-10.724-3.026c-2.303 0-4.671.263-7.105.855c-2.435.592-4.803 1.316-7.106 2.237a18.87 18.87 0 0 1-2.302.855c-.46.132-.79.198-1.053.198c-.92 0-1.382-.658-1.382-2.04v-3.224c0-1.052.132-1.842.461-2.302c.329-.46.921-.921 1.842-1.382c2.303-1.184 5.066-2.17 8.29-2.96c3.223-.856 6.644-1.25 10.263-1.25c7.829 0 13.552 1.776 17.237 5.328c3.618 3.553 5.46 8.948 5.46 16.185v21.316h.132Zm-26.71 10c2.17 0 4.407-.395 6.776-1.185c2.368-.789 4.473-2.237 6.25-4.21c1.052-1.25 1.842-2.632 2.236-4.211c.395-1.579.658-3.487.658-5.723v-2.764a55.03 55.03 0 0 0-6.052-1.118a49.603 49.603 0 0 0-6.185-.395c-4.408 0-7.631.856-9.802 2.632c-2.171 1.776-3.224 4.276-3.224 7.566c0 3.092.79 5.394 2.434 6.973c1.58 1.645 3.882 2.435 6.908 2.435Zm52.828 7.105c-1.184 0-1.974-.198-2.5-.658c-.526-.395-.987-1.316-1.381-2.566l-15.46-50.855c-.396-1.316-.593-2.171-.593-2.632c0-1.052.526-1.645 1.579-1.645h6.447c1.25 0 2.106.198 2.566.658c.526.395.921 1.316 1.316 2.566l11.052 43.553l10.264-43.553c.329-1.316.723-2.17 1.25-2.566c.526-.394 1.447-.657 2.631-.657h5.263c1.25 0 2.106.197 2.632.657c.526.395.987 1.316 1.25 2.566l10.395 44.079l11.381-44.079c.395-1.316.856-2.17 1.316-2.566c.526-.394 1.382-.657 2.566-.657h6.118c1.053 0 1.645.526 1.645 1.644c0 .33-.066.658-.132 1.053c-.065.395-.197.92-.46 1.645l-15.855 50.855c-.395 1.316-.856 2.171-1.382 2.566c-.526.394-1.382.658-2.5.658h-5.658c-1.25 0-2.105-.198-2.631-.658c-.527-.461-.987-1.316-1.25-2.632l-10.198-42.434l-10.131 42.368c-.329 1.316-.724 2.171-1.25 2.632c-.527.46-1.448.658-2.632.658h-5.658Zm84.54 1.776c-3.421 0-6.842-.395-10.132-1.184c-3.289-.79-5.855-1.645-7.566-2.632c-1.052-.592-1.776-1.25-2.039-1.842a4.646 4.646 0 0 1-.395-1.842v-3.355c0-1.382.526-2.04 1.513-2.04c.395 0 .79.066 1.184.198c.395.131.987.394 1.645.658a35.818 35.818 0 0 0 7.237 2.302a39.46 39.46 0 0 0 7.829.79c4.145 0 7.368-.724 9.605-2.171c2.237-1.448 3.421-3.553 3.421-6.25c0-1.842-.592-3.356-1.776-4.606c-1.184-1.25-3.421-2.368-6.645-3.421l-9.539-2.96c-4.803-1.513-8.356-3.75-10.527-6.71c-2.171-2.895-3.289-6.12-3.289-9.54c0-2.763.592-5.197 1.776-7.303c1.184-2.105 2.763-3.947 4.737-5.394c1.974-1.514 4.211-2.632 6.842-3.422c2.632-.79 5.395-1.118 8.29-1.118c1.447 0 2.96.066 4.408.263c1.513.197 2.894.46 4.276.724c1.316.329 2.566.658 3.75 1.053c1.184.394 2.105.789 2.763 1.184c.921.526 1.579 1.052 1.974 1.644c.394.527.592 1.25.592 2.172v3.092c0 1.381-.526 2.105-1.513 2.105c-.527 0-1.382-.263-2.5-.79c-3.75-1.71-7.961-2.565-12.632-2.565c-3.75 0-6.71.592-8.75 1.842c-2.039 1.25-3.092 3.158-3.092 5.855c0 1.842.658 3.421 1.974 4.671c1.315 1.25 3.75 2.5 7.237 3.618l9.342 2.96c4.736 1.514 8.158 3.619 10.197 6.317c2.039 2.697 3.026 5.789 3.026 9.21c0 2.829-.592 5.395-1.71 7.632c-1.184 2.237-2.763 4.21-4.803 5.789c-2.039 1.645-4.474 2.829-7.302 3.685c-2.961.921-6.053 1.381-9.408 1.381Z"/>
                        <path fill="#F90" fill-rule="evenodd" d="M207.837 162.816c-21.645 15.987-53.092 24.474-80.132 24.474c-37.894 0-72.04-14.014-97.829-37.303c-2.04-1.842-.197-4.342 2.237-2.895c27.895 16.184 62.303 25.987 97.895 25.987c24.013 0 50.395-5 74.671-15.263c3.618-1.645 6.71 2.368 3.158 5Z" clip-rule="evenodd"/>
                        <path fill="#F90" fill-rule="evenodd" d="M216.85 152.553c-2.763-3.553-18.289-1.711-25.329-.856c-2.105.264-2.434-1.579-.526-2.96c12.368-8.684 32.697-6.184 35.066-3.29c2.368 2.961-.658 23.29-12.237 33.027c-1.777 1.513-3.487.723-2.698-1.25c2.632-6.513 8.487-21.185 5.724-24.671Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-white font-semibold">AWS</h3>
                <p class="text-gray-400 text-sm mt-2">Infraestrutura cloud escalável</p>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('contact') }}?subject=tech" class="inline-flex items-center bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                Consultar sobre Tecnologias
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="py-20 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-green-600/20 border border-green-400/30 rounded-full text-green-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Portfolio
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Nossos <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-400">Projetos</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Conheça alguns dos projetos que desenvolvemos com excelência e inovação
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProjects as $project)
            <!-- Projeto Dinâmico -->
            <div class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-green-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    @if($project->featured_image)
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $project->featured_image }}');">
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ $project->title }}</span>
                    </div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">
                            {{ $project->category->name ?? 'Projeto' }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-3">{{ $project->title }}</h3>
                    <p class="text-gray-300 mb-4">{{ Str::limit($project->description, 100) }}</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if(is_array($project->technologies) && count($project->technologies) > 0)
                            @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm">{{ $tech }}</span>
                            @endforeach
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">
                            @if($project->completion_date)
                                {{ $project->completion_date->format('M Y') }}
                            @endif
                        </span>
                        <a href="{{ route('projects.show', $project->slug) }}" class="text-green-400 hover:text-green-300 transition-colors">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback quando não há projetos -->
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-400 text-lg">Nenhum projeto em destaque no momento.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                Ver Todos os Projetos
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-yellow-600/20 border border-yellow-400/30 rounded-full text-yellow-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                Depoimentos
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                O que nossos <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-400">Clientes</span> dizem
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Veja o que nossos clientes falam sobre nossos serviços e resultados alcançados
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Depoimento 1 -->
            <div class="bg-gray-800/50 backdrop-blur-md p-8 rounded-2xl border border-gray-700 hover:border-yellow-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="flex mb-4">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    "Excelente trabalho! A NiceDesigns desenvolveu nosso e-commerce com muita qualidade e no prazo combinado. O suporte pós-lançamento também é excepcional."
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">M</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Maria Silva</h4>
                        <p class="text-gray-400 text-sm">CEO, TechCorp</p>
                    </div>
                </div>
            </div>

            <!-- Depoimento 2 -->
            <div class="bg-gray-800/50 backdrop-blur-md p-8 rounded-2xl border border-gray-700 hover:border-blue-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="flex mb-4">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    "Profissionais muito competentes! Criaram nossa landing page e sistema de gestão. O design ficou moderno e a funcionalidade é perfeita."
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">J</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">João Santos</h4>
                        <p class="text-gray-400 text-sm">Fundador, StartUp Inc</p>
                    </div>
                </div>
            </div>

            <!-- Depoimento 3 -->
            <div class="bg-gray-800/50 backdrop-blur-md p-8 rounded-2xl border border-gray-700 hover:border-green-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="flex mb-4">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    "Superou nossas expectativas! O site da nossa boutique ficou elegante e as vendas online aumentaram 300%. Recomendo muito!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">A</span>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Ana Costa</h4>
                        <p class="text-gray-400 text-sm">Proprietária, ModaStyle</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
            Vamos começar seu projeto
        </div>
        
        <h2 class="text-4xl md:text-6xl font-bold mb-8 leading-tight">
            Pronto para Transformar sua
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                Presença Digital?
            </span>
        </h2>
        
        <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
            Entre em contato conosco e descubra como podemos ajudar sua empresa a se destacar no mundo digital 
            com soluções personalizadas e resultados comprovados.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('contact') }}" 
               class="group bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-12 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                <span class="inline-flex items-center">
                    Solicitar Orçamento
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </span>
            </a>
            <a href="{{ route('projects.index') }}" 
               class="group border-2 border-white/30 text-white hover:bg-white hover:text-gray-900 px-12 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                <span class="inline-flex items-center">
                    Ver Portfolio
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="py-20 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-purple-600/20 border border-purple-400/30 rounded-full text-purple-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-purple-400 rounded-full mr-2 animate-pulse"></span>
                Blog
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Últimas <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Novidades</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Fique por dentro das tendências e novidades do mundo digital
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($latestPosts as $post)
            <!-- Post Dinâmico -->
            <article class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-purple-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    @if($post->featured_image)
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $post->featured_image }}');">
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">
                            {{ $post->category->name ?? 'Blog' }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-400 text-sm mb-3">
                        <span>{{ $post->published_at ? $post->published_at->format('d \d\e M, Y') : 'Publicado' }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ ceil(str_word_count($post->content) / 200) }} min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        {{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">{{ $post->author ? substr($post->author->name, 0, 2) : 'ND' }}</span>
                            </div>
                            <span class="text-gray-400 text-sm">{{ $post->author->name ?? 'NiceDesigns Team' }}</span>
                        </div>
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-purple-400 hover:text-purple-300 transition-colors">
                            Ler mais →
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <!-- Fallback quando não há posts -->
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-400 text-lg">Nenhum post publicado no momento.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('posts.index') }}" class="inline-flex items-center bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                Ver Todos os Posts
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Adicionar animações CSS customizadas -->
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