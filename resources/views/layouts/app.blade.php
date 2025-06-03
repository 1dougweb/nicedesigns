<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nice Designs') }} @yield('title')</title>

    <!-- Meta Tags SEO -->
    <meta name="description" content="@yield('meta_description', 'Agência de Web Design Moderna')">
    <meta name="keywords" content="@yield('meta_keywords', 'web design, desenvolvimento, agência')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Agência de Web Design Moderna')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900 text-white">
    <div class="min-h-screen bg-gray-900">
        <!-- Navigation -->
        <nav class="bg-gray-900/95 backdrop-blur-md border-b border-gray-800 shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Nice Designs</h1>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" 
                           class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium transition duration-300
                                  {{ request()->routeIs('home') ? 'text-blue-400' : '' }}">
                            Início
                        </a>
                        <a href="{{ route('posts.index') }}" 
                           class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium transition duration-300
                                  {{ request()->routeIs('posts.*') ? 'text-blue-400' : '' }}">
                            Blog
                        </a>
                        <a href="{{ route('projects.index') }}" 
                           class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium transition duration-300
                                  {{ request()->routeIs('projects.*') ? 'text-blue-400' : '' }}">
                            Portfolio
                        </a>
                        <a href="{{ route('about') }}" 
                           class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium transition duration-300
                                  {{ request()->routeIs('about') ? 'text-blue-400' : '' }}">
                            Sobre
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium transition duration-300
                                  {{ request()->routeIs('contact') ? 'text-blue-400' : '' }}">
                            Contato
                        </a>

                        @auth
                            <a href="{{ route('admin.dashboard') }}" 
                               class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-300 shadow-lg">
                                Admin
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium">
                                    Sair
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium">
                                Login
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" class="text-gray-300 hover:text-blue-400 focus:outline-none focus:text-blue-400" id="mobile-menu-button">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-800/95 backdrop-blur-md border-t border-gray-700">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Início</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Blog</a>
                    <a href="{{ route('projects.index') }}" class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Portfolio</a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Sobre</a>
                    <a href="{{ route('contact') }}" class="text-gray-300 hover:text-blue-400 block px-3 py-2 text-base font-medium">Contato</a>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="bg-gray-900">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-b from-gray-900 to-black border-t border-gray-800">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 mb-4">Nice Designs</h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            Agência especializada em web design moderno e desenvolvimento de sites responsivos. 
                            Transformamos ideias em experiências digitais incríveis.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-6 text-white">Links Rápidos</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60"></span>Início
                            </a></li>
                            <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60"></span>Blog
                            </a></li>
                            <li><a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60"></span>Portfolio
                            </a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60"></span>Sobre
                            </a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60"></span>Contato
                            </a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-6 text-white">Contato</h4>
                        <ul class="space-y-3 text-gray-400">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                contato@nicedesigns.com.br
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                (11) 99999-9999
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                São Paulo, SP
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} Nice Designs. Todos os direitos reservados.</p>
                    <p class="text-gray-500 text-sm mt-2">Transformando ideias em experiências digitais incríveis ✨</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html> 