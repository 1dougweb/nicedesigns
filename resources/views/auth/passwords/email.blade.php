@extends('layouts.app')

@section('title', '- Recuperar Senha')

@section('content')
<section class="bg-gradient-to-r from-gray-900 to-blue-900 text-white py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Recuperar Senha</h1>
            <p class="text-xl text-gray-300">
                Insira seu email para receber o link de recuperação
            </p>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                        Enviar Link de Recuperação
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