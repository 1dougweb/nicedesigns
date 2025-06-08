<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-900 text-white">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800/50 backdrop-blur-xl border-r border-gray-700/50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" id="sidebar">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-blue-600/20 to-purple-600/20 border-b border-gray-700/50">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fi fi-rr-dashboard w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Admin</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 sm:mt-8 px-3 sm:px-4 space-y-1 sm:space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : '' }}">
                    <i class="fi fi-rr-dashboard w-5 h-5 mr-3"></i>
                    Dashboard
                </a>

                <!-- Posts -->
                <a href="{{ route('admin.posts.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.posts.*') ? 'bg-green-600/20 text-green-400 border border-green-500/30' : '' }}">
                    <i class="fi fi-rr-edit w-5 h-5 mr-3"></i>
                    Posts
                </a>

                <!-- Projects -->
                <a href="{{ route('admin.projects.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.projects.*') ? 'bg-purple-600/20 text-purple-400 border border-purple-500/30' : '' }}">
                    <i class="fi fi-rr-briefcase w-5 h-5 mr-3"></i>
                    Projetos
                </a>

                <!-- Client Projects -->
                <a href="{{ route('admin.client-projects.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.client-projects.*') ? 'bg-cyan-600/20 text-cyan-400 border border-cyan-500/30' : '' }}">
                    <i class="fi fi-rr-users w-5 h-5 mr-3"></i>
                    Projetos Clientes
                </a>

                <!-- Invoices -->
                <a href="{{ route('admin.invoices.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.invoices.*') ? 'bg-emerald-600/20 text-emerald-400 border border-emerald-500/30' : '' }}">
                    <i class="fi fi-rr-receipt w-5 h-5 mr-3"></i>
                    Faturas
                </a>

                <!-- Support Tickets -->
                <a href="{{ route('admin.support-tickets.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.support-tickets.*') ? 'bg-orange-600/20 text-orange-400 border border-orange-500/30' : '' }}">
                    <i class="fi fi-rr-headset w-5 h-5 mr-3"></i>
                    Suporte
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'bg-yellow-600/20 text-yellow-400 border border-yellow-500/30' : '' }}">
                    <i class="fi fi-rr-tags w-5 h-5 mr-3"></i>
                    Categorias
                </a>

                <!-- Contacts -->
                <a href="{{ route('admin.contacts.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.contacts.*') ? 'bg-pink-600/20 text-pink-400 border border-pink-500/30' : '' }}">
                    <i class="fi fi-rr-envelope w-5 h-5 mr-3"></i>
                    Contatos
                    @if(isset($newContactsCount) && $newContactsCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $newContactsCount }}</span>
                    @endif
                </a>

                <!-- Settings -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : '' }}">
                    <i class="fi fi-rr-settings w-5 h-5 mr-3"></i>
                    Configurações
                </a>

                <!-- SEO -->
                <a href="{{ route('admin.seo.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('admin.seo.*') ? 'bg-green-600/20 text-green-400 border border-green-500/30' : '' }}">
                    <i class="fi fi-rr-search w-5 h-5 mr-3"></i>
                    SEO Manager
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-700/50 my-6"></div>

                <!-- Site Link -->
                <a href="{{ route('home') }}" 
                   target="_blank"
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group">
                    <i class="fi fi-rr-globe w-5 h-5 mr-3"></i>
                    Ver Site
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-red-600/20 hover:text-red-400 transition-all duration-200 group">
                        <i class="fi fi-rr-sign-out-alt w-5 h-5 mr-3"></i>
                        Sair
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-gray-800/30 backdrop-blur-xl border-b border-gray-700/50 sticky top-0 z-40">
                <div class="px-4 sm:px-6 py-3 sm:py-4">
                    <div class="flex items-center justify-between">
                        <!-- Mobile menu button -->
                        <button type="button" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700/50 transition-colors" onclick="toggleSidebar()">
                            <i class="fi fi-rr-menu-burger w-5 h-5 sm:w-6 sm:h-6"></i>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 lg:flex-none ml-3 lg:ml-0">
                            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-white truncate">@yield('page-title', 'Dashboard')</h1>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <!-- Notifications -->
                            <button class="p-1.5 sm:p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg sm:rounded-xl transition-colors relative">
                                <i class="fi fi-rr-bell w-5 h-5 sm:w-6 sm:h-6"></i>
                                @if(isset($newContactsCount) && $newContactsCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center text-[10px] sm:text-xs">{{ $newContactsCount }}</span>
                                @endif
                            </button>

                            <!-- User Info -->
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-xs sm:text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-xs sm:text-sm font-medium text-white truncate max-w-20 sm:max-w-none">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] sm:text-xs text-gray-400">Administrador</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>



    <!-- Sidebar Mobile Overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity lg:hidden hidden" id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Mobile Sidebar Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Show sidebar
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                // Hide sidebar
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarButton = event.target.closest('button[onclick="toggleSidebar()"]');
            
            if (!sidebar.contains(event.target) && !sidebarButton && window.innerWidth < 1024) {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth >= 1024) {
                // Desktop: ensure sidebar is visible and remove mobile states
                sidebar.classList.remove('-translate-x-full', 'translate-x-0');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                // Mobile: ensure sidebar is hidden
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html> 