@extends('layouts.client')

@section('title', '- Meu Perfil')
@section('page-title', 'Meu Perfil')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="bg-gradient-to-r from-purple-600/20 to-pink-600/20 backdrop-blur-md rounded-3xl border border-purple-500/30 p-8">
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
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" 
                         alt="Avatar" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-purple-500/30">
                @else
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ substr($user->display_name, 0, 2) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Avatar Upload Section -->
<div class="mb-8">
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Foto do Perfil
        </h3>
        
        <div class="flex flex-col md:flex-row items-center gap-8">
            <!-- Current Avatar -->
            <div class="flex-shrink-0">
                <div class="relative">
                    @if($user->avatar)
                        <img src="{{ $user->avatar_url }}" 
                             alt="Avatar atual" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-purple-500/30"
                             id="current-avatar">
                    @else
                        <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center border-4 border-purple-500/30" id="current-avatar">
                            <span class="text-white text-3xl font-bold">{{ substr($user->display_name, 0, 2) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Upload Form -->
            <div class="flex-1 w-full">
                <form id="avatar-form" method="POST" action="{{ route('client.profile.upload-avatar') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-300 mb-2">
                            Escolher nova foto de perfil
                        </label>
                        
                        <!-- Mobile Camera Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 mb-4 md:hidden">
                            <button type="button" 
                                    id="camera-avatar-btn"
                                    class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-4 py-3 rounded-xl font-medium transition-all duration-300 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Tirar Selfie
                            </button>
                        </div>
                        
                        <input type="file" 
                               name="avatar" 
                               id="avatar" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-purple-600 file:text-white hover:file:bg-purple-700 transition-colors @error('avatar') border-red-500 @enderror">
                        @error('avatar')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-400 text-sm mt-2">
                            Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB
                            <span class="block md:hidden text-green-400 mt-1">💡 Use o botão "Tirar Selfie" para foto com a câmera</span>
                        </p>
                    </div>
                    
                    <!-- Preview area -->
                    <div id="preview-container" class="hidden">
                        <img id="preview-image" class="w-32 h-32 rounded-full object-cover border-4 border-purple-500/30 mb-4" alt="Preview">
                        <div class="flex gap-3">
                            <button type="submit" 
                                    id="upload-btn"
                                    class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                                <span id="upload-text">Salvar Nova Foto</span>
                                <svg id="upload-loading" class="hidden w-5 h-5 ml-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </button>
                            <button type="button" 
                                    id="cancel-upload"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Remove Avatar Button -->
                @if($user->avatar)
                    <form method="POST" action="{{ route('client.profile.remove-avatar') }}" class="mt-4" 
                          onsubmit="return confirm('Tem certeza que deseja remover sua foto de perfil?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-medium transition-colors text-sm">
                            Remover Foto
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="mb-6 bg-green-500/20 border border-green-500/30 rounded-2xl p-4">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-green-300 font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="mb-6 bg-red-500/20 border border-red-500/30 rounded-2xl p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-red-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-red-300 font-medium mb-2">Existem erros no formulário:</h4>
                <ul class="text-red-200 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Form -->
    <div class="lg:col-span-2">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informações Pessoais
            </h3>

            <form method="POST" action="{{ route('client.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-300 mb-2">Nome Completo *</label>
                        <input type="text" name="full_name" id="full_name" 
                               value="{{ old('full_name', $user->full_name) }}"
                               class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('full_name') border-red-500 @enderror"
                               placeholder="Seu nome completo" required>
                        @error('full_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-mail *</label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="seu@email.com" required>
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Person Type and Document -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Person Type -->
                    <div>
                        <label for="person_type" class="block text-sm font-medium text-gray-300 mb-2">Tipo de Pessoa *</label>
                        <select name="person_type" id="person_type" 
                                class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('person_type') border-red-500 @enderror"
                                required>
                            <option value="">Selecione...</option>
                            <option value="fisica" {{ old('person_type', $user->person_type) === 'fisica' ? 'selected' : '' }}>
                                Pessoa Física
                            </option>
                            <option value="juridica" {{ old('person_type', $user->person_type) === 'juridica' ? 'selected' : '' }}>
                                Pessoa Jurídica
                            </option>
                        </select>
                        @error('person_type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Document -->
                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-300 mb-2">
                            <span id="document-label">CPF/CNPJ</span> *
                        </label>
                        <div class="relative">
                            <input type="text" name="document" id="document" 
                                   value="{{ old('document', $user->formatted_document) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12 @error('document') border-red-500 @enderror"
                                   placeholder="000.000.000-00" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <div id="document-status" class="hidden">
                                    <svg class="w-5 h-5 text-green-400" id="document-valid" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <svg class="w-5 h-5 text-red-400" id="document-invalid" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <p id="document-message" class="text-sm mt-1 hidden"></p>
                        @error('document')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Telefone *</label>
                        <input type="text" name="phone" id="phone" 
                               value="{{ old('phone', $user->formatted_phone) }}"
                               class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="(00) 00000-0000" required>
                        @error('phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-medium text-gray-300 mb-2">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" 
                               value="{{ old('whatsapp', $user->whatsapp) }}"
                               class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('whatsapp') border-red-500 @enderror"
                               placeholder="(00) 00000-0000">
                        @error('whatsapp')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Information -->
                <div class="border-t border-gray-700/50 pt-6">
                    <h4 class="text-lg font-semibold text-white mb-4">Endereço</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- ZIP Code -->
                        <div>
                            <label for="zip_code" class="block text-sm font-medium text-gray-300 mb-2">CEP</label>
                            <input type="text" name="zip_code" id="zip_code" 
                                   value="{{ old('zip_code', $user->zip_code) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('zip_code') border-red-500 @enderror"
                                   placeholder="00000-000">
                            @error('zip_code')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Endereço</label>
                            <input type="text" name="address" id="address" 
                                   value="{{ old('address', $user->address) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                                   placeholder="Rua, Avenida...">
                            @error('address')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <!-- Number -->
                        <div>
                            <label for="address_number" class="block text-sm font-medium text-gray-300 mb-2">Número</label>
                            <input type="text" name="address_number" id="address_number" 
                                   value="{{ old('address_number', $user->address_number) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address_number') border-red-500 @enderror"
                                   placeholder="123">
                            @error('address_number')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Complement -->
                        <div>
                            <label for="address_complement" class="block text-sm font-medium text-gray-300 mb-2">Complemento</label>
                            <input type="text" name="address_complement" id="address_complement" 
                                   value="{{ old('address_complement', $user->address_complement) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address_complement') border-red-500 @enderror"
                                   placeholder="Apto, Sala...">
                            @error('address_complement')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Neighborhood -->
                        <div class="md:col-span-2">
                            <label for="neighborhood" class="block text-sm font-medium text-gray-300 mb-2">Bairro</label>
                            <input type="text" name="neighborhood" id="neighborhood" 
                                   value="{{ old('neighborhood', $user->neighborhood) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('neighborhood') border-red-500 @enderror"
                                   placeholder="Nome do bairro">
                            @error('neighborhood')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-300 mb-2">Cidade</label>
                            <input type="text" name="city" id="city" 
                                   value="{{ old('city', $user->city) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('city') border-red-500 @enderror"
                                   placeholder="Nome da cidade">
                            @error('city')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-300 mb-2">Estado</label>
                            <input type="text" name="state" id="state" 
                                   value="{{ old('state', $user->state) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('state') border-red-500 @enderror"
                                   placeholder="SP" maxlength="2">
                            @error('state')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-300 mb-2">País</label>
                            <input type="text" name="country" id="country" 
                                   value="{{ old('country', $user->country ?? 'Brasil') }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('country') border-red-500 @enderror"
                                   placeholder="Brasil">
                            @error('country')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Company Information (for juridica) -->
                <div id="company-fields" class="border-t border-gray-700/50 pt-6 {{ old('person_type', $user->person_type) !== 'juridica' ? 'hidden' : '' }}">
                    <h4 class="text-lg font-semibold text-white mb-4">Informações da Empresa</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">Nome da Empresa</label>
                            <input type="text" name="company_name" id="company_name" 
                                   value="{{ old('company_name', $user->company_name) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_name') border-red-500 @enderror"
                                   placeholder="Nome da empresa">
                            @error('company_name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-300 mb-2">Cargo</label>
                            <input type="text" name="position" id="position" 
                                   value="{{ old('position', $user->position) }}"
                                   class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('position') border-red-500 @enderror"
                                   placeholder="Seu cargo na empresa">
                            @error('position')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <div class="border-t border-gray-700/50 pt-6">
                    <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Biografia</label>
                    <textarea name="bio" id="bio" rows="4" 
                              class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                              placeholder="Conte um pouco sobre você...">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Atualizar Perfil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Password Change -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Alterar Senha
            </h3>

            <form method="POST" action="{{ route('client.profile.password') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Senha Atual</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                           required>
                    @error('current_password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Nova Senha</label>
                    <input type="password" name="password" id="password" 
                           class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           required>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirmar Nova Senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full bg-gray-700/50 border border-gray-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-xl font-medium transition-colors">
                    Alterar Senha
                </button>
            </form>
        </div>

        <!-- Profile Completion -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center">
                @php
                    $isComplete = $user->isProfileComplete();
                    $completionPercentage = $user->getProfileCompletionPercentage();
                @endphp
                
                @if($completionPercentage >= 90)
                    <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @elseif($completionPercentage >= 50)
                    <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
                Completude do Perfil
            </h3>
            
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-300 mb-2">
                    <span>Progresso</span>
                    <span class="font-semibold {{ $completionPercentage >= 90 ? 'text-green-400' : ($completionPercentage >= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                        {{ $completionPercentage }}%
                    </span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div class="h-4 rounded-full transition-all duration-700 ease-out {{ $completionPercentage >= 90 ? 'bg-gradient-to-r from-green-500 to-emerald-400' : ($completionPercentage >= 50 ? 'bg-gradient-to-r from-yellow-500 to-orange-400' : 'bg-gradient-to-r from-red-500 to-pink-500') }}" 
                        style="width: {{ $completionPercentage }}%">
                        <div class="h-full bg-gradient-to-r from-white/20 to-transparent animate-pulse"></div>
                    </div>
                </div>
            </div>
            
            @if($isComplete)
                <div class="bg-green-500/10 border border-green-500/30 rounded-xl p-3 mb-3">
                    <div class="text-green-400 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Perfil completo!</span>
                    </div>
                    <p class="text-green-300 text-xs mt-1 ml-6">
                        Todas as informações essenciais foram preenchidas.
                    </p>
                </div>
            @else
                <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-3 mb-3">
                    <div class="text-yellow-400 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="font-medium">Perfil incompleto</span>
                    </div>
                    <p class="text-yellow-300 text-xs mt-1 ml-6">
                        Complete seu perfil para melhor atendimento.
                    </p>
                </div>
            @endif
            
            @php
                $missingFields = [];
                if (empty($user->full_name)) $missingFields[] = 'Nome completo';
                if (empty($user->document)) $missingFields[] = 'CPF/CNPJ';
                if (empty($user->phone)) $missingFields[] = 'Telefone';
                if (empty($user->city) && empty($user->address)) $missingFields[] = 'Localização';
                
                $extraPoints = [];
                if (!empty($user->whatsapp)) $extraPoints[] = 'WhatsApp';
                if (!empty($user->bio)) $extraPoints[] = 'Biografia';
                if (!empty($user->address_number)) $extraPoints[] = 'Endereço completo';
                if ($user->avatar) $extraPoints[] = 'Foto de perfil';
            @endphp
            
            @if(count($missingFields) > 0)
                <div class="text-xs text-gray-400 mb-3">
                    <div class="font-medium text-gray-300 mb-1">📋 Campos faltantes:</div>
                    <ul class="space-y-1">
                        @foreach($missingFields as $field)
                            <li class="flex items-center">
                                <span class="w-1 h-1 bg-red-400 rounded-full mr-2"></span>
                                {{ $field }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(count($extraPoints) > 0)
                <div class="text-xs text-gray-400">
                    <div class="font-medium text-gray-300 mb-1">✨ Extras preenchidos:</div>
                    <ul class="space-y-1">
                        @foreach($extraPoints as $point)
                            <li class="flex items-center">
                                <span class="w-1 h-1 bg-green-400 rounded-full mr-2"></span>
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Person type change handler
    const personTypeSelect = document.getElementById('person_type');
    const companyFields = document.getElementById('company-fields');
    const documentInput = document.getElementById('document');
    const documentLabel = document.getElementById('document-label');
    
    function updateDocumentField(clearValue = false) {
        const personType = personTypeSelect.value;
        
        console.log('Updating document field, personType:', personType, 'clearValue:', clearValue);
        
        if (personType === 'fisica') {
            documentLabel.textContent = 'CPF';
            documentInput.placeholder = '000.000.000-00';
            companyFields.classList.add('hidden');
        } else if (personType === 'juridica') {
            documentLabel.textContent = 'CNPJ';
            documentInput.placeholder = '00.000.000/0000-00';
            companyFields.classList.remove('hidden');
        } else {
            documentLabel.textContent = 'CPF/CNPJ';
            documentInput.placeholder = '000.000.000-00';
            companyFields.classList.add('hidden');
        }
        
        // Only clear the value when explicitly requested (when user changes person type)
        if (clearValue) {
            console.log('Clearing document input value');
            documentInput.value = '';
        } else {
            console.log('Preserving document input value:', documentInput.value);
        }
        hideDocumentStatus();
    }
    
    personTypeSelect.addEventListener('change', function() {
        updateDocumentField(true); // Clear value when person type changes
    });
    
    // Document validation
    let documentTimeout;
    
    function hideDocumentStatus() {
        document.getElementById('document-status').classList.add('hidden');
        document.getElementById('document-valid').classList.add('hidden');
        document.getElementById('document-invalid').classList.add('hidden');
        document.getElementById('document-message').classList.add('hidden');
    }
    
    function showDocumentStatus(isValid, message) {
        const statusDiv = document.getElementById('document-status');
        const validIcon = document.getElementById('document-valid');
        const invalidIcon = document.getElementById('document-invalid');
        const messageP = document.getElementById('document-message');
        
        statusDiv.classList.remove('hidden');
        
        if (isValid) {
            validIcon.classList.remove('hidden');
            invalidIcon.classList.add('hidden');
            messageP.className = 'text-green-400 text-sm mt-1';
        } else {
            validIcon.classList.add('hidden');
            invalidIcon.classList.remove('hidden');
            messageP.className = 'text-red-400 text-sm mt-1';
        }
        
        messageP.textContent = message;
        messageP.classList.remove('hidden');
    }
    
    documentInput.addEventListener('input', function() {
        clearTimeout(documentTimeout);
        hideDocumentStatus();
        
        const value = this.value.replace(/\D/g, '');
        const personType = personTypeSelect.value;
        
        if (!personType || value.length < 11) return;
        
        // Apply mask
        if (personType === 'fisica') {
            this.value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        } else if (personType === 'juridica') {
            this.value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
        }
        
        // Validate after delay
        documentTimeout = setTimeout(() => {
            validateDocument(value, personType);
        }, 500);
    });
    
    function validateDocument(document, personType) {
        axios.post('{{ route("client.profile.validate-document") }}', {
            document: document,
            person_type: personType
        })
        .then(response => {
            showDocumentStatus(response.data.valid, response.data.message);
        })
        .catch(error => {
            console.error('Error validating document:', error);
        });
    }
    
    // Phone masks
    function applyPhoneMask(input) {
        input.addEventListener('input', function() {
            const value = this.value.replace(/\D/g, '');
            
            if (value.length <= 10) {
                this.value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else {
                this.value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
        });
    }
    
    applyPhoneMask(document.getElementById('phone'));
    applyPhoneMask(document.getElementById('whatsapp'));
    
    // CEP mask
    document.getElementById('zip_code').addEventListener('input', function() {
        const value = this.value.replace(/\D/g, '');
        this.value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
    });
    
    // State uppercase
    document.getElementById('state').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
    
    // Initialize masks on page load (without clearing the document value)
    updateDocumentField(false);
    
    // Avatar upload preview functionality
    const avatarInput = document.getElementById('avatar');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const cancelUploadBtn = document.getElementById('cancel-upload');
    const avatarForm = document.getElementById('avatar-form');
    const uploadBtn = document.getElementById('upload-btn');
    const uploadText = document.getElementById('upload-text');
    const uploadLoading = document.getElementById('upload-loading');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Por favor, selecione um arquivo de imagem válido (JPG, PNG, GIF).');
                    this.value = '';
                    return;
                }
                
                // Validate file size (2MB = 2048KB)
                if (file.size > 2048 * 1024) {
                    alert('O arquivo deve ter no máximo 2MB.');
                    this.value = '';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });
        
        // Cancel upload
        if (cancelUploadBtn) {
            cancelUploadBtn.addEventListener('click', function() {
                avatarInput.value = '';
                previewContainer.classList.add('hidden');
            });
        }
        
        // Handle form submission
        if (avatarForm) {
            avatarForm.addEventListener('submit', function() {
                if (uploadBtn && uploadText && uploadLoading) {
                    uploadBtn.disabled = true;
                    uploadText.textContent = 'Enviando...';
                    uploadLoading.classList.remove('hidden');
                }
            });
        }
    }
    
    // ====== CAMERA FUNCTIONALITY ======
    
    // Camera modal and functionality
    function createCameraModal() {
        const modal = document.createElement('div');
        modal.id = 'camera-modal';
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 hidden';
        modal.innerHTML = `
            <div class="relative w-full h-full max-w-md max-h-screen bg-gray-900 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="absolute top-0 left-0 right-0 z-10 bg-gradient-to-b from-black/80 to-transparent p-4">
                    <div class="flex items-center justify-between text-white">
                        <h3 id="camera-title" class="text-lg font-semibold">📱 Câmera</h3>
                        <button id="close-camera" class="p-2 hover:bg-white/20 rounded-full transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Camera preview -->
                <video id="camera-video" class="w-full h-full object-cover" autoplay playsinline></video>
                <canvas id="camera-canvas" class="hidden"></canvas>
                
                <!-- Overlay for document (only shown when capturing document) -->
                <div id="document-overlay" class="absolute inset-0 pointer-events-none hidden">
                    <div class="absolute inset-4 border-2 border-white/50 rounded-lg">
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-center">
                            <div class="bg-black/60 rounded-lg p-3">
                                <p class="text-sm">📄 Posicione o documento dentro da moldura</p>
                                <p class="text-xs mt-1 opacity-80">Certifique-se que está bem iluminado e legível</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom controls -->
                <div class="absolute bottom-0 left-0 right-0 z-10 bg-gradient-to-t from-black/80 to-transparent p-6">
                    <div class="flex items-center justify-center space-x-8">
                        <!-- Switch camera (front/back) -->
                        <button id="switch-camera" class="p-3 bg-white/20 rounded-full text-white hover:bg-white/30 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                        
                        <!-- Capture button -->
                        <button id="capture-photo" class="w-20 h-20 bg-white rounded-full border-4 border-gray-300 hover:border-gray-400 transition-colors relative overflow-hidden">
                            <div class="absolute inset-2 bg-white rounded-full shadow-inner"></div>
                        </button>
                        
                        <!-- Flashlight toggle -->
                        <button id="toggle-flash" class="p-3 bg-white/20 rounded-full text-white hover:bg-white/30 transition-colors hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="mt-4 text-center">
                        <p class="text-white text-sm opacity-80" id="camera-instructions">
                            Toque no botão central para capturar
                        </p>
                    </div>
                </div>
                
                <!-- Photo preview after capture -->
                <div id="photo-preview" class="absolute inset-0 bg-black hidden">
                    <img id="captured-image" class="w-full h-full object-contain">
                    <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
                        <div class="flex items-center justify-center space-x-4">
                            <button id="retake-photo" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition-colors">
                                🔄 Tirar Nova
                            </button>
                            <button id="use-photo" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-colors">
                                ✅ Usar Esta Foto
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Loading indicator -->
                <div id="camera-loading" class="absolute inset-0 bg-black/60 flex items-center justify-center hidden">
                    <div class="text-center text-white">
                        <div class="w-12 h-12 border-4 border-white/30 border-t-white rounded-full animate-spin mx-auto mb-4"></div>
                        <p>Processando...</p>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        return modal;
    }
    
    // Camera variables
    let cameraModal = null;
    let currentStream = null;
    let currentCameraType = 'user'; // 'user' for front, 'environment' for back
    let currentCaptureMode = 'avatar'; // 'avatar' or 'document'
    
    // Camera functionality
    async function openCamera(mode = 'avatar') {
        currentCaptureMode = mode;
        
        // Create modal if it doesn't exist
        if (!cameraModal) {
            cameraModal = createCameraModal();
            setupCameraEvents();
        }
        
        // Update UI based on mode
        const title = document.getElementById('camera-title');
        const overlay = document.getElementById('document-overlay');
        const instructions = document.getElementById('camera-instructions');
        
        if (mode === 'document') {
            title.textContent = '📄 Fotografar Documento';
            overlay.classList.remove('hidden');
            instructions.textContent = 'Posicione o documento na moldura e toque para capturar';
            currentCameraType = 'environment'; // Start with back camera for documents
        } else {
            title.textContent = '🤳 Tirar Selfie';
            overlay.classList.add('hidden');
            instructions.textContent = 'Posicione o rosto no centro e toque para capturar';
            currentCameraType = 'user'; // Start with front camera for selfies
        }
        
        // Show modal
        cameraModal.classList.remove('hidden');
        
        // Start camera
        await startCamera();
    }
    
    async function startCamera() {
        try {
            // Stop current stream
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }
            
            const video = document.getElementById('camera-video');
            const constraints = {
                video: { 
                    facingMode: currentCameraType,
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            };
            
            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            video.srcObject = currentStream;
            
            // Check if device has flashlight
            const track = currentStream.getVideoTracks()[0];
            const capabilities = track.getCapabilities();
            const flashButton = document.getElementById('toggle-flash');
            
            if (capabilities.torch) {
                flashButton.classList.remove('hidden');
            } else {
                flashButton.classList.add('hidden');
            }
            
        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('Não foi possível acessar a câmera. Verifique se você deu permissão para o site acessar a câmera.');
            closeCamera();
        }
    }
    
    function setupCameraEvents() {
        const modal = cameraModal;
        const video = document.getElementById('camera-video');
        const canvas = document.getElementById('camera-canvas');
        const capturedImage = document.getElementById('captured-image');
        const photoPreview = document.getElementById('photo-preview');
        const loading = document.getElementById('camera-loading');
        
        // Close camera
        document.getElementById('close-camera').addEventListener('click', closeCamera);
        
        // Switch camera
        document.getElementById('switch-camera').addEventListener('click', async () => {
            currentCameraType = currentCameraType === 'user' ? 'environment' : 'user';
            await startCamera();
        });
        
        // Capture photo
        document.getElementById('capture-photo').addEventListener('click', () => {
            capturePhoto();
        });
        
        // Retake photo
        document.getElementById('retake-photo').addEventListener('click', () => {
            photoPreview.classList.add('hidden');
            video.style.display = 'block';
        });
        
        // Use photo
        document.getElementById('use-photo').addEventListener('click', () => {
            usePhoto();
        });
        
        // Flash toggle
        document.getElementById('toggle-flash').addEventListener('click', toggleFlash);
        
        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeCamera();
            }
        });
    }
    
    function capturePhoto() {
        const video = document.getElementById('camera-video');
        const canvas = document.getElementById('camera-canvas');
        const capturedImage = document.getElementById('captured-image');
        const photoPreview = document.getElementById('photo-preview');
        
        // Set canvas dimensions to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);
        
        // Get image data
        const imageDataUrl = canvas.toDataURL('image/jpeg', 0.8);
        
        // Show preview
        capturedImage.src = imageDataUrl;
        video.style.display = 'none';
        photoPreview.classList.remove('hidden');
    }
    
    async function usePhoto() {
        const canvas = document.getElementById('camera-canvas');
        const loading = document.getElementById('camera-loading');
        
        loading.classList.remove('hidden');
        
        try {
            // Convert canvas to blob
            const blob = await new Promise(resolve => {
                canvas.toBlob(resolve, 'image/jpeg', 0.8);
            });
            
            if (currentCaptureMode === 'avatar') {
                // Handle avatar upload
                await uploadAvatar(blob);
            } else if (currentCaptureMode === 'document') {
                // Handle document processing
                await processDocument(blob);
            }
            
        } catch (error) {
            console.error('Error processing photo:', error);
            alert('Erro ao processar a foto. Tente novamente.');
        } finally {
            loading.classList.add('hidden');
            closeCamera();
        }
    }
    
    async function uploadAvatar(blob) {
        const formData = new FormData();
        formData.append('avatar', blob, 'selfie.jpg');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        try {
            const response = await fetch('{{ route("client.profile.upload-avatar") }}', {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                // Reload page to show new avatar
                window.location.reload();
            } else {
                throw new Error('Upload failed');
            }
        } catch (error) {
            console.error('Error uploading avatar:', error);
            alert('Erro ao enviar a foto. Tente novamente.');
        }
    }
    
    async function processDocument(blob) {
        // For now, just show a message that OCR processing would go here
        // In a real implementation, you would send to an OCR service
        alert('📄 Foto capturada! Em uma versão futura, o sistema irá extrair automaticamente os dados do documento. Por enquanto, digite manualmente os dados no formulário.');
    }
    
    function toggleFlash() {
        if (currentStream) {
            const track = currentStream.getVideoTracks()[0];
            const capabilities = track.getCapabilities();
            
            if (capabilities.torch) {
                const settings = track.getSettings();
                track.applyConstraints({
                    advanced: [{ torch: !settings.torch }]
                });
                
                const flashButton = document.getElementById('toggle-flash');
                flashButton.classList.toggle('bg-yellow-500');
            }
        }
    }
    
    function closeCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            currentStream = null;
        }
        
        if (cameraModal) {
            cameraModal.classList.add('hidden');
            
            // Reset UI
            document.getElementById('photo-preview').classList.add('hidden');
            document.getElementById('camera-video').style.display = 'block';
        }
    }
    
    // Setup camera buttons
    const cameraAvatarBtn = document.getElementById('camera-avatar-btn');
    const cameraDocumentBtn = document.getElementById('camera-document-btn');
    
    if (cameraAvatarBtn) {
        cameraAvatarBtn.addEventListener('click', () => {
            openCamera('avatar');
        });
    }
    
    if (cameraDocumentBtn) {
        cameraDocumentBtn.addEventListener('click', () => {
            openCamera('document');
        });
    }
    
    // Check if device supports camera
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        // Hide camera buttons if camera is not supported
        const cameraButtons = document.querySelectorAll('#camera-avatar-btn, #camera-document-btn');
        cameraButtons.forEach(btn => {
            if (btn) btn.style.display = 'none';
        });
    }
});
</script>
@endpush
@endsection 