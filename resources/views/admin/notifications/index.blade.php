@extends('layouts.admin')

@section('title', ' - Notificações')
@section('page-title', 'Notificações')

@section('content')
<div class="max-w-7xl mx-auto">
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Minhas Notificações</h2>
        <p class="text-gray-400 mt-1">Gerencie suas notificações e mantenha-se atualizado</p>
    </div>
    <div class="flex space-x-4">
        <button type="button" onclick="markAllAsRead()"
                class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <i class="fi fi-rr-check-double w-5 h-5"></i>
            <span>Marcar todas como lidas</span>
        </button>
        <button type="button" onclick="clearRead()"
                class="bg-red-600/20 text-red-300 border border-red-600/30 hover:bg-red-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <i class="fi fi-rr-trash w-5 h-5"></i>
            <span>Limpar lidas</span>
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 lg:mb-8">
    <!-- Total -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-bell w-7 h-7 sm:w-8 sm:h-8 text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ method_exists($notifications, 'count') ? $notifications->count() : count($notifications) }}</p>
                <p class="text-sm text-gray-400">Total</p>
            </div>
        </div>
    </div>

    <!-- Unread -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-red-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-bell-ring w-7 h-7 sm:w-8 sm:h-8 text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white" id="unread-count">
                    @if(method_exists($notifications, 'where'))
                        {{ $notifications->where('read_at', null)->count() }}
                    @else
                        {{ collect($notifications)->where('read_at', null)->count() }}
                    @endif
                </p>
                <p class="text-sm text-gray-400">Não lidas</p>
            </div>
        </div>
    </div>

    <!-- Read -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-check-circle w-7 h-7 sm:w-8 sm:h-8 text-white"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">
                    @if(method_exists($notifications, 'where'))
                        {{ $notifications->where('read_at', '!=', null)->count() }}
                    @else
                        {{ collect($notifications)->where('read_at', '!=', null)->count() }}
                    @endif
                </p>
                <p class="text-sm text-gray-400">Lidas</p>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50">
        <div class="p-6">
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
                                    <span class="text-xs text-gray-500">
                                        @if(is_object($notification->created_at) && method_exists($notification->created_at, 'diffForHumans'))
                                            {{ $notification->created_at->diffForHumans() }}
                                        @else
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-400 mt-1">{{ $notification->message }}</p>
                            
                            @if($notification->url)
                                <a href="{{ $notification->url }}" class="inline-flex items-center text-xs text-blue-400 hover:text-blue-300 transition-colors mt-2">
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
        @if(method_exists($notifications, 'hasPages') && $notifications->hasPages())
            <div class="p-6 border-t border-gray-700/50">
                <div class="text-center text-gray-400 text-sm">
                    @if(method_exists($notifications, 'count') && method_exists($notifications, 'total'))
                        Mostrando {{ $notifications->count() }} de {{ $notifications->total() }} notificações
                    @else
                        {{ count($notifications) }} notificações
                    @endif
                </div>
            </div>
        @endif
    </div>




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
</div>
@endsection