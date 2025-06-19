@extends('layouts.admin')

@section('title', '- Novo Cliente')
@section('page-title', 'Novo Cliente')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.clients.index') }}" 
           class="inline-flex items-center text-gray-400 hover:text-white transition-colors">
            <i class="fi fi-rr-angle-left w-5 h-5 mr-2"></i>
            Voltar para Lista de Clientes
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 overflow-hidden">
        <div class="p-6 lg:p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fi fi-rr-user-add text-white text-2xl mt-2"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Adicionar Novo Cliente</h2>
                    <p class="text-gray-400">O cliente receberá um email para completar o cadastro</p>
                </div>
            </div>

            <form action="{{ route('admin.clients.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Essential Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        📋 Informações Essenciais
                    </h3>

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nome Completo *
                        </label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               value="{{ old('full_name') }}" 
                               required
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Ex: João Silva Santos">
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="cliente@exemplo.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-400">
                            <i class="fi fi-rr-info mr-1"></i>
                            O cliente receberá as credenciais neste email
                        </p>
                    </div>
                </div>

                <!-- Optional Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        🏢 Informações Opcionais
                        <span class="text-sm font-normal text-gray-400 ml-2">(Cliente pode preencher depois)</span>
                    </h3>

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nome da Empresa
                        </label>
                        <input type="text" 
                               id="company_name" 
                               name="company_name" 
                               value="{{ old('company_name') }}" 
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Ex: Empresa LTDA">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                            Telefone
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="(11) 99999-9999">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email Configuration -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        📧 Configuração do Email
                    </h3>

                    <!-- Send Credentials -->
                    <div class="flex items-center space-x-3 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                        <input type="checkbox" 
                               id="send_credentials" 
                               name="send_credentials" 
                               value="1" 
                               {{ old('send_credentials', true) ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="send_credentials" class="text-white font-medium">
                            Enviar credenciais por email
                        </label>
                    </div>

                    <div class="bg-gray-900/30 border border-gray-700/50 rounded-xl p-4">
                        <h4 class="text-white font-medium mb-2 flex items-center">
                            <i class="fi fi-rr-info w-4 h-4 mr-2 text-blue-400"></i>
                            O que acontece depois?
                        </h4>
                        <ul class="text-sm text-gray-300 space-y-2">
                            <li class="flex items-start">
                                <i class="fi fi-rr-check text-green-400 w-4 h-4 mr-2 mt-0.5"></i>
                                Uma senha será gerada automaticamente
                            </li>
                            <li class="flex items-start">
                                <i class="fi fi-rr-check text-green-400 w-4 h-4 mr-2 mt-0.5"></i>
                                Cliente receberá email com login e senha
                            </li>
                            <li class="flex items-start">
                                <i class="fi fi-rr-check text-green-400 w-4 h-4 mr-2 mt-0.5"></i>
                                Cliente poderá completar o perfil após login
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-700/50">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center">
                        <i class="fi fi-rr-user-add w-5 h-5 mr-2"></i>
                        Criar Cliente
                    </button>
                    <a href="{{ route('admin.clients.index') }}" 
                       class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center">
                        <i class="fi fi-rr-cross w-5 h-5 mr-2"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Phone mask
    document.getElementById('phone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length <= 11) {
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
        }
        
        e.target.value = value;
    });
</script>
@endpush
@endsection 