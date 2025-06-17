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
        @if($ticket->replies && $ticket->replies->where('is_internal', false)->count() > 0)
            @foreach($ticket->replies->where('is_internal', false) as $reply)
                <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @if($reply->user->role === 'admin')
                                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($reply->user->display_name, 0, 2) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="text-white font-semibold">
                                    {{ $reply->user->display_name }}
                                    @if($reply->user->role === 'admin')
                                        <span class="text-purple-400 text-sm font-normal">(Suporte)</span>
                                    @endif
                                </div>
                                <div class="text-gray-400 text-sm">{{ $reply->created_at->format('d/m/Y \à\s H:i') }}</div>
                            </div>
                        </div>
                        @if($reply->user->role === 'admin')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                Resposta da Equipe
                            </span>
                        @endif
                    </div>
                    
                    <div class="prose prose-invert max-w-none">
                        <div class="text-gray-300 whitespace-pre-line">{{ $reply->message }}</div>
                    </div>
                    
                    <!-- Attachments -->
                    @if($reply->attachments && count($reply->attachments) > 0)
                        <div class="mt-4 pt-4 border-t border-gray-600">
                            <p class="text-gray-400 text-sm mb-3">Anexos:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($reply->attachments as $attachment)
                                    <div class="flex items-center p-3 bg-gray-700/30 rounded-xl">
                                        <svg class="w-5 h-5 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-white text-sm font-medium">{{ $attachment['name'] }}</p>
                                            <p class="text-gray-400 text-xs">{{ number_format($attachment['size'] / 1024, 1) }} KB</p>
                                        </div>
                                        <a href="{{ Storage::url($attachment['path']) }}" target="_blank" 
                                           class="text-blue-400 hover:text-blue-300 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <!-- No Responses Yet -->
        @if(!$ticket->replies || $ticket->replies->where('is_internal', false)->count() === 0)
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

        <!-- Reply Form -->
        @if($ticket->status !== 'fechado')
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Responder ao Ticket
                </h3>

                @if(session('error'))
                    <div class="mb-6 bg-red-500/20 border border-red-500/30 rounded-2xl p-4">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-red-300 font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('client.support.reply', $ticket) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                                Sua Mensagem <span class="text-red-400">*</span>
                            </label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="6"
                                      required
                                      placeholder="Digite sua resposta ou informações adicionais..."
                                      class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attachments -->
                        <div>
                            <label for="attachments" class="block text-sm font-medium text-gray-300 mb-2">
                                Anexos (Opcional)
                            </label>
                            <input type="file" 
                                   name="attachments[]" 
                                   id="attachments"
                                   multiple
                                   accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip"
                                   class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('attachments') border-red-500 @enderror">
                            <p class="text-gray-500 text-sm mt-1">
                                Máximo 10MB por arquivo. Formatos: JPG, PNG, PDF, DOC, TXT, ZIP
                            </p>
                            @error('attachments')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-4">
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-cyan-500/25">
                                    <i class="fi fi-rr-paper-plane text-white ml-2 mt-2"></i>
                                Enviar Resposta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <!-- Ticket Closed Message -->
            <div class="bg-gray-700/30 backdrop-blur-md rounded-3xl border border-gray-600/50 p-6">
                <div class="flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-300">Ticket Fechado</h3>
                        <p class="text-gray-400 text-sm">Este ticket foi fechado e não aceita mais respostas.</p>
                    </div>
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