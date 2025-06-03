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

    <!-- Client Projects Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-cyan-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['client_projects']['total'] }}</p>
                <p class="text-sm text-gray-400">Projetos Clientes</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                {{ $stats['client_projects']['active'] }} ativos
            </span>
            <span class="text-blue-400">{{ $stats['client_projects']['completed'] }} concluídos</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.client-projects.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-colors">
                Gerenciar →
            </a>
        </div>
    </div>

    <!-- Invoices Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-emerald-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['invoices']['total'] }}</p>
                <p class="text-sm text-gray-400">Faturas</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-yellow-400">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                {{ $stats['invoices']['pending'] }} pendentes
            </span>
            <span class="text-green-400">{{ $stats['invoices']['paid'] }} pagas</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.invoices.index') }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium transition-colors">
                Gerenciar Faturas →
            </a>
        </div>
    </div>
</div>

<!-- Additional Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Support Tickets Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-orange-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['support_tickets']['total'] }}</p>
                <p class="text-sm text-gray-400">Tickets</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-red-400">
                <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
                {{ $stats['support_tickets']['open'] }} abertos
            </span>
            <span class="text-green-400">{{ $stats['support_tickets']['resolved_today'] }} resolvidos hoje</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.support-tickets.index') }}" class="text-orange-400 hover:text-orange-300 text-sm font-medium transition-colors">
                Ver Tickets →
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

    <!-- Clients Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-indigo-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['clients']['total'] }}</p>
                <p class="text-sm text-gray-400">Clientes</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                {{ $stats['clients']['active'] }} ativos
            </span>
            <span class="text-gray-500">com projetos</span>
        </div>
        <div class="mt-4">
            <span class="text-indigo-400 text-sm font-medium">
                Gestão de Clientes
            </span>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-white">R$ {{ number_format($stats['invoices']['total_amount'], 0, ',', '.') }}</p>
                <p class="text-sm text-gray-400">Faturado</p>
            </div>
        </div>
        <div class="text-sm">
            <span class="flex items-center text-yellow-400 mb-1">
                A receber: R$ {{ number_format($stats['invoices']['pending_amount'], 0, ',', '.') }}
            </span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.invoices.index') }}" class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                Ver Financeiro →
            </a>
        </div>
    </div>
</div>

<!-- Urgent Alerts & Recent Activity -->
@if($urgentTickets->count() > 0 || $upcomingInvoices->count() > 0)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Urgent Tickets -->
    @if($urgentTickets->count() > 0)
    <div class="bg-red-600/10 border border-red-500/30 rounded-3xl p-6">
        <h3 class="text-xl font-bold text-red-400 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            Tickets Urgentes
        </h3>
        <div class="space-y-3">
            @foreach($urgentTickets as $ticket)
                <div class="bg-gray-800/50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-medium">{{ $ticket->subject }}</h4>
                            <p class="text-gray-400 text-sm">{{ $ticket->user->full_name }}</p>
                        </div>
                        <a href="{{ route('admin.support-tickets.show', $ticket) }}" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                            Ver
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Upcoming Invoices -->
    @if($upcomingInvoices->count() > 0)
    <div class="bg-yellow-600/10 border border-yellow-500/30 rounded-3xl p-6">
        <h3 class="text-xl font-bold text-yellow-400 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Faturas Vencendo em Breve
        </h3>
        <div class="space-y-3">
            @foreach($upcomingInvoices as $invoice)
                <div class="bg-gray-800/50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-medium">{{ $invoice->title }}</h4>
                            <p class="text-gray-400 text-sm">{{ $invoice->user->full_name }} - Vence {{ $invoice->due_date->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('admin.invoices.show', $invoice) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                            Ver
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endif

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

            <a href="{{ route('admin.client-projects.create') }}" class="flex flex-col items-center p-4 bg-cyan-600/20 rounded-2xl hover:bg-cyan-600/30 transition-all duration-300 group border border-cyan-500/30">
                <div class="w-10 h-10 bg-cyan-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white">Projeto Cliente</span>
            </a>

            <a href="{{ route('admin.invoices.create') }}" class="flex flex-col items-center p-4 bg-emerald-600/20 rounded-2xl hover:bg-emerald-600/30 transition-all duration-300 group border border-emerald-500/30">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-white">Nova Fatura</span>
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
            @if($recentClientProjects->count() > 0)
                @foreach($recentClientProjects->take(2) as $project)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition-colors">
                        <div class="w-10 h-10 bg-cyan-600/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">Projeto: {{ Str::limit($project->name, 25) }}</p>
                            <p class="text-gray-400 text-sm">{{ $project->user->full_name }} - {{ $project->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.client-projects.show', $project) }}" class="text-cyan-400 hover:text-cyan-300 text-sm">
                            Ver →
                        </a>
                    </div>
                @endforeach
            @endif

            @if($recentTickets->count() > 0)
                @foreach($recentTickets->take(2) as $ticket)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition-colors">
                        <div class="w-10 h-10 bg-orange-600/20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">Ticket: {{ Str::limit($ticket->subject, 25) }}</p>
                            <p class="text-gray-400 text-sm">{{ $ticket->user->full_name }} - {{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.support-tickets.show', $ticket) }}" class="text-orange-400 hover:text-orange-300 text-sm">
                            Ver →
                        </a>
                    </div>
                @endforeach
            @endif

            @if($recentPosts->count() > 0 && $recentClientProjects->count() == 0 && $recentTickets->count() == 0)
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
                        <a href="{{ route('admin.posts.show', $post) }}" class="text-blue-400 hover:text-blue-300 text-sm">
                            Ver →
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Recent Contacts -->
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
                            @php
                                $statusColors = [
                                    'new' => 'red',
                                    'in_progress' => 'yellow',
                                    'completed' => 'green'
                                ];
                                $statusLabels = [
                                    'new' => 'Novo',
                                    'in_progress' => 'Em Andamento',
                                    'completed' => 'Concluído'
                                ];
                                $color = $statusColors[$contact->status] ?? 'gray';
                                $label = $statusLabels[$contact->status] ?? 'Desconhecido';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-500/20 text-{{ $color }}-400 border border-{{ $color }}-500/30">
                                {{ $label }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

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