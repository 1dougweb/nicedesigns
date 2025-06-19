@extends('layouts.admin')

@section('title', '- Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-6 lg:mb-8">
    <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-blue-500/30 p-4 sm:p-6 lg:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">
                    Bem-vindo de volta, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-gray-300 text-sm sm:text-base lg:text-lg">
                    Aqui está um resumo das atividades do seu site hoje.
                </p>
            </div>
            <div class="hidden sm:block lg:block flex-shrink-0">
                <div class=" lg:w-24 lg:h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fi fi-rr-stats text-white text-4xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 lg:mb-8">
    <!-- Posts Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 p-4 sm:p-6 hover:border-blue-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <i class="fi fi-rr-edit text-white text-3xl mt-2"></i>
        </div>
            <div class="text-right">
                <p class="text-2xl sm:text-3xl font-bold text-white">{{ $stats['posts']['total'] }}</p>
                <p class="text-xs sm:text-sm text-gray-400">Posts</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs sm:text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 flex-shrink-0"></span>
                <span class="truncate">{{ $stats['posts']['published'] }} publicados</span>
            </span>
            <span class="text-gray-500 text-right sm:text-left">{{ $stats['posts']['drafts'] }} rascunhos</span>
        </div>
        <div class="mt-3 sm:mt-4">
            <a href="{{ route('admin.posts.index') }}" class="text-blue-400 hover:text-blue-300 text-xs sm:text-sm font-medium transition-colors">
                Gerenciar Posts →
            </a>
        </div>
    </div>

    <!-- Projects Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-purple-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-briefcase text-white text-3xl mt-2"></i>
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
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-users text-white text-3xl mt-2"></i>
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
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-receipt text-white text-3xl mt-2"></i>
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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 lg:mb-8">
    <!-- Support Tickets Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-orange-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-headset text-white text-3xl mt-2"></i>
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
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-envelope text-white text-3xl mt-2"></i>
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
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-user text-white text-3xl mt-2"></i>
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

    <!-- Quotes Stats -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-amber-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i class="fi fi-rr-document text-white text-3xl mt-2"></i>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">{{ $stats['quotes']['total'] }}</p>
                <p class="text-sm text-gray-400">Orçamentos</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-yellow-400">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                {{ $stats['quotes']['pending'] }} pendentes
            </span>
            <span class="text-green-400">{{ $stats['quotes']['accepted'] }} aceitos</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.quotes.index') }}" class="text-amber-400 hover:text-amber-300 text-sm font-medium transition-colors">
                Gerenciar Orçamentos →
            </a>
        </div>
    </div>
</div>

<!-- Urgent Alerts & Recent Activity -->
@if($urgentTickets->count() > 0 || $upcomingInvoices->count() > 0)
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 mb-6 lg:mb-8">
    <!-- Urgent Tickets -->
    @if($urgentTickets->count() > 0)
    <div class="bg-red-600/10 border border-red-500/30 rounded-2xl lg:rounded-3xl p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-bold text-red-400 mb-3 sm:mb-4 flex items-center">
            <i class="fi fi-rr-triangle-warning text-white text-3xl mt-2"></i>
            <span class="truncate">Tickets Urgentes</span>
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
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 lg:gap-8 mb-6 lg:mb-8">
    <!-- Quick Actions -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-bold text-white mb-4 sm:mb-6 flex items-center">
            <i class="fi fi-rr-bolt w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3 text-blue-400"></i>
            <span class="truncate">Ações Rápidas</span>
        </h3>
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <a href="{{ route('admin.posts.create') }}" class="flex flex-col items-center p-3 sm:p-4 bg-blue-600/20 rounded-xl sm:rounded-2xl hover:bg-blue-600/30 transition-all duration-300 group border border-blue-500/30">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-600 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-2 sm:mb-3">
                    <i class="fi fi-rr-plus text-white text-2xl mt-2"></i>
                </div>
                <span class="text-xs sm:text-sm font-medium text-white text-center">Novo Post</span>
            </a>

            <a href="{{ route('admin.projects.create') }}" class="flex flex-col items-center p-3 sm:p-4 bg-purple-600/20 rounded-xl sm:rounded-2xl hover:bg-purple-600/30 transition-all duration-300 group border border-purple-500/30">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-600 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-2 sm:mb-3">
                    <i class="fi fi-rr-plus text-white text-2xl mt-2"></i>
                </div>
                <span class="text-xs sm:text-sm font-medium text-white text-center">Novo Projeto</span>
            </a>

            <a href="{{ route('admin.client-projects.create') }}" class="flex flex-col items-center p-3 sm:p-4 bg-cyan-600/20 rounded-xl sm:rounded-2xl hover:bg-cyan-600/30 transition-all duration-300 group border border-cyan-500/30">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-cyan-600 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-2 sm:mb-3">
                    <i class="fi fi-rr-plus text-white text-2xl mt-2"></i>
                </div>
                <span class="text-xs sm:text-sm font-medium text-white text-center">Projeto Cliente</span>
            </a>

            <a href="{{ route('admin.quotes.create') }}" class="flex flex-col items-center p-3 sm:p-4 bg-amber-600/20 rounded-xl sm:rounded-2xl hover:bg-amber-600/30 transition-all duration-300 group border border-amber-500/30">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-600 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-2 sm:mb-3">
                    <i class="fi fi-rr-plus text-white text-2xl mt-2"></i>
                </div>
                <span class="text-xs sm:text-sm font-medium text-white text-center">Novo Orçamento</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-bold text-white mb-4 sm:mb-6 flex items-center">
            <i class="fi fi-rr-clock w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3 text-green-400"></i>
            <span class="truncate">Atividade Recente</span>
        </h3>
        <div class="space-y-4">
            @if($recentClientProjects->count() > 0)
                @foreach($recentClientProjects->take(2) as $project)
                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl hover:bg-gray-700/50 transition-colors">
                        <div class="w-10 h-10 bg-cyan-600/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fi fi-rr-users w-5 h-5 text-cyan-400"></i>
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
                            <i class="fi fi-rr-headset w-5 h-5 text-orange-400"></i>
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
                            <i class="fi fi-rr-edit w-5 h-5 text-blue-400"></i>
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
            <i class="fi fi-rr-envelope w-6 h-6 mr-3 text-pink-400"></i>
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