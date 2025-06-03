@extends('layouts.client')

@section('title', '- Meu Perfil')
@section('page-title', 'Meu Perfil')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-pink-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl border border-pink-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Meu Perfil 👤
                </h2>
                <p class="text-gray-300 text-lg">
                    Gerencie suas informações pessoais e configurações da conta.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Avatar e Info Básica -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-4xl">{{ substr(auth()->user()->name, 0, 2) }}</span>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ auth()->user()->name }}</h3>
            <p class="text-gray-400 mb-4">{{ auth()->user()->email }}</p>
            <span class="px-4 py-2 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-sm font-medium">
                Cliente Ativo
            </span>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-700/50">
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Membro desde:</span>
                    <span class="text-white">Janeiro 2024</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Projetos:</span>
                    <span class="text-white">3 ativos</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Último acesso:</span>
                    <span class="text-white">Hoje, 14:30</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Estatísticas Rápidas -->
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Projetos -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">3</p>
                    <p class="text-sm text-gray-400">Projetos</p>
                </div>
            </div>
            <div class="text-blue-400 text-sm font-medium">2 em andamento</div>
        </div>

        <!-- Faturas -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-purple-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">5</p>
                    <p class="text-sm text-gray-400">Faturas</p>
                </div>
            </div>
            <div class="text-purple-400 text-sm font-medium">R$ 12.500 total</div>
        </div>

        <!-- Tickets -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">8</p>
                    <p class="text-sm text-gray-400">Tickets</p>
                </div>
            </div>
            <div class="text-yellow-400 text-sm font-medium">2 abertos</div>
        </div>

        <!-- Satisfação -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white">98%</p>
                    <p class="text-sm text-gray-400">Satisfação</p>
                </div>
            </div>
            <div class="text-green-400 text-sm font-medium">Excelente avaliação</div>
        </div>
    </div>
</div>

<!-- Formulário de Edição -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Informações Pessoais -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Informações Pessoais
        </h3>

        <form class="space-y-6">
            <!-- Nome -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Nome Completo</label>
                <input type="text" value="{{ auth()->user()->name }}" 
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20 transition-all">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" 
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20 transition-all">
            </div>

            <!-- Telefone -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Telefone</label>
                <input type="tel" placeholder="(11) 99999-9999" 
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20 transition-all">
            </div>

            <!-- Empresa -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Empresa</label>
                <input type="text" placeholder="Nome da sua empresa" 
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-pink-500/50 focus:ring-2 focus:ring-pink-500/20 transition-all">
            </div>

            <!-- Botão Salvar -->
            <button type="submit" 
                    class="w-full px-6 py-3 bg-pink-600/20 text-pink-400 border border-pink-500/30 rounded-xl font-medium hover:bg-pink-600/30 transition-colors">
                Salvar Alterações
            </button>
        </form>
    </div>

    <!-- Segurança e Configurações -->
    <div class="space-y-8">
        <!-- Alterar Senha -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Alterar Senha
            </h3>

            <form class="space-y-4">
                <!-- Senha Atual -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Senha Atual</label>
                    <input type="password" placeholder="Digite sua senha atual" 
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-red-500/50 focus:ring-2 focus:ring-red-500/20 transition-all">
                </div>

                <!-- Nova Senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nova Senha</label>
                    <input type="password" placeholder="Digite sua nova senha" 
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-red-500/50 focus:ring-2 focus:ring-red-500/20 transition-all">
                </div>

                <!-- Confirmar Senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Confirmar Nova Senha</label>
                    <input type="password" placeholder="Confirme sua nova senha" 
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-red-500/50 focus:ring-2 focus:ring-red-500/20 transition-all">
                </div>

                <!-- Botão Alterar -->
                <button type="submit" 
                        class="w-full px-6 py-3 bg-red-600/20 text-red-400 border border-red-500/30 rounded-xl font-medium hover:bg-red-600/30 transition-colors">
                    Alterar Senha
                </button>
            </form>
        </div>

        <!-- Preferências -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Preferências de Notificação
            </h3>

            <div class="space-y-4">
                <!-- Email Notifications -->
                <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                    <div>
                        <h4 class="text-white font-medium">Notificações por Email</h4>
                        <p class="text-gray-400 text-sm">Receber updates de projetos e faturas</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- SMS Notifications -->
                <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                    <div>
                        <h4 class="text-white font-medium">Notificações SMS</h4>
                        <p class="text-gray-400 text-sm">Alertas urgentes por SMS</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <!-- Weekly Reports -->
                <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                    <div>
                        <h4 class="text-white font-medium">Relatórios Semanais</h4>
                        <p class="text-gray-400 text-sm">Resumo semanal de atividades</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ações Avançadas -->
<div class="mt-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-bold text-white mb-4">Ações da Conta</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Download Dados -->
            <button class="flex items-center justify-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-xl hover:bg-blue-600/30 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 4V5a3 3 0 016 0z"/>
                </svg>
                Baixar Meus Dados
            </button>

            <!-- Exportar Relatórios -->
            <button class="flex items-center justify-center p-4 bg-green-600/20 text-green-400 border border-green-500/30 rounded-xl hover:bg-green-600/30 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Exportar Relatórios
            </button>

            <!-- Suporte -->
            <button class="flex items-center justify-center p-4 bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 rounded-xl hover:bg-yellow-600/30 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Contatar Suporte
            </button>
        </div>
    </div>
</div>
@endsection 