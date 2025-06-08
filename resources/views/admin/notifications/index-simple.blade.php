@extends('layouts.admin')

@section('title', ' - Notificações')
@section('page-title', 'Notificações')

@section('content')
<div class="space-y-6">
    <!-- Header simples -->
    <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50 p-6">
        <h2 class="text-2xl font-bold text-white mb-2">Minhas Notificações</h2>
        <p class="text-gray-400">Teste de layout</p>
    </div>

    <!-- Lista de notificações simples -->
    <div class="bg-gray-800/50 backdrop-blur-xl rounded-xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Todas as Notificações</h3>
        
        @forelse($notifications as $notification)
            <div class="p-4 mb-4 bg-gray-700/30 rounded-lg">
                <h4 class="text-white font-medium">{{ $notification->title }}</h4>
                <p class="text-gray-400 text-sm">{{ $notification->message }}</p>
                <small class="text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-400">Nenhuma notificação encontrada</p>
            </div>
        @endforelse
    </div>
</div>
@endsection 