<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        
        $query = Invoice::where('user_id', $user->id)->with(['clientProject']);
        
        if ($status && $status !== 'todos') {
            $query->where('status', $status);
        }
        
        $invoices = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Estatísticas das faturas
        $stats = [
            'total' => Invoice::where('user_id', $user->id)->count(),
            'paid' => Invoice::where('user_id', $user->id)->where('status', 'paga')->count(),
            'pending' => Invoice::where('user_id', $user->id)->where('status', 'pendente')->count(),
            'overdue' => Invoice::where('user_id', $user->id)->where('status', 'vencida')->count(),
            'total_amount' => Invoice::where('user_id', $user->id)->sum('total_amount'),
            'amount_due' => Invoice::where('user_id', $user->id)->whereIn('status', ['pendente', 'vencida'])->sum('total_amount'),
        ];
        
        // Opções para filtros
        $statusOptions = [
            'pendente' => 'Pendente',
            'paga' => 'Paga',
            'vencida' => 'Vencida',
            'cancelada' => 'Cancelada',
        ];
        
        return view('client.invoices.index', compact(
            'invoices', 
            'statusOptions', 
            'status', 
            'stats'
        ));
    }

    public function show(Invoice $invoice): View
    {
        // Verificar se a fatura pertence ao cliente logado
        if ($invoice->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $invoice->load(['clientProject']);
        
        return view('client.invoices.show', compact('invoice'));
    }
} 