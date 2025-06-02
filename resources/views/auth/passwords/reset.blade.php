@extends('layouts.app')

@section('title', '- Redefinir Senha')

@section('content')
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Redefinir Senha</h1>
            <p class="text-xl text-gray-300">
                Crie uma nova senha para sua conta
            </p>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nova Senha
                    </label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmar Nova Senha
                    </label>
                    <input id="password-confirm" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="mb-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                        Redefinir Senha
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Voltar ao Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection 