<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Erro') | {{ config('app.name', 'Nice Designs') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <meta name="description" content="@yield('description', 'Página de erro')">
    <meta name="robots" content="noindex, nofollow">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: @yield('background', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)');
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
        
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        @yield('custom-styles')
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
        @yield('content')
        
        <!-- Footer Info -->
        <div class="slide-in mt-8 text-center">
            <p class="text-white/60 text-sm">
                @yield('footer-text', 'Se o problema persistir, entre em contato conosco:')
                <a href="mailto:contato@nicedesigns.com.br" class="text-white hover:text-white/80 underline">
                    contato@nicedesigns.com.br
                </a>
            </p>
        </div>
    </div>

    @yield('scripts')
    
    <!-- Default Scripts -->
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
        });
    </script>
</body>
</html> 