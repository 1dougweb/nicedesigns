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

    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css">

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

                <!-- Orçamentos -->
                <a href="{{ route('client.quotes.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.quotes.*') ? 'bg-orange-600/20 text-orange-400 border border-orange-500/30' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Orçamentos
                    @php
                        $pendingQuotes = auth()->user()->quotes()->pending()->count();
                    @endphp
                    @if($pendingQuotes > 0)
                        <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $pendingQuotes }}
                        </span>
                    @endif
                </a>

                <!-- Meus Projetos -->
                @if(auth()->user()->hasAcceptedQuote())
                    <a href="{{ route('client.projects.index') }}" 
                       class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.projects.*') ? 'bg-blue-600/20 text-blue-400 border border-blue-500/30' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Meus Projetos
                    </a>
                @else
                    <div class="flex items-center px-4 py-3 text-gray-500 rounded-xl cursor-not-allowed group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Meus Projetos
                        <svg class="w-4 h-4 ml-auto text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                @endif

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

                <!-- Notificações -->
                <a href="{{ route('client.notifications.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group {{ request()->routeIs('client.notifications.*') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : '' }}">
                    <i class="fi fi-rr-bell w-5 h-5 mr-3"></i>
                    Notificações
                    @php
                        $unreadCount = \App\Models\Notification::forUser(auth()->id())->unread()->notExpired()->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
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
                            <!-- Notifications Dropdown -->
                            <div class="relative" id="notifications-dropdown">
                                <button onclick="toggleNotifications()" class="p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-xl transition-colors relative">
                                    <i class="fi fi-rr-bell text-xl"></i>
                                    @php
                                        $unreadCount = \App\Models\Notification::forUser(auth()->id())->unread()->notExpired()->count();
                                    @endphp
                                    <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center {{ $unreadCount > 0 ? '' : 'hidden' }}">
                                        <span id="notification-count">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                    </span>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="notifications-menu" class="absolute right-0 mt-2 w-80 bg-gray-800 rounded-2xl shadow-2xl border border-gray-700/50 backdrop-blur-xl z-50 hidden">
                                    <!-- Header -->
                                    <div class="p-4 border-b border-gray-700/50">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-white">Notificações</h3>
                                            <button onclick="markAllAsRead()" class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                                                Marcar todas como lidas
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Notifications List -->
                                    <div id="notifications-list" class="max-h-96 overflow-y-auto">
                                        <div class="p-4 text-center text-gray-400">
                                            <i class="fi fi-rr-spinner animate-spin text-2xl mb-2"></i>
                                            <p>Carregando notificações...</p>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="p-4 border-t border-gray-700/50">
                                        <a href="{{ route('client.notifications.index') }}" class="block text-center text-blue-400 hover:text-blue-300 font-medium">
                                            Ver todas as notificações
                                        </a>
                                    </div>
                                </div>
                            </div>

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

        // Notifications Dropdown
        let notificationsOpen = false;
        let notificationsLoaded = false;

        function toggleNotifications() {
            const menu = document.getElementById('notifications-menu');
            
            if (notificationsOpen) {
                menu.classList.add('hidden');
                notificationsOpen = false;
            } else {
                menu.classList.remove('hidden');
                notificationsOpen = true;
                
                // Load notifications if not loaded yet
                if (!notificationsLoaded) {
                    loadNotifications();
                }
            }
        }

        function loadNotifications() {
            fetch('/client/notifications/unread')
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('notifications-list');
                    
                    if (data.notifications.length === 0) {
                        list.innerHTML = `
                            <div class="p-6 text-center text-gray-400">
                                <i class="fi fi-rr-bell text-3xl mb-2"></i>
                                <p>Nenhuma notificação</p>
                            </div>
                        `;
                    } else {
                        list.innerHTML = data.notifications.map(notification => `
                            <div class="p-4 border-b border-gray-700/30 hover:bg-gray-700/20 transition-colors">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-${notification.color}-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="${notification.icon} text-${notification.color}-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="text-white font-medium text-sm">${notification.title}</h4>
                                            <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>
                                        </div>
                                        <p class="text-gray-300 text-sm leading-5 mb-2">${notification.message}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-500 text-xs">${formatDate(notification.created_at)}</span>
                                            <div class="flex space-x-2">
                                                ${notification.url ? `<button onclick="redirectToNotification(${notification.id}, '${notification.url}')" class="text-blue-400 hover:text-blue-300 text-xs">Ver</button>` : ''}
                                                <button onclick="markAsRead(${notification.id})" class="text-gray-400 hover:text-white text-xs">Marcar como lida</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                    
                    notificationsLoaded = true;
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    document.getElementById('notifications-list').innerHTML = `
                        <div class="p-6 text-center text-red-400">
                            <i class="fi fi-rr-cross-circle text-3xl mb-2"></i>
                            <p>Erro ao carregar notificações</p>
                        </div>
                    `;
                });
        }

        function markAsRead(notificationId) {
            fetch(`/client/notifications/${notificationId}/read`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload notifications
                    notificationsLoaded = false;
                    loadNotifications();
                    updateNotificationCount();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function markAllAsRead() {
            fetch('/client/notifications/mark-all-read', {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload notifications
                    notificationsLoaded = false;
                    loadNotifications();
                    updateNotificationCount();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function redirectToNotification(notificationId, url) {
            // Mark as read and redirect
            fetch(`/client/notifications/${notificationId}/read`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(() => {
                window.location.href = url;
            })
            .catch(error => console.error('Error:', error));
        }

        function updateNotificationCount() {
            fetch('/client/notifications/check-new')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    const count = document.getElementById('notification-count');
                    
                    if (data.count > 0) {
                        badge.classList.remove('hidden');
                        count.textContent = data.count > 9 ? '9+' : data.count;
                    } else {
                        badge.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInMinutes = Math.floor((now - date) / 60000);
            
            if (diffInMinutes < 1) return 'Agora';
            if (diffInMinutes < 60) return `${diffInMinutes}m atrás`;
            if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h atrás`;
            if (diffInMinutes < 2880) return 'Ontem';
            return `${Math.floor(diffInMinutes / 1440)}d atrás`;
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notifications-dropdown');
            const menu = document.getElementById('notifications-menu');
            
            if (!dropdown.contains(event.target) && notificationsOpen) {
                menu.classList.add('hidden');
                notificationsOpen = false;
            }
        });

        // Check for new notifications periodically (only if authenticated)
        @auth
            setInterval(updateNotificationCount, 30000); // Every 30 seconds
        @endauth

        // Initial load
        document.addEventListener('DOMContentLoaded', function() {
            // Only update notification count if user is authenticated
            @auth
                updateNotificationCount();
            @endauth
        });
    </script>

    @stack('scripts')
</body>
</html> 