@extends('layouts.admin')

@section('title', '- Editar Cliente')
@section('page-title', 'Editar Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.clients.show', $client) }}" 
           class="inline-flex items-center text-gray-400 hover:text-white transition-colors">
            <i class="fi fi-rr-angle-left w-5 h-5 mr-2"></i>
            Voltar para Perfil do Cliente
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-2xl lg:rounded-3xl border border-gray-700/50 overflow-hidden">
        <div class="p-6 lg:p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fi fi-rr-edit text-white text-2xl mt-2"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Editar Cliente</h2>
                    <p class="text-gray-400">Atualize os dados do cliente {{ $client->full_name }}</p>
                </div>
            </div>

            <form action="{{ route('admin.clients.update', $client) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Personal Information Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        📋 Informações Pessoais
                    </h3>

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-300 mb-2">
                            Nome Completo *
                        </label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               value="{{ old('full_name', $client->full_name) }}" 
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
                               value="{{ old('email', $client->email) }}" 
                               required
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="cliente@exemplo.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Person Type and Document -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="person_type" class="block text-sm font-medium text-gray-300 mb-2">
                                Tipo de Pessoa *
                            </label>
                            <select id="person_type" 
                                    name="person_type" 
                                    required
                                    onchange="updateDocumentField()"
                                    class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Selecione...</option>
                                <option value="fisica" {{ old('person_type', $client->person_type) === 'fisica' ? 'selected' : '' }}>Pessoa Física</option>
                                <option value="juridica" {{ old('person_type', $client->person_type) === 'juridica' ? 'selected' : '' }}>Pessoa Jurídica</option>
                            </select>
                            @error('person_type')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="document" class="block text-sm font-medium text-gray-300 mb-2">
                                <span id="document_label">CPF/CNPJ *</span>
                            </label>
                            <input type="text" 
                                   id="document" 
                                   name="document" 
                                   value="{{ old('document', $client->formatted_document) }}" 
                                   required
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="000.000.000-00">
                            @error('document')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone and WhatsApp -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                                Telefone *
                            </label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $client->phone) }}" 
                                   required
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="(11) 99999-9999">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-300 mb-2">
                                WhatsApp
                            </label>
                            <input type="text" 
                                   id="whatsapp" 
                                   name="whatsapp" 
                                   value="{{ old('whatsapp', $client->whatsapp) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="(11) 99999-9999">
                            @error('whatsapp')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Company Information Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        🏢 Informações Profissionais
                    </h3>

                    <!-- Company Name and Position -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">
                                Nome da Empresa
                            </label>
                            <input type="text" 
                                   id="company_name" 
                                   name="company_name" 
                                   value="{{ old('company_name', $client->company_name) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Empresa LTDA">
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-300 mb-2">
                                Cargo/Posição
                            </label>
                            <input type="text" 
                                   id="position" 
                                   name="position" 
                                   value="{{ old('position', $client->position) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ex: Diretor, Gerente">
                            @error('position')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        📍 Endereço
                    </h3>

                    <!-- CEP and Address -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="zip_code" class="block text-sm font-medium text-gray-300 mb-2">
                                CEP
                            </label>
                            <input type="text" 
                                   id="zip_code" 
                                   name="zip_code" 
                                   value="{{ old('zip_code', $client->zip_code) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="00000-000">
                            @error('zip_code')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-300 mb-2">
                                Endereço
                            </label>
                            <input type="text" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address', $client->address) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Rua, Avenida...">
                            @error('address')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Number, Complement, Neighborhood -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="address_number" class="block text-sm font-medium text-gray-300 mb-2">
                                Número
                            </label>
                            <input type="text" 
                                   id="address_number" 
                                   name="address_number" 
                                   value="{{ old('address_number', $client->address_number) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="123">
                            @error('address_number')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address_complement" class="block text-sm font-medium text-gray-300 mb-2">
                                Complemento
                            </label>
                            <input type="text" 
                                   id="address_complement" 
                                   name="address_complement" 
                                   value="{{ old('address_complement', $client->address_complement) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Apto, Sala...">
                            @error('address_complement')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="neighborhood" class="block text-sm font-medium text-gray-300 mb-2">
                                Bairro
                            </label>
                            <input type="text" 
                                   id="neighborhood" 
                                   name="neighborhood" 
                                   value="{{ old('neighborhood', $client->neighborhood) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Centro">
                            @error('neighborhood')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- City, State, Country -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-300 mb-2">
                                Cidade
                            </label>
                            <input type="text" 
                                   id="city" 
                                   name="city" 
                                   value="{{ old('city', $client->city) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="São Paulo">
                            @error('city')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-300 mb-2">
                                Estado
                            </label>
                            <input type="text" 
                                   id="state" 
                                   name="state" 
                                   value="{{ old('state', $client->state) }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="SP">
                            @error('state')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-300 mb-2">
                                País
                            </label>
                            <input type="text" 
                                   id="country" 
                                   name="country" 
                                   value="{{ old('country', $client->country ?? 'Brasil') }}" 
                                   class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Brasil">
                            @error('country')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-gray-700/50 pb-2">
                        📝 Informações Adicionais
                    </h3>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">
                            Biografia/Observações
                        </label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="3"
                                  class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                  placeholder="Informações adicionais sobre o cliente...">{{ old('bio', $client->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                            Status da Conta *
                        </label>
                        <select id="status" 
                                name="status" 
                                required
                                class="w-full px-4 py-3 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="inactive" {{ old('status', 'active') === 'inactive' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-700/50">
                    <button type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-colors flex items-center justify-center">
                        <i class="fi fi-rr-check w-5 h-5 mr-2"></i>
                        Salvar Alterações
                    </button>
                    <a href="{{ route('admin.clients.show', $client) }}" 
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
    // Phone masks
    function applyPhoneMask(element) {
        element.addEventListener('input', function(e) {
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
    }

    // CEP mask
    document.getElementById('zip_code').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    });

    // Document field update
    function updateDocumentField() {
        const personType = document.getElementById('person_type').value;
        const documentField = document.getElementById('document');
        const documentLabel = document.getElementById('document_label');

        if (personType === 'fisica') {
            documentLabel.textContent = 'CPF *';
            documentField.placeholder = '000.000.000-00';
            documentField.maxLength = 14;
        } else if (personType === 'juridica') {
            documentLabel.textContent = 'CNPJ *';
            documentField.placeholder = '00.000.000/0000-00';
            documentField.maxLength = 18;
        } else {
            documentLabel.textContent = 'CPF/CNPJ *';
            documentField.placeholder = '000.000.000-00';
            documentField.maxLength = 18;
        }
    }

    // Document masks
    document.getElementById('document').addEventListener('input', function(e) {
        const personType = document.getElementById('person_type').value;
        let value = e.target.value.replace(/\D/g, '');

        if (personType === 'fisica') {
            // CPF mask: 000.000.000-00
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})/, '$1-$2');
        } else if (personType === 'juridica') {
            // CNPJ mask: 00.000.000/0000-00
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1/$2');
            value = value.replace(/(\d{4})(\d{1,2})/, '$1-$2');
        }

        e.target.value = value;
    });

    // Apply phone masks
    applyPhoneMask(document.getElementById('phone'));
    applyPhoneMask(document.getElementById('whatsapp'));

    // Initialize document field
    updateDocumentField();
</script>
@endpush
@endsection 