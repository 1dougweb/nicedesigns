<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ site_setting('name') ?? config('app.name', 'Nice Designs') }} @yield('title')</title>

    <!-- Favicon -->
    @if(site_setting('favicon'))
        <link rel="icon" type="image/x-icon" href="{{ site_setting('favicon') }}">
    @endif

    <!-- Meta Tags SEO -->
    <meta name="description" content="@yield('meta_description', site_setting('description') ?? 'Agência de Web Design Moderna')">
    <meta name="keywords" content="@yield('meta_keywords', site_setting('keywords') ?? 'web design, desenvolvimento, agência')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', site_setting('name') ?? config('app.name'))">
    <meta property="og:description" content="@yield('og_description', site_setting('description') ?? 'Agência de Web Design Moderna')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ site_setting('name') ?? config('app.name') }}">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', site_setting('name') ?? config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', site_setting('description') ?? 'Agência de Web Design Moderna')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-image.jpg'))">
    @if(site_setting('twitter_handle'))
        <meta name="twitter:site" content="{{ site_setting('twitter_handle') }}">
    @endif

    <!-- Additional SEO -->
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="{{ url()->current() }}">
    @yield('structured_data')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Script para suprimir warnings -->
    <script src="{{ asset('js/suppress-warnings.js') }}"></script>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'ui-sans-serif', 'system-ui'],
                    },
                }
            }
        }
    </script>

    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
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
                            @if(site_setting('use_logo') && site_setting('logo'))
                                <img src="{{ site_setting('logo') }}" alt="{{ site_setting('name') ?? 'Nice Designs' }}" class="h-8">
                            @else
                                <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                                    {{ site_setting('name') ?? 'Nice Designs' }}
                                </h1>
                            @endif
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
                                <button type="submit" 
                                        class="text-gray-300 hover:text-blue-400 px-3 py-2 text-sm font-medium"
                                        aria-label="Fazer logout da conta">
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
                        <button type="button" 
                                class="text-gray-300 hover:text-blue-400 focus:outline-none focus:text-blue-400" 
                                id="mobile-menu-button"
                                aria-label="Abrir menu de navegação"
                                aria-expanded="false"
                                aria-controls="mobile-menu">
                            <i class="fi fi-rr-menu-burger h-6 w-6" aria-hidden="true"></i>
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
                        <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 mb-4">
                            {{ footer_info('company_name') ?? 'Nice Designs' }}
                        </h3>
                        <p class="text-gray-400 mb-6 leading-relaxed">
                            {{ footer_info('company_description') ?? 'Agência especializada em web design moderno e desenvolvimento de sites responsivos. Transformamos ideias em experiências digitais incríveis.' }}
                        </p>
                        <div class="flex space-x-4">
                            @if(footer_info('social_twitter'))
                                <a href="{{ footer_info('social_twitter') }}" 
                                   class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800"
                                   aria-label="Siga-nos no Twitter"
                                   target="_blank">
                                    <i class="fi fi-br-twitter h-6 w-6" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if(footer_info('social_linkedin'))
                                <a href="{{ footer_info('social_linkedin') }}" 
                                   class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800"
                                   aria-label="Conecte-se conosco no LinkedIn"
                                   target="_blank">
                                    <i class="fi fi-br-linkedin h-6 w-6" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if(footer_info('social_instagram'))
                                <a href="{{ footer_info('social_instagram') }}" 
                                   class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800"
                                   aria-label="Siga-nos no Instagram"
                                   target="_blank">
                                    <i class="fi fi-br-instagram h-6 w-6" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if(footer_info('social_facebook'))
                                <a href="{{ footer_info('social_facebook') }}" 
                                   class="text-gray-400 hover:text-blue-400 transition duration-300 p-2 rounded-lg hover:bg-gray-800"
                                   aria-label="Siga-nos no Facebook"
                                   target="_blank">
                                    <i class="fi fi-br-facebook h-6 w-6" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-6 text-white">Links Rápidos</h4>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60" aria-hidden="true"></span>Início
                            </a></li>
                            <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60" aria-hidden="true"></span>Blog
                            </a></li>
                            <li><a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60" aria-hidden="true"></span>Portfolio
                            </a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60" aria-hidden="true"></span>Sobre
                            </a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-blue-400 transition duration-300 flex items-center">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-3 opacity-60" aria-hidden="true"></span>Contato
                            </a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-6 text-white">Contato</h4>
                        <ul class="space-y-3 text-gray-400">
                            @if(contact_info('email'))
                                <li class="flex items-center">
                                    <i class="fi fi-rr-envelope w-5 h-5 mr-3 text-blue-400" aria-hidden="true"></i>
                                    {{ contact_info('email') }}
                                </li>
                            @endif
                            @if(contact_info('phone'))
                                <li class="flex items-center">
                                    <i class="fi fi-rr-phone-call w-5 h-5 mr-3 text-blue-400" aria-hidden="true"></i>
                                    {{ contact_info('phone') }}
                                </li>
                            @endif
                            @if(contact_info('city') && contact_info('state'))
                                <li class="flex items-center">
                                    <i class="fi fi-rr-marker w-5 h-5 mr-3 text-blue-400" aria-hidden="true"></i>
                                    {{ contact_info('city') }}, {{ contact_info('state') }}
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                    <p class="text-gray-400">
                        &copy; {{ date('Y') }} {{ footer_info('company_name') ?? 'Nice Designs' }}. 
                        {{ footer_info('copyright_text') ?? 'Todos os direitos reservados.' }}
                    </p>
                    @if(footer_info('footer_text'))
                        <p class="text-gray-500 text-sm mt-2">{{ footer_info('footer_text') }}</p>
                    @endif
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const isOpen = !mobileMenu.classList.contains('hidden');
            
            mobileMenu.classList.toggle('hidden');
            this.setAttribute('aria-expanded', !isOpen);
        });
    </script>

    @stack('scripts')
</body>
</html> 