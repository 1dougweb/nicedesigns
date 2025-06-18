@extends('layouts.app')

@section('title', '- Registro')
@section('meta_description', 'Crie sua conta na Nice Designs e tenha acesso completo ao nosso painel administrativo.')

@section('content')
<!-- Register Section -->
<section class="min-h-screen bg-gradient-to-br from-black via-gray-900 to-purple-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><path d="m36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/></g></g></svg></div>
    </div>

    <!-- Animated Blobs -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative">
        <!-- Header -->
        <div class="text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-2xl">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            
            <h2 class="text-4xl font-bold text-white mb-4">
                Junte-se a nós!
            </h2>
            <p class="text-gray-300 text-lg">
                Crie sua conta e comece a usar nossos serviços
            </p>
        </div>

        <!-- Register Form -->
        <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-2xl">
            <!-- Exibir erros de validação em destaque -->
            @if($errors->any())
                <div class="bg-red-600/20 border border-red-400/30 text-red-400 px-6 py-4 rounded-xl mb-8 backdrop-blur-sm">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Erro no cadastro</p>
                            <p class="text-sm">Corrija os campos destacados e tente novamente.</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6" id="register-form" novalidate>
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Nome Completo *
                    </label>
                    <div class="relative">
                        <input id="name" 
                               name="name" 
                               type="text" 
                               value="{{ old('name') }}"
                               required 
                               minlength="2"
                               autocomplete="name"
                               data-required-message="O campo nome é obrigatório"
                               data-minlength-message="O nome deve ter pelo menos 2 caracteres"
                               class="w-full px-4 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-300 pl-12 @error('name') border-red-400 focus:ring-red-500 @enderror"
                               placeholder="Seu nome completo">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                        E-mail *
                    </label>
                    <div class="relative">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               value="{{ old('email') }}"
                               required 
                               autocomplete="email"
                               data-validate-message="Por favor, insira um endereço de e-mail válido"
                               data-required-message="O campo e-mail é obrigatório"
                               class="w-full px-4 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-300 pl-12 @error('email') border-red-400 focus:ring-red-500 @enderror"
                               placeholder="seu@email.com">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                        Senha *
                    </label>
                    <div class="relative">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               minlength="8"
                               autocomplete="new-password"
                               data-required-message="O campo senha é obrigatório"
                               data-minlength-message="A senha deve ter pelo menos 8 caracteres"
                               class="w-full px-4 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-300 pl-12 pr-12 @error('password') border-red-400 focus:ring-red-500 @enderror"
                               placeholder="••••••••">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <button type="button" 
                                onclick="togglePasswordVisibility('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white transition-colors">
                            <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        Confirmar Senha *
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               required 
                               minlength="8"
                               autocomplete="new-password"
                               data-required-message="A confirmação de senha é obrigatória"
                               data-match-message="As senhas não coincidem"
                               class="w-full px-4 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-300 pl-12 pr-12 @error('password_confirmation') border-red-400 focus:ring-red-500 @enderror"
                               placeholder="••••••••">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <button type="button" 
                                onclick="togglePasswordVisibility('password_confirmation')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white transition-colors">
                            <svg id="password_confirmation-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <input id="terms" 
                           name="terms" 
                           type="checkbox" 
                           required
                           data-required-message="Você deve concordar com os termos de serviço"
                           class="w-4 h-4 text-purple-600 bg-white/10 border-white/20 rounded focus:ring-purple-500 focus:ring-2 mt-1 @error('terms') border-red-400 @enderror">
                    <label for="terms" class="ml-3 text-sm text-gray-300 leading-relaxed">
                        Eu concordo com os 
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">Termos de Serviço</a> 
                        e 
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">Política de Privacidade</a> *
                    </label>
                </div>
                @error('terms')
                    <p class="text-red-400 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <!-- Submit Button -->
                <button type="submit" 
                        id="register-submit-btn"
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-4 px-8 rounded-xl transition duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/25 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <span class="inline-flex items-center">
                        <span id="register-btn-text">Criar Conta</span>
                        <svg id="register-btn-icon" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-transparent text-gray-400">
                        Já tem uma conta?
                    </span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" 
                   class="text-purple-400 hover:text-purple-300 font-semibold transition-colors">
                    Fazer login
                </a>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" 
               class="text-gray-400 hover:text-white transition-colors inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar ao início
            </a>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('register-form');
    const submitBtn = document.getElementById('register-submit-btn');
    const btnText = document.getElementById('register-btn-text');
    const btnIcon = document.getElementById('register-btn-icon');
    
    // Mensagens de validação customizadas em português
    const validationMessages = {
        name: {
            valueMissing: 'O campo nome é obrigatório.',
            tooShort: 'O nome deve ter pelo menos 2 caracteres.'
        },
        email: {
            valueMissing: 'O campo e-mail é obrigatório.',
            typeMismatch: 'Por favor, insira um endereço de e-mail válido.',
            patternMismatch: 'Por favor, insira um endereço de e-mail válido.'
        },
        password: {
            valueMissing: 'O campo senha é obrigatório.',
            tooShort: 'A senha deve ter pelo menos 8 caracteres.'
        },
        password_confirmation: {
            valueMissing: 'A confirmação de senha é obrigatória.',
            customMismatch: 'As senhas não coincidem.'
        },
        terms: {
            valueMissing: 'Você deve concordar com os termos de serviço.'
        }
    };
    
    // Aplicar validação customizada
    function setCustomValidation(input) {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            
            const fieldName = this.name;
            const validity = this.validity;
            let message = '';
            
            if (validity.valueMissing) {
                message = validationMessages[fieldName]?.valueMissing || 'Este campo é obrigatório.';
            } else if (validity.typeMismatch) {
                message = validationMessages[fieldName]?.typeMismatch || 'Por favor, insira um valor válido.';
            } else if (validity.tooShort) {
                message = validationMessages[fieldName]?.tooShort || 'Valor muito curto.';
            } else if (validity.patternMismatch) {
                message = validationMessages[fieldName]?.patternMismatch || 'Formato inválido.';
            } else if (validity.customError) {
                message = this.validationMessage || 'Valor inválido.';
            }
            
            this.setCustomValidity(message);
            showFieldError(this, message);
        });
        
        // Limpar mensagem quando usuário começar a digitar
        input.addEventListener('input', function() {
            this.setCustomValidity('');
            clearFieldError(this);
            
            // Validação especial para confirmação de senha
            if (this.name === 'password_confirmation') {
                validatePasswordMatch();
            }
        });
        
        // Para checkboxes
        if (input.type === 'checkbox') {
            input.addEventListener('change', function() {
                this.setCustomValidity('');
                clearFieldError(this);
            });
        }
    }
    
    // Validar se as senhas coincidem
    function validatePasswordMatch() {
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        
        if (password.value !== passwordConfirm.value && passwordConfirm.value !== '') {
            passwordConfirm.setCustomValidity('As senhas não coincidem.');
            showFieldError(passwordConfirm, 'As senhas não coincidem.');
        } else {
            passwordConfirm.setCustomValidity('');
            clearFieldError(passwordConfirm);
        }
    }
    
    // Mostrar erro no campo
    function showFieldError(input, message) {
        clearFieldError(input);
        
        if (input.type === 'checkbox') {
            input.classList.add('border-red-400');
        } else {
            input.classList.add('border-red-400', 'focus:ring-red-500');
            input.classList.remove('border-white/20', 'focus:ring-purple-500');
        }
        
        const errorDiv = document.createElement('p');
        errorDiv.className = 'text-red-400 text-sm mt-2 flex items-center field-error';
        errorDiv.innerHTML = `
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            ${message}
        `;
        
        // Para checkbox, inserir após o label
        if (input.type === 'checkbox') {
            input.parentNode.parentNode.appendChild(errorDiv);
        } else {
            input.parentNode.parentNode.appendChild(errorDiv);
        }
    }
    
    // Limpar erro do campo
    function clearFieldError(input) {
        if (input.type === 'checkbox') {
            input.classList.remove('border-red-400');
        } else {
            input.classList.remove('border-red-400', 'focus:ring-red-500');
            input.classList.add('border-white/20', 'focus:ring-purple-500');
        }
        
        const existingError = input.parentNode.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }
    
    // Aplicar validação aos campos
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const termsInput = document.getElementById('terms');
    
    setCustomValidation(nameInput);
    setCustomValidation(emailInput);
    setCustomValidation(passwordInput);
    setCustomValidation(passwordConfirmInput);
    setCustomValidation(termsInput);
    
    // Validação especial para confirmação de senha
    passwordInput.addEventListener('input', validatePasswordMatch);
    
    // Interceptar submit do formulário
    form.addEventListener('submit', function(e) {
        // Limpar erros anteriores
        const inputs = form.querySelectorAll('input[required]');
        inputs.forEach(input => {
            clearFieldError(input);
            input.setCustomValidity('');
        });
        
        // Validar confirmação de senha
        validatePasswordMatch();
        
        // Validar formulário
        if (!form.checkValidity()) {
            e.preventDefault();
            
            // Focar no primeiro campo com erro
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.focus();
            }
            
            return false;
        }
        
        // Mostrar loading no botão
        submitBtn.disabled = true;
        btnText.textContent = 'Criando conta...';
        btnIcon.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    });
});

// Função para alternar visibilidade da senha
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(inputId + '-eye');
    
    if (input.type === 'password') {
        input.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L15 15"></path>
        `;
    } else {
        input.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}
</script>
@endsection 