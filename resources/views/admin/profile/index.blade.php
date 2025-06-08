@extends('layouts.admin')

@section('title', '- Meu Perfil')
@section('page-title', 'Meu Perfil')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white">Meu Perfil</h2>
        <p class="text-gray-400 mt-1">Gerencie suas informações pessoais e configurações da conta</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Form -->
    <div class="lg:col-span-2">
        <!-- Avatar Upload Section -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8 mb-8">
            <h3 class="text-xl font-bold text-white mb-6">Foto do Perfil</h3>
            
            <div class="flex items-center space-x-6">
                <div class="relative">
                    @if($user->avatar)
                        <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-gray-700">
                    @else
                        <div id="avatar-preview" class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-gray-700">
                            <span class="text-white font-bold text-2xl">{{ substr($user->name, 0, 2) }}</span>
                        </div>
                    @endif
                    
                    <!-- Upload Button Overlay -->
                    <label for="avatar-upload" class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                        <i class="fi fi-rr-camera text-white text-xl"></i>
                    </label>
                    <input type="file" id="avatar-upload" class="hidden" accept="image/*">
                </div>
                
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-white mb-2">Foto do Perfil</h4>
                    <p class="text-gray-400 text-sm mb-4">Adicione uma foto para personalizar seu perfil. Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</p>
                    
                    <div class="flex space-x-4">
                        <label for="avatar-upload" class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-4 py-2 rounded-xl font-medium transition-all duration-300 cursor-pointer">
                            <i class="fi fi-rr-upload mr-2"></i>
                            Carregar Nova Foto
                        </label>
                        
                        @if($user->avatar)
                            <form method="POST" action="{{ route('admin.profile.remove-avatar') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600/20 text-red-300 border border-red-600/30 hover:bg-red-600/30 px-4 py-2 rounded-xl font-medium transition-all duration-300">
                                    <i class="fi fi-rr-trash mr-2"></i>
                                    Remover
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <h3 class="text-xl font-bold text-white mb-6">Informações Pessoais</h3>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nome de Usuário</label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-300 mb-2">Nome Completo</label>
                        <input type="text" name="full_name" id="full_name" 
                               value="{{ old('full_name', $user->full_name) }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('full_name') border-red-500 @enderror">
                        @error('full_name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-mail</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Telefone</label>
                        <input type="text" name="phone" id="phone" 
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="(11) 99999-9999">
                        @error('phone')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-300 mb-2">Cargo</label>
                        <input type="text" name="position" id="position" 
                               value="{{ old('position', $user->position) }}"
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('position') border-red-500 @enderror">
                        @error('position')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Biografia</label>
                    <textarea name="bio" id="bio" rows="4" 
                              class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                              placeholder="Conte um pouco sobre você...">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="bg-blue-600/20 text-blue-300 border border-blue-600/30 hover:bg-blue-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300">
                    Salvar Informações
                </button>
            </form>
        </div>

        <!-- Password Change Section -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8 mt-8">
            <h3 class="text-xl font-bold text-white mb-6">Alterar Senha</h3>

            <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Senha Atual</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                           required>
                    @error('current_password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Nova Senha</label>
                        <input type="password" name="password" id="password" 
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full bg-gray-700/50 border border-gray-600/50 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                               required>
                    </div>
                </div>

                <button type="submit" 
                        class="bg-yellow-600/20 text-yellow-300 border border-yellow-600/30 hover:bg-yellow-600/30 px-6 py-3 rounded-2xl font-medium transition-all duration-300">
                    Alterar Senha
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Profile Info -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4">Informações da Conta</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">Tipo de conta:</span>
                    <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-full text-xs font-medium">
                        Administrador
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">Conta criada:</span>
                    <span class="text-white text-sm">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">Último acesso:</span>
                    <span class="text-white text-sm">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Admin Stats -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-6">
            <h3 class="text-xl font-bold text-white mb-4">Estatísticas</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">Posts criados:</span>
                    <span class="text-white text-sm font-semibold">{{ $user->posts()->count() ?? 0 }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-300 text-sm">Projetos criados:</span>
                    <span class="text-white text-sm font-semibold">{{ $user->projects()->count() ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Phone masking
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length <= 11) {
                if (value.length <= 2) {
                    value = value.replace(/^(\d{0,2})/, '($1');
                } else if (value.length <= 6) {
                    value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
                } else if (value.length === 10) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                }
            }
            
            e.target.value = value;
        });
    }

    // Avatar upload
    const avatarUpload = document.getElementById('avatar-upload');
    const avatarPreview = document.getElementById('avatar-preview');

    if (avatarUpload && avatarPreview) {
        avatarUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validate file type
                if (!file.type.match(/^image\/(jpeg|png|jpg|gif)$/)) {
                    alert('Por favor, selecione apenas arquivos de imagem (JPEG, PNG, GIF).');
                    return;
                }
                
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('O arquivo deve ter no máximo 2MB.');
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-24 h-24 rounded-full object-cover border-4 border-gray-700">`;
                };
                reader.readAsDataURL(file);
                
                // Upload via AJAX
                uploadAvatar(file);
            }
        });
    }

    function uploadAvatar(file) {
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        fetch('{{ route("admin.profile.upload-avatar") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update avatar preview with new URL
                avatarPreview.innerHTML = `<img src="${data.avatar_url}?t=${new Date().getTime()}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-gray-700">`;
                
                // Show success message (you can implement a toast notification here)
                showNotification(data.message, 'success');
            } else {
                showNotification('Erro ao fazer upload da imagem', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erro ao fazer upload da imagem', 'error');
        });
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-600 text-white' : 
            type === 'error' ? 'bg-red-600 text-white' : 
            'bg-blue-600 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fi fi-rr-${type === 'success' ? 'check' : type === 'error' ? 'cross' : 'info'} w-5 h-5 mr-3"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateY(0)';
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fi fi-rr-spinner animate-spin mr-2"></i>Salvando...';
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = submitButton.getAttribute('data-original-text') || 'Salvar';
                }, 5000);
            }
        });
    });
});
</script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    showNotification('{{ session("success") }}', 'success');
});

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-600 text-white' : 
        type === 'error' ? 'bg-red-600 text-white' : 
        'bg-blue-600 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fi fi-rr-${type === 'success' ? 'check' : type === 'error' ? 'cross' : 'info'} w-5 h-5 mr-3"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateY(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateY(-100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endif
@endpush
@endsection 