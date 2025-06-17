@extends('layouts.admin')

@section('title', '- AbacatePay')
@section('page-title', 'Configurações do AbacatePay')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Configurações do AbacatePay</h2>
        <p class="text-gray-400 mt-1">Configure a integração com o gateway de pagamentos</p>
    </div>
    <a href="{{ route('admin.settings.index') }}#abacatepay-tab" 
       class="bg-gray-600/20 text-gray-300 border border-gray-600/30 hover:bg-gray-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
        <i class="fi fi-rr-arrow-left text-lg"></i>
        <span>Voltar</span>
    </a>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 bg-green-500/20 border border-green-500/30 text-green-300 px-6 py-4 rounded-2xl flex items-center">
    <i class="fi fi-rr-check-circle text-xl mr-3"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl flex items-center">
    <i class="fi fi-rr-cross-circle text-xl mr-3"></i>
    {{ session('error') }}
</div>
@endif

<!-- Form Container -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
        <i class="fi fi-rr-credit-card text-emerald-400 text-2xl mr-3"></i>
        Configurações do AbacatePay
    </h3>

    <form action="{{ route('admin.settings.abacatepay.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Token -->
            <div>
                <label for="token" class="block text-sm font-medium text-gray-300 mb-2">Token da API</label>
                <input
                    type="password"
                    id="token"
                    name="token"
                    value="{{ old('token', $settings['token'] ?? '') }}"
                    class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    placeholder="Digite o token da API"
                />
                <p class="mt-2 text-sm text-gray-400">
                    Token de acesso à API do AbacatePay. Encontre no painel do AbacatePay em Configurações > API Keys.
                </p>
                @error('token')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Webhook Secret -->
            <div>
                <label for="webhook_secret" class="block text-sm font-medium text-gray-300 mb-2">Webhook Secret</label>
                <input
                    type="password"
                    id="webhook_secret"
                    name="webhook_secret"
                    value="{{ old('webhook_secret', $settings['webhook_secret'] ?? '') }}"
                    class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    placeholder="Digite o webhook secret"
                />
                <p class="mt-2 text-sm text-gray-400">
                    Chave secreta para validação dos webhooks. Encontre no painel do AbacatePay em Configurações > Webhooks.
                </p>
                @error('webhook_secret')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ambiente -->
            <div class="md:col-span-2">
                <label for="environment" class="block text-sm font-medium text-gray-300 mb-2">Ambiente</label>
                <select
                    id="environment"
                    name="environment"
                    class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                >
                    <option value="sandbox" {{ (old('environment', $settings['environment'] ?? '') == 'sandbox') ? 'selected' : '' }}>Sandbox (Testes)</option>
                    <option value="production" {{ (old('environment', $settings['environment'] ?? '') == 'production') ? 'selected' : '' }}>Produção</option>
                </select>
                <p class="mt-2 text-sm text-gray-400">
                    Escolha o ambiente de operação. Use Sandbox para testes e Produção para ambiente real.
                </p>
                @error('environment')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex items-center justify-end space-x-4 mt-8">
            <a href="{{ route('admin.settings.abacatepay.test') }}"
               class="bg-yellow-600/20 text-yellow-300 border border-yellow-600/30 hover:bg-yellow-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
                <i class="fi fi-rr-refresh text-xl"></i>
                <span>Testar Conexão</span>
            </a>

            <button type="submit"
                    class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
                <i class="fi fi-rr-check text-xl"></i>
                <span>Salvar Configurações</span>
            </button>
        </div>
    </form>
</div>
@endsection 