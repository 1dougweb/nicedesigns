@extends('layouts.admin')

@section('title', '- Configurações')
@section('page-title', 'Configurações do Sistema')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Configurações do Sistema</h2>
        <p class="text-gray-400 mt-1">Gerencie todas as configurações da agência</p>
    </div>
    <div class="flex space-x-4">
        <button type="button" onclick="clearCache()"
                class="bg-yellow-600/20 text-yellow-300 border border-yellow-600/30 hover:bg-yellow-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span>Limpar Cache</span>
        </button>
        <button type="submit" form="settings-form"
                class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2"
                id="save-button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Salvar Configurações</span>
        </button>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 bg-green-500/20 border border-green-500/30 text-green-300 px-6 py-4 rounded-2xl flex items-center">
    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl flex items-center">
    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
    </svg>
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl">
    <div class="flex items-center mb-2">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <strong>Erros de Validação:</strong>
    </div>
    <ul class="list-disc list-inside ml-8">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Tabs Navigation -->
<div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 mb-8">
    <div class=" border-gray-700/50">
        <nav class="flex space-x-8 px-8 py-4" id="settings-tabs">
            <button type="button" onclick="switchTab('general')" 
                    class="tab-button active flex items-center space-x-2 py-2 px-1 border-b-2 border-blue-500 text-blue-400 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Geral</span>
            </button>
            <button type="button" onclick="switchTab('contact')" 
                    class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Contato</span>
            </button>
            <button type="button" onclick="switchTab('social')" 
                    class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span>Redes Sociais</span>
            </button>
            <button type="button" onclick="switchTab('seo')" 
                    class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>SEO</span>
            </button>
            <button type="button" onclick="switchTab('email')" 
                    class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
                <span>Email</span>
            </button>
            <button type="button" onclick="switchTab('appearance')" 
                    class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2V3z"/>
                </svg>
                <span>Aparência</span>
            </button>
            <button type="button" onclick="switchTab('pagarme')" 
                    class="tab-button flex items-center space-x-2 py-2 px-1 border-b-2 border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600 font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Pagar.me</span>
            </button>
        </nav>
    </div>
</div>

<!-- Form Container -->
<form id="settings-form" method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
    @csrf
    @method('PUT')
    
    <!-- General Settings Tab -->
    <div id="general-tab" class="tab-content">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Configurações Gerais
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-300 mb-2">Nome do Site</label>
                    <input type="text" id="site_name" name="site_name" 
                           value="{{ $settings['general']->where('key', 'site_name')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-300 mb-2">Fuso Horário</label>
                    <select id="timezone" name="timezone" 
                            class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="America/Sao_Paulo" {{ ($settings['general']->where('key', 'timezone')->first()->value ?? 'America/Sao_Paulo') == 'America/Sao_Paulo' ? 'selected' : '' }}>América/São Paulo</option>
                        <option value="America/New_York" {{ ($settings['general']->where('key', 'timezone')->first()->value ?? '') == 'America/New_York' ? 'selected' : '' }}>América/Nova York</option>
                        <option value="Europe/London" {{ ($settings['general']->where('key', 'timezone')->first()->value ?? '') == 'Europe/London' ? 'selected' : '' }}>Europa/Londres</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label for="site_description" class="block text-sm font-medium text-gray-300 mb-2">Descrição do Site</label>
                    <textarea id="site_description" name="site_description" rows="3"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">{{ $settings['general']->where('key', 'site_description')->first()->value ?? '' }}</textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label for="site_keywords" class="block text-sm font-medium text-gray-300 mb-2">Palavras-chave (SEO)</label>
                    <input type="text" id="site_keywords" name="site_keywords" 
                           value="{{ $settings['general']->where('key', 'site_keywords')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="web design, desenvolvimento, agência digital">
                </div>
                
                <div>
                    <label for="site_logo" class="block text-sm font-medium text-gray-300 mb-2">URL do Logo</label>
                    <input type="url" id="site_logo" name="site_logo" 
                           value="{{ $settings['general']->where('key', 'site_logo')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="site_favicon" class="block text-sm font-medium text-gray-300 mb-2">URL do Favicon</label>
                    <input type="url" id="site_favicon" name="site_favicon" 
                           value="{{ $settings['general']->where('key', 'site_favicon')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="posts_per_page" class="block text-sm font-medium text-gray-300 mb-2">Posts por Página</label>
                    <input type="number" id="posts_per_page" name="posts_per_page" min="1" max="50"
                           value="{{ $settings['general']->where('key', 'posts_per_page')->first()->value ?? 12 }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="projects_per_page" class="block text-sm font-medium text-gray-300 mb-2">Projetos por Página</label>
                    <input type="number" id="projects_per_page" name="projects_per_page" min="1" max="50"
                           value="{{ $settings['general']->where('key', 'projects_per_page')->first()->value ?? 12 }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="date_format" class="block text-sm font-medium text-gray-300 mb-2">Formato de Data</label>
                    <select id="date_format" name="date_format" 
                            class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="d/m/Y" {{ ($settings['general']->where('key', 'date_format')->first()->value ?? 'd/m/Y') == 'd/m/Y' ? 'selected' : '' }}>dd/mm/aaaa</option>
                        <option value="Y-m-d" {{ ($settings['general']->where('key', 'date_format')->first()->value ?? '') == 'Y-m-d' ? 'selected' : '' }}>aaaa-mm-dd</option>
                        <option value="m/d/Y" {{ ($settings['general']->where('key', 'date_format')->first()->value ?? '') == 'm/d/Y' ? 'selected' : '' }}>mm/dd/aaaa</option>
                    </select>
                </div>
                
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-300 mb-2">Moeda Padrão</label>
                    <select id="currency" name="currency" 
                            class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="BRL" {{ ($settings['general']->where('key', 'currency')->first()->value ?? 'BRL') == 'BRL' ? 'selected' : '' }}>Real (BRL)</option>
                        <option value="USD" {{ ($settings['general']->where('key', 'currency')->first()->value ?? '') == 'USD' ? 'selected' : '' }}>Dólar (USD)</option>
                        <option value="EUR" {{ ($settings['general']->where('key', 'currency')->first()->value ?? '') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="maintenance_mode" value="1"
                                   {{ ($settings['general']->where('key', 'maintenance_mode')->first()->value ?? false) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-gray-300">Modo Manutenção</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="allow_registration" value="1"
                                   {{ ($settings['general']->where('key', 'allow_registration')->first()->value ?? false) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-gray-300">Permitir Registro</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Settings Tab -->
    <div id="contact-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Informações de Contato
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-300 mb-2">Email de Contato</label>
                    <input type="email" id="contact_email" name="contact_email" 
                           value="{{ $settings['contact']->where('key', 'contact_email')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-300 mb-2">Telefone</label>
                    <input type="text" id="contact_phone" name="contact_phone" 
                           value="{{ $settings['contact']->where('key', 'contact_phone')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div>
                    <label for="contact_whatsapp" class="block text-sm font-medium text-gray-300 mb-2">WhatsApp</label>
                    <input type="text" id="contact_whatsapp" name="contact_whatsapp" 
                           value="{{ $settings['contact']->where('key', 'contact_whatsapp')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="5511999999999">
                </div>
                
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-300 mb-2">Cidade</label>
                    <input type="text" id="city" name="city" 
                           value="{{ $settings['contact']->where('key', 'city')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Endereço</label>
                    <input type="text" id="address" name="address" 
                           value="{{ $settings['contact']->where('key', 'address')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div>
                    <label for="address_complement" class="block text-sm font-medium text-gray-300 mb-2">Complemento</label>
                    <input type="text" id="address_complement" name="address_complement" 
                           value="{{ $settings['contact']->where('key', 'address_complement')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Apto, sala, andar...">
                </div>
                
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-300 mb-2">CEP</label>
                    <input type="text" id="zip_code" name="zip_code" 
                           value="{{ $settings['contact']->where('key', 'zip_code')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-300 mb-2">Estado</label>
                    <input type="text" id="state" name="state" 
                           value="{{ $settings['contact']->where('key', 'state')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           required>
                </div>
                
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-300 mb-2">País</label>
                    <select id="country" name="country" 
                            class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="Brasil" {{ ($settings['contact']->where('key', 'country')->first()->value ?? 'Brasil') == 'Brasil' ? 'selected' : '' }}>Brasil</option>
                        <option value="Portugal" {{ ($settings['contact']->where('key', 'country')->first()->value ?? '') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                        <option value="Estados Unidos" {{ ($settings['contact']->where('key', 'country')->first()->value ?? '') == 'Estados Unidos' ? 'selected' : '' }}>Estados Unidos</option>
                        <option value="Espanha" {{ ($settings['contact']->where('key', 'country')->first()->value ?? '') == 'Espanha' ? 'selected' : '' }}>Espanha</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Tab -->
    <div id="social-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Redes Sociais
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="facebook_url" class="block text-sm font-medium text-gray-300 mb-2">Facebook</label>
                    <input type="url" id="facebook_url" name="facebook_url" 
                           value="{{ $settings['social']->where('key', 'facebook_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-300 mb-2">Instagram</label>
                    <input type="url" id="instagram_url" name="instagram_url" 
                           value="{{ $settings['social']->where('key', 'instagram_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="linkedin_url" class="block text-sm font-medium text-gray-300 mb-2">LinkedIn</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" 
                           value="{{ $settings['social']->where('key', 'linkedin_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="behance_url" class="block text-sm font-medium text-gray-300 mb-2">Behance</label>
                    <input type="url" id="behance_url" name="behance_url" 
                           value="{{ $settings['social']->where('key', 'behance_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="twitter_url" class="block text-sm font-medium text-gray-300 mb-2">Twitter/X</label>
                    <input type="url" id="twitter_url" name="twitter_url" 
                           value="{{ $settings['social']->where('key', 'twitter_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="youtube_url" class="block text-sm font-medium text-gray-300 mb-2">YouTube</label>
                    <input type="url" id="youtube_url" name="youtube_url" 
                           value="{{ $settings['social']->where('key', 'youtube_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="github_url" class="block text-sm font-medium text-gray-300 mb-2">GitHub</label>
                    <input type="url" id="github_url" name="github_url" 
                           value="{{ $settings['social']->where('key', 'github_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="dribbble_url" class="block text-sm font-medium text-gray-300 mb-2">Dribbble</label>
                    <input type="url" id="dribbble_url" name="dribbble_url" 
                           value="{{ $settings['social']->where('key', 'dribbble_url')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Tab -->
    <div id="seo-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                SEO e Analytics
            </h3>
            
            <div class="space-y-6">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-300 mb-2">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" maxlength="60"
                           value="{{ $settings['seo']->where('key', 'meta_title')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <p class="text-xs text-gray-400 mt-1">Máximo 60 caracteres</p>
                </div>
                
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-300 mb-2">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">{{ $settings['seo']->where('key', 'meta_description')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Máximo 160 caracteres</p>
                </div>
                
                <div>
                    <label for="google_analytics_id" class="block text-sm font-medium text-gray-300 mb-2">Google Analytics ID</label>
                    <input type="text" id="google_analytics_id" name="google_analytics_id" 
                           value="{{ $settings['seo']->where('key', 'google_analytics_id')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="GA-XXXXXXXXX-X">
                </div>
                
                <div>
                    <label for="facebook_pixel_id" class="block text-sm font-medium text-gray-300 mb-2">Facebook Pixel ID</label>
                    <input type="text" id="facebook_pixel_id" name="facebook_pixel_id" 
                           value="{{ $settings['seo']->where('key', 'facebook_pixel_id')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="123456789012345">
                </div>
                
                <div>
                    <label for="google_search_console" class="block text-sm font-medium text-gray-300 mb-2">Google Search Console</label>
                    <textarea id="google_search_console" name="google_search_console" rows="4"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                              placeholder="Cole aqui o código de verificação do Google Search Console">{{ $settings['seo']->where('key', 'google_search_console')->first()->value ?? '' }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Código HTML de verificação do Google Search Console</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Tab -->
    <div id="email-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
                Configurações de Email
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="smtp_host" class="block text-sm font-medium text-gray-300 mb-2">Host SMTP</label>
                    <input type="text" id="smtp_host" name="smtp_host" 
                           value="{{ $settings['email']->where('key', 'smtp_host')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="smtp.gmail.com">
                </div>
                
                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-300 mb-2">Porta SMTP</label>
                    <input type="number" id="smtp_port" name="smtp_port" 
                           value="{{ $settings['email']->where('key', 'smtp_port')->first()->value ?? 587 }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="587">
                </div>
                
                <div>
                    <label for="smtp_username" class="block text-sm font-medium text-gray-300 mb-2">Usuário SMTP</label>
                    <input type="email" id="smtp_username" name="smtp_username" 
                           value="{{ $settings['email']->where('key', 'smtp_username')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="seu@email.com">
                </div>
                
                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-300 mb-2">Senha SMTP</label>
                    <input type="password" id="smtp_password" name="smtp_password" 
                           value="{{ $settings['email']->where('key', 'smtp_password')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="••••••••">
                </div>
                
                <div>
                    <label for="smtp_encryption" class="block text-sm font-medium text-gray-300 mb-2">Criptografia</label>
                    <select id="smtp_encryption" name="smtp_encryption" 
                            class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="tls" {{ ($settings['email']->where('key', 'smtp_encryption')->first()->value ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ ($settings['email']->where('key', 'smtp_encryption')->first()->value ?? 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                    </select>
                </div>
                
                <div>
                    <label for="mail_from_address" class="block text-sm font-medium text-gray-300 mb-2">Email Remetente</label>
                    <input type="email" id="mail_from_address" name="mail_from_address" 
                           value="{{ $settings['email']->where('key', 'mail_from_address')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="noreply@seusite.com">
                </div>
                
                <div>
                    <label for="mail_from_name" class="block text-sm font-medium text-gray-300 mb-2">Nome Remetente</label>
                    <input type="text" id="mail_from_name" name="mail_from_name" 
                           value="{{ $settings['email']->where('key', 'mail_from_name')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="Nice Designs">
                </div>
                
                <div class="md:col-span-2 pt-6 border-t border-gray-700/50">
                    <div class="flex items-center space-x-4">
                        <input type="email" placeholder="Digite seu email para teste..." 
                               class="flex-1 bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <button type="button" onclick="testEmail(this)"
                                class="bg-green-600/20 text-green-300 border border-green-600/30 hover:bg-green-600/30 px-6 py-3 rounded-xl font-medium transition-all duration-300 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            <span>Testar Email</span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">
                        O email de teste usará as configurações atuais. Certifique-se de salvar antes de testar.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Appearance Tab -->
    <div id="appearance-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2V3z"/>
                </svg>
                Aparência
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label for="primary_color" class="block text-sm font-medium text-gray-300 mb-2">Cor Primária</label>
                    <input type="color" id="primary_color" name="primary_color" 
                           value="{{ $settings['appearance']->where('key', 'primary_color')->first()->value ?? '#3B82F6' }}"
                           class="w-full h-12 bg-gray-700/50 border border-gray-600/50 rounded-xl cursor-pointer">
                </div>
                
                <div>
                    <label for="secondary_color" class="block text-sm font-medium text-gray-300 mb-2">Cor Secundária</label>
                    <input type="color" id="secondary_color" name="secondary_color" 
                           value="{{ $settings['appearance']->where('key', 'secondary_color')->first()->value ?? '#1F2937' }}"
                           class="w-full h-12 bg-gray-700/50 border border-gray-600/50 rounded-xl cursor-pointer">
                </div>
                
                <div>
                    <label for="accent_color" class="block text-sm font-medium text-gray-300 mb-2">Cor de Destaque</label>
                    <input type="color" id="accent_color" name="accent_color" 
                           value="{{ $settings['appearance']->where('key', 'accent_color')->first()->value ?? '#10B981' }}"
                           class="w-full h-12 bg-gray-700/50 border border-gray-600/50 rounded-xl cursor-pointer">
                </div>
            </div>
            
            <div class="space-y-6">
                <div>
                    <label for="custom_css" class="block text-sm font-medium text-gray-300 mb-2">CSS Personalizado</label>
                    <textarea id="custom_css" name="custom_css" rows="6"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 font-mono text-sm">{{ $settings['appearance']->where('key', 'custom_css')->first()->value ?? '' }}</textarea>
                </div>
                
                <div>
                    <label for="custom_js" class="block text-sm font-medium text-gray-300 mb-2">JavaScript Personalizado</label>
                    <textarea id="custom_js" name="custom_js" rows="6"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 font-mono text-sm">{{ $settings['appearance']->where('key', 'custom_js')->first()->value ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- PagarMe Tab -->
    <div id="pagarme-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Configurações Pagar.me
            </h3>
            
            <div class="mb-8 p-4 bg-blue-500/10 border border-blue-500/30 rounded-xl">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="text-blue-300 font-medium mb-1">Configuração da Integração Pagar.me</h4>
                        <p class="text-blue-200 text-sm">
                            Configure suas credenciais da API Pagar.me para processar pagamentos. Use o ambiente <strong>sandbox</strong> para testes e <strong>live</strong> para produção.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Environment -->
                <div class="md:col-span-2">
                    <label for="pagarme_environment" class="block text-sm font-medium text-gray-300 mb-2">
                        Ambiente <span class="text-red-400">*</span>
                    </label>
                    <select id="pagarme_environment" name="pagarme_environment" 
                            class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                            onchange="togglePagarMeEnvironment()">
                        <option value="sandbox" {{ ($settings['pagarme']->where('key', 'pagarme_environment')->first()->value ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox (Testes)</option>
                        <option value="live" {{ ($settings['pagarme']->where('key', 'pagarme_environment')->first()->value ?? 'sandbox') == 'live' ? 'selected' : '' }}>Live (Produção)</option>
                    </select>
                </div>

                <!-- API Key -->
                <div>
                    <label for="pagarme_api_key" class="block text-sm font-medium text-gray-300 mb-2">
                        API Key <span class="text-red-400">*</span>
                        <span class="text-xs text-gray-400 ml-2" id="api-key-hint">(Inicia com ak_test_ para sandbox)</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="pagarme_api_key" name="pagarme_api_key" 
                               value="{{ $settings['pagarme']->where('key', 'pagarme_api_key')->first()->value ?? '' }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="ak_test_...">
                        <button type="button" onclick="togglePasswordVisibility('pagarme_api_key')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Encryption Key -->
                <div>
                    <label for="pagarme_encryption_key" class="block text-sm font-medium text-gray-300 mb-2">
                        Encryption Key <span class="text-red-400">*</span>
                        <span class="text-xs text-gray-400 ml-2" id="encryption-key-hint">(Inicia com ek_test_ para sandbox)</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="pagarme_encryption_key" name="pagarme_encryption_key" 
                               value="{{ $settings['pagarme']->where('key', 'pagarme_encryption_key')->first()->value ?? '' }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="ek_test_...">
                        <button type="button" onclick="togglePasswordVisibility('pagarme_encryption_key')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Webhook Secret -->
                <div>
                    <label for="pagarme_webhook_secret" class="block text-sm font-medium text-gray-300 mb-2">
                        Webhook Secret
                        <span class="text-xs text-gray-400 ml-2">(Opcional - para validação de webhooks)</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="pagarme_webhook_secret" name="pagarme_webhook_secret" 
                               value="{{ $settings['pagarme']->where('key', 'pagarme_webhook_secret')->first()->value ?? '' }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               placeholder="whsec_...">
                        <button type="button" onclick="togglePasswordVisibility('pagarme_webhook_secret')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div>
                    <label for="pagarme_default_methods" class="block text-sm font-medium text-gray-300 mb-2">
                        Métodos de Pagamento Padrão
                    </label>
                    <input type="text" id="pagarme_default_methods" name="pagarme_default_methods" 
                           value="{{ $settings['pagarme']->where('key', 'pagarme_default_methods')->first()->value ?? 'boleto,pix' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                           placeholder="boleto,pix">
                    <p class="text-xs text-gray-400 mt-1">Separados por vírgula: boleto, pix, credit_card</p>
                </div>

                <!-- Auto Charge Days -->
                <div>
                    <label for="pagarme_auto_charge_days" class="block text-sm font-medium text-gray-300 mb-2">
                        Dias para Cobrança Automática
                    </label>
                    <input type="number" id="pagarme_auto_charge_days" name="pagarme_auto_charge_days" min="0" max="30"
                           value="{{ $settings['pagarme']->where('key', 'pagarme_auto_charge_days')->first()->value ?? 0 }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <p class="text-xs text-gray-400 mt-1">0 = desabilitado</p>
                </div>

                <!-- Max Retry Attempts -->
                <div>
                    <label for="pagarme_max_retry_attempts" class="block text-sm font-medium text-gray-300 mb-2">
                        Máximo de Tentativas
                    </label>
                    <input type="number" id="pagarme_max_retry_attempts" name="pagarme_max_retry_attempts" min="1" max="10"
                           value="{{ $settings['pagarme']->where('key', 'pagarme_max_retry_attempts')->first()->value ?? 3 }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Send Email on Generation -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="pagarme_send_email_on_generation" value="1"
                               {{ ($settings['pagarme']->where('key', 'pagarme_send_email_on_generation')->first()->value ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-gray-300">Enviar Email na Geração</span>
                    </label>
                </div>

                <!-- Boleto Instructions -->
                <div class="md:col-span-2">
                    <label for="pagarme_boleto_instructions" class="block text-sm font-medium text-gray-300 mb-2">
                        Instruções do Boleto
                    </label>
                    <textarea id="pagarme_boleto_instructions" name="pagarme_boleto_instructions" rows="3"
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">{{ $settings['pagarme']->where('key', 'pagarme_boleto_instructions')->first()->value ?? 'Pagar preferencialmente em bancos digitais para compensação mais rápida.' }}</textarea>
                </div>

                <!-- Test Connection -->
                <div class="md:col-span-2 pt-6 border-t border-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-medium mb-1">Testar Conexão</h4>
                            <p class="text-gray-400 text-sm">Verifique se as credenciais estão funcionando corretamente</p>
                        </div>
                        <button type="button" onclick="testPagarMeConnection()"
                                class="bg-green-600/20 text-green-300 border border-green-600/30 hover:bg-green-600/30 px-6 py-3 rounded-xl font-medium transition-all duration-300 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Testar Conexão</span>
                        </button>
                    </div>
                    
                    <!-- Webhook URL Info -->
                    <div class="mt-6 p-4 bg-gray-700/30 rounded-xl">
                        <h5 class="text-gray-300 font-medium mb-2">URL do Webhook</h5>
                        <div class="flex items-center space-x-2">
                            <input type="text" readonly 
                                   value="{{ route('pagarme.webhook') }}"
                                   class="flex-1 bg-gray-600/50 border border-gray-500/50 text-gray-300 rounded-lg px-3 py-2 text-sm font-mono">
                            <button type="button" onclick="copyToClipboard('{{ route('pagarme.webhook') }}')"
                                    class="bg-gray-600/50 hover:bg-gray-600/70 text-gray-300 px-3 py-2 rounded-lg text-sm transition-colors">
                                Copiar
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Configure esta URL no painel do Pagar.me para receber notificações de pagamento</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-blue-500', 'text-blue-400');
        btn.classList.add('border-transparent', 'text-gray-400');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Mark button as active
    event.target.closest('.tab-button').classList.add('active', 'border-blue-500', 'text-blue-400');
    event.target.closest('.tab-button').classList.remove('border-transparent', 'text-gray-400');
}

function clearCache() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Mostrar loading
    button.innerHTML = '<svg class="w-4 h-4 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Limpando...';
    button.disabled = true;
    
    fetch('{{ route("admin.settings.clear-cache") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cache limpo com sucesso!');
        } else {
            alert('Erro ao limpar cache: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao limpar cache');
        console.error('Error:', error);
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function testEmail(button) {
    const email = button.previousElementSibling.value;
    if (!email) {
        alert('Digite um email para teste');
        return;
    }
    
    const originalText = button.innerHTML;
    
    // Mostrar loading
    button.innerHTML = '<svg class="w-4 h-4 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Enviando...';
    button.disabled = true;
    
    fetch('{{ route("admin.settings.test-email") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ test_email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Email de teste enviado com sucesso!');
        } else {
            alert('Erro ao enviar email: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao enviar email de teste');
        console.error('Error:', error);
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function togglePagarMeEnvironment() {
    const environment = document.getElementById('pagarme_environment').value;
    const apiKey = document.getElementById('pagarme_api_key');
    const encryptionKey = document.getElementById('pagarme_encryption_key');
    const webhookSecret = document.getElementById('pagarme_webhook_secret');

    if (environment === 'live') {
        apiKey.disabled = true;
        encryptionKey.disabled = true;
        webhookSecret.disabled = true;
    } else {
        apiKey.disabled = false;
        encryptionKey.disabled = false;
        webhookSecret.disabled = false;
    }
}

function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
}

function testPagarMeConnection() {
    const environment = document.getElementById('pagarme_environment').value;
    const apiKey = document.getElementById('pagarme_api_key').value;
    const encryptionKey = document.getElementById('pagarme_encryption_key').value;
    const webhookSecret = document.getElementById('pagarme_webhook_secret').value;

    if (!environment || !apiKey || !encryptionKey) {
        alert('Por favor, preencha pelo menos Ambiente, API Key e Encryption Key antes de testar a conexão.');
        return;
    }

    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Testando...';
    button.disabled = true;

    fetch('{{ route("admin.settings.test-pagarme-connection") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            environment: environment,
            api_key: apiKey,
            encryption_key: encryptionKey,
            webhook_secret: webhookSecret
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Conexão com Pagar.me estabelecida com sucesso!');
        } else {
            alert('Erro ao testar conexão: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao testar conexão');
        console.error('Error:', error);
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function copyToClipboard(text) {
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('URL copiada para o clipboard!');
}

// Adicionar feedback visual ao formulário
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settings-form');
    const saveButton = document.getElementById('save-button');
    
    if (form && saveButton) {
        form.addEventListener('submit', function() {
            const originalText = saveButton.innerHTML;
            saveButton.innerHTML = '<svg class="w-4 h-4 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Salvando...';
            saveButton.disabled = true;
        });
    }
});
</script>
@endsection 