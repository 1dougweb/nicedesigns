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
            <i class="fi fi-rr-broom text-xl mt-2"></i>
            <span>Limpar Cache</span>
        </button>
        <button type="submit" form="settings-form"
                class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2"
                id="save-button">
            <i class="fi fi-rr-disk text-xl mt-2"></i>
            <span>Salvar Configurações</span>
        </button>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 bg-green-500/20 border border-green-500/30 text-green-300 px-6 py-4 rounded-2xl flex items-center">
    <i class="fi fi-rr-check-circle text-xl mr-3 mt-2"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl flex items-center">
    <i class="fi fi-rr-cross-circle text-xl mr-3"></i>
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl">
    <div class="flex items-center mb-2">
        <i class="fi fi-rr-exclamation-triangle text-xl mr-3"></i>
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
    <div class="border-gray-700/50">
        <nav class="flex space-x-4 px-8 py-4" id="settings-tabs">
            <button 
                data-tab="general-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-settings text-xl mt-2"></i>
                <span>Geral</span>
            </button>
            
            <button 
                data-tab="contact-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-envelope text-xl mt-2"></i>
                <span>Contato</span>
            </button>
            
            <button 
                data-tab="social-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-share text-xl mt-2"></i>
                <span>Redes Sociais</span>
            </button>
            
            <button 
                data-tab="seo-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-search text-xl mt-2"></i>
                <span>SEO</span>
            </button>
            
            <button 
                data-tab="email-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-at text-xl mt-2"></i>
                <span>Email</span>
            </button>
            
            <button 
                data-tab="appearance-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-palette text-xl mt-2"></i>
                <span>Aparência</span>
            </button>
            
            <button 
                data-tab="abacatepay-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-credit-card text-xl mt-2"></i>
                <span>AbacatePay</span>
            </button>
            
            <button 
                data-tab="profile-tab"
                class="tab-button flex items-center space-x-2 py-2 px-3 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-300 text-gray-400"
            >
                <i class="fi fi-rr-user text-xl mt-2"></i>
                <span>Meu Perfil</span>
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
                <i class="fi fi-rr-settings text-blue-400 text-2xl mr-3 mt-2"></i>
                Configurações Gerais
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-300 mb-2">Nome do Site</label>
                    <input type="text" id="site_name" name="site_name" 
                           value="{{ $settings['general']->where('key', 'site_name')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
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
                           placeholder="palavra1, palavra2, palavra3">
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
                <i class="fi fi-rr-envelope text-green-400 text-2xl mr-3 mt-2"></i>
                Informações de Contato
            </h3>
            
            <div class="mb-6 p-4 bg-blue-600/20 border border-blue-400/30 rounded-xl">
                <div class="flex items-center text-blue-300">
                    <i class="fi fi-rr-info text-xl mr-3"></i>
                    <div>
                        <p class="font-medium">Informações Importantes</p>
                        <p class="text-sm text-blue-200">Os campos de email e telefone são essenciais para o funcionamento do site de contato.</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-300 mb-2">Email de Contato</label>
                    <input type="email" id="contact_email" name="contact_email" 
                           value="{{ $settings['contact']->where('key', 'contact_email')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-300 mb-2">Telefone</label>
                    <input type="text" id="contact_phone" name="contact_phone" 
                           value="{{ $settings['contact']->where('key', 'contact_phone')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
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
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Endereço</label>
                    <input type="text" id="address" name="address" 
                           value="{{ $settings['contact']->where('key', 'address')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
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
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>
                
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-300 mb-2">Estado</label>
                    <input type="text" id="state" name="state" 
                           value="{{ $settings['contact']->where('key', 'state')->first()->value ?? '' }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
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
                <i class="fi fi-rr-share text-purple-400 text-2xl mr-3"></i>
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
                <i class="fi fi-rr-search text-yellow-400 text-2xl mr-3"></i>
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
                <i class="fi fi-rr-at text-red-400 text-2xl mr-3"></i>
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
                            <i class="fi fi-rr-check text-xl"></i>
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
                <i class="fi fi-rr-palette text-pink-400 text-2xl mr-3"></i>
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

    <!-- AbacatePay Settings Tab -->
    <div id="abacatepay-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <i class="fi fi-rr-credit-card text-emerald-400 text-2xl mr-3"></i>
                Configurações do AbacatePay
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Token -->
                <div>
                    <label for="abacatepay_token" class="block text-sm font-medium text-gray-300 mb-2">Token da API</label>
                    <input
                        type="password"
                        id="abacatepay_token"
                        name="abacatepay[token]"
                        value="{{ old('abacatepay.token', $settings['abacatepay']['token'] ?? '') }}"
                        class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        placeholder="Digite o token da API"
                    />
                    <p class="mt-2 text-sm text-gray-400">
                        Token de acesso à API do AbacatePay. Encontre no painel do AbacatePay em Configurações > API Keys.
                    </p>
                    @error('abacatepay.token')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Webhook Secret -->
                <div>
                    <label for="abacatepay_webhook_secret" class="block text-sm font-medium text-gray-300 mb-2">Webhook Secret</label>
                    <input
                        type="password"
                        id="abacatepay_webhook_secret"
                        name="abacatepay[webhook_secret]"
                        value="{{ old('abacatepay.webhook_secret', $settings['abacatepay']['webhook_secret'] ?? '') }}"
                        class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        placeholder="Digite o webhook secret"
                    />
                    <p class="mt-2 text-sm text-gray-400">
                        Chave secreta para validação dos webhooks. Encontre no painel do AbacatePay em Configurações > Webhooks.
                    </p>
                    @error('abacatepay.webhook_secret')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ambiente -->
                <div class="md:col-span-2">
                    <label for="abacatepay_environment" class="block text-sm font-medium text-gray-300 mb-2">Ambiente</label>
                    <select
                        id="abacatepay_environment"
                        name="abacatepay[environment]"
                        class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    >
                        <option value="sandbox" {{ (old('abacatepay.environment', $settings['abacatepay']['environment'] ?? '') == 'sandbox') ? 'selected' : '' }}>Sandbox (Testes)</option>
                        <option value="production" {{ (old('abacatepay.environment', $settings['abacatepay']['environment'] ?? '') == 'production') ? 'selected' : '' }}>Produção</option>
                    </select>
                    <p class="mt-2 text-sm text-gray-400">
                        Escolha o ambiente de operação. Use Sandbox para testes e Produção para ambiente real.
                    </p>
                    @error('abacatepay.environment')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botão de teste -->
            <div class="flex items-center justify-end space-x-4 mt-8">
                <a
                    href="{{ route('admin.settings.abacatepay.test') }}"
                    class="bg-yellow-600/20 text-yellow-300 border border-yellow-600/30 hover:bg-yellow-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2"
                >
                    <i class="fi fi-rr-refresh text-xl"></i>
                    <span>Testar Conexão</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Tab -->
    <div id="profile-tab" class="tab-content hidden">
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                <i class="fi fi-rr-user text-purple-400 text-2xl mr-3"></i>
                Meu Perfil de Administrador
            </h3>
            
            <div class="mb-6 p-4 bg-blue-600/10 border border-blue-500/30 rounded-xl">
                <div class="flex items-center">
                    <i class="fi fi-rr-user text-blue-400 text-2xl mr-3"></i>
                    <div class="text-blue-300">
                        <p class="font-medium">Acesso ao Perfil Completo</p>
                        <p class="text-sm">Para gerenciar todas as informações do seu perfil, use a página dedicada do perfil.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Quick Profile Info -->
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Informações Básicas</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <span class="text-gray-300">Nome:</span>
                                <span class="text-white font-medium">{{ auth()->user()->display_name ?? 'Não informado' }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <span class="text-gray-300">Email:</span>
                                <span class="text-white font-medium">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <span class="text-gray-300">Cargo:</span>
                                <span class="text-white font-medium">{{ auth()->user()->position ?? 'Administrador' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Estatísticas da Conta</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <span class="text-gray-300">Tipo de conta:</span>
                                <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-xs font-medium">
                                    Administrador
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <span class="text-gray-300">Membro desde:</span>
                                <span class="text-white">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-xl">
                                <span class="text-gray-300">Última atualização:</span>
                                <span class="text-white">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-6">
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Ações Rápidas</h4>
                        <div class="space-y-4">
                            <a href="{{ route('admin.profile.index') }}" 
                               class="block w-full bg-purple-600/20 text-purple-300 border border-purple-600/30 hover:bg-purple-600/30 px-6 py-4 rounded-xl font-medium transition-all duration-300 text-center">
                                <i class="fi fi-rr-user-edit text-xl inline mr-2"></i>
                                Editar Perfil Completo
                            </a>
                            
                            <button type="button" onclick="showPasswordChangeModal()" 
                                    class="block w-full bg-yellow-600/20 text-yellow-300 border border-yellow-600/30 hover:bg-yellow-600/30 px-6 py-4 rounded-xl font-medium transition-all duration-300 text-center">
                                <i class="fi fi-rr-key text-xl inline mr-2"></i>
                                Alterar Senha
                            </button>
                        </div>
                    </div>

                    @if(auth()->user()->avatar)
                    <div>
                        <h4 class="text-lg font-semibold text-white mb-4">Foto do Perfil</h4>
                        <div class="flex items-center space-x-4">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 alt="Avatar" 
                                 class="w-16 h-16 rounded-full object-cover border-2 border-purple-500/30">
                            <div>
                                <p class="text-white font-medium">Foto atual</p>
                                <p class="text-gray-400 text-sm">Atualize na página do perfil</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="p-4 bg-gray-700/30 rounded-xl">
                        <h5 class="text-white font-medium mb-2">Dica de Segurança</h5>
                        <p class="text-gray-300 text-sm">
                            Mantenha suas informações de perfil atualizadas e altere sua senha regularmente para manter sua conta segura.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentActiveTab = 'general-tab';
    
    // Função para alternar entre as abas
    function switchTab(tabId) {
        // Esconde todas as abas
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Remove a classe ativa de todos os botões
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('bg-gray-700/50', 'text-white');
            button.classList.add('text-gray-400', 'hover:text-white');
        });
        
        // Mostra a aba selecionada
        document.getElementById(tabId).classList.remove('hidden');
        
        // Ativa o botão selecionado
        document.querySelector(`[data-tab="${tabId}"]`).classList.remove('text-gray-400', 'hover:text-white');
        document.querySelector(`[data-tab="${tabId}"]`).classList.add('bg-gray-700/50', 'text-white');
        
        // Atualiza a aba ativa atual
        currentActiveTab = tabId;
        
        // Atualiza a URL com o hash da aba
        window.location.hash = tabId;
        

    }
    
    // Adiciona os event listeners aos botões das abas
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
    
    // Verifica se há um hash na URL e ativa a aba correspondente
    if (window.location.hash) {
        const tabId = window.location.hash.substring(1);
        if (document.getElementById(tabId)) {
            switchTab(tabId);
        }
    } else {
        // Se não houver hash, ativa a primeira aba
        const firstTab = document.querySelector('.tab-button');
        if (firstTab) {
            switchTab(firstTab.getAttribute('data-tab'));
        }
    }
    
    // Interceptar submit do formulário para validação customizada
    const form = document.getElementById('settings-form');
    if (form) {
        form.addEventListener('submit', function(e) {

            
            // Remover todos os atributos required temporariamente para evitar conflitos
            const allInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            allInputs.forEach(input => {
                input.removeAttribute('required');
            });
            
            // Validação básica no JavaScript apenas para campos críticos
            let hasErrors = false;
            const errors = [];
            
            // Validar apenas se estivermos na aba de contato ou se for um submit geral
            if (currentActiveTab === 'contact-tab' || true) {
                const contactEmail = document.getElementById('contact_email');
                const contactPhone = document.getElementById('contact_phone');
                
                if (contactEmail && contactEmail.value.trim() === '') {
                    errors.push('Email de contato é obrigatório');
                    hasErrors = true;
                }
                
                if (contactPhone && contactPhone.value.trim() === '') {
                    errors.push('Telefone de contato é obrigatório');
                    hasErrors = true;
                }
            }
            
            if (hasErrors) {
                alert('Por favor, preencha os campos obrigatórios:\n' + errors.join('\n'));
                e.preventDefault();
                return false;
            }
            // O formulário será enviado normalmente
        });
    }
});
</script>
@endpush

<script>
function showPasswordChangeModal() {
    // Redirecionar para a página do perfil com foco na seção de senha
    window.location.href = '{{ route("admin.profile.index") }}#password-section';
}

function clearCache() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Mostrar loading
    button.innerHTML = '<i class="fi fi-rr-spinner animate-spin mr-2"></i>Limpando...';
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
    button.innerHTML = '<i class="fi fi-rr-spinner animate-spin mr-2"></i>Enviando...';
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
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
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
        form.addEventListener('submit', function(e) {
            const originalText = saveButton.innerHTML;
            saveButton.innerHTML = '<i class="fi fi-rr-spinner animate-spin mr-2"></i>Salvando...';
            saveButton.disabled = true;
            
            // Timeout para reabilitar o botão em caso de erro
            setTimeout(() => {
                if (saveButton.disabled) {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                }
            }, 30000); // 30 segundos
        });
    }
    

});
</script>
@endsection 

