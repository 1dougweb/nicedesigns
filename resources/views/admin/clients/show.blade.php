@extends('layouts.admin')

@section('title', '- ' . $client->full_name)
@section('page-title', 'Perfil do Cliente')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.clients.index') }}" 
           class="inline-flex items-center text-gray-400 hover:text-white transition-colors">
            <i class="fi fi-rr-angle-left w-5 h-5 mr-2"></i>
            Voltar para Lista de Clientes
        </a>
    </div>

    <!-- Client Header -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 p-6 lg:p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center space-x-4">
                @if($client->avatar)
                    <img src="{{ asset('storage/' . $client->avatar) }}" 
                         alt="{{ $client->full_name }}" 
                         class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-xl">{{ substr($client->full_name, 0, 2) }}</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $client->full_name }}</h1>
                    <p class="text-gray-400">{{ $client->email }}</p>
                    @if($client->company_name)
                        <p class="text-blue-400">{{ $client->company_name }}</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <!-- Send Password Reset -->
                <form action="{{ route('admin.clients.send-password-reset', $client) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-yellow-600/20 hover:bg-yellow-600/30 text-yellow-400 px-4 py-2 rounded-xl border border-yellow-500/30 transition-colors"
                            onclick="return confirm('Enviar link de redefinição de senha para {{ $client->full_name }}?')">
                        <i class="fi fi-rr-lock w-4 h-4 mr-2"></i>
                        Resetar Senha
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Client Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fi fi-rr-user w-5 h-5 mr-2"></i>
                Informações Pessoais
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-400">Nome Completo</label>
                    <p class="text-white font-medium">{{ $client->full_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-400">Email</label>
                    <p class="text-white font-medium">{{ $client->email }}</p>
                </div>
                @if($client->person_type)
                    <div>
                        <label class="text-sm text-gray-400">Tipo de Pessoa</label>
                        <p class="text-white font-medium">
                            {{ $client->person_type === 'fisica' ? 'Pessoa Física' : 'Pessoa Jurídica' }}
                        </p>
                    </div>
                @endif
                @if($client->document)
                    <div>
                        <label class="text-sm text-gray-400">{{ $client->person_type === 'fisica' ? 'CPF' : 'CNPJ' }}</label>
                        <p class="text-white font-medium">{{ $client->formatted_document }}</p>
                    </div>
                @endif
                @if($client->phone)
                    <div>
                        <label class="text-sm text-gray-400">Telefone</label>
                        <p class="text-white font-medium">{{ $client->formatted_phone }}</p>
                    </div>
                @endif
                @if($client->whatsapp)
                    <div>
                        <label class="text-sm text-gray-400">WhatsApp</label>
                        <p class="text-white font-medium">{{ $client->whatsapp }}</p>
                    </div>
                @endif
                @if($client->company_name)
                    <div>
                        <label class="text-sm text-gray-400">Empresa</label>
                        <p class="text-white font-medium">{{ $client->company_name }}</p>
                    </div>
                @endif
                @if($client->position)
                    <div>
                        <label class="text-sm text-gray-400">Cargo/Posição</label>
                        <p class="text-white font-medium">{{ $client->position }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Account Information -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fi fi-rr-settings w-5 h-5 mr-2"></i>
                Informações da Conta
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-400">Data de Cadastro</label>
                    <p class="text-white font-medium">{{ $client->created_at->format('d/m/Y \à\s H:i') }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-400">Status</label>
                    <p class="text-white font-medium">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Ativo
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-sm text-gray-400">Email Verificado</label>
                    <p class="text-white font-medium">
                        @if($client->email_verified_at)
                            <span class="text-green-400">✓ Verificado</span>
                        @else
                            <span class="text-red-400">✗ Não verificado</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Address Information -->
        @if($client->address || $client->city || $client->state)
            <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <i class="fi fi-rr-map-marker w-5 h-5 mr-2"></i>
                    Endereço
                </h3>
                <div class="space-y-4">
                    @if($client->zip_code)
                        <div>
                            <label class="text-sm text-gray-400">CEP</label>
                            <p class="text-white font-medium">{{ $client->zip_code }}</p>
                        </div>
                    @endif
                    @if($client->full_address)
                        <div>
                            <label class="text-sm text-gray-400">Endereço Completo</label>
                            <p class="text-white font-medium">{{ $client->full_address }}</p>
                        </div>
                    @endif
                    @if($client->neighborhood)
                        <div>
                            <label class="text-sm text-gray-400">Bairro</label>
                            <p class="text-white font-medium">{{ $client->neighborhood }}</p>
                        </div>
                    @endif
                    @if($client->city && $client->state)
                        <div>
                            <label class="text-sm text-gray-400">Cidade/Estado</label>
                            <p class="text-white font-medium">{{ $client->city }} - {{ $client->state }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Profile Completion -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fi fi-rr-chart-line-up w-5 h-5 mr-2"></i>
                Completude do Perfil
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-400">Progresso</span>
                        <span class="text-sm font-medium text-white">{{ $client->getProfileCompletionPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $client->getProfileCompletionPercentage() }}%"></div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @if($client->isProfileComplete())
                        <i class="fi fi-rr-check-circle text-green-400 text-lg"></i>
                        <span class="text-green-400 font-medium">Perfil Completo</span>
                    @else
                        <i class="fi fi-rr-exclamation-circle text-yellow-400 text-lg"></i>
                        <span class="text-yellow-400 font-medium">Perfil Incompleto</span>
                    @endif
                </div>
                @if($client->profile_completed_at)
                    <div>
                        <label class="text-sm text-gray-400">Completado em</label>
                        <p class="text-white font-medium">{{ $client->profile_completed_at->format('d/m/Y \à\s H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    @if($client->bio)
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fi fi-rr-document w-5 h-5 mr-2"></i>
                Observações
            </h3>
            <div class="prose prose-invert max-w-none">
                <p class="text-gray-300 leading-relaxed">{{ $client->bio }}</p>
            </div>
        </div>
    @endif
</div>
@endsection 