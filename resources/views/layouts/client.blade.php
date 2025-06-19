<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Área do Cliente') - {{ site_setting('name') ?? config('app.name', 'Nice Designs') }}</title>

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

    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-900 text-white">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800/50 backdrop-blur-xl border-r border-gray-700/50 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" id="sidebar">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-green-600/20 to-blue-600/20 border-b border-gray-700/50">
                <a href="{{ route('client.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Cliente</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-8 px-4 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('client.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.dashboard') ? 'bg-green-600/20 text-green-400 border border-green-500/30' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v3H8V5z"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Meus Projetos -->
                <a href="{{ route('client.projects.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.projects.*') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Meus Projetos
                </a>

                <!-- Faturas -->
                <a href="{{ route('client.invoices.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.invoices.*') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/30' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Faturas
                </a>

                <!-- Suporte -->
                <a href="{{ route('client.support.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.support.*') ? 'bg-yellow-600/20 text-yellow-400 border border-yellow-500/30' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Suporte
                </a>

                <!-- Perfil -->
                <a href="{{ route('client.profile.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.profile.*') ? 'bg-pink-600/20 text-pink-400 border border-pink-500/30' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Meu Perfil
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-700/50 my-6"></div>

                <!-- Site Link -->
                <a href="{{ route('home') }}" 
                   target="_blank"
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Ver Site
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-red-600/20 hover:text-red-400 transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sair
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-gray-800/30 backdrop-blur-xl border-b border-gray-700/50 sticky top-0 z-40">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Mobile menu button -->
                        <button type="button" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700/50 transition-colors" onclick="toggleSidebar()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 lg:flex-none">
                            <h1 class="text-2xl font-bold text-white">@yield('page-title', 'Área do Cliente')</h1>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-xl transition-colors relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.5a6 6 0 0 1 6 6v2l1.5 3h-15l1.5-3v-2a6 6 0 0 1 6-6z"/>
                                </svg>
                                @if(isset($newNotifications) && $newNotifications > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $newNotifications }}</span>
                                @endif
                            </button>

                            <!-- User Info -->
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr(auth()->user()->display_name, 0, 2) }}</span>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm font-medium text-white">{{ auth()->user()->display_name }}</p>
                                    <p class="text-xs text-gray-400">Cliente</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="fixed inset-0 z-40 lg:hidden hidden" id="sidebar-overlay" onclick="toggleSidebar()">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    </div>

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const menuButton = event.target.closest('button[onclick="toggleSidebar()"]');
            
            if (!menuButton && !sidebar.contains(event.target) && !overlay.classList.contains('hidden')) {
                toggleSidebar();
            }
        });
    </script>

    @stack('scripts')
</body>
</html> 