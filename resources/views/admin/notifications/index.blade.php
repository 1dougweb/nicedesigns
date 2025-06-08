@extends('layouts.admin')

@section('title', ' - Notificações')
@section('page-title', 'Notificações')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Minhas Notificações</h2>
                <p class="text-gray-400">Gerencie suas notificações e mantenha-se atualizado</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="markAllAsRead()" class="btn btn-secondary">
                    <i class="fi fi-rr-check-double w-4 h-4 mr-2"></i>
                    Marcar todas como lidas
                </button>
                <button onclick="clearRead()" class="btn btn-outline-red">
                    <i class="fi fi-rr-trash w-4 h-4 mr-2"></i>
                    Limpar lidas
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total de Notificações</p>
                    <p class="text-2xl font-bold text-white">{{ $notifications->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-600/20 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rr-bell w-6 h-6 text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Não Lidas</p>
                    <p class="text-2xl font-bold text-white" id="unread-count">{{ $notifications->where('read_at', null)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-600/20 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rr-bell-ring w-6 h-6 text-red-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Lidas</p>
                    <p class="text-2xl font-bold text-white">{{ $notifications->where('read_at', '!=', null)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-600/20 rounded-lg flex items-center justify-center">
                    <i class="fi fi-rr-check-circle w-6 h-6 text-green-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h3 class="text-lg font-semibold text-white">Todas as Notificações</h3>
        </div>
        
        <div class="divide-y divide-gray-700/50" id="notifications-container">
            @forelse($notifications as $notification)
                <div class="notification-row p-6 hover:bg-gray-700/30 transition-colors {{ !$notification->read_at ? 'bg-blue-600/10' : '' }}" data-id="{{ $notification->id }}">
                    <div class="flex items-start space-x-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-{{ $notification->color }}-600/20 rounded-lg flex items-center justify-center">
                                <i class="fi {{ $notification->icon }} w-5 h-5 text-{{ $notification->color }}-400"></i>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-white">{{ $notification->title }}</h4>
                                <div class="flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 mt-1">{{ $notification->message }}</p>
                            
                            @if($notification->url)
                                <a href="{{ route('admin.notifications.redirect', $notification) }}" class="inline-flex items-center text-xs text-blue-400 hover:text-blue-300 transition-colors mt-2">
                                    <i class="fi fi-rr-arrow-right w-3 h-3 mr-1"></i>
                                    Ver detalhes
                                </a>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex-shrink-0 flex items-center space-x-2">
                            @if(!$notification->read_at)
                                <button onclick="markAsRead({{ $notification->id }})" class="text-xs text-blue-400 hover:text-blue-300 transition-colors px-2 py-1 rounded">
                                    Marcar como lida
                                </button>
                            @endif
                            <button onclick="deleteNotification({{ $notification->id }})" class="text-gray-500 hover:text-red-400 transition-colors p-1 rounded">
                                <i class="fi fi-rr-trash w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fi fi-rr-bell-slash w-8 h-8 text-gray-500"></i>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">Nenhuma notificação</h3>
                    <p class="text-gray-400">Você não possui notificações no momento.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="p-6 border-t border-gray-700/50">
                {{ $notifications->links('pagination::custom-pagination') }}
            </div>
        @endif
    </div>

    <!-- Test Notification Button (Development Only) -->
    @if(config('app.debug'))
        <div class="bg-yellow-600/20 border border-yellow-600/50 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-yellow-400 font-medium">Modo de Desenvolvimento</h4>
                    <p class="text-yellow-300/80 text-sm">Criar notificação de teste</p>
                </div>
                <button onclick="createTestNotification()" class="btn btn-outline-yellow">
                    <i class="fi fi-rr-test w-4 h-4 mr-2"></i>
                    Criar Notificação de Teste
                </button>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .btn {
        @apply inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors;
    }
    .btn-secondary {
        @apply bg-gray-700 text-white hover:bg-gray-600;
    }
    .btn-outline-red {
        @apply border border-red-600 text-red-400 hover:bg-red-600/10;
    }
    .btn-outline-yellow {
        @apply border border-yellow-600 text-yellow-400 hover:bg-yellow-600/10;
    }
</style>
@endpush

@push('scripts')
<script>
    // Mark notification as read
    function markAsRead(notificationId) {
        fetch(`/admin/notifications/${notificationId}/read`, {
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
                // Update the notification row
                const row = document.querySelector(`[data-id="${notificationId}"]`);
                if (row) {
                    row.classList.remove('bg-blue-600/10');
                    const badge = row.querySelector('.bg-blue-500');
                    if (badge) badge.remove();
                    const button = row.querySelector('button[onclick*="markAsRead"]');
                    if (button) button.remove();
                }
                
                // Update unread count
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Mark all as read
    function markAllAsRead() {
        if (!confirm('Marcar todas as notificações como lidas?')) return;
        
        fetch('/admin/notifications/mark-all-read', {
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
                // Update all notification rows
                document.querySelectorAll('.notification-row').forEach(row => {
                    row.classList.remove('bg-blue-600/10');
                    const badge = row.querySelector('.bg-blue-500');
                    if (badge) badge.remove();
                    const button = row.querySelector('button[onclick*="markAsRead"]');
                    if (button) button.remove();
                });
                
                // Update unread count
                document.getElementById('unread-count').textContent = '0';
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Delete notification
    function deleteNotification(notificationId) {
        if (!confirm('Tem certeza que deseja excluir esta notificação?')) return;
        
        fetch(`/admin/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the notification row
                const row = document.querySelector(`[data-id="${notificationId}"]`);
                if (row) {
                    row.remove();
                }
                
                // Update unread count
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Clear read notifications
    function clearRead() {
        if (!confirm('Excluir todas as notificações lidas?')) return;
        
        fetch('/admin/notifications/clear-read', {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove read notification rows
                document.querySelectorAll('.notification-row').forEach(row => {
                    if (!row.classList.contains('bg-blue-600/10')) {
                        row.remove();
                    }
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Update unread count
    function updateUnreadCount() {
        const unreadRows = document.querySelectorAll('.notification-row.bg-blue-600\\/10').length;
        document.getElementById('unread-count').textContent = unreadRows.toString();
    }

    // Create test notification (development only)
    @if(config('app.debug'))
    function createTestNotification() {
        const types = ['info', 'success', 'warning', 'error', 'new_contact', 'new_project', 'invoice_paid', 'support_ticket'];
        const type = types[Math.floor(Math.random() * types.length)];
        
        const testData = {
            title: 'Notificação de Teste',
            message: `Esta é uma notificação de teste do tipo ${type}`,
            type: type,
            url: Math.random() > 0.5 ? '/admin/dashboard' : null
        };

        fetch('/admin/notifications', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(testData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Reload to show new notification
            }
        })
        .catch(error => console.error('Error:', error));
    }
    @endif
</script>
@endpush 