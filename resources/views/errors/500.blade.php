<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erro interno do servidor | {{ config('app.name', 'Nice Designs') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <meta name="description" content="Erro interno do servidor - 500">
    <meta name="robots" content="noindex, nofollow">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            min-height: 100vh;
        }
        
        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulse-glow {
            from {
                text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            }
            to {
                text-shadow: 0 0 30px rgba(255, 255, 255, 0.8);
            }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-animation absolute top-20 left-20 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="floating-animation absolute top-40 right-32 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
        <div class="floating-animation absolute bottom-20 left-1/3 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <!-- 500 Number -->
        <div class="slide-in mb-8">
            <h1 class="text-8xl md:text-9xl lg:text-[12rem] font-bold text-white pulse-glow mb-4">
                500
            </h1>
        </div>

        <!-- Error Message -->
        <div class="slide-in glass-effect rounded-3xl p-8 md:p-12 mb-8">
            <div class="mb-6">
                <svg class="w-16 h-16 md:w-20 md:h-20 mx-auto text-white/80 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">
                Erro Interno do Servidor
            </h2>
            
            <p class="text-lg md:text-xl text-white/80 mb-6 max-w-2xl mx-auto leading-relaxed">
                Algo deu errado em nossos servidores. Nossa equipe foi notificada e está trabalhando para resolver o problema.
            </p>
            
            <div class="bg-white/5 rounded-2xl p-6 mb-8 text-left">
                <h3 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    O que você pode fazer:
                </h3>
                <ul class="text-white/80 space-y-2">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Tente recarregar a página em alguns minutos
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Volte à página inicial
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Entre em contato se o problema persistir
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-8 py-4 bg-white text-red-600 font-semibold rounded-2xl hover:bg-gray-100 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Voltar ao Início
                </a>
                
                <button onclick="window.location.reload()" 
                        class="inline-flex items-center px-8 py-4 bg-white/10 text-white font-semibold rounded-2xl hover:bg-white/20 transition-all duration-300 border border-white/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Tentar Novamente
                </button>
            </div>
        </div>

        <div class="slide-in mt-8 text-center">
            <p class="text-white/60 text-sm">
                Código do erro: {{ $exception->getMessage() ?? 'Erro interno do servidor' }}
            </p>
        </div>
    </div>
</body>
</html> 