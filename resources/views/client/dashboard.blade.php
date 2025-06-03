@extends('layouts.client')

@section('title', '- Área do Cliente')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-green-600/20 to-blue-600/20 backdrop-blur-md rounded-3xl border border-green-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Bem-vindo, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-gray-300 text-lg">
                    Aqui você pode acompanhar seus projetos e gerenciar sua conta.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Projetos Ativos -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">3</p>
                <p class="text-sm text-gray-400">Projetos</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                2 em andamento
            </span>
            <span class="text-gray-500">1 concluído</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.projects') }}" class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                Ver Projetos →
            </a>
        </div>
    </div>

    <!-- Faturas -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">5</p>
                <p class="text-sm text-gray-400">Faturas</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                4 pagas
            </span>
            <span class="text-yellow-400">1 pendente</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.invoices') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                Ver Faturas →
            </a>
        </div>
    </div>

    <!-- Suporte -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-purple-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">2</p>
                <p class="text-sm text-gray-400">Tickets</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="flex items-center text-yellow-400">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                1 aberto
            </span>
            <span class="text-green-400">1 resolvido</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.support') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium transition-colors">
                Ver Suporte →
            </a>
        </div>
    </div>

    <!-- Próximo Pagamento -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white">R$ 2.500</p>
                <p class="text-sm text-gray-400">Próximo</p>
            </div>
        </div>
        <div class="flex items-center justify-between text-sm">
            <span class="text-gray-300">Vencimento:</span>
            <span class="text-yellow-400">15/06/2025</span>
        </div>
        <div class="mt-4">
            <a href="{{ route('client.invoices') }}" class="text-yellow-400 hover:text-yellow-300 text-sm font-medium transition-colors">
                Ver Detalhes →
            </a>
        </div>
    </div>
</div>

<!-- Projetos Recentes & Atividades -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Projetos em Andamento -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Projetos em Andamento
        </h3>
        <div class="space-y-4">
            <!-- Projeto 1 -->
            <div class="flex items-center p-4 bg-gray-700/30 rounded-2xl hover:bg-gray-700/50 transition-colors">
                <div class="w-12 h-12 bg-blue-600/20 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold">Site Corporativo</h4>
                    <p class="text-gray-400 text-sm">Desenvolvimento em andamento</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-600 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">75% concluído</p>
                    </div>
                </div>
                <span class="text-blue-400 text-sm font-medium">Em andamento</span>
            </div>

            <!-- Projeto 2 -->
            <div class="flex items-center p-4 bg-gray-700/30 rounded-2xl hover:bg-gray-700/50 transition-colors">
                <div class="w-12 h-12 bg-purple-600/20 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-semibold">App Mobile</h4>
                    <p class="text-gray-400 text-sm">Design em aprovação</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-600 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">45% concluído</p>
                    </div>
                </div>
                <span class="text-yellow-400 text-sm font-medium">Aguardando</span>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('client.projects') }}" class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                Ver Todos os Projetos →
            </a>
        </div>
    </div>

    <!-- Atividades Recentes -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Atividades Recentes
        </h3>
        <div class="space-y-4">
            <!-- Atividade 1 -->
            <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-green-600/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium">Projeto Site Corporativo atualizado</p>
                    <p class="text-gray-400 text-sm">Nova versão do design aprovada</p>
                    <p class="text-gray-500 text-xs mt-1">Há 2 horas</p>
                </div>
            </div>

            <!-- Atividade 2 -->
            <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-blue-600/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium">Nova fatura gerada</p>
                    <p class="text-gray-400 text-sm">Fatura #2025-006 - R$ 2.500,00</p>
                    <p class="text-gray-500 text-xs mt-1">Ontem</p>
                </div>
            </div>

            <!-- Atividade 3 -->
            <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-purple-600/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium">Ticket de suporte respondido</p>
                    <p class="text-gray-400 text-sm">Dúvida sobre hospedagem esclarecida</p>
                    <p class="text-gray-500 text-xs mt-1">2 dias atrás</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
        <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>
        Ações Rápidas
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('client.support') }}" class="flex flex-col items-center p-4 bg-blue-600/20 rounded-2xl hover:bg-blue-600/30 transition-all duration-300 group border border-blue-500/30">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-white">Abrir Ticket</span>
        </a>

        <a href="{{ route('client.invoices') }}" class="flex flex-col items-center p-4 bg-green-600/20 rounded-2xl hover:bg-green-600/30 transition-all duration-300 group border border-green-500/30">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-white">Ver Faturas</span>
        </a>

        <a href="{{ route('client.profile') }}" class="flex flex-col items-center p-4 bg-purple-600/20 rounded-2xl hover:bg-purple-600/30 transition-all duration-300 group border border-purple-500/30">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-white">Meu Perfil</span>
        </a>

        <a href="{{ route('home') }}" target="_blank" class="flex flex-col items-center p-4 bg-yellow-600/20 rounded-2xl hover:bg-yellow-600/30 transition-all duration-300 group border border-yellow-500/30">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-white">Ver Site</span>
        </a>
    </div>
</div>

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