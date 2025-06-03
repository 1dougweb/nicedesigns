@extends('layouts.admin')

@section('title', '- Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl border border-blue-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Bem-vindo de volta, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-gray-300 text-lg">
                    Aqui está um resumo das atividades do seu site hoje.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Posts Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['posts']['total'] }}</p>
                <p class="text-sm text-gray-400">Posts</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                {{ $stats['posts']['published'] }} publicados
            </span>
            <span class="text-gray-500">{{ $stats['posts']['drafts'] }} rascunhos</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.posts.index') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                Gerenciar Posts →
            </a>
        </div>
    </div>

    <!-- Projects Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-purple-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['projects']['total'] }}</p>
                <p class="text-sm text-gray-400">Projetos</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                {{ $stats['projects']['published'] }} publicados
            </span>
            <span class="text-yellow-400">{{ $stats['projects']['featured'] }} destaques</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.projects.index') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium transition-colors">
                Gerenciar Projetos →
            </a>
        </div>
    </div>

    <!-- Contacts Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-pink-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['contacts']['total'] }}</p>
                <p class="text-sm text-gray-400">Contatos</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-red-400">
                <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
                {{ $stats['contacts']['new'] }} novos
            </span>
            <span class="text-green-400">{{ $stats['contacts']['completed'] }} concluídos</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.contacts.index') }}" class="text-pink-400 hover:text-pink-300 text-sm font-medium transition-colors">
                Ver Contatos →
            </a>
        </div>
    </div>

    <!-- Categories Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['categories']['total'] }}</p>
                <p class="text-sm text-gray-400">Categorias</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                {{ $stats['categories']['active'] }} ativas
            </span>
            <span class="text-gray-500">{{ $stats['categories']['total'] - $stats['categories']['active'] }} inativas</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.categories.index') }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-medium transition-colors">
                Gerenciar Categorias →
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Quick Actions -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Ações Rápidas
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('admin.posts.create') }}" class="flex flex-col items-center p-4 bg-blue-600/20 rounded-2xl hover:bg-blue-600/30 transition-all duration-300 group border border-blue-500/30">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white">Novo Post</span>
            </a>

            <a href="{{ route('admin.projects.create') }}" class="flex flex-col items-center p-4 bg-purple-600/20 rounded-2xl hover:bg-purple-600/30 transition-all duration-300 group border border-purple-500/30">
                <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white">Novo Projeto</span>
            </a>

            <a href="{{ route('admin.categories.create') }}" class="flex flex-col items-center p-4 bg-yellow-600/20 rounded-2xl hover:bg-yellow-600/30 transition-all duration-300 group border border-yellow-500/30">
                <div class="w-10 h-10 bg-yellow-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white">Nova Categoria</span>
            </a>

            <a href="{{ route('home') }}" target="_blank" class="flex flex-col items-center p-4 bg-green-600/20 rounded-2xl hover:bg-green-600/30 transition-all duration-300 group border border-green-500/30">
                <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white">Ver Site</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Atividade Recente
        </h3>
        <div class="space-y-4">
            @if($recentPosts->count() > 0)
                @foreach($recentPosts->take(3) as $post)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition-colors">
                        <div class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ Str::limit($post->title, 30) }}</p>
                            <p class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400">Nenhuma atividade recente</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Recent Contacts -->
@if($recentContacts->count() > 0)
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-white flex items-center">
            <svg class="w-6 h-6 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Contatos Recentes
        </h3>
        <a href="{{ route('admin.contacts.index') }}" class="text-pink-400 hover:text-pink-300 text-sm font-medium transition-colors">
            Ver Todos →
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700/50">
                    <th class="text-left py-3 px-4 text-gray-400 font-medium">Nome</th>
                    <th class="text-left py-3 px-4 text-gray-400 font-medium">Email</th>
                    <th class="text-left py-3 px-4 text-gray-400 font-medium">Assunto</th>
                    <th class="text-left py-3 px-4 text-gray-400 font-medium">Data</th>
                    <th class="text-left py-3 px-4 text-gray-400 font-medium">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentContacts->take(5) as $contact)
                    <tr class="border-b border-gray-700/30 hover:bg-gray-700/20 transition-colors">
                        <td class="py-3 px-4 text-white font-medium">{{ $contact->name }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $contact->email }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ Str::limit($contact->subject, 30) }}</td>
                        <td class="py-3 px-4 text-gray-400">{{ $contact->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            @if($contact->status === 'new')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    Novo
                                </span>
                            @elseif($contact->status === 'in_progress')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    Em Andamento
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    Concluído
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@push('styles')
<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}
</style>
@endpush
@endsection 