@extends('layouts.client')

@section('title', '- Minhas Faturas')
@section('page-title', 'Minhas Faturas')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-purple-600/20 to-pink-600/20 backdrop-blur-md rounded-3xl border border-purple-500/30 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">
                    Minhas Faturas 🧾
                </h2>
                <p class="text-gray-300 text-lg">
                    Gerencie suas faturas, pagamentos e histórico financeiro.
                </p>
            </div>
            <div class="hidden lg:block">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Faturas -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-purple-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-white">5</p>
                <p class="text-sm text-gray-400">Total de Faturas</p>
            </div>
            <div class="w-12 h-12 bg-purple-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pagas -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-green-400">4</p>
                <p class="text-sm text-gray-400">Pagas</p>
            </div>
            <div class="w-12 h-12 bg-green-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Pendentes -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-yellow-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-3xl font-bold text-yellow-400">1</p>
                <p class="text-sm text-gray-400">Pendentes</p>
            </div>
            <div class="w-12 h-12 bg-yellow-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Valor -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-blue-500/50 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-2xl font-bold text-blue-400">R$ 12.500</p>
                <p class="text-sm text-gray-400">Total Pago</p>
            </div>
            <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="mb-6">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex flex-wrap gap-4">
            <button class="px-4 py-2 bg-purple-600/20 text-purple-400 border border-purple-500/30 rounded-xl text-sm font-medium hover:bg-purple-600/30 transition-colors">
                Todas (5)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Pagas (4)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Pendentes (1)
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Vencidas (0)
            </button>
        </div>
    </div>
</div>

<!-- Lista de Faturas -->
<div class="space-y-6">
    <!-- Fatura Pendente -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-yellow-500/30 p-6 hover:border-yellow-500/50 transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-yellow-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#INV-2024-005</h3>
                    <p class="text-gray-400">Site Corporativo - 2ª Parcela</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-yellow-400">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                            Pendente
                        </span>
                        <span class="text-gray-500">Vence em 15/06/2024</span>
                        <span class="text-gray-500">5 dias restantes</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-yellow-400">R$ 2.500</p>
                <span class="px-3 py-1 bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 rounded-full text-sm font-medium">
                    Pendente
                </span>
            </div>
        </div>

        <!-- Detalhes da Fatura -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-sm">
            <div>
                <p class="text-gray-400">Data de Emissão:</p>
                <p class="text-white font-medium">16/05/2024</p>
            </div>
            <div>
                <p class="text-gray-400">Data de Vencimento:</p>
                <p class="text-white font-medium">15/06/2024</p>
            </div>
            <div>
                <p class="text-gray-400">Método de Pagamento:</p>
                <p class="text-white font-medium">PIX / Boleto</p>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="px-4 py-2 bg-yellow-600/20 text-yellow-400 border border-yellow-500/30 rounded-xl text-sm font-medium hover:bg-yellow-600/30 transition-colors">
                    Pagar Agora
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Download PDF
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Enviar por Email
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Criada há 20 dias
            </div>
        </div>
    </div>

    <!-- Fatura Paga 1 -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 opacity-90">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#INV-2024-004</h3>
                    <p class="text-gray-400">Site Corporativo - 1ª Parcela</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Paga
                        </span>
                        <span class="text-gray-500">Paga em 12/04/2024</span>
                        <span class="text-green-400">PIX</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-green-400">R$ 2.500</p>
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-sm font-medium">
                    Paga
                </span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                    Ver Comprovante
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Download PDF
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Paga há 2 meses
            </div>
        </div>
    </div>

    <!-- Fatura Paga 2 -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 opacity-90">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#INV-2024-003</h3>
                    <p class="text-gray-400">App Mobile - Sinal</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Paga
                        </span>
                        <span class="text-gray-500">Paga em 05/04/2024</span>
                        <span class="text-green-400">Transferência</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-green-400">R$ 3.000</p>
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-sm font-medium">
                    Paga
                </span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                    Ver Comprovante
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Download PDF
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Paga há 2 meses
            </div>
        </div>
    </div>

    <!-- Fatura Paga 3 -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 opacity-90">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#INV-2024-002</h3>
                    <p class="text-gray-400">Sistema de Login - Final</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Paga
                        </span>
                        <span class="text-gray-500">Paga em 28/02/2024</span>
                        <span class="text-green-400">PIX</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-green-400">R$ 2.500</p>
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-sm font-medium">
                    Paga
                </span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                    Ver Comprovante
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Download PDF
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Paga há 4 meses
            </div>
        </div>
    </div>

    <!-- Fatura Paga 4 -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6 hover:border-green-500/50 transition-all duration-300 opacity-90">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-600/20 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">#INV-2024-001</h3>
                    <p class="text-gray-400">Sistema de Login - Sinal</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm">
                        <span class="flex items-center text-green-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                            Paga
                        </span>
                        <span class="text-gray-500">Paga em 15/01/2024</span>
                        <span class="text-green-400">Boleto</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-green-400">R$ 2.000</p>
                <span class="px-3 py-1 bg-green-600/20 text-green-400 border border-green-500/30 rounded-full text-sm font-medium">
                    Paga
                </span>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors">
                    Ver Comprovante
                </button>
                <button class="text-gray-400 hover:text-white text-sm font-medium transition-colors">
                    Download PDF
                </button>
            </div>
            <div class="text-sm text-gray-400">
                Paga há 5 meses
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <h3 class="text-lg font-bold text-white mb-4">Informações Financeiras</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Resumo Financeiro -->
            <div class="bg-gray-700/30 rounded-2xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Resumo dos Pagamentos
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total Pago:</span>
                        <span class="text-green-400 font-medium">R$ 10.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Pendente:</span>
                        <span class="text-yellow-400 font-medium">R$ 2.500</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-600 pt-3">
                        <span class="text-white font-medium">Total Geral:</span>
                        <span class="text-white font-bold">R$ 12.500</span>
                    </div>
                </div>
            </div>

            <!-- Métodos de Pagamento -->
            <div class="bg-gray-700/30 rounded-2xl p-6">
                <h4 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Métodos Aceitos
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600/20 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <span class="text-gray-300">PIX - Instantâneo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600/20 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-gray-300">Boleto Bancário</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-600/20 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                        <span class="text-gray-300">Transferência Bancária</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 