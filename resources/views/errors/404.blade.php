<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página não encontrada | {{ config('app.name', 'Nice Designs') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Meta Tags -->
    <meta name="description" content="Página não encontrada - 404">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Open Graph -->
    <meta property="og:title" content="404 - Página não encontrada">
    <meta property="og:description" content="A página que você está procurando não foi encontrada.">
    <meta property="og:type" content="website">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }
        
        .floating-animation:nth-child(2) {
            animation-delay: 1s;
        }
        
        .floating-animation:nth-child(3) {
            animation-delay: 2s;
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
                text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 0 40px rgba(255, 255, 255, 0.5);
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
        
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Decoration -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="floating-animation absolute top-20 left-20 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="floating-animation absolute top-40 right-32 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
        <div class="floating-animation absolute bottom-20 left-1/3 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="floating-animation absolute bottom-40 right-20 w-16 h-16 bg-white/15 rounded-full blur-lg"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <!-- 404 Number -->
        <div class="slide-in mb-8">
            <h1 class="text-8xl md:text-9xl lg:text-[12rem] font-bold text-white pulse-glow mb-4">
                404
            </h1>
        </div>

        <!-- Error Message -->
        <div class="slide-in glass-effect rounded-3xl p-8 md:p-12 mb-8 hover-scale">
            <div class="mb-6">
                <svg class="w-16 h-16 md:w-20 md:h-20 mx-auto text-white/80 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.343 0-4.441.815-6.111 2.17C3.8 15.77 2 13.79 2 11.5 2 7.358 6.477 4 12 4s10 3.358 10 7.5c0 2.29-1.8 4.27-3.889 5.67z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4">
                Oops! Página não encontrada
            </h2>
            
            <p class="text-lg md:text-xl text-white/80 mb-6 max-w-2xl mx-auto leading-relaxed">
                A página que você está procurando pode ter sido removida, teve seu nome alterado ou está temporariamente indisponível.
            </p>
            
            <!-- Search Suggestions -->
            <div class="bg-white/5 rounded-2xl p-6 mb-8 text-left">
                <h3 class="text-white font-semibold mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Sugestões:
                </h3>
                <ul class="text-white/80 space-y-2">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Verifique se o endereço foi digitado corretamente
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Use o menu de navegação para encontrar o que procura
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Volte à página inicial e navegue a partir dela
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-8 py-4 bg-white text-purple-600 font-semibold rounded-2xl hover:bg-gray-100 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Voltar ao Início
                </a>
                
                <button onclick="history.back()" 
                        class="inline-flex items-center px-8 py-4 bg-white/10 text-white font-semibold rounded-2xl hover:bg-white/20 transition-all duration-300 hover:scale-105 border border-white/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Página Anterior
                </button>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="slide-in glass-effect rounded-3xl p-6 hover-scale">
            <h3 class="text-white font-semibold mb-4">Navegação Rápida</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('home') }}" class="group text-center p-4 rounded-xl hover:bg-white/10 transition-all duration-300">
                    <svg class="w-8 h-8 mx-auto mb-2 text-white/80 group-hover:text-white group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-white/80 group-hover:text-white text-sm">Início</span>
                </a>
                
                @if(Route::has('posts.index'))
                <a href="{{ route('posts.index') }}" class="group text-center p-4 rounded-xl hover:bg-white/10 transition-all duration-300">
                    <svg class="w-8 h-8 mx-auto mb-2 text-white/80 group-hover:text-white group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <span class="text-white/80 group-hover:text-white text-sm">Blog</span>
                </a>
                @endif
                
                @if(Route::has('projects.index'))
                <a href="{{ route('projects.index') }}" class="group text-center p-4 rounded-xl hover:bg-white/10 transition-all duration-300">
                    <svg class="w-8 h-8 mx-auto mb-2 text-white/80 group-hover:text-white group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="text-white/80 group-hover:text-white text-sm">Portfolio</span>
                </a>
                @endif
                
                @if(Route::has('contact'))
                <a href="{{ route('contact') }}" class="group text-center p-4 rounded-xl hover:bg-white/10 transition-all duration-300">
                    <svg class="w-8 h-8 mx-auto mb-2 text-white/80 group-hover:text-white group-hover:scale-110 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white/80 group-hover:text-white text-sm">Contato</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Footer Info -->
        <div class="slide-in mt-8 text-center">
            <p class="text-white/60 text-sm">
                Se o problema persistir, entre em contato conosco: 
                <a href="mailto:contato@nicedesigns.com.br" class="text-white hover:text-white/80 underline">
                    contato@nicedesigns.com.br
                </a>
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add parallax effect to background elements
            document.addEventListener('mousemove', function(e) {
                const floatingElements = document.querySelectorAll('.floating-animation');
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;
                
                floatingElements.forEach((element, index) => {
                    const speed = (index + 1) * 0.5;
                    const x = (mouseX - 0.5) * speed * 20;
                    const y = (mouseY - 0.5) * speed * 20;
                    
                    element.style.transform = `translate(${x}px, ${y}px)`;
                });
            });
            
            // Animate elements on scroll (if needed)
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe all slide-in elements
            document.querySelectorAll('.slide-in').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html> 