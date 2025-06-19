@extends('layouts.admin')

@section('title', '- Gerenciar Clientes')
@section('page-title', 'Gerenciar Clientes')

@section('content')
<!-- Header with Statistics -->
<div class="mb-6 lg:mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
        <!-- Total Clients -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fi fi-rr-users text-white text-2xl mt-2"></i>
                </div>
                <div class="text-right">
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-400">Total de Clientes</p>
                </div>
            </div>
        </div>

        <!-- New This Month -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 p-4 sm:p-6">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i class="fi fi-rr-user-add text-white text-2xl mt-2"></i>
                </div>
                <div class="text-right">
                    <p class="text-2xl sm:text-3xl font-bold text-white">{{ $stats['new_this_month'] }}</p>
                    <p class="text-sm text-gray-400">Novos este Mês</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions Bar -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div class="flex flex-col sm:flex-row gap-3">
        <!-- Search -->
        <form method="GET" class="flex-1 sm:max-w-md">
            <div class="relative">
                <i class="fi fi-rr-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
                <input type="text" 
                       name="search" 
                       placeholder="Buscar clientes..." 
                       value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-3 bg-gray-800/50 border border-gray-700/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </form>
    </div>

    <!-- Add Client Button -->
    <a href="{{ route('admin.clients.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center">
        <i class="fi fi-rr-plus w-5 h-5 mr-2"></i>
        Adicionar Cliente
    </a>
</div>

<!-- Clients List -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 overflow-hidden">
    @if($clients->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">Cliente</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium hidden md:table-cell">Email</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium hidden lg:table-cell">Empresa</th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium hidden sm:table-cell">Cadastrado</th>
                        <th class="text-right py-4 px-6 text-gray-300 font-medium">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @foreach($clients as $client)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    @if($client->avatar)
                                        <img src="{{ asset('storage/' . $client->avatar) }}" 
                                             alt="{{ $client->full_name }}" 
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($client->full_name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white font-medium">{{ $client->full_name }}</p>
                                        @if($client->phone)
                                            <p class="text-gray-400 text-sm">{{ $client->formatted_phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 hidden md:table-cell">
                                <span class="text-gray-300">{{ $client->email }}</span>
                            </td>
                            <td class="py-4 px-6 hidden lg:table-cell">
                                <span class="text-gray-300">{{ $client->company_name ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-6 hidden sm:table-cell">
                                <span class="text-gray-400 text-sm">{{ $client->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Send Password Reset -->
                                    <form action="{{ route('admin.clients.send-password-reset', $client) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="p-2 text-yellow-400 hover:text-yellow-300 hover:bg-yellow-600/20 rounded-lg transition-colors"
                                                title="Enviar link de redefinição de senha"
                                                onclick="return confirm('Enviar link de redefinição de senha para {{ $client->full_name }}?')">
                                            <i class="fi fi-rr-lock w-4 h-4"></i>
                                        </button>
                                    </form>

                                    <!-- View Client Profile -->
                                    <a href="{{ route('admin.clients.show', $client) }}" 
                                       class="p-2 text-blue-400 hover:text-blue-300 hover:bg-blue-600/20 rounded-lg transition-colors"
                                       title="Ver perfil do cliente">
                                        <i class="fi fi-rr-eye w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($clients->hasPages())
            <div class="px-6 py-4 border-t border-gray-700/50">
                {{ $clients->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-700/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fi fi-rr-users text-gray-500 text-3xl mt-2"></i>
            </div>
            <h3 class="text-lg font-medium text-white mb-2">Nenhum cliente encontrado</h3>
            <p class="text-gray-400 mb-6">
                @if(request('search'))
                    Nenhum cliente corresponde aos critérios de busca.
                @else
                    Comece adicionando seu primeiro cliente.
                @endif
            </p>
            @if(!request('search'))
                <a href="{{ route('admin.clients.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">
                    <i class="fi fi-rr-plus w-5 h-5 mr-2"></i>
                    Adicionar Primeiro Cliente
                </a>
            @else
                <a href="{{ route('admin.clients.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition-colors">
                    Limpar Busca
                </a>
            @endif
        </div>
    @endif
</div>
@endsection 