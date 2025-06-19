@extends('layouts.client')

@section('title', '- Notificações')
@section('page-title', 'Notificações')

@section('content')
<div class="space-y-8">
    <!-- Notifications List -->
    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 transition-all duration-300 hover:border-gray-600/50">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <!-- Icon -->
                        <div class="w-12 h-12 bg-{{ $notification->color }}-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
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
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2 ml-4">
                        @if($notification->url)
                            <a href="{{ route('client.notifications.redirect', $notification) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Ver
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-12 text-center">
                <div class="w-20 h-20 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fi fi-rr-bell text-gray-500 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Nenhuma notificação encontrada</h3>
                <p class="text-gray-400">Você não possui notificações no momento.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
