@extends('layouts.app')

@section('title', '- Agência de Web Design Moderna')
@section('meta_description', 'Nice Designs - Agência especializada em web design moderno e desenvolvimento de sites responsivos. Transformamos ideias em experiências digitais incríveis.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg>')"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                Agência de Web Design Premium
            </div>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight">
                Transformamos 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 animate-pulse">
                    Ideias
                </span> 
                em<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">
                    Experiências Digitais
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                Somos uma agência especializada em web design moderno e desenvolvimento de sites responsivos 
                que conectam marcas aos seus clientes de forma impactante.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center mb-16">
                <a href="{{ route('projects.index') }}" 
                   class="group bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-10 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                    <span class="inline-flex items-center">
                        Ver Portfolio
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </a>
                <a href="{{ route('contact') }}" 
                   class="group border-2 border-blue-400 text-blue-400 hover:bg-blue-400 hover:text-black px-10 py-5 rounded-xl text-lg font-semibold transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                    <span class="inline-flex items-center">
                        Fale Conosco
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </span>
                </a>
            </div>
            
            <!-- Floating Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-blue-400 mb-2">50+</div>
                    <div class="text-gray-300">Projetos Entregues</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-cyan-400 mb-2">98%</div>
                    <div class="text-gray-300">Clientes Satisfeitos</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                    <div class="text-3xl font-bold text-blue-400 mb-2">5+</div>
                    <div class="text-gray-300">Anos de Experiência</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- Serviços Section -->
<section class="py-24 bg-gradient-to-b from-gray-800 to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <span class="inline-block px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-4 backdrop-blur-sm">
                Nossos Serviços
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Soluções Completas para sua
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Presença Digital</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Oferecemos um conjunto completo de serviços para transformar sua visão em realidade digital
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Web Design -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-blue-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-blue-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Web Design</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Criamos designs modernos, responsivos e otimizados para conversão que encantam seus usuários e fortalecem sua marca.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Design Responsivo
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        UI/UX Otimizado
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Prototipagem Avançada
                    </li>
                </ul>
            </div>

            <!-- Desenvolvimento -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-purple-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-purple-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Desenvolvimento</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Desenvolvemos sites e aplicações web robustas utilizando as tecnologias mais modernas e práticas do mercado.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Laravel & PHP
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        React & Vue.js
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-purple-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        APIs & Integrações
                    </li>
                </ul>
            </div>

            <!-- SEO & Performance -->
            <div class="group bg-gray-800/50 backdrop-blur-md p-10 rounded-3xl border border-gray-700 hover:border-green-500/50 hover:bg-gray-700/50 transition-all duration-500 transform hover:-translate-y-4 shadow-2xl hover:shadow-green-500/25">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">SEO & Performance</h3>
                <p class="text-gray-300 mb-6 leading-relaxed">
                    Otimizamos seu site para mecanismos de busca e garantimos máxima performance, velocidade e conversão.
                </p>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        SEO Técnico
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Core Web Vitals
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Analytics Avançado
                    </li>
                </ul>
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
                Desenvolvimento
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Código em <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Ação</span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Desenvolvemos com as melhores tecnologias e práticas do mercado
            </p>
        </div>

        <!-- VSCode Windows -->
        <div class="grid lg:grid-cols-2 gap-8 mb-16">
            <!-- Laravel PHP Window -->
            <div class="group bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700 overflow-hidden hover:scale-105 hover:border-purple-500/50 transition-all duration-300 shadow-2xl h-full min-h-[400px]">
                <!-- macOS Title Bar -->
                <div class="flex items-center px-4 py-3 bg-gray-700/80 border-b border-gray-600">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full group-hover:bg-red-400 transition-colors"></div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full group-hover:bg-yellow-400 transition-colors"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full group-hover:bg-green-400 transition-colors"></div>
                    </div>
                    <div class="flex-1 flex justify-center">
                        <div class="bg-gray-600/50 px-3 py-1 rounded text-sm text-gray-300 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-orange-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,2.2467A10.00042,10.00042,0,0,0,8.83752,21.73419c.5.08752.6875-.21247.6875-.475,0-.23752-.01251-1.025-.01251-1.86249C7,19.85919,6.35,18.78423,6.15,18.22173A3.636,3.636,0,0,0,5.125,16.8092c-.35-.1875-.85-.65-.01251-.66248A2.00117,2.00117,0,0,1,6.65,17.17169a2.13742,2.13742,0,0,0,2.91248.825A2.10376,2.10376,0,0,1,10.2,16.65923c-2.225-.25-4.55-1.11254-4.55-4.9375a3.89187,3.89187,0,0,1,1.025-2.6875,3.59373,3.59373,0,0,1,.1-2.65s.83747-.26251,2.75,1.025a9.42747,9.42747,0,0,1,5,0c1.91248-1.3,2.75-1.025,2.75-1.025a3.59323,3.59323,0,0,1,.1,2.65,3.869,3.869,0,0,1,1.025,2.6875c0,3.83747-2.33752,4.6875-4.5625,4.9375a2.36814,2.36814,0,0,1,.675,1.85c0,1.33752-.01251,2.41248-.01251,2.75,0,.26251.1875.575.6875.475A10.0053,10.0053,0,0,0,12,2.2467Z"/>
                            </svg>
                            UserController.php
                        </div>
                    </div>
                </div>
                
                <!-- Code Content -->
                <div class="p-6 font-mono text-sm h-full flex flex-col">
                    <div class="text-gray-300 leading-relaxed flex-1">
                        <div class="text-purple-400">&lt;?php</div>
                        <br>
                        <div><span class="text-blue-400">namespace</span> App\Http\Controllers;</div>
                        <br>
                        <div><span class="text-blue-400">use</span> App\Models\User;</div>
                        <div><span class="text-blue-400">use</span> Illuminate\Http\Request;</div>
                        <br>
                        <div><span class="text-blue-400">class</span> <span class="text-yellow-400">UserController</span> <span class="text-purple-400">extends</span> <span class="text-yellow-400">Controller</span></div>
                        <div>{</div>
                        <div class="ml-4">
                            <div><span class="text-blue-400">public function</span> <span class="text-green-400">index</span>()</div>
                            <div>{</div>
                            <div class="ml-4">
                                <div><span class="text-blue-400">return</span> User::<span class="text-green-400">paginate</span>(<span class="text-orange-400">15</span>);</div>
                            </div>
                            <div>}</div>
                        </div>
                        <div>}</div>
                    </div>
                    
                    <!-- Status Bar -->
                    <div class="mt-4 pt-4 border-t border-gray-600 flex justify-between text-xs text-gray-400">
                        <span>Laravel 11, PHP 8.2</span>
                        <span class="text-green-400">● Ready</span>
                    </div>
                </div>
            </div>

            <!-- Vue.js Window -->
            <div class="group bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700 overflow-hidden hover:scale-105 hover:border-green-500/50 transition-all duration-300 shadow-2xl h-full min-h-[400px]">
                <!-- macOS Title Bar -->
                <div class="flex items-center px-4 py-3 bg-gray-700/80 border-b border-gray-600">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full group-hover:bg-red-400 transition-colors"></div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full group-hover:bg-yellow-400 transition-colors"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full group-hover:bg-green-400 transition-colors"></div>
                    </div>
                    <div class="flex-1 flex justify-center">
                        <div class="bg-gray-600/50 px-3 py-1 rounded text-sm text-gray-300 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12,2.2467A10.00042,10.00042,0,0,0,8.83752,21.73419c.5.08752.6875-.21247.6875-.475,0-.23752-.01251-1.025-.01251-1.86249C7,19.85919,6.35,18.78423,6.15,18.22173A3.636,3.636,0,0,0,5.125,16.8092c-.35-.1875-.85-.65-.01251-.66248A2.00117,2.00117,0,0,1,6.65,17.17169a2.13742,2.13742,0,0,0,2.91248.825A2.10376,2.10376,0,0,1,10.2,16.65923c-2.225-.25-4.55-1.11254-4.55-4.9375a3.89187,3.89187,0,0,1,1.025-2.6875,3.59373,3.59373,0,0,1,.1-2.65s.83747-.26251,2.75,1.025a9.42747,9.42747,0,0,1,5,0c1.91248-1.3,2.75-1.025,2.75-1.025a3.59323,3.59323,0,0,1,.1,2.65,3.869,3.869,0,0,1,1.025,2.6875c0,3.83747-2.33752,4.6875-4.5625,4.9375a2.36814,2.36814,0,0,1,.675,1.85c0,1.33752-.01251,2.41248-.01251,2.75,0,.26251.1875.575.6875.475A10.0053,10.0053,0,0,0,12,2.2467Z"/>
                            </svg>
                            Dashboard.vue
                        </div>
                    </div>
                </div>
                
                <!-- Code Content -->
                <div class="p-6 font-mono text-sm h-full flex flex-col">
                    <div class="text-gray-300 leading-relaxed flex-1">
                        <div><span class="text-purple-400">&lt;template&gt;</span></div>
                        <div class="ml-2">
                            <div><span class="text-purple-400">&lt;div</span> <span class="text-yellow-400">class</span>=<span class="text-green-400">"dashboard"</span><span class="text-purple-400">&gt;</span></div>
                            <div class="ml-2">
                                <div><span class="text-purple-400">&lt;h1&gt;</span>@{{ title }}<span class="text-purple-400">&lt;/h1&gt;</span></div>
                                <div><span class="text-purple-400">&lt;UserStats</span> <span class="text-yellow-400">:data</span>=<span class="text-green-400">"stats"</span> <span class="text-purple-400">/&gt;</span></div>
                            </div>
                            <div><span class="text-purple-400">&lt;/div&gt;</span></div>
                        </div>
                        <div><span class="text-purple-400">&lt;/template&gt;</span></div>
                        <br>
                        <div><span class="text-purple-400">&lt;script&gt;</span></div>
                        <div><span class="text-blue-400">export default</span> {</div>
                        <div class="ml-2">
                            <div><span class="text-yellow-400">name</span>: <span class="text-green-400">'Dashboard'</span>,</div>
                            <div><span class="text-yellow-400">data</span>() {</div>
                            <div class="ml-2">
                                <div><span class="text-blue-400">return</span> {</div>
                                <div class="ml-2">
                                    <div><span class="text-yellow-400">title</span>: <span class="text-green-400">'Dashboard'</span></div>
                                </div>
                                <div>}</div>
                            </div>
                            <div>}</div>
                        </div>
                        <div>}</div>
                        <div><span class="text-purple-400">&lt;/script&gt;</span></div>
                    </div>
                    
                    <!-- Status Bar -->
                    <div class="mt-4 pt-4 border-t border-gray-600 flex justify-between text-xs text-gray-400">
                        <span>Vue.js 3, TypeScript</span>
                        <span class="text-green-400">● Ready</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tech Stack Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Laravel -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-red-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">L</span>
                </div>
                <h3 class="text-white font-semibold">Laravel</h3>
                <p class="text-gray-400 text-sm mt-2">PHP Framework</p>
            </div>

            <!-- Vue.js -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-green-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">V</span>
                </div>
                <h3 class="text-white font-semibold">Vue.js</h3>
                <p class="text-gray-400 text-sm mt-2">Frontend Framework</p>
            </div>

            <!-- React -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-blue-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">R</span>
                </div>
                <h3 class="text-white font-semibold">React</h3>
                <p class="text-gray-400 text-sm mt-2">UI Library</p>
            </div>

            <!-- Tailwind -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-cyan-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">T</span>
                </div>
                <h3 class="text-white font-semibold">Tailwind</h3>
                <p class="text-gray-400 text-sm mt-2">CSS Framework</p>
            </div>

            <!-- MySQL -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-orange-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">M</span>
                </div>
                <h3 class="text-white font-semibold">MySQL</h3>
                <p class="text-gray-400 text-sm mt-2">Database</p>
            </div>

            <!-- Docker -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-blue-400/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">D</span>
                </div>
                <h3 class="text-white font-semibold">Docker</h3>
                <p class="text-gray-400 text-sm mt-2">Container</p>
            </div>

            <!-- Git -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-gray-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-gray-600 to-gray-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
                <h3 class="text-white font-semibold">Git</h3>
                <p class="text-gray-400 text-sm mt-2">Version Control</p>
            </div>

            <!-- AWS -->
            <div class="group bg-gray-800/30 backdrop-blur-sm border border-gray-700 rounded-xl p-6 text-center hover:border-yellow-500/50 hover:bg-gray-700/30 transition-all duration-300 hover:scale-105">
                <div class="w-12 h-12 mx-auto mb-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="text-white font-bold text-xl">A</span>
                </div>
                <h3 class="text-white font-semibold">AWS</h3>
                <p class="text-gray-400 text-sm mt-2">Cloud Platform</p>
            </div>
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
            <!-- Projeto 1 -->
            <div class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-green-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">E-commerce</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Concluído</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-3">Loja Virtual Premium</h3>
                    <p class="text-gray-300 mb-4">Sistema completo de e-commerce com gestão de produtos, pagamentos e relatórios avançados.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm">Laravel</span>
                        <span class="bg-green-600/20 text-green-400 px-3 py-1 rounded-full text-sm">Vue.js</span>
                        <span class="bg-purple-600/20 text-purple-400 px-3 py-1 rounded-full text-sm">MySQL</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">6 meses</span>
                        <a href="#" class="text-green-400 hover:text-green-300 transition-colors">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Projeto 2 -->
            <div class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-blue-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">Dashboard</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Em desenvolvimento</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-3">Sistema de Gestão</h3>
                    <p class="text-gray-300 mb-4">Plataforma administrativa com analytics em tempo real e controle completo de dados.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-red-600/20 text-red-400 px-3 py-1 rounded-full text-sm">Laravel</span>
                        <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm">React</span>
                        <span class="bg-yellow-600/20 text-yellow-400 px-3 py-1 rounded-full text-sm">PostgreSQL</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">4 meses</span>
                        <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Projeto 3 -->
            <div class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-purple-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">Mobile App</span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Planejamento</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-3">App de Delivery</h3>
                    <p class="text-gray-300 mb-4">Aplicativo mobile para delivery com rastreamento em tempo real e pagamentos integrados.</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-sm">Flutter</span>
                        <span class="bg-red-600/20 text-red-400 px-3 py-1 rounded-full text-sm">Laravel API</span>
                        <span class="bg-green-600/20 text-green-400 px-3 py-1 rounded-full text-sm">Firebase</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">8 meses</span>
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            </div>
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
            <!-- Post 1 -->
            <article class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-purple-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Desenvolvimento</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-400 text-sm mb-3">
                        <span>15 de Dezembro, 2024</span>
                        <span class="mx-2">•</span>
                        <span>5 min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">
                        As Tendências de Web Development para 2025
                    </h3>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        Descubra as principais tecnologias e frameworks que dominarão o mercado de desenvolvimento web no próximo ano.
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">ND</span>
                            </div>
                            <span class="text-gray-400 text-sm">NiceDesigns Team</span>
                        </div>
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">
                            Ler mais →
                        </a>
                    </div>
                </div>
            </article>

            <!-- Post 2 -->
            <article class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-blue-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4 4 4 0 004-4V5z"/>
                        </svg>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">Design</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-400 text-sm mb-3">
                        <span>10 de Dezembro, 2024</span>
                        <span class="mx-2">•</span>
                        <span>8 min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">
                        UI/UX: Como Criar Interfaces que Convertem
                    </h3>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        Aprenda os princípios fundamentais de design que transformam visitantes em clientes através de interfaces intuitivas.
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">ND</span>
                            </div>
                            <span class="text-gray-400 text-sm">NiceDesigns Team</span>
                        </div>
                        <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors">
                            Ler mais →
                        </a>
                    </div>
                </div>
            </article>

            <!-- Post 3 -->
            <article class="group bg-gray-700/50 backdrop-blur-md rounded-2xl overflow-hidden border border-gray-600 hover:border-green-500/50 transition-all duration-300 hover:scale-105 shadow-2xl">
                <div class="relative overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-float">SEO</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center text-gray-400 text-sm mb-3">
                        <span>5 de Dezembro, 2024</span>
                        <span class="mx-2">•</span>
                        <span>6 min de leitura</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors">
                        SEO em 2025: Estratégias que Realmente Funcionam
                    </h3>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        Conheça as técnicas de SEO mais eficazes para posicionar seu site no topo dos resultados do Google.
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">ND</span>
                            </div>
                            <span class="text-gray-400 text-sm">NiceDesigns Team</span>
                        </div>
                        <a href="#" class="text-green-400 hover:text-green-300 transition-colors">
                            Ler mais →
                        </a>
                    </div>
                </div>
            </article>
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