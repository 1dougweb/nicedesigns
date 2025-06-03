@extends('layouts.client')

@section('title', '- Meus Projetos')
@section('page-title', 'Meus Projetos')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600/20 to-purple-600/20 backdrop-blur-md rounded-3xl border border-blue-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Meus Projetos 📂
                </h2>
                <p class="text-gray-300 text-lg">
                    Acompanhe o progresso de todos os seus projetos em desenvolvimento.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="mb-6">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex flex-wrap gap-4">
            <button class="px-4 py-2 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-xl text-sm font-medium hover:bg-blue-600/30 transition-colors">
                Todos (3)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Em Andamento (2)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Concluídos (1)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Pausados (0)
            </button>
        </div>
    </div>
</div>

<!-- Lista de Projetos -->
<div class="space-y-6">
    <!-- Projeto 1 - Em Andamento -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Site Corporativo</h3>
                    <p class="text-gray-400">Desenvolvimento de website institucional com painel administrativo</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-blue-400">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                            Em andamento
                        </span>
                        <span class="text-gray-500">Iniciado em 15/03/2024</span>
                        <span class="text-gray-500">Prazo: 30/06/2024</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-full text-sm font-medium">
                    Em Andamento
                </span>
            </div>
        </div>

        <!-- Progresso -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-300">Progresso do Projeto</span>
                <span class="text-sm font-medium text-blue-400">75%</span>
            </div>
            <div class="w-full bg-gray-700/50 rounded-full h-3">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300" style="width: 75%"></div>
            </div>
        </div>

        <!-- Etapas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="text-center">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-xs text-green-400 font-medium">Design</p>
                <p class="text-xs text-gray-500">Concluído</p>
            </div>
            <div class="text-center">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-xs text-green-400 font-medium">Frontend</p>
                <p class="text-xs text-gray-500">Concluído</p>
            </div>
            <div class="text-center">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2 animate-pulse">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                    </svg>
                </div>
                <p class="text-xs text-blue-400 font-medium">Backend</p>
                <p class="text-xs text-gray-500">Em andamento</p>
            </div>
            <div class="text-center">
                <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 font-medium">Deploy</p>
                <p class="text-xs text-gray-500">Aguardando</p>
            </div>
        </div>

        <!-- Tecnologias -->
        <div class="mb-6">
            <p class="text-sm text-gray-300 mb-2">Tecnologias:</p>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-red-600/20 text-red-400 border border-red-500/30 rounded-full text-xs">Laravel</span>
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-full text-xs">Vue.js</span>
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-xs">MySQL</span>
                <span class="px-3 py-1 bg-purple-600/20 text-purple-400 border border-purple-500/30 rounded-full text-xs">Tailwind CSS</span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                    Ver Detalhes
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Downloads
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Última atualização: há 2 dias
            </div>
        </div>
    </div>

    <!-- Projeto 2 - Em Andamento -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-purple-500/50 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-purple-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">App Mobile</h3>
                    <p class="text-gray-400">Aplicativo móvel para gestão de vendas</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-yellow-400">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                            Aguardando aprovação
                        </span>
                        <span class="text-gray-500">Iniciado em 01/04/2024</span>
                        <span class="text-gray-500">Prazo: 15/07/2024</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 rounded-full text-sm font-medium">
                    Aguardando
                </span>
            </div>
        </div>

        <!-- Progresso -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-300">Progresso do Projeto</span>
                <span class="text-sm font-medium text-purple-400">45%</span>
            </div>
            <div class="w-full bg-gray-700/50 rounded-full h-3">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full transition-all duration-300" style="width: 45%"></div>
            </div>
        </div>

        <!-- Etapas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="text-center">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-xs text-green-400 font-medium">UX/UI</p>
                <p class="text-xs text-gray-500">Concluído</p>
            </div>
            <div class="text-center">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs text-yellow-400 font-medium">Protótipo</p>
                <p class="text-xs text-gray-500">Aprovação</p>
            </div>
            <div class="text-center">
                <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 font-medium">Desenvolvimento</p>
                <p class="text-xs text-gray-500">Aguardando</p>
            </div>
            <div class="text-center">
                <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 font-medium">Testes</p>
                <p class="text-xs text-gray-500">Aguardando</p>
            </div>
        </div>

        <!-- Tecnologias -->
        <div class="mb-6">
            <p class="text-sm text-gray-300 mb-2">Tecnologias:</p>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-full text-xs">React Native</span>
                <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 rounded-full text-xs">Node.js</span>
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-xs">MongoDB</span>
                <span class="px-3 py-1 bg-purple-600/20 text-purple-400 border border-purple-500/30 rounded-full text-xs">Firebase</span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-purple-400 hover:text-purple-300 text-sm font-medium transition-colors">
                    Ver Protótipo
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Dar Feedback
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Última atualização: há 5 dias
            </div>
        </div>
    </div>

    <!-- Projeto 3 - Concluído -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 opacity-80">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Sistema de Login</h3>
                    <p class="text-gray-400">Sistema de autenticação segura e dashboard administrativo</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Concluído
                        </span>
                        <span class="text-gray-500">Concluído em 28/02/2024</span>
                        <span class="text-gray-500">Entregue no prazo</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-sm font-medium">
                    Concluído
                </span>
            </div>
        </div>

        <!-- Progresso -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-300">Progresso do Projeto</span>
                <span class="text-sm font-medium text-green-400">100%</span>
            </div>
            <div class="w-full bg-gray-700/50 rounded-full h-3">
                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-300" style="width: 100%"></div>
            </div>
        </div>

        <!-- Tecnologias -->
        <div class="mb-6">
            <p class="text-sm text-gray-300 mb-2">Tecnologias:</p>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1 bg-red-600/20 text-red-400 border border-red-500/30 rounded-full text-xs">Laravel</span>
                <span class="px-3 py-1 bg-orange-600/20 text-orange-400 border border-orange-500/30 rounded-full text-xs">Bootstrap</span>
                <span class="px-3 py-1 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-full text-xs">MySQL</span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                    Ver Site
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Arquivos Finais
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Entregue há 3 meses
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-bold text-white mb-4">Ações Rápidas</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="flex items-center justify-center p-4 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-xl hover:bg-blue-600/30 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Solicitar Novo Projeto
            </button>
            <button class="flex items-center justify-center p-4 bg-purple-600/20 text-purple-400 border border-purple-500/30 rounded-xl hover:bg-purple-600/30 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Abrir Suporte
            </button>
            <button class="flex items-center justify-center p-4 bg-green-600/20 text-green-400 border border-green-500/30 rounded-xl hover:bg-green-600/30 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Ver Faturas
            </button>
        </div>
    </div>
</div>
@endsection 