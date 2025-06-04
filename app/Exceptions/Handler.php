<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Se não for uma requisição HTTP, use o handler padrão
        if (!$request instanceof Request) {
            return parent::render($request, $e);
        }

        // Se for uma requisição AJAX/API, retorne JSON
        if ($request->expectsJson()) {
            return $this->renderJsonException($request, $e);
        }

        // Se estiver em modo debug e não for produção, use o handler padrão
        if (config('app.debug') && !app()->environment('production')) {
            return parent::render($request, $e);
        }

        // Renderizar páginas de erro personalizadas
        if ($e instanceof HttpException) {
            return $this->renderHttpException($e);
        }

        // Para outros tipos de exceção, trate como erro 500
        if (app()->environment('production')) {
            return $this->renderCustomErrorPage(500, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render HTTP exceptions with custom error pages
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();
        
        // Verificar se existe uma view personalizada para este status
        if (view()->exists("errors.{$status}")) {
            return response()->view("errors.{$status}", [
                'exception' => $e,
                'message' => $e->getMessage(),
                'status' => $status
            ], $status);
        }

        // Fallback para páginas genéricas baseadas no tipo de erro
        return $this->renderCustomErrorPage($status, $e);
    }

    /**
     * Render custom error page based on status code
     */
    protected function renderCustomErrorPage(int $status, Throwable $e)
    {
        $viewName = match($status) {
            404 => 'errors.404',
            403 => 'errors.403',
            500, 502, 504 => 'errors.500',
            503 => 'errors.503',
            default => 'errors.404'
        };

        // Se a view específica não existir, use a página 404 como fallback
        if (!view()->exists($viewName)) {
            $viewName = 'errors.404';
            $status = 404;
        }

        return response()->view($viewName, [
            'exception' => $e,
            'message' => $e->getMessage(),
            'status' => $status
        ], $status);
    }

    /**
     * Render JSON exception for API requests
     */
    protected function renderJsonException(Request $request, Throwable $e)
    {
        $status = 500;
        $message = 'Erro interno do servidor';

        if ($e instanceof HttpException) {
            $status = $e->getStatusCode();
            $message = match($status) {
                404 => 'Recurso não encontrado',
                403 => 'Acesso negado',
                422 => 'Dados inválidos',
                429 => 'Muitas tentativas',
                503 => 'Serviço indisponível',
                default => 'Erro no servidor'
            };
        }

        $response = [
            'error' => true,
            'message' => $message,
            'status' => $status,
        ];

        // Em desenvolvimento, incluir mais detalhes
        if (config('app.debug') && !app()->environment('production')) {
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ];
        }

        return response()->json($response, $status);
    }

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => true,
                'message' => 'Não autenticado',
                'status' => 401
            ], 401);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * Convert a validation exception into a JSON response.
     */
    protected function invalidJson($request, \Illuminate\Validation\ValidationException $exception)
    {
        return response()->json([
            'error' => true,
            'message' => 'Dados de validação inválidos',
            'status' => 422,
            'errors' => $exception->errors(),
        ], 422);
    }

    /**
     * Determine if the exception should be reported.
     */
    public function shouldReport(Throwable $e)
    {
        // Não reportar erros 404 em produção para evitar spam nos logs
        if ($e instanceof NotFoundHttpException && app()->environment('production')) {
            return false;
        }

        return parent::shouldReport($e);
    }
}