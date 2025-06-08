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
            <header class="bg-gray-800/30 backdrop-blur-xl border-b border-gray-700/50 sticky top-0 z-30">
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
                            <div class="relative" id="notifications-dropdown">
                                <button id="notifications-button" class="p-1.5 sm:p-2 text-gray-400 hover:text-white hover:bg-gray-700/50 rounded-lg sm:rounded-xl transition-colors relative">
                                    <i class="fi fi-rr-bell w-5 h-5 sm:w-6 sm:h-6"></i>
                                    <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center text-[10px] sm:text-xs hidden">0</span>
                                </button>

                                <!-- Notifications Dropdown -->
                                <div id="notifications-panel" class="absolute right-0 mt-2 w-80 sm:w-96 bg-gray-800 border border-gray-700 rounded-xl shadow-xl z-40 hidden">
                                    <div class="p-4 border-b border-gray-700">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-white">Notificações</h3>
                                            <button id="mark-all-read" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                                Marcar todas como lidas
                                            </button>
                                        </div>
                                    </div>
                                    <div id="notifications-list" class="max-h-96 overflow-y-auto">
                                        <div id="notifications-loading" class="p-4 text-center text-gray-400">
                                            <i class="fi fi-rr-spinner animate-spin w-5 h-5 mx-auto mb-2"></i>
                                            Carregando notificações...
                                        </div>
                                        <div id="notifications-empty" class="p-4 text-center text-gray-400 hidden">
                                            <i class="fi fi-rr-bell-slash w-8 h-8 mx-auto mb-2 opacity-50"></i>
                                            <p>Nenhuma notificação</p>
                                        </div>
                                    </div>
                                    <div class="p-3 border-t border-gray-700">
                                        <a href="{{ route('admin.notifications.index') }}" class="block w-full text-center text-sm text-blue-400 hover:text-blue-300 transition-colors">
                                            Ver todas as notificações
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- User Profile Dropdown -->
                            <div class="relative" id="user-dropdown">
                                <button id="user-button" class="flex items-center space-x-2 sm:space-x-3 hover:bg-gray-700/50 rounded-lg p-1.5 sm:p-2 transition-colors">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-xs sm:text-sm">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="hidden sm:block text-left">
                                        <p class="text-xs sm:text-sm font-medium text-white truncate max-w-32">{{ auth()->user()->name }}</p>
                                        <p class="text-[10px] sm:text-xs text-gray-400">Administrador</p>
                                    </div>
                                    <i class="fi fi-rr-angle-down w-3 h-3 text-gray-400 hidden sm:block"></i>
                                </button>

                                <!-- User Dropdown Menu -->
                                <div id="user-panel" class="absolute right-0 mt-2 w-56 bg-gray-800 border border-gray-700 rounded-xl shadow-xl z-40 hidden">
                                    <div class="p-3 border-b border-gray-700">
                                        <div class="flex items-center space-x-3">
                                            @if(auth()->user()->avatar)
                                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-white">{{ auth()->user()->name }}</p>
                                                <p class="text-sm text-gray-400">{{ auth()->user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-2">
                                        <a href="{{ route('admin.profile.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 hover:text-white transition-colors">
                                            <i class="fi fi-rr-user w-4 h-4 mr-3"></i>
                                            Meu Perfil
                                        </a>
                                        <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700/50 hover:text-white transition-colors">
                                            <i class="fi fi-rr-settings w-4 h-4 mr-3"></i>
                                            Configurações
                                        </a>
                                        <div class="border-t border-gray-700 my-2"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-red-600/20 hover:text-red-400 transition-colors">
                                                <i class="fi fi-rr-sign-out-alt w-4 h-4 mr-3"></i>
                                                Sair
                                            </button>
                                        </form>
                                    </div>
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

    <!-- Topbar JavaScript -->
    <script>
        // Variables
        let notificationsPanel = null;
        let userPanel = null;
        let lastNotificationCheck = new Date().toISOString();
        let notificationCheckInterval = null;

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeTopbar();
            loadNotifications();
            startNotificationPolling();
        });

        // Initialize topbar dropdowns
        function initializeTopbar() {
            // Notifications dropdown
            const notificationsButton = document.getElementById('notifications-button');
            notificationsPanel = document.getElementById('notifications-panel');
            
            if (notificationsButton && notificationsPanel) {
                notificationsButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDropdown('notifications');
                });
            }

            // User dropdown
            const userButton = document.getElementById('user-button');
            userPanel = document.getElementById('user-panel');
            
            if (userButton && userPanel) {
                userButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleDropdown('user');
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#notifications-dropdown')) {
                    closeDropdown('notifications');
                }
                if (!e.target.closest('#user-dropdown')) {
                    closeDropdown('user');
                }
            });

            // Mark all as read button
            const markAllReadBtn = document.getElementById('mark-all-read');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', markAllNotificationsAsRead);
            }
        }

        // Toggle dropdown
        function toggleDropdown(type) {
            if (type === 'notifications') {
                const isVisible = !notificationsPanel.classList.contains('hidden');
                closeDropdown('user'); // Close user dropdown
                
                if (isVisible) {
                    closeDropdown('notifications');
                } else {
                    openDropdown('notifications');
                    loadNotifications(); // Reload notifications when opening
                }
            } else if (type === 'user') {
                const isVisible = !userPanel.classList.contains('hidden');
                closeDropdown('notifications'); // Close notifications dropdown
                
                if (isVisible) {
                    closeDropdown('user');
                } else {
                    openDropdown('user');
                }
            }
        }

        // Open dropdown
        function openDropdown(type) {
            if (type === 'notifications' && notificationsPanel) {
                notificationsPanel.classList.remove('hidden');
            } else if (type === 'user' && userPanel) {
                userPanel.classList.remove('hidden');
            }
        }

        // Close dropdown
        function closeDropdown(type) {
            if (type === 'notifications' && notificationsPanel) {
                notificationsPanel.classList.add('hidden');
            } else if (type === 'user' && userPanel) {
                userPanel.classList.add('hidden');
            }
        }

        // Load notifications
        function loadNotifications() {
            const loadingDiv = document.getElementById('notifications-loading');
            const emptyDiv = document.getElementById('notifications-empty');
            const listDiv = document.getElementById('notifications-list');
            
            if (loadingDiv) loadingDiv.classList.remove('hidden');
            if (emptyDiv) emptyDiv.classList.add('hidden');

            fetch('{{ route("admin.notifications.unread") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                updateNotificationBadge(data.unread_count);
                displayNotifications(data.notifications);
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                if (loadingDiv) loadingDiv.classList.add('hidden');
                if (emptyDiv) emptyDiv.classList.remove('hidden');
            });
        }

        // Display notifications
        function displayNotifications(notifications) {
            const loadingDiv = document.getElementById('notifications-loading');
            const emptyDiv = document.getElementById('notifications-empty');
            const listDiv = document.getElementById('notifications-list');
            
            if (loadingDiv) loadingDiv.classList.add('hidden');

            if (notifications.length === 0) {
                if (emptyDiv) emptyDiv.classList.remove('hidden');
                return;
            }

            if (emptyDiv) emptyDiv.classList.add('hidden');

            // Clear existing notifications (except loading and empty)
            const existingNotifications = listDiv.querySelectorAll('.notification-item');
            existingNotifications.forEach(item => item.remove());

            // Add new notifications
            notifications.forEach(notification => {
                const notificationElement = createNotificationElement(notification);
                listDiv.appendChild(notificationElement);
            });
        }

        // Create notification element
        function createNotificationElement(notification) {
            const div = document.createElement('div');
            div.className = 'notification-item border-b border-gray-700 last:border-b-0';
            
            const isUnread = !notification.read_at;
            const bgClass = isUnread ? 'bg-blue-600/10' : '';
            const timeAgo = getTimeAgo(new Date(notification.created_at));
            
            div.innerHTML = `
                <div class="p-4 hover:bg-gray-700/30 transition-colors ${bgClass}">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-${notification.color}-600/20 rounded-lg flex items-center justify-center">
                                <i class="fi ${notification.icon} w-4 h-4 text-${notification.color}-400"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-white truncate">${notification.title}</p>
                                ${isUnread ? '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>' : ''}
                            </div>
                            <p class="text-sm text-gray-400 mt-1">${notification.message}</p>
                            <p class="text-xs text-gray-500 mt-2">${timeAgo}</p>
                        </div>
                        <div class="flex-shrink-0 flex items-center space-x-1">
                            ${!isUnread ? '' : `
                                <button onclick="markNotificationAsRead(${notification.id})" class="text-xs text-blue-400 hover:text-blue-300 transition-colors">
                                    Marcar como lida
                                </button>
                            `}
                            <button onclick="deleteNotification(${notification.id})" class="text-gray-500 hover:text-red-400 transition-colors">
                                <i class="fi fi-rr-cross w-3 h-3"></i>
                            </button>
                        </div>
                    </div>
                    ${notification.url ? `
                        <a href="${notification.url}" class="block mt-2">
                            <div class="text-xs text-blue-400 hover:text-blue-300 transition-colors">Ver detalhes →</div>
                        </a>
                    ` : ''}
                </div>
            `;
            
            return div;
        }

        // Update notification badge
        function updateNotificationBadge(count) {
            const badge = document.getElementById('notification-badge');
            if (!badge) return;
            
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count.toString();
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // Mark notification as read
        function markNotificationAsRead(notificationId) {
            fetch(`{{ route("admin.notifications.mark-read", "__ID__") }}`.replace('__ID__', notificationId), {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(); // Reload notifications
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        }

        // Mark all notifications as read
        function markAllNotificationsAsRead() {
            fetch('{{ route("admin.notifications.mark-all-read") }}', {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(); // Reload notifications
                }
            })
            .catch(error => console.error('Error marking all notifications as read:', error));
        }

        // Delete notification
        function deleteNotification(notificationId) {
            if (!confirm('Tem certeza que deseja excluir esta notificação?')) {
                return;
            }
            
            fetch(`{{ route("admin.notifications.destroy", "__ID__") }}`.replace('__ID__', notificationId), {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(); // Reload notifications
                }
            })
            .catch(error => console.error('Error deleting notification:', error));
        }

        // Start notification polling
        function startNotificationPolling() {
            // Check for new notifications every 30 seconds
            notificationCheckInterval = setInterval(checkForNewNotifications, 30000);
        }

        // Check for new notifications
        function checkForNewNotifications() {
            fetch(`{{ route("admin.notifications.check-new") }}?last_check=${encodeURIComponent(lastNotificationCheck)}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.has_new) {
                    updateNotificationBadge(data.unread_count);
                    // Optionally show a toast notification for new notifications
                    showNotificationToast('Você tem novas notificações!');
                }
                lastNotificationCheck = data.last_check;
            })
            .catch(error => console.error('Error checking new notifications:', error));
        }

        // Show notification toast (optional)
        function showNotificationToast(message) {
            // You can implement a toast notification here
            console.log('New notification:', message);
        }

        // Get time ago string
        function getTimeAgo(date) {
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) {
                return 'agora mesmo';
            } else if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                return `${minutes} minuto${minutes > 1 ? 's' : ''} atrás`;
            } else if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                return `${hours} hora${hours > 1 ? 's' : ''} atrás`;
            } else {
                const days = Math.floor(diffInSeconds / 86400);
                return `${days} dia${days > 1 ? 's' : ''} atrás`;
            }
        }
    </script>

    @stack('scripts')
</body>
</html> 