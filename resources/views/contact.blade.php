@extends('layouts.app')

@section('title', '- Contato')
@section('meta_description', 'Entre em contato com a Nice Designs. Transforme sua presença digital com nossa agência especializada em web design moderno.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-blue-900 text-white py-24 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg>')"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-blue-600/20 border border-blue-400/30 rounded-full text-blue-400 text-sm font-semibold mb-8 backdrop-blur-sm">
                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></span>
                Vamos Conversar
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold mb-8 leading-tight">
                Transforme sua 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                    Visão Digital
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
                Pronto para começar seu projeto? Entre em contato conosco e vamos criar algo incrível juntos.
            </p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl p-8 border border-gray-700 shadow-2xl">
                <h2 class="text-3xl font-bold text-white mb-8">Envie uma Mensagem</h2>
                
                @if(session('success'))
                    <div class="bg-green-600/20 border border-green-400/30 text-green-400 px-6 py-4 rounded-xl mb-8 backdrop-blur-sm">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nome *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 backdrop-blur-sm"
                                   placeholder="Seu nome completo">
                            @error('name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-mail *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 backdrop-blur-sm"
                                   placeholder="seu@email.com">
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Telefone</label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 backdrop-blur-sm"
                               placeholder="(11) 99999-9999">
                        @error('phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Assunto *</label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}"
                               required
                               class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 backdrop-blur-sm"
                               placeholder="Como podemos ajudar?">
                        @error('subject')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Mensagem *</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 backdrop-blur-sm resize-none"
                                  placeholder="Conte-nos sobre seu projeto ou dúvida...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold py-4 px-8 rounded-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25"
                            aria-label="Enviar mensagem de contato">
                        <span class="inline-flex items-center">
                            Enviar Mensagem
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-8">Informações de Contato</h2>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Estamos aqui para transformar suas ideias em realidade digital. Entre em contato através dos canais abaixo.
                    </p>
                </div>

                <div class="space-y-6">
                    <!-- Email -->
                    <div class="bg-gray-800/30 backdrop-blur-md rounded-2xl p-6 border border-gray-700 hover:border-blue-500/50 transition-all duration-300 hover:scale-105">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">E-mail</h3>
                                <p class="text-gray-300">contato@nicedesigns.com.br</p>
                                <p class="text-gray-400 text-sm mt-1">Resposta em até 24h</p>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="bg-gray-800/30 backdrop-blur-md rounded-2xl p-6 border border-gray-700 hover:border-green-500/50 transition-all duration-300 hover:scale-105">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">Telefone</h3>
                                <p class="text-gray-300">(11) 99999-9999</p>
                                <p class="text-gray-400 text-sm mt-1">Seg à Sex, 9h às 18h</p>
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="bg-gray-800/30 backdrop-blur-md rounded-2xl p-6 border border-gray-700 hover:border-purple-500/50 transition-all duration-300 hover:scale-105">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">Localização</h3>
                                <p class="text-gray-300">São Paulo, SP</p>
                                <p class="text-gray-400 text-sm mt-1">Atendimento remoto e presencial</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-gray-800/30 backdrop-blur-md rounded-2xl p-6 border border-gray-700">
                    <h3 class="text-lg font-semibold text-white mb-4">Redes Sociais</h3>
                    <div class="flex space-x-4">
                        <a href="#" 
                           class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300"
                           aria-label="Siga-nos no Twitter">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300"
                           aria-label="Siga-nos no Pinterest">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.146-1.378l.584-2.197c.242-.906.473-1.847.473-2.298 0-.532-.285-.976-.878-.976-.695 0-1.254.719-1.254 1.684 0 .615.233 1.041.233 1.041l-.947 4.02c-.279 1.198-.042 2.667.105 3.518C-.837 21.404 4.396 24 12.017 24c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300"
                           aria-label="Conecte-se conosco no LinkedIn">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" 
                           class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white hover:scale-110 transition-transform duration-300"
                           aria-label="Fale conosco no WhatsApp">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-6">Perguntas Frequentes</h2>
            <p class="text-xl text-gray-300">Esclarecemos as dúvidas mais comuns sobre nossos serviços</p>
        </div>

        <div class="space-y-6">
            <div class="bg-gray-700/50 backdrop-blur-md rounded-2xl border border-gray-600">
                <button class="w-full text-left px-6 py-4 focus:outline-none" 
                        onclick="toggleFaq(1)"
                        aria-label="Expandir pergunta sobre tempo de desenvolvimento"
                        aria-expanded="false"
                        aria-controls="content-1">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Quanto tempo leva para desenvolver um site?</h3>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" id="icon-1" aria-hidden="true">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div class="hidden px-6 pb-4" id="content-1">
                    <p class="text-gray-300">O tempo de desenvolvimento varia de acordo com a complexidade do projeto. Sites simples podem ser entregues em 2-3 semanas, enquanto projetos mais complexos podem levar de 1-3 meses.</p>
                </div>
            </div>

            <div class="bg-gray-700/50 backdrop-blur-md rounded-2xl border border-gray-600">
                <button class="w-full text-left px-6 py-4 focus:outline-none" 
                        onclick="toggleFaq(2)"
                        aria-label="Expandir pergunta sobre suporte pós-entrega"
                        aria-expanded="false"
                        aria-controls="content-2">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">Vocês oferecem suporte após a entrega?</h3>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" id="icon-2" aria-hidden="true">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div class="hidden px-6 pb-4" id="content-2">
                    <p class="text-gray-300">Sim! Oferecemos 30 dias de suporte gratuito após a entrega. Também temos planos de manutenção mensal para atualizações e melhorias contínuas.</p>
                </div>
            </div>

            <div class="bg-gray-700/50 backdrop-blur-md rounded-2xl border border-gray-600">
                <button class="w-full text-left px-6 py-4 focus:outline-none" 
                        onclick="toggleFaq(3)"
                        aria-label="Expandir pergunta sobre responsividade"
                        aria-expanded="false"
                        aria-controls="content-3">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white">O site será responsivo?</h3>
                        <svg class="w-5 h-5 text-gray-400 transform transition-transform" id="icon-3" aria-hidden="true">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>
                <div class="hidden px-6 pb-4" id="content-3">
                    <p class="text-gray-300">Absolutamente! Todos os nossos sites são desenvolvidos com design responsivo, garantindo perfeita visualização em desktop, tablet e smartphone.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFaq(index) {
    const content = document.getElementById(`content-${index}`);
    const icon = document.getElementById(`icon-${index}`);
    const button = document.querySelector(`[aria-controls="content-${index}"]`);
    
    const isExpanded = !content.classList.contains('hidden');
    
    content.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
    button.setAttribute('aria-expanded', !isExpanded);
}
</script>
@endsection 