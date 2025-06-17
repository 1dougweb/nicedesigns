@extends('layouts.admin')

@section('title', 'SEO Manager')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">🔍 SEO Manager</h1>
        <p class="text-gray-400">Gerencie sitemap.xml e robots.txt para otimização de SEO</p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Sitemap Card -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <div class="flex items-center mb-6">
                <div class="bg-green-500/20 p-3 rounded-xl mr-4">
                <i class="fi fi-rr-document text-green-400 text-2xl mt-2"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Sitemap XML</h2>
                    <p class="text-gray-400">Gerador automático de sitemap</p>
                </div>
            </div>

            <!-- Sitemap Stats -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-700/30 p-4 rounded-xl">
                    <div class="text-2xl font-bold text-green-400">{{ array_sum($urlCounts) }}</div>
                    <div class="text-sm text-gray-400">URLs Totais</div>
                </div>
                <div class="bg-gray-700/30 p-4 rounded-xl">
                    <div class="text-sm font-medium text-blue-400">{{ $sitemapLastGenerated }}</div>
                    <div class="text-sm text-gray-400">Última Geração</div>
                </div>
            </div>

            <!-- URL Breakdown -->
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-gray-300">Páginas estáticas</span>
                    <span class="text-yellow-400">{{ $urlCounts['pages'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Posts do blog</span>
                    <span class="text-blue-400">{{ $urlCounts['posts'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Projetos</span>
                    <span class="text-purple-400">{{ $urlCounts['projects'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-300">Categorias</span>
                    <span class="text-green-400">{{ $urlCounts['categories'] }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button id="generate-sitemap" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fi fi-rr-refresh  text-white ml-2 justify-center align-middle"></i>
                    Gerar Sitemap
                </button>
                
                @if($sitemapExists)
                <div class="flex space-x-3">
                    <a href="{{ url('sitemap.xml') }}" target="_blank"
                       class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-xl transition-all duration-300 text-center">
                        Ver Sitemap
                    </a>
                    <a href="{{ url('sitemap.xml') }}" download
                       class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-xl transition-all duration-300 text-center">
                        Download
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Robots.txt Card -->
        <div class="bg-gray-800/50 backdrop-blur-md rounded-3xl border border-gray-700/50 p-8">
            <div class="flex items-center mb-6">
                <div class="bg-red-500/20 p-3 rounded-xl mr-4">
                <i class="fi fi-rr-robot text-red-400 text-2xl mt-2"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Robots.txt</h2>
                    <p class="text-gray-400">Editor de robots.txt</p>
                </div>
            </div>

            <!-- Robots.txt Editor -->
            <div class="mb-6">
                <textarea id="robots-content" 
                          class="w-full h-64 bg-gray-900/50 border border-gray-600/50 text-green-400 rounded-xl px-4 py-3 font-mono text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300"
                          placeholder="User-agent: *&#10;Disallow: /admin/">{{ $robotsContent }}</textarea>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <div class="flex space-x-3">
                    <button id="save-robots" 
                            class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fi fi-rr-disk text-white ml-2 justify-center align-middle mt-2"></i>
                        Salvar
                    </button>
                    
                    <button id="reset-robots" 
                            class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-xl transition-all duration-300">
                            <i class="fi fi-rr-refresh  text-white ml-2 justify-center align-middle mt-2"></i>
                        Restaurar
                    </button>
                </div>
                
                <a href="{{ url('robots.txt') }}" target="_blank"
                   class="block w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-xl transition-all duration-300 text-center">
                    Ver Robots.txt
                </a>
            </div>
        </div>
    </div>

    <!-- SEO Tips -->
    <div class="mt-8 bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-3xl p-8">
        <h3 class="text-xl font-bold text-white mb-4">💡 Dicas de SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">
            <div>
                <h4 class="font-semibold text-blue-400 mb-2">Sitemap XML</h4>
                <ul class="space-y-1 text-sm">
                    <li>• Gere o sitemap após adicionar novo conteúdo</li>
                    <li>• Submeta para Google Search Console</li>
                    <li>• Atualize automaticamente com cron job</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-red-400 mb-2">Robots.txt</h4>
                <ul class="space-y-1 text-sm">
                    <li>• Bloqueie páginas admin e privadas</li>
                    <li>• Sempre inclua a URL do sitemap</li>
                    <li>• Teste com Google Search Console</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Sitemap
    document.getElementById('generate-sitemap').addEventListener('click', function() {
        const button = this;
        const originalText = button.innerHTML;
        
        button.innerHTML = '<svg class="inline w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Gerando...';
        button.disabled = true;
        
        fetch('{{ route("admin.seo.sitemap.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Erro ao gerar sitemap', 'error');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
    
    // Save Robots.txt
    document.getElementById('save-robots').addEventListener('click', function() {
        const content = document.getElementById('robots-content').value;
        const button = this;
        const originalText = button.innerHTML;
        
        button.innerHTML = '<svg class="inline w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>Salvando...';
        button.disabled = true;
        
        fetch('{{ route("admin.seo.robots.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                robots_content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            showNotification(data.message, data.success ? 'success' : 'error');
        })
        .catch(error => {
            showNotification('Erro ao salvar robots.txt', 'error');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
    
    // Reset Robots.txt
    document.getElementById('reset-robots').addEventListener('click', function() {
        if (!confirm('Tem certeza que deseja restaurar o robots.txt para o padrão?')) {
            return;
        }
        
        const button = this;
        const originalText = button.innerHTML;
        
        button.innerHTML = '<svg class="inline w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Restaurando...';
        button.disabled = true;
        
        fetch('{{ route("admin.seo.robots.reset") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('robots-content').value = data.content;
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Erro ao restaurar robots.txt', 'error');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.innerHTML = message;
        
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('translate-y-0', 'opacity-100');
        }, 100);
        
        // Hide notification
        setTimeout(() => {
            notification.classList.add('-translate-y-2', 'opacity-0');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
</script>
@endsection 