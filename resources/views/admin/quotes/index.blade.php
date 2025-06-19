@extends('layouts.admin')

@section('title', 'Orçamentos')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Orçamentos</h1>
            <p class="text-gray-400">Gerencie propostas de orçamento para clientes</p>
        </div>
        <a href="{{ route('admin.quotes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center w-fit">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Novo Orçamento
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Pendentes</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Aceitos</p>
                    <p class="text-2xl font-bold text-green-400">{{ $stats['accepted'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Rejeitados</p>
                    <p class="text-2xl font-bold text-red-400">{{ $stats['rejected'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Expirados</p>
                    <p class="text-2xl font-bold text-gray-400">{{ $stats['expired'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6 mb-8">
        <form method="GET" action="{{ route('admin.quotes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Título do orçamento ou cliente..." 
                       class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="status" id="status" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos os Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Client Filter -->
            <div>
                <label for="client" class="block text-sm font-medium text-gray-300 mb-2">Cliente</label>
                <select name="client" id="client" class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Todos os Clientes</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-medium transition-colors">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Quotes Table -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="text-left py-4 px-6 font-medium text-gray-300">Orçamento</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-300">Cliente</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-300">Valor</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-300">Status</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-300">Data</th>
                        <th class="text-right py-4 px-6 font-medium text-gray-300">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        <tr class="border-t border-gray-700/50 hover:bg-gray-700/30 transition-colors">
                            <!-- Quote Info -->
                            <td class="py-4 px-6">
                                <div>
                                    <h3 class="text-white font-medium">{{ $quote->title }}</h3>
                                    <p class="text-gray-400 text-sm">{{ Str::limit($quote->description, 50) }}</p>
                                    @if($quote->valid_until)
                                        <p class="text-xs text-gray-500 mt-1">
                                            Válido até {{ $quote->valid_until->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            <!-- Client -->
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-bold text-sm">{{ substr($quote->user->full_name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $quote->user->full_name }}</p>
                                        <p class="text-gray-400 text-sm">{{ $quote->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Value -->
                            <td class="py-4 px-6">
                                <div>
                                    <p class="text-white font-semibold">{{ $quote->formatted_total_amount }}</p>
                                    @if($quote->discount_amount || $quote->discount_percentage)
                                        <p class="text-gray-400 text-sm line-through">{{ $quote->formatted_budget }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $quote->status_color }}-500/20 text-{{ $quote->status_color }}-400 border border-{{ $quote->status_color }}-500/30">
                                    {{ $quote->status_label }}
                                </span>
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-6">
                                <p class="text-gray-300">{{ $quote->created_at->format('d/m/Y') }}</p>
                                <p class="text-gray-500 text-sm">{{ $quote->created_at->diffForHumans() }}</p>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.quotes.show', $quote) }}" class="text-blue-400 hover:text-blue-300 p-2 rounded-lg hover:bg-blue-600/20 transition-colors" title="Ver detalhes">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.quotes.edit', $quote) }}" class="text-yellow-400 hover:text-yellow-300 p-2 rounded-lg hover:bg-yellow-600/20 transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.quotes.duplicate', $quote) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-400 hover:text-green-300 p-2 rounded-lg hover:bg-green-600/20 transition-colors" title="Duplicar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @if($quote->status !== 'aceito' && !$quote->clientProjects()->exists())
                                        <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este orçamento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 p-2 rounded-lg hover:bg-red-600/20 transition-colors" title="Excluir">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="text-xl font-medium text-white mb-2">Nenhum orçamento encontrado</h3>
                                    <p class="text-gray-400 mb-4">Não há orçamentos que correspondem aos filtros aplicados.</p>
                                    <a href="{{ route('admin.quotes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                                        Criar Primeiro Orçamento
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($quotes->hasPages())
            <div class="px-6 py-4 border-t border-gray-700/50">
                {{ $quotes->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 