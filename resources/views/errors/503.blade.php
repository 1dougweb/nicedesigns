<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Serviço temporariamente indisponível | {{ config('app.name', 'Nice Designs') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <meta name="description" content="Serviço temporariamente indisponível - 503">
    <meta name="robots" content="noindex, nofollow">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
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
        
        .progress-bar {
            animation: progress 3s ease-in-out infinite;
        }
        
        @keyframes progress {
            0%, 100% { width: 0%; }
            50% { width: 100%; }
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
        <!-- 503 Number -->
        <div class="slide-in mb-8">
            <h1 class="text-8xl md:text-9xl lg:text-[12rem] font-bold text-white pulse-glow mb-4">
                503
            </h1>
        </div>

        <!-- Error Message -->
        <div class="slide-in glass-effect rounded-3xl p-8 md:p-12 mb-8">
            <div class="mb-6">
                <svg class="w-16 h-16 md:w-20 md:h-20 mx-auto text-white/80 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">
                Serviço Temporariamente Indisponível
            </h2>
            
            <p class="text-lg md:text-xl text-white/80 mb-6 max-w-2xl mx-auto leading-relaxed">
                Estamos realizando manutenção em nossos serviços para melhorar sua experiência. Voltaremos em breve!
            </p>
            
            <!-- Progress Bar -->
            <div class="bg-white/10 rounded-full h-2 mb-6 overflow-hidden">
                <div class="progress-bar bg-white/40 h-full rounded-full"></div>
            </div>
            
            <div class="bg-white/5 rounded-2xl p-6 mb-8 text-left">
                <h3 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Durante a manutenção:
                </h3>
                <ul class="text-white/80 space-y-2">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Melhoramos a performance do sistema
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Aplicamos atualizações de segurança
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                        </svg>
                        Adicionamos novas funcionalidades
                    </li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <button onclick="window.location.reload()" 
                        class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-semibold rounded-2xl hover:bg-gray-100 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Tentar Novamente
                </button>
                
                <a href="mailto:contato@nicedesigns.com.br" 
                   class="inline-flex items-center px-8 py-4 bg-white/10 text-white font-semibold rounded-2xl hover:bg-white/20 transition-all duration-300 border border-white/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contato
                </a>
            </div>
        </div>

        <!-- Status Updates -->
        <div class="slide-in glass-effect rounded-3xl p-6 mb-8">
            <h3 class="text-white font-semibold mb-4">Atualizações em Tempo Real</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl">
                    <span class="text-white/80">Manutenção iniciada</span>
                    <span class="text-green-300" id="maintenance-time">--:--</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl">
                    <span class="text-white/80">Tempo estimado</span>
                    <span class="text-purple-300">30-60 minutos</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl">
                    <span class="text-white/80">Status</span>
                    <span class="text-yellow-300 flex items-center">
                        <div class="w-2 h-2 bg-yellow-300 rounded-full mr-2 animate-pulse"></div>
                        Em andamento
                    </span>
                </div>
            </div>
        </div>

        <div class="slide-in mt-8 text-center">
            <p class="text-white/60 text-sm">
                Acompanhe nossas redes sociais para atualizações em tempo real sobre a manutenção.
            </p>
        </div>
    </div>

    <script>
        // Update maintenance time every second
        function updateMaintenanceTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            document.getElementById('maintenance-time').textContent = timeString;
        }
        
        // Auto-refresh every 30 seconds
        let refreshInterval;
        
        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                window.location.reload();
            }, 30000); // 30 seconds
        }
        
        // Update time immediately and then every second
        updateMaintenanceTime();
        setInterval(updateMaintenanceTime, 1000);
        
        // Start auto-refresh after 2 minutes
        setTimeout(startAutoRefresh, 120000);
        
        // Add visual feedback for refresh attempts
        let refreshAttempts = 0;
        const maxAttempts = 10;
        
        function attemptRefresh() {
            refreshAttempts++;
            if (refreshAttempts <= maxAttempts) {
                setTimeout(() => {
                    window.location.reload();
                }, 5000 * refreshAttempts); // Exponential backoff
            }
        }
    </script>
</body>
</html> 