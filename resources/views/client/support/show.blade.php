@extends('layouts.client')

@section('title', '- Ticket #' . $ticket->id)
@section('page-title', 'Ticket #' . $ticket->id)

@section('content')
@php
    $statusColors = [
        'aberto' => 'blue',
        'em_andamento' => 'yellow', 
        'aguardando_cliente' => 'orange',
        'resolvido' => 'green',
        'fechado' => 'gray',
    ];
    $statusColor = $statusColors[$ticket->status] ?? 'blue';
    
    $priorityColors = [
        'baixa' => 'green',
        'normal' => 'blue',
        'alta' => 'orange',
        'urgente' => 'red',
    ];
    $priorityColor = $priorityColors[$ticket->priority] ?? 'blue';
    
    $statusLabels = [
        'aberto' => 'Aberto',
        'em_andamento' => 'Em Andamento',
        'aguardando_cliente' => 'Aguardando Cliente',
        'resolvido' => 'Resolvido',
        'fechado' => 'Fechado',
    ];
    
    $priorityLabels = [
        'baixa' => 'Baixa',
        'normal' => 'Normal',
        'alta' => 'Alta',
        'urgente' => 'Urgente',
    ];
@endphp

<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-{{ $statusColor }}-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl border border-{{ $statusColor }}-500/30 p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
            <div class="mb-6 lg:mb-0 flex-1">
                <div class="flex items-center mb-4">
                    <a href="{{ route('client.support.index') }}" class="text-gray-300 hover:text-white mr-4 p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-white">{{ $ticket->subject }}</h1>
                </div>
                
                <p class="text-gray-300 text-lg mb-4">Ticket #{{ $ticket->id }}</p>
                
                <div class="flex flex-wrap items-center gap-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $statusLabels[$ticket->status] ?? 'Aberto' }}
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $priorityColor }}-500/20 text-{{ $priorityColor }}-400 border border-{{ $priorityColor }}-500/30">
                        <div class="w-2 h-2 bg-{{ $priorityColor }}-400 rounded-full mr-2"></div>
                        {{ $priorityLabels[$ticket->priority] ?? 'Média' }}
                    </span>
                    @if($ticket->clientProject)
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            {{ $ticket->clientProject->name }}
                        </span>
                    @endif
                    @if($ticket->category)
                        @php
                            $categoryLabels = [
                                'suporte_tecnico' => 'Suporte Técnico',
                                'bug_report' => 'Bug Report',
                                'nova_funcionalidade' => 'Nova Funcionalidade',
                                'duvida' => 'Dúvida',
                                'alteracao_projeto' => 'Alteração de Projeto',
                                'financeiro' => 'Financeiro',
                                'outro' => 'Outro',
                            ];
                            $categoryColors = [
                                'suporte_tecnico' => 'blue',
                                'bug_report' => 'red',
                                'nova_funcionalidade' => 'purple',
                                'duvida' => 'gray',
                                'alteracao_projeto' => 'orange',
                                'financeiro' => 'green',
                                'outro' => 'gray',
                            ];
                            $categoryColor = $categoryColors[$ticket->category] ?? 'gray';
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-{{ $categoryColor }}-500/20 text-{{ $categoryColor }}-400 border border-{{ $categoryColor }}-500/30">
                            {{ $categoryLabels[$ticket->category] ?? 'Outro' }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Status Icon -->
            <div class="flex-shrink-0">
                <div class="w-20 h-20 bg-{{ $statusColor }}-500/20 rounded-full flex items-center justify-center">
                    @if($ticket->status === 'resolved')
                        <svg class="w-10 h-10 text-{{ $statusColor }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @elseif($ticket->status === 'closed')
                        <svg class="w-10 h-10 text-{{ $statusColor }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    @else
                        <svg class="w-10 h-10 text-{{ $statusColor }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="mb-6 bg-green-500/20 border border-green-500/30 rounded-2xl p-4">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-green-300 font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Conversation Thread -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Original Ticket -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr($ticket->user->display_name, 0, 2) }}</span>
                    </div>
                    <div>
                        <div class="text-white font-semibold">{{ $ticket->user->display_name }}</div>
                        <div class="text-gray-400 text-sm">{{ $ticket->created_at->format('d/m/Y \à\s H:i') }}</div>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                    Ticket Original
                </span>
            </div>
            
            <div class="prose prose-invert max-w-none">
                <div class="text-gray-300 whitespace-pre-line">{{ $ticket->description }}</div>
            </div>
        </div>

        <!-- Responses -->
        @if($ticket->responses && $ticket->responses->count() > 0)
            @foreach($ticket->responses as $response)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @if($response->user->role === 'admin')
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($response->user->display_name, 0, 2) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="text-white font-semibold">
                                    {{ $response->user->display_name }}
                                    @if($response->user->role === 'admin')
                                        <span class="text-purple-400 text-sm font-normal">(Suporte)</span>
                                    @endif
                                </div>
                                <div class="text-gray-400 text-sm">{{ $response->created_at->format('d/m/Y \à\s H:i') }}</div>
                            </div>
                        </div>
                        @if($response->user->role === 'admin')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                Resposta da Equipe
                            </span>
                        @endif
                    </div>
                    
                    <div class="prose prose-invert max-w-none">
                        <div class="text-gray-300 whitespace-pre-line">{{ $response->message }}</div>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- No Responses Yet -->
        @if(!$ticket->responses || $ticket->responses->count() === 0)
            <div class="text-center py-8">
                <div class="bg-gray-800/30 backdrop-blur-md rounded-3xl border border-gray-700/30 p-8">
                    <div class="w-16 h-16 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Aguardando Resposta</h3>
                    <p class="text-gray-400">Nossa equipe de suporte responderá em breve. Você receberá uma notificação quando houver uma atualização.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Ticket Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informações do Ticket
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                    <span class="text-gray-400">ID</span>
                    <span class="text-white font-medium">#{{ $ticket->id }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                    <span class="text-gray-400">Status</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ $statusLabels[$ticket->status] ?? 'Aberto' }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                    <span class="text-gray-400">Prioridade</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $priorityColor }}-500/20 text-{{ $priorityColor }}-400 border border-{{ $priorityColor }}-500/30">
                        <div class="w-2 h-2 bg-{{ $priorityColor }}-400 rounded-full mr-2"></div>
                        {{ $priorityLabels[$ticket->priority] ?? 'Média' }}
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-700/50">
                    <span class="text-gray-400">Criado em</span>
                    <span class="text-white font-medium">{{ $ticket->created_at->format('d/m/Y') }}</span>
                </div>
                @if($ticket->updated_at != $ticket->created_at)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-400">Última atualização</span>
                        <span class="text-white font-medium">{{ $ticket->updated_at->diffForHumans() }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Project -->
        @if($ticket->clientProject)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Projeto Relacionado
                </h3>
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-2xl p-4">
                    <h4 class="text-white font-semibold mb-2">{{ $ticket->clientProject->name }}</h4>
                    @if($ticket->clientProject->description)
                        <p class="text-gray-300 text-sm mb-3">{{ Str::limit($ticket->clientProject->description, 100) }}</p>
                    @endif
                    <a href="{{ route('client.projects.show', $ticket->clientProject) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                        Ver Projeto
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Ações
            </h3>
            <div class="space-y-3">
                <a href="{{ route('client.support.create') }}" class="w-full flex items-center justify-center p-3 bg-blue-600/20 rounded-xl hover:bg-blue-600/30 transition-colors group border border-blue-500/30">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-white font-medium">Novo Ticket</div>
                        <div class="text-blue-300 text-sm">Criar outro ticket</div>
                    </div>
                </a>
                
                <a href="{{ route('client.support.index') }}" class="w-full flex items-center justify-center p-3 bg-gray-600/20 rounded-xl hover:bg-gray-600/30 transition-colors group border border-gray-500/30">
                    <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-left">
                        <div class="text-white font-medium">Todos os Tickets</div>
                        <div class="text-gray-300 text-sm">Ver histórico</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Response Time Info -->
        <div class="bg-gradient-to-r from-green-500/10 to-blue-500/10 border border-green-500/20 rounded-3xl p-6">
            <h4 class="text-white font-semibold mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tempo de Resposta
            </h4>
            <div class="space-y-3 text-sm text-gray-300">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                    <span><strong>Urgente:</strong> 2-4 horas</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-orange-400 rounded-full"></div>
                    <span><strong>Alta:</strong> 6-12 horas</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                    <span><strong>Média:</strong> 1-2 dias úteis</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    <span><strong>Baixa:</strong> 2-3 dias úteis</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 