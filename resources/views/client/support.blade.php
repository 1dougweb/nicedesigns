@extends('layouts.client')

@section('title', '- Suporte')
@section('page-title', 'Suporte')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-yellow-600/20 to-orange-600/20 backdrop-blur-md rounded-3xl border border-yellow-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Suporte Técnico 🎧
                </h2>
                <p class="text-gray-300 text-lg">
                    Abra tickets, tire dúvidas e acompanhe o andamento do seu suporte.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Tickets -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-white">8</p>
                <p class="text-sm text-gray-400">Total de Tickets</p>
            </div>
            <div class="w-12 h-12 bg-yellow-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Abertos -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-red-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-red-400">2</p>
                <p class="text-sm text-gray-400">Abertos</p>
            </div>
            <div class="w-12 h-12 bg-red-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Em Andamento -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-blue-400">1</p>
                <p class="text-sm text-gray-400">Em Andamento</p>
            </div>
            <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Resolvidos -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-green-400">5</p>
                <p class="text-sm text-gray-400">Resolvidos</p>
            </div>
            <div class="w-12 h-12 bg-green-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Novo Ticket -->
<div class="mb-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-white flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Abrir Novo Ticket
            </h3>
            <button class="px-6 py-3 bg-green-600/20 text-green-400 border border-green-500/30 rounded-xl font-medium hover:bg-green-600/30 transition-colors">
                Novo Ticket
            </button>
        </div>
        <p class="text-gray-400">
            Precisa de ajuda? Abra um ticket e nossa equipe irá te atender o mais breve possível.
        </p>
    </div>
</div>

<!-- Filtros -->
<div class="mb-6">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex flex-wrap gap-4">
            <button class="px-4 py-2 bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 rounded-xl text-sm font-medium hover:bg-yellow-600/30 transition-colors">
                Todos (8)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Abertos (2)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Em Andamento (1)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Resolvidos (5)
            </button>
        </div>
    </div>
</div>

<!-- Lista de Tickets -->
<div class="space-y-6">
    <!-- Ticket Aberto - Urgente -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-red-500/30 p-6 hover:border-red-500/50 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-start space-x-4">
                <div class="w-16 h-16 bg-red-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#TICKET-2024-008</h3>
                    <p class="text-gray-400">Site fora do ar - Erro 500</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-red-400">
                            <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
                            Urgente
                        </span>
                        <span class="text-gray-500">Aberto há 2 horas</span>
                        <span class="text-gray-500">Técnico</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-red-600/20 text-red-400 border border-red-500/30 rounded-full text-sm font-medium">
                    Urgente
                </span>
            </div>
        </div>

        <!-- Descrição -->
        <div class="mb-4 p-4 bg-gray-700/30 rounded-2xl">
            <p class="text-gray-300 text-sm">
                O site está apresentando erro 500 desde hoje de manhã. Os usuários não conseguem acessar a área administrativa. Preciso de ajuda urgente para resolver este problema.
            </p>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">
                    Ver Detalhes
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Adicionar Comentário
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Última atualização: há 1 hora
            </div>
        </div>
    </div>

    <!-- Ticket Aberto - Normal -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-orange-500/30 p-6 hover:border-orange-500/50 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-start space-x-4">
                <div class="w-16 h-16 bg-orange-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#TICKET-2024-007</h3>
                    <p class="text-gray-400">Dúvida sobre funcionalidade</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-orange-400">
                            <span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>
                            Normal
                        </span>
                        <span class="text-gray-500">Aberto há 1 dia</span>
                        <span class="text-gray-500">Suporte</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-orange-600/20 text-orange-400 border border-orange-500/30 rounded-full text-sm font-medium">
                    Normal
                </span>
            </div>
        </div>

        <!-- Descrição -->
        <div class="mb-4 p-4 bg-gray-700/30 rounded-2xl">
            <p class="text-gray-300 text-sm">
                Gostaria de entender como funciona o sistema de relatórios. É possível exportar dados personalizados?
            </p>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-orange-400 hover:text-orange-300 text-sm font-medium transition-colors">
                    Ver Detalhes
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Adicionar Comentário
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Última atualização: há 6 horas
            </div>
        </div>
    </div>

    <!-- Ticket Em Andamento -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-blue-500/30 p-6 hover:border-blue-500/50 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-start space-x-4">
                <div class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#TICKET-2024-006</h3>
                    <p class="text-gray-400">Solicitação de nova funcionalidade</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-blue-400">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                            Em andamento
                        </span>
                        <span class="text-gray-500">Aberto há 3 dias</span>
                        <span class="text-gray-500">Desenvolvimento</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-full text-sm font-medium">
                    Em Andamento
                </span>
            </div>
        </div>

        <!-- Descrição -->
        <div class="mb-4 p-4 bg-gray-700/30 rounded-2xl">
            <p class="text-gray-300 text-sm">
                Gostaria de solicitar a implementação de um sistema de notificações por email quando novos pedidos chegarem.
            </p>
        </div>

        <!-- Progresso -->
        <div class="mb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-300">Progresso</span>
                <span class="text-sm font-medium text-blue-400">65%</span>
            </div>
            <div class="w-full bg-gray-700/50 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full" style="width: 65%"></div>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                    Ver Progresso
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Comentários (3)
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Última atualização: há 4 horas
            </div>
        </div>
    </div>

    <!-- Tickets Resolvidos (Condensados) -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 opacity-75">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Tickets Resolvidos Recentes
        </h3>
        
        <div class="space-y-3">
            <!-- Ticket Resolvido 1 -->
            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">#TICKET-2024-005</p>
                        <p class="text-gray-400 text-sm">Problema com login</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-lg text-xs">
                        Resolvido
                    </span>
                    <p class="text-gray-500 text-xs mt-1">há 2 dias</p>
                </div>
            </div>

            <!-- Ticket Resolvido 2 -->
            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">#TICKET-2024-004</p>
                        <p class="text-gray-400 text-sm">Alteração de dados</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-lg text-xs">
                        Resolvido
                    </span>
                    <p class="text-gray-500 text-xs mt-1">há 1 semana</p>
                </div>
            </div>

            <!-- Ticket Resolvido 3 -->
            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-600/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-medium">#TICKET-2024-003</p>
                        <p class="text-gray-400 text-sm">Dúvida sobre backup</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-lg text-xs">
                        Resolvido
                    </span>
                    <p class="text-gray-500 text-xs mt-1">há 2 semanas</p>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                Ver Todos os Tickets Resolvidos →
            </button>
        </div>
    </div>
</div>

<!-- Informações de Suporte -->
<div class="mt-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-bold text-white mb-4">Informações de Suporte</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Horários de Atendimento -->
            <div class="bg-gray-700/30 rounded-2xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Horários de Atendimento
                </h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Segunda a Sexta:</span>
                        <span class="text-white">8h às 18h</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Sábado:</span>
                        <span class="text-white">8h às 12h</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Domingo:</span>
                        <span class="text-gray-500">Fechado</span>
                    </div>
                    <div class="mt-4 p-3 bg-green-600/20 border border-green-500/30 rounded-xl">
                        <p class="text-green-400 text-sm font-medium">🟢 Estamos Online</p>
                        <p class="text-gray-300 text-xs">Tempo médio de resposta: 2-4 horas</p>
                    </div>
                </div>
            </div>

            <!-- Contatos de Emergência -->
            <div class="bg-gray-700/30 rounded-2xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Suporte de Emergência
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-600/20 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">(11) 9999-9999</p>
                            <p class="text-gray-400 text-sm">WhatsApp 24h</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600/20 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">suporte@nicedesigns.com.br</p>
                            <p class="text-gray-400 text-sm">Email prioritário</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 