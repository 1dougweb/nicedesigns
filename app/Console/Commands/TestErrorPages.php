<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;

class TestErrorPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:error-pages {--status=all : Status code to test (404, 403, 500, 503, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testa se as páginas de erro personalizadas estão funcionando';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status = $this->option('status');
        
        $this->info('🧪 Testando páginas de erro personalizadas...');
        $this->newLine();

        $errorPages = [
            '404' => '404 - Página não encontrada',
            '403' => '403 - Acesso negado', 
            '500' => '500 - Erro interno do servidor',
            '503' => '503 - Serviço indisponível'
        ];

        if ($status !== 'all' && !array_key_exists($status, $errorPages)) {
            $this->error("Status code '{$status}' não é válido. Use: 404, 403, 500, 503, ou all");
            return 1;
        }

        $testPages = $status === 'all' ? $errorPages : [$status => $errorPages[$status]];
        $results = [];

        foreach ($testPages as $code => $description) {
            $this->info("🔍 Testando {$description}...");
            
            $viewName = "errors.{$code}";
            $exists = View::exists($viewName);
            
            if ($exists) {
                try {
                    $content = view($viewName, [
                        'exception' => new \Exception('Teste'),
                        'message' => 'Erro de teste',
                        'status' => (int)$code
                    ])->render();
                    
                    $hasTitle = str_contains($content, $code);
                    $hasBackButton = str_contains($content, 'Voltar');
                    $hasHomeLink = str_contains($content, 'route(\'home\')');
                    
                    $results[$code] = [
                        'exists' => true,
                        'renders' => true,
                        'has_title' => $hasTitle,
                        'has_navigation' => $hasBackButton || $hasHomeLink,
                        'size' => strlen($content)
                    ];
                    
                    $this->line("  ✅ Arquivo existe: {$viewName}");
                    $this->line("  ✅ Renderiza corretamente");
                    $this->line("  " . ($hasTitle ? '✅' : '❌') . " Contém título do erro");
                    $this->line("  " . ($hasBackButton || $hasHomeLink ? '✅' : '❌') . " Contém navegação");
                    $this->line("  📊 Tamanho: " . number_format(strlen($content)) . " bytes");
                    
                } catch (\Exception $e) {
                    $results[$code] = [
                        'exists' => true,
                        'renders' => false,
                        'error' => $e->getMessage()
                    ];
                    
                    $this->line("  ✅ Arquivo existe: {$viewName}");
                    $this->line("  ❌ Erro ao renderizar: " . $e->getMessage());
                }
            } else {
                $results[$code] = ['exists' => false];
                $this->line("  ❌ Arquivo não encontrado: {$viewName}");
            }
            
            $this->newLine();
        }

        // Relatório final
        $this->info('📋 Relatório Final:');
        $this->newLine();

        $table = [];
        $totalPages = count($results);
        $workingPages = 0;

        foreach ($results as $code => $result) {
            $status = '❌ Falhou';
            if ($result['exists'] && isset($result['renders']) && $result['renders']) {
                $status = '✅ Funcionando';
                $workingPages++;
            } elseif ($result['exists']) {
                $status = '⚠️  Erro de renderização';
            }

            $table[] = [
                $code,
                $errorPages[$code],
                $status,
                $result['exists'] ? 'Sim' : 'Não',
                isset($result['size']) ? number_format($result['size']) . ' bytes' : 'N/A'
            ];
        }

        $this->table(
            ['Código', 'Descrição', 'Status', 'Existe', 'Tamanho'],
            $table
        );

        $this->newLine();
        
        if ($workingPages === $totalPages) {
            $this->info("🎉 Todas as {$totalPages} páginas estão funcionando corretamente!");
        } else {
            $this->warn("⚠️  {$workingPages}/{$totalPages} páginas estão funcionando.");
        }

        // Testes adicionais
        $this->newLine();
        $this->info('🔧 Testes Adicionais:');
        
        // Verificar Handler
        $handlerExists = file_exists(app_path('Exceptions/Handler.php'));
        $this->line(($handlerExists ? '✅' : '❌') . ' Exception Handler personalizado');
        
        // Verificar layout base
        $layoutExists = View::exists('errors.layout');
        $this->line(($layoutExists ? '✅' : '❌') . ' Layout base para erros');
        
        // Verificar configurações de debug
        $debugMode = config('app.debug');
        $environment = app()->environment();
        $this->line("📊 Modo debug: " . ($debugMode ? 'Ativado' : 'Desativado'));
        $this->line("🌍 Ambiente: {$environment}");

        if ($environment === 'production' && $debugMode) {
            $this->warn('⚠️  ATENÇÃO: Debug está ativado em produção!');
        }

        $this->newLine();
        $this->info('💡 Comandos úteis:');
        $this->line('  • php artisan test:error-pages --status=404');
        $this->line('  • curl -I http://seu-site.com/pagina-inexistente');
        $this->line('  • php artisan config:clear && php artisan view:clear');

        return $workingPages === $totalPages ? 0 : 1;
    }
}
