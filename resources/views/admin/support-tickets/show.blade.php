@extends('layouts.admin')

@section('title', '- Ticket #' . $supportTicket->id)
@section('page-title', 'Ticket #' . $supportTicket->id . ' - ' . $supportTicket->subject)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-2">{{ $supportTicket->subject }}</h2>
        <p class="text-gray-400">Ticket #{{ $supportTicket->id }} - {{ $supportTicket->user->full_name }}</p>
    </div>
    <div class="flex space-x-4">
        <a href="{{ route('admin.support-tickets.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
    </div>
</div>

<!-- Status Alert -->
@if($supportTicket->status === 'resolvido')
    <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-4 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-green-400 font-bold">Ticket Resolvido</h3>
                <p class="text-green-400/80">
                    Este ticket foi resolvido em {{ $supportTicket->resolved_at ? $supportTicket->resolved_at->format('d/m/Y H:i') : 'Data não informada' }}
                </p>
            </div>
        </div>
    </div>
@elseif($supportTicket->status === 'fechado')
    <div class="bg-gray-500/10 border border-gray-500/30 rounded-xl p-4 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <div>
                <h3 class="text-gray-400 font-bold">Ticket Fechado</h3>
                <p class="text-gray-400/80">Este ticket foi fechado e não aceita mais respostas</p>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Ticket Details -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Detalhes do Problema
            </h3>

            <!-- Status and Priority -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h4 class="text-gray-300 font-medium mb-2">Status</h4>
                    @php
                        $statusColors = [
                            'aberto' => 'blue',
                            'em_andamento' => 'yellow',
                            'aguardando_resposta' => 'orange',
                            'resolvido' => 'green',
                            'fechado' => 'gray'
                        ];
                        $statusColor = $statusColors[$supportTicket->status] ?? 'gray';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $statusColor }}-500/20 text-{{ $statusColor }}-400 border border-{{ $statusColor }}-500/30">
                        {{ ucfirst(str_replace('_', ' ', $supportTicket->status)) }}
                    </span>
                </div>

                <div>
                    <h4 class="text-gray-300 font-medium mb-2">Prioridade</h4>
                    @php
                        $priorityColors = [
                            'baixa' => 'green',
                            'normal' => 'blue',
                            'alta' => 'yellow',
                            'urgente' => 'red'
                        ];
                        $priorityColor = $priorityColors[$supportTicket->priority] ?? 'gray';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $priorityColor }}-500/20 text-{{ $priorityColor }}-400 border border-{{ $priorityColor }}-500/30">
                        {{ ucfirst($supportTicket->priority) }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h4 class="text-gray-300 font-medium mb-3">Descrição do Problema</h4>
                <div class="bg-gray-700/30 rounded-xl p-4">
                    <div class="text-gray-300 leading-relaxed">
                        {!! nl2br(e($supportTicket->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Related Project -->
            @if($supportTicket->clientProject)
                <div class="mb-6">
                    <h4 class="text-gray-300 font-medium mb-3">Projeto Relacionado</h4>
                    <div class="flex items-center p-4 bg-gray-700/30 rounded-xl">
                        <div class="flex-1">
                            <h5 class="text-white font-medium">{{ $supportTicket->clientProject->name }}</h5>
                            <p class="text-gray-400 text-sm">Status: {{ $supportTicket->clientProject->status_label }}</p>
                        </div>
                        <a href="{{ route('admin.client-projects.show', $supportTicket->clientProject) }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-colors">
                            Ver Projeto
                        </a>
                    </div>
                </div>
            @endif

            <!-- Attachments -->
            @if($supportTicket->attachments && count($supportTicket->attachments) > 0)
                <div>
                    <h4 class="text-gray-300 font-medium mb-3">Anexos</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($supportTicket->attachments as $attachment)
                            <div class="flex items-center p-3 bg-gray-700/30 rounded-xl">
                                <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-white text-sm font-medium">{{ $attachment['name'] }}</p>
                                    <p class="text-gray-400 text-xs">{{ number_format($attachment['size'] / 1024, 1) }} KB</p>
                                </div>
                                <a href="{{ Storage::url($attachment['path']) }}" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Conversation History -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Histórico de Conversas
            </h3>

            <div class="space-y-6">
                <!-- Initial Message -->
                <div class="flex space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 width=[200px] rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-sm">{{ substr($supportTicket->user->full_name, 0, 2) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-blue-400 font-medium">{{ $supportTicket->user->full_name }}</h4>
                                <span class="text-gray-400 text-sm">{{ $supportTicket->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="text-gray-300 leading-relaxed">
                                {!! nl2br(e($supportTicket->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                @foreach($supportTicket->replies as $reply)
                    <div class="flex space-x-4 {{ $reply->user->role === 'admin' ? 'flex-row-reverse' : '' }}">
                        <div class="w-10 h-10 {{ $reply->user->role === 'admin' ? 'bg-gradient-to-br from-emerald-500 to-teal-600' : 'bg-gradient-to-br from-blue-500 to-purple-600' }} rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ substr($reply->user->full_name, 0, 2) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="{{ $reply->user->role === 'admin' ? 'bg-emerald-500/10 border border-emerald-500/30' : 'bg-blue-500/10 border border-blue-500/30' }} rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <h4 class="{{ $reply->user->role === 'admin' ? 'text-emerald-400' : 'text-blue-400' }} font-medium">
                                            {{ $reply->user->full_name }}
                                        </h4>
                                        @if($reply->user->role === 'admin')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-500/20 text-emerald-400">
                                                Suporte
                                            </span>
                                        @endif
                                        @if($reply->is_internal)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-500/20 text-orange-400">
                                                Interno
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-gray-400 text-sm">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="text-gray-300 leading-relaxed">
                                    {!! nl2br(e($reply->message)) !!}
                                </div>
                                
                                <!-- Reply Attachments -->
                                @if($reply->attachments && count($reply->attachments) > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-600">
                                        <p class="text-gray-400 text-sm mb-2">Anexos:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($reply->attachments as $attachment)
                                                <a href="{{ Storage::url($attachment['path']) }}" target="_blank" 
                                                   class="inline-flex items-center px-3 py-1 bg-gray-700/50 hover:bg-gray-700 text-gray-300 rounded-lg text-sm transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                    </svg>
                                                    {{ $attachment['name'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reply Form -->
        @if($supportTicket->status !== 'fechado')
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Responder Ticket
                </h3>

                <form action="{{ route('admin.support-tickets.reply', $supportTicket) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">
                                Mensagem <span class="text-red-400">*</span>
                            </label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="6"
                                      required
                                      placeholder="Digite sua resposta..."
                                      class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type and Options -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-300 mb-2">
                                    Tipo de Resposta
                                </label>
                                <select name="type" 
                                        id="type"
                                        class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('type') border-red-500 @enderror">
                                    <option value="resposta">Resposta</option>
                                    <option value="pergunta">Pergunta</option>
                                    <option value="atualizacao">Atualização</option>
                                    <option value="resolucao">Resolução</option>
                                </select>
                                @error('type')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_internal" 
                                           value="1"
                                           class="w-4 h-4 text-cyan-600 bg-gray-700 border-gray-600 rounded focus:ring-cyan-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-300">Nota interna</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="resolve_ticket" 
                                           value="1"
                                           id="resolve_ticket"
                                           class="w-4 h-4 text-emerald-600 bg-gray-700 border-gray-600 rounded focus:ring-emerald-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-300">Marcar como resolvido</span>
                                </label>
                            </div>
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
                                   accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt"
                                   class="w-full bg-gray-700/50 border border-gray-600 text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('attachments') border-red-500 @enderror">
                            <p class="text-gray-500 text-sm mt-1">
                                Máximo 10MB por arquivo. Formatos: JPG, PNG, PDF, DOC, TXT
                            </p>
                            @error('attachments')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-4">
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-cyan-500/25">
                                Enviar Resposta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Ticket Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Informações do Ticket</h3>
            
            <div class="space-y-4">
                <!-- Client -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Cliente</h4>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">{{ substr($supportTicket->user->full_name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $supportTicket->user->full_name }}</p>
                            <p class="text-gray-400 text-sm">{{ $supportTicket->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Assigned To -->
                @if($supportTicket->assigned_to)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Atribuído para</h4>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">{{ substr($supportTicket->assignedUser->full_name, 0, 2) }}</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $supportTicket->assignedUser->full_name }}</p>
                                <p class="text-gray-400 text-sm">{{ $supportTicket->assignedUser->email }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Dates -->
                <div>
                    <h4 class="text-gray-400 text-sm font-medium mb-1">Criado em</h4>
                    <p class="text-white">{{ $supportTicket->created_at->format('d/m/Y H:i') }}</p>
                    <p class="text-gray-400 text-sm">{{ $supportTicket->created_at->diffForHumans() }}</p>
                </div>

                @if($supportTicket->first_response_at)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Primeira Resposta</h4>
                        <p class="text-white">{{ $supportTicket->first_response_at->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-400 text-sm">{{ $supportTicket->first_response_at->diffForHumans() }}</p>
                    </div>
                @endif

                @if($supportTicket->last_response_at)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Última Resposta</h4>
                        <p class="text-white">{{ $supportTicket->last_response_at->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-400 text-sm">{{ $supportTicket->last_response_at->diffForHumans() }}</p>
                    </div>
                @endif

                @if($supportTicket->resolved_at)
                    <div>
                        <h4 class="text-gray-400 text-sm font-medium mb-1">Resolvido em</h4>
                        <p class="text-green-400">{{ $supportTicket->resolved_at->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-400 text-sm">{{ $supportTicket->resolved_at->diffForHumans() }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Ações Rápidas</h3>
            
            <div class="space-y-3">
                @if($supportTicket->status !== 'resolvido')
                    <button onclick="markAsResolved()" 
                            class="w-full flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Marcar como Resolvido
                    </button>
                @endif

                @if($supportTicket->status !== 'fechado')
                    <form action="{{ route('admin.support-tickets.close', $supportTicket) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Tem certeza que deseja fechar este ticket?')"
                                class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Fechar Ticket
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.support-tickets.reopen', $supportTicket) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reabrir Ticket
                        </button>
                    </form>
                @endif

                <button onclick="assignTicket()" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Atribuir Ticket
                </button>

                <button onclick="updatePriority()" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 3v10a2 2 0 002 2h6a2 2 0 002-2V7H7zM9 7h6m-3 4l3 3m0 0l-3 3"/>
                    </svg>
                    Alterar Prioridade
                </button>
            </div>
        </div>

        <!-- Related Content -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-bold text-white mb-6">Conteúdo Relacionado</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.support-tickets.index', ['client' => $supportTicket->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Outros Tickets</span>
                        <span class="text-gray-400 text-sm">{{ $supportTicket->user->supportTickets->where('id', '!=', $supportTicket->id)->count() }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.client-projects.index', ['client' => $supportTicket->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Projetos do Cliente</span>
                        <span class="text-gray-400 text-sm">{{ $supportTicket->user->clientProjects->count() }}</span>
                    </div>
                </a>
                
                <a href="{{ route('admin.invoices.index', ['client' => $supportTicket->user_id]) }}" 
                   class="block p-3 bg-gray-700/30 hover:bg-gray-700/50 rounded-xl transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-white">Faturas do Cliente</span>
                        <span class="text-gray-400 text-sm">{{ $supportTicket->user->invoices->count() }}</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Mark as Resolved Modal -->
<div id="markAsResolvedModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-3xl border border-gray-700 p-8 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-white mb-6">Marcar como Resolvido</h3>
        <form action="{{ route('admin.support-tickets.mark-as-resolved', $supportTicket) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="resolution_message" class="block text-sm font-medium text-gray-300 mb-2">
                        Mensagem de Resolução (Opcional)
                    </label>
                    <textarea name="resolution_message" id="resolution_message" rows="4"
                              placeholder="Descreva como o problema foi resolvido..."
                              class="w-full bg-gray-700/50 border border-gray-600 text-white placeholder-gray-400 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-8">
                <button type="button" onclick="closeMarkAsResolvedModal()" 
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-xl transition-all duration-300">
                    Marcar como Resolvido
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Additional modals for assign and priority update would go here... -->

@endsection

@push('scripts')
<script>
function markAsResolved() {
    const modal = document.getElementById('markAsResolvedModal');
    modal.classList.remove('hidden');
}

function closeMarkAsResolvedModal() {
    const modal = document.getElementById('markAsResolvedModal');
    modal.classList.add('hidden');
}

function assignTicket() {
    // Implement assign functionality
    alert('Funcionalidade de atribuição será implementada');
}

function updatePriority() {
    // Implement priority update functionality
    alert('Funcionalidade de atualização de prioridade será implementada');
}

// Close modal when clicking outside
document.getElementById('markAsResolvedModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMarkAsResolvedModal();
    }
});
</script>
@endpush 