<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAcceptedQuote
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Verificar se é um cliente
        if ($user && $user->isClient()) {
            // Verificar se tem orçamento aceito
            if (!$user->hasAcceptedQuote()) {
                return redirect()
                    ->route('client.quotes.index')
                    ->with('warning', 'Você precisa aceitar um orçamento antes de acessar os projetos.');
            }
        }
        
        return $next($request);
    }
}
