@extends('layouts.admin')

@section('title', '- Criar Projeto')
@section('page-title', 'Criar Projeto')

@section('content')
<!-- Header Actions -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Criar Novo Projeto</h2>
        <p class="text-gray-400 mt-1">Adicione um novo projeto ao portfólio da agência</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" 
       class="bg-gray-600/20 text-gray-300 border border-gray-600/30 hover:bg-gray-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300 flex items-center space-x-2">
        <i class="fi fi-rr-arrow-left text-lg"></i>
        <span>Voltar</span>
    </a>
</div>

<!-- Alerts -->
@if($errors->any())
<div class="bg-red-500/20 border border-red-500/30 text-red-400 px-6 py-4 rounded-2xl mb-6 backdrop-blur-md">
    <div class="flex items-center mb-2">
        <i class="fi fi-rr-triangle-warning mr-3 text-xl"></i>
        <span class="font-medium">Erro(s) encontrado(s):</span>
    </div>
    <ul class="list-disc list-inside space-y-1 ml-8">
        @foreach($errors->all() as $error)
            <li class="text-sm">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-8" enctype="multipart/form-data">
    @csrf

    <!-- Basic Information -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <i class="fi fi-rr-document-signed text-purple-400 text-2xl mr-3"></i>
            Informações Básicas
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Title -->
            <div class="lg:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">
                    Título do Projeto *
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title') }}" 
                       required
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('title') border-red-500/50 @enderror"
                       placeholder="Ex: Sistema de E-commerce Completo">
                @error('title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Client Name -->
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-300 mb-2">
                    Cliente
                </label>
                <input type="text" 
                       name="client_name" 
                       id="client_name" 
                       value="{{ old('client_name') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('client_name') border-red-500/50 @enderror"
                       placeholder="Nome do cliente">
                @error('client_name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">
                    Categoria *
                </label>
                <select name="category_id" 
                        id="category_id"
                        required
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('category_id') border-red-500/50 @enderror">
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição Curta *
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="3"
                          required
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('description') border-red-500/50 @enderror"
                          placeholder="Descreva o projeto brevemente (máx. 500 caracteres)"
                          maxlength="500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Máximo de 500 caracteres</p>
            </div>
            
            <!-- Content -->
            <div class="lg:col-span-2">
                <label for="content" class="block text-sm font-medium text-gray-300 mb-2">
                    Conteúdo Completo *
                </label>
                <textarea name="content" 
                          id="content" 
                          rows="6"
                          required
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/20 transition-all @error('content') border-red-500/50 @enderror"
                          placeholder="Descreva detalhadamente o projeto, seus objetivos e principais funcionalidades...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <i class="fi fi-rr-info text-blue-400 text-2xl mr-3"></i>
            Detalhes do Projeto
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Technologies -->
            <div>
                <label for="technologies" class="block text-sm font-medium text-gray-300 mb-2">
                    Tecnologias Utilizadas
                </label>
                <input type="text" 
                       name="technologies" 
                       id="technologies" 
                       value="{{ old('technologies') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('technologies') border-red-500/50 @enderror"
                       placeholder="Ex: Laravel, Vue.js, MySQL, Tailwind CSS">
                @error('technologies')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Separe as tecnologias por vírgula</p>
            </div>
            
            <!-- Completion Date -->
            <div>
                <label for="completion_date" class="block text-sm font-medium text-gray-300 mb-2">
                    Data de Conclusão
                </label>
                <input type="date" 
                       name="completion_date" 
                       id="completion_date" 
                       value="{{ old('completion_date') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('completion_date') border-red-500/50 @enderror">
                @error('completion_date')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Options -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    Status do Projeto
                </label>
                <div class="flex items-center space-x-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured') ? 'checked' : '' }}
                               class="w-4 h-4 text-yellow-600 bg-gray-700 border-gray-600 focus:ring-yellow-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Destaque</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_published" 
                               value="1" 
                               {{ old('is_published', '1') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 text-green-600 bg-gray-700 border-gray-600 focus:ring-green-500 focus:ring-2">
                        <span class="ml-2 text-gray-300">Publicado</span>
                    </label>
                </div>
            </div>

            <!-- Project URL -->
            <div>
                <label for="project_url" class="block text-sm font-medium text-gray-300 mb-2">
                    URL do Projeto
                </label>
                <input type="url" 
                       name="project_url" 
                       id="project_url" 
                       value="{{ old('project_url') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-blue-500/50 focus:ring-2 focus:ring-blue-500/20 transition-all @error('project_url') border-red-500/50 @enderror"
                       placeholder="https://exemplo.com">
                @error('project_url')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Media -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <i class="fi fi-rr-picture text-green-400 text-2xl mr-3"></i>
            Imagens e Mídia
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-300 mb-2">
                    Imagem Destacada
                </label>
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center justify-center w-full">
                        <label for="featured_image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-xl cursor-pointer bg-gray-700/30 border-gray-600/50 hover:bg-gray-700/50">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fi fi-rr-cloud-upload text-gray-400 text-3xl mb-3"></i>
                                <p class="mb-2 text-sm text-gray-400"><span class="font-semibold">Clique para fazer upload</span> ou arraste e solte</p>
                                <p class="text-xs text-gray-400">PNG, JPG, GIF (MAX. 2MB)</p>
                            </div>
                            <input id="featured_image" name="featured_image" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <div class="text-center text-sm text-gray-400">ou</div>
                    <input type="url" 
                           name="featured_image_url" 
                           id="featured_image_url" 
                           value="{{ old('featured_image_url') }}"
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="https://exemplo.com/imagem.jpg">
                    <p class="text-xs text-gray-400">Insira uma URL da imagem se preferir</p>
                </div>
                @error('featured_image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                @error('featured_image_url')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gallery Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-300 mb-2">
                    Galeria de Imagens (URLs)
                </label>
                <textarea name="images" 
                          id="images" 
                          rows="3"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-green-500/50 focus:ring-2 focus:ring-green-500/20 transition-all @error('images') border-red-500/50 @enderror"
                          placeholder="https://exemplo.com/img1.jpg&#10;https://exemplo.com/img2.jpg&#10;https://exemplo.com/img3.jpg">{{ old('images') }}</textarea>
                @error('images')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Uma URL por linha</p>
            </div>
        </div>
    </div>

    <!-- SEO Configuration -->
    <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <i class="fi fi-rr-search text-orange-400 text-2xl mr-3"></i>
            Configuração SEO
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Meta Title -->
            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-300 mb-2">
                    Título Meta (SEO)
                </label>
                <input type="text" 
                       name="meta_title" 
                       id="meta_title" 
                       value="{{ old('meta_title') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 transition-all @error('meta_title') border-red-500/50 @enderror"
                       placeholder="Título para SEO (máx. 70 caracteres)"
                       maxlength="70">
                @error('meta_title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe em branco para usar o título do projeto</p>
            </div>

            <!-- Meta Description -->
            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição Meta (SEO)
                </label>
                <textarea name="meta_description" 
                          id="meta_description" 
                          rows="2"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 transition-all @error('meta_description') border-red-500/50 @enderror"
                          placeholder="Descrição para SEO (máx. 160 caracteres)"
                          maxlength="160">{{ old('meta_description') }}</textarea>
                @error('meta_description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe em branco para usar a descrição do projeto</p>
            </div>

            <!-- Meta Keywords -->
            <div>
                <label for="meta_keywords" class="block text-sm font-medium text-gray-300 mb-2">
                    Palavras-chave (SEO)
                </label>
                <input type="text" 
                       name="meta_keywords" 
                       id="meta_keywords" 
                       value="{{ old('meta_keywords') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 transition-all @error('meta_keywords') border-red-500/50 @enderror"
                       placeholder="Ex: desenvolvimento web, laravel, design responsivo">
                @error('meta_keywords')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Palavras-chave separadas por vírgula</p>
            </div>

            <!-- Open Graph Title -->
            <div>
                <label for="og_title" class="block text-sm font-medium text-gray-300 mb-2">
                    Título Open Graph
                </label>
                <input type="text" 
                       name="og_title" 
                       id="og_title" 
                       value="{{ old('og_title') }}"
                       class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 transition-all @error('og_title') border-red-500/50 @enderror"
                       placeholder="Título para compartilhamento em redes sociais"
                       maxlength="70">
                @error('og_title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe em branco para usar o título meta</p>
            </div>

            <!-- Open Graph Description -->
            <div>
                <label for="og_description" class="block text-sm font-medium text-gray-300 mb-2">
                    Descrição Open Graph
                </label>
                <textarea name="og_description" 
                          id="og_description" 
                          rows="2"
                          class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 transition-all @error('og_description') border-red-500/50 @enderror"
                          placeholder="Descrição para compartilhamento em redes sociais"
                          maxlength="200">{{ old('og_description') }}</textarea>
                @error('og_description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe em branco para usar a descrição meta</p>
            </div>

            <!-- Open Graph Image -->
            <div>
                <label for="og_image" class="block text-sm font-medium text-gray-300 mb-2">
                    Imagem Open Graph
                </label>
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center justify-center w-full">
                        <label for="og_image" class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer bg-gray-700/30 border-gray-600/50 hover:bg-gray-700/50">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fi fi-rr-cloud-upload text-gray-400 text-2xl mb-2"></i>
                                <p class="text-xs text-gray-400">Imagem para redes sociais (1200x630px)</p>
                            </div>
                            <input id="og_image" name="og_image" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                    <div class="text-center text-sm text-gray-400">ou</div>
                    <input type="url" 
                           name="og_image_url" 
                           id="og_image_url" 
                           value="{{ old('og_image_url') }}"
                           class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-orange-500/50 focus:ring-2 focus:ring-orange-500/20 transition-all"
                           placeholder="https://exemplo.com/og-image.jpg">
                </div>
                @error('og_image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                @error('og_image_url')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-400">Deixe em branco para usar a imagem destacada</p>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <button type="submit" 
                class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium px-8 py-4 rounded-2xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500/50 shadow-lg shadow-purple-500/20">
            <div class="flex items-center space-x-2">
                <i class="fi fi-rr-plus text-white text-xl"></i>
                <span>Criar Projeto</span>
            </div>
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        // Slug generation will be handled by the backend
    });
    
    // Preview image upload
    document.getElementById('featured_image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            const fileInput = e.target;
            const fileLabel = fileInput.parentElement;
            
            reader.onload = function(e) {
                // Create preview
                const preview = document.createElement('div');
                preview.className = 'absolute inset-0 bg-cover bg-center bg-no-repeat';
                preview.style.backgroundImage = `url('${e.target.result}')`;
                preview.style.borderRadius = 'inherit';
                
                // Add overlay
                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-black/50 flex items-center justify-center';
                overlay.innerHTML = '<p class="text-white text-sm">Clique para alterar</p>';
                
                // Clear previous preview
                const previousPreview = fileLabel.querySelector('.absolute');
                if (previousPreview) {
                    previousPreview.remove();
                }
                
                fileLabel.appendChild(preview);
                fileLabel.appendChild(overlay);
                fileLabel.querySelector('.flex-col').style.display = 'none';
            }
            
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});
</script>
@endsection 