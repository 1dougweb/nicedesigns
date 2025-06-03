<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Aqui você pode buscar dados específicos do cliente
        // Por exemplo: projetos do cliente, faturas, tickets de suporte, etc.
        
        return view('client.dashboard');
    }

    public function projects(): View
    {
        // Lista projetos do cliente
        return view('client.projects');
    }

    public function invoices(): View
    {
        // Lista faturas do cliente
        return view('client.invoices');
    }

    public function support(): View
    {
        // Lista tickets de suporte do cliente
        return view('client.support');
    }

    public function profile(): View
    {
        // Perfil do cliente
        return view('client.profile');
    }
}
