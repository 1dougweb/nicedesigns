/**
 * Sistema de Validação de Formulários em Português
 * Nice Designs - Formulários com validação HTML5 customizada
 */

class FormValidator {
    constructor(formId, options = {}) {
        this.form = document.getElementById(formId);
        this.options = {
            showSuccessMessage: options.showSuccessMessage || false,
            validateOnInput: options.validateOnInput !== false,
            focusOnError: options.focusOnError !== false,
            ...options
        };
        
        if (!this.form) {
            console.warn(`Formulário com ID '${formId}' não encontrado.`);
            return;
        }
        
        this.init();
    }
    
    // Mensagens de validação padrão em português
    static validationMessages = {
        valueMissing: {
            default: 'Este campo é obrigatório.',
            email: 'O campo e-mail é obrigatório.',
            password: 'O campo senha é obrigatório.',
            name: 'O campo nome é obrigatório.',
            terms: 'Você deve concordar com os termos de serviço.',
            checkbox: 'Este campo deve ser marcado.',
            radio: 'Selecione uma opção.'
        },
        typeMismatch: {
            email: 'Por favor, insira um endereço de e-mail válido.',
            url: 'Por favor, insira uma URL válida.',
            number: 'Por favor, insira um número válido.',
            tel: 'Por favor, insira um número de telefone válido.'
        },
        tooShort: {
            default: 'Este campo deve ter pelo menos :min caracteres.',
            password: 'A senha deve ter pelo menos :min caracteres.',
            name: 'O nome deve ter pelo menos :min caracteres.'
        },
        tooLong: {
            default: 'Este campo deve ter no máximo :max caracteres.'
        },
        patternMismatch: {
            default: 'O formato inserido não é válido.',
            email: 'Por favor, insira um endereço de e-mail válido.',
            phone: 'Por favor, insira um número de telefone válido.',
            zipcode: 'Por favor, insira um CEP válido (formato: 00000-000).'
        },
        rangeUnderflow: {
            default: 'O valor deve ser maior ou igual a :min.'
        },
        rangeOverflow: {
            default: 'O valor deve ser menor ou igual a :max.'
        },
        stepMismatch: {
            default: 'Por favor, insira um valor válido.'
        },
        customError: {
            passwordMismatch: 'As senhas não coincidem.',
            weakPassword: 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número.'
        }
    };
    
    init() {
        // Adicionar novalidate para prevenir validação nativa do browser
        this.form.setAttribute('novalidate', '');
        
        // Configurar validação em tempo real se habilitada
        if (this.options.validateOnInput) {
            this.setupRealTimeValidation();
        }
        
        // Configurar interceptação do submit
        this.setupSubmitHandler();
        
        // Configurar validações customizadas
        this.setupCustomValidations();
    }
    
    setupRealTimeValidation() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Limpar erro quando usuário começar a digitar/alterar
            const events = input.type === 'checkbox' || input.type === 'radio' ? ['change'] : ['input', 'blur'];
            
            events.forEach(event => {
                input.addEventListener(event, () => {
                    if (event === 'input') {
                        // Só validar se o campo já teve algum erro antes
                        if (input.classList.contains('field-error')) {
                            this.validateField(input);
                        }
                    } else if (event === 'blur') {
                        // Validar quando perder o foco
                        this.validateField(input);
                    } else if (event === 'change') {
                        // Para checkboxes e radios
                        this.validateField(input);
                    }
                });
            });
        });
    }
    
    setupSubmitHandler() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                return false;
            }
            
            // Executar callback de submit customizado se definido
            if (this.options.onSubmit) {
                return this.options.onSubmit(e);
            }
        });
    }
    
    setupCustomValidations() {
        // Validação de confirmação de senha
        const passwordField = this.form.querySelector('input[name="password"]');
        const passwordConfirmField = this.form.querySelector('input[name="password_confirmation"]');
        
        if (passwordField && passwordConfirmField) {
            const validatePasswordMatch = () => {
                if (passwordConfirmField.value && passwordField.value !== passwordConfirmField.value) {
                    this.setCustomError(passwordConfirmField, 'passwordMismatch');
                } else {
                    this.clearCustomError(passwordConfirmField);
                }
            };
            
            passwordField.addEventListener('input', validatePasswordMatch);
            passwordConfirmField.addEventListener('input', validatePasswordMatch);
        }
    }
    
    validateForm() {
        const inputs = this.form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        let firstInvalidField = null;
        
        // Limpar todos os erros anteriores
        this.clearAllErrors();
        
        inputs.forEach(input => {
            if (!this.validateField(input) && !firstInvalidField) {
                firstInvalidField = input;
                isValid = false;
            }
        });
        
        // Focar no primeiro campo com erro
        if (!isValid && firstInvalidField && this.options.focusOnError) {
            firstInvalidField.focus();
        }
        
        return isValid;
    }
    
    validateField(input) {
        // Limpar erro anterior
        this.clearFieldError(input);
        
        // Verificar validade nativa
        if (!input.checkValidity()) {
            const message = this.getValidationMessage(input);
            this.showFieldError(input, message);
            return false;
        }
        
        return true;
    }
    
    getValidationMessage(input) {
        const validity = input.validity;
        const fieldName = input.name;
        const fieldType = input.type;
        
        // Verificar qual tipo de erro
        if (validity.valueMissing) {
            return this.getMessage('valueMissing', fieldName) || 
                   this.getMessage('valueMissing', fieldType) || 
                   FormValidator.validationMessages.valueMissing.default;
        }
        
        if (validity.typeMismatch) {
            return FormValidator.validationMessages.typeMismatch[fieldType] || 
                   FormValidator.validationMessages.typeMismatch.email;
        }
        
        if (validity.tooShort) {
            const message = this.getMessage('tooShort', fieldName) || 
                           this.getMessage('tooShort', fieldType) || 
                           FormValidator.validationMessages.tooShort.default;
            return message.replace(':min', input.getAttribute('minlength') || input.minLength);
        }
        
        if (validity.tooLong) {
            const message = FormValidator.validationMessages.tooLong.default;
            return message.replace(':max', input.getAttribute('maxlength') || input.maxLength);
        }
        
        if (validity.patternMismatch) {
            return this.getMessage('patternMismatch', fieldName) || 
                   FormValidator.validationMessages.patternMismatch.default;
        }
        
        if (validity.rangeUnderflow) {
            const message = FormValidator.validationMessages.rangeUnderflow.default;
            return message.replace(':min', input.min);
        }
        
        if (validity.rangeOverflow) {
            const message = FormValidator.validationMessages.rangeOverflow.default;
            return message.replace(':max', input.max);
        }
        
        if (validity.customError) {
            return input.validationMessage;
        }
        
        return 'Por favor, corrija este campo.';
    }
    
    getMessage(type, key) {
        return FormValidator.validationMessages[type]?.[key];
    }
    
    showFieldError(input, message) {
        // Adicionar classes de erro
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.classList.add('border-red-400');
        } else {
            input.classList.add('border-red-400', 'focus:ring-red-500', 'field-error');
            input.classList.remove('border-white/20', 'border-gray-300', 'focus:ring-blue-500', 'focus:ring-purple-500');
        }
        
        // Criar elemento de erro
        const errorElement = document.createElement('p');
        errorElement.className = 'text-red-400 text-sm mt-2 flex items-center field-error-message';
        errorElement.innerHTML = `
            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            ${message}
        `;
        
        // Inserir elemento de erro
        const container = input.closest('.form-group') || input.parentNode.parentNode;
        container.appendChild(errorElement);
    }
    
    clearFieldError(input) {
        // Remover classes de erro
        input.classList.remove('border-red-400', 'focus:ring-red-500', 'field-error');
        
        // Restaurar classes padrão baseado no contexto
        if (input.closest('[class*="bg-white/10"]')) {
            // Contexto escuro (formulários de auth)
            input.classList.add('border-white/20');
            if (input.closest('[class*="purple"]')) {
                input.classList.add('focus:ring-purple-500');
            } else {
                input.classList.add('focus:ring-blue-500');
            }
        } else {
            // Contexto claro
            input.classList.add('border-gray-300', 'focus:ring-blue-500');
        }
        
        // Remover mensagem de erro
        const container = input.closest('.form-group') || input.parentNode.parentNode;
        const errorMessage = container.querySelector('.field-error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
        
        // Limpar validação customizada
        input.setCustomValidity('');
    }
    
    clearAllErrors() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => this.clearFieldError(input));
    }
    
    setCustomError(input, errorType, customMessage = null) {
        const message = customMessage || FormValidator.validationMessages.customError[errorType] || 'Erro de validação.';
        input.setCustomValidity(message);
        this.showFieldError(input, message);
    }
    
    clearCustomError(input) {
        input.setCustomValidity('');
        this.clearFieldError(input);
    }
    
    // Método público para adicionar validações customizadas
    addCustomValidation(fieldSelector, validationFunction, errorMessage) {
        const field = this.form.querySelector(fieldSelector);
        if (!field) return;
        
        field.addEventListener('input', () => {
            if (validationFunction(field.value, field)) {
                this.clearCustomError(field);
            } else {
                this.setCustomError(field, 'custom', errorMessage);
            }
        });
    }
    
    // Método para definir mensagens personalizadas
    static setCustomMessages(messages) {
        FormValidator.validationMessages = {
            ...FormValidator.validationMessages,
            ...messages
        };
    }
}

// Função helper para inicializar validação rapidamente
window.initFormValidation = function(formId, options = {}) {
    return new FormValidator(formId, options);
};

// Função para alternar visibilidade de senha (global)
window.togglePasswordVisibility = function(inputId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(inputId + '-eye');
    
    if (!input || !eye) return;
    
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
};

// Exportar para uso como módulo se necessário
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FormValidator;
} 