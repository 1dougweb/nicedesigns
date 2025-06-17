@extends('layouts.admin')

@section('title', '- Gerenciar Contatos')
@section('page-title', 'Contatos')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Gerenciar Contatos</h2>
        <p class="text-gray-400 mt-1">Visualize e gerencie todas as mensagens de contato recebidas</p>
    </div>
    <div class="flex space-x-4">
        <!-- Filter Buttons -->
        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-blue-600/20 text-blue-400 border border-blue-500/30 rounded-xl text-sm font-medium hover:bg-blue-600/30 transition-colors">
                Todos
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Novos
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Em Andamento
            </button>
            <button class="px-4 py-2 text-gray-400 border border-gray-700/50 rounded-xl text-sm font-medium hover:bg-gray-700/30 transition-colors">
                Concluídos
            </button>
        </div>
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
<div class="bg-green-500/20 border border-green-500/30 text-green-400 px-6 py-4 rounded-2xl mb-6 backdrop-blur-md">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-6 backdrop-blur-md">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
</div>
@endif

<!-- Contacts Table -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 overflow-hidden">
    @if(isset($contacts) && $contacts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Contato</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Assunto</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Status</th>
                        <th class="text-left py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Data</th>
                        <th class="text-right py-6 px-6 text-gray-400 font-medium uppercase tracking-wider text-sm">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr class="border-b border-gray-700/30 hover:bg-gray-700/20 transition-colors duration-200">
                        <td class="py-6 px-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">{{ substr($contact->name, 0, 2) }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-white font-semibold text-lg">{{ $contact->name }}</h3>
                                    <p class="text-gray-400 text-sm">{{ $contact->email }}</p>
                                    @if($contact->phone)
                                        <p class="text-gray-500 text-xs">{{ $contact->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="max-w-xs">
                                <h4 class="text-white font-medium">{{ $contact->subject ?? 'Contato Geral' }}</h4>
                                <p class="text-gray-400 text-sm mt-1">{{ Str::limit($contact->message, 100) }}</p>
                            </div>
                        </td>
                        <td class="py-6 px-6">
                            @if($contact->status === 'new')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                                    Novo
                                </span>
                            @elseif($contact->status === 'in_progress')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                    Em Andamento
                                </span>
                            @elseif($contact->status === 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                    Concluído
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                    <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                    Pendente
                                </span>
                            @endif
                        </td>
                        <td class="py-6 px-6">
                            <div class="text-gray-300">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                            <div class="text-gray-500 text-xs">{{ $contact->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="py-6 px-6">
                            <div class="flex items-center justify-end space-x-2">
                                <button onclick="viewContact({{ $contact->id }})" 
                                   class="p-2 text-gray-400 hover:text-blue-400 hover:bg-blue-500/20 rounded-xl transition-all duration-200"
                                   title="Visualizar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                
                                @if($contact->email)
                                    <a href="mailto:{{ $contact->email }}" 
                                       class="p-2 text-gray-400 hover:text-green-400 hover:bg-green-500/20 rounded-xl transition-all duration-200"
                                       title="Responder por email">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </a>
                                @endif

                                @if($contact->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" 
                                       target="_blank"
                                       class="p-2 text-gray-400 hover:text-green-400 hover:bg-green-500/20 rounded-xl transition-all duration-200"
                                       title="WhatsApp">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </a>
                                @endif

                                <!-- Status Change Dropdown -->
                                <div class="relative">
                                    <button onclick="toggleStatusMenu({{ $contact->id }})"
                                            class="p-2 text-gray-400 hover:text-purple-400 hover:bg-purple-500/20 rounded-xl transition-all duration-200"
                                            title="Alterar Status">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="inline" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este contato?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-xl transition-all duration-200"
                                            title="Excluir">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($contacts->hasPages())
        <div class="px-6 py-6 border-t border-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-gray-400 text-sm">
                    Mostrando {{ $contacts->firstItem() }} a {{ $contacts->lastItem() }} de {{ $contacts->total() }} resultados
                </div>
                <div class="flex space-x-2">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fi fi-rr-envelope-open-text text-gray-400 text-4xl mt-2"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Nenhuma mensagem encontrada</h3>
            <p class="text-gray-400 mb-8">Quando alguém entrar em contato, as mensagens aparecerão aqui.</p>
            <a href="{{ route('contact') }}" 
               target="_blank"
               class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-8 py-4 rounded-2xl font-medium transition-all duration-300 inline-flex items-center space-x-2 shadow-lg hover:shadow-green-500/25">
               <i class="fi fi-rr-link-alt text-white ml-2 justify-center align-middle mt-2"></i>
                <span>Ver Página de Contato</span>
            </a>
        </div>
    @endif
</div>

<!-- Summary Cards -->
@if(isset($contacts) && $contacts->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
    <!-- Total Contacts -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ $contacts->total() ?? 0 }}</p>
                <p class="text-sm text-gray-400">Total de Contatos</p>
            </div>
        </div>
    </div>

    <!-- New Contacts -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 0v4m0-4h4m-4 0H8"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ isset($contacts) ? $contacts->where('status', 'new')->count() : 0 }}</p>
                <p class="text-sm text-gray-400">Novos</p>
            </div>
        </div>
    </div>

    <!-- In Progress -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ isset($contacts) ? $contacts->where('status', 'in_progress')->count() : 0 }}</p>
                <p class="text-sm text-gray-400">Em Andamento</p>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-emerald-600/20 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">{{ isset($contacts) ? $contacts->where('status', 'completed')->count() : 0 }}</p>
                <p class="text-sm text-gray-400">Concluídos</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Contact Detail Modal -->
<div id="contactModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-gray-800 rounded-3xl border border-gray-700/50 max-w-2xl w-full p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-white">Detalhes do Contato</h3>
                <button onclick="closeContactModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="contactModalContent">
                <!-- Contact details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function viewContact(contactId) {
    document.getElementById('contactModal').classList.remove('hidden');
    // Here you would typically load contact details via AJAX
    // For now, showing a placeholder
    document.getElementById('contactModalContent').innerHTML = `
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-400 mx-auto"></div>
            <p class="text-gray-400 mt-4">Carregando detalhes...</p>
        </div>
    `;
}

function closeContactModal() {
    document.getElementById('contactModal').classList.add('hidden');
}

function toggleStatusMenu(contactId) {
    // Implement status change dropdown functionality
    console.log('Toggle status menu for contact:', contactId);
}
</script>
@endsection 