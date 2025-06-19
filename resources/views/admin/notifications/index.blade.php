@extends('layouts.admin')

@section('title', 'Notificações')
@section('page-title', 'Notificações')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-600/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fi fi-rr-bell text-blue-400 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ $stats['total'] }}</div>
                    <div class="text-gray-400 text-sm">Total de Notificações</div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-600/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fi fi-rr-exclamation text-yellow-400 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ $stats['unread'] }}</div>
                    <div class="text-gray-400 text-sm">Não Lidas</div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-600/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fi fi-rr-calendar text-green-400 text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ $stats['today'] }}</div>
                    <div class="text-gray-400 text-sm">Hoje</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-gray-800 rounded-xl border border-gray-700">
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white">Notificações</h2>
                @if($stats['unread'] > 0)
                    <button onclick="markAllAsRead()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Marcar Todas como Lidas
                    </button>
                @endif
            </div>
        </div>

        <div class="divide-y divide-gray-700">
            @forelse($notifications as $notification)
                <div class="p-6 notification-item {{ !$notification->isRead() ? 'bg-blue-600/10' : '' }}" data-id="{{ $notification->id }}">
                    <div class="flex items-start space-x-4">
                        <!-- Icon -->
                        <div class="w-12 h-12 bg-{{ $notification->color }}-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="{{ $notification->icon }} text-{{ $notification->color }}-400 text-lg"></i>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2 mb-2">
                                <h3 class="text-white font-semibold">{{ $notification->title }}</h3>
                                @if(!$notification->isRead())
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                @endif
                            </div>
                            <p class="text-gray-300 mb-3">{{ $notification->message }}</p>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-{{ $notification->color }}-600/20 text-{{ $notification->color }}-400">
                                    {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 ml-4">
                            @if($notification->url)
                                <a href="{{ route('admin.notifications.redirect', $notification) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Ver
                                </a>
                            @endif
                            
                            @if(!$notification->isRead())
                                <button onclick="markAsRead({{ $notification->id }})" 
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Marcar como Lida
                                </button>
                            @endif

                            <button onclick="deleteNotification({{ $notification->id }})" 
                                    class="text-red-400 hover:text-red-300 p-2 rounded-lg hover:bg-red-500/10 transition-colors">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fi fi-rr-bell text-gray-500 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Nenhuma notificação encontrada</h3>
                    <p class="text-gray-400">Você não possui notificações no momento.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="p-6 border-t border-gray-700">
                {{ $notifications->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<script>
// Mark single notification as read
function markAsRead(notificationId) {
    fetch(`/admin/notifications/${notificationId}/read`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Mark all notifications as read
function markAllAsRead() {
    if (!confirm('Marcar todas as notificações como lidas?')) return;
    
    fetch('/admin/notifications/mark-all-read', {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Delete notification
function deleteNotification(notificationId) {
    if (!confirm('Tem certeza que deseja excluir esta notificação?')) return;
    
    fetch(`/admin/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection