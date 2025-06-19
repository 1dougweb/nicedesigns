<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status');
        
        $query = $user->quotes()->with(['creator']);
        
        if ($status && $status !== 'todos') {
            $query->byStatus($status);
        }
        
        $quotes = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Opções para filtros
        $statusOptions = Quote::getStatusLabels();
        
        // Estatísticas dos orçamentos
        $stats = [
            'total' => $user->quotes()->count(),
            'pending' => $user->quotes()->pending()->count(),
            'accepted' => $user->quotes()->accepted()->count(),
            'rejected' => $user->quotes()->rejected()->count(),
            'expired' => $user->quotes()->where('status', 'expirado')->count(),
        ];
        
        return view('client.quotes.index', compact(
            'quotes', 
            'statusOptions', 
            'status', 
            'stats'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote): View
    {
        // Verificar se o orçamento pertence ao cliente logado
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $quote->load(['creator', 'clientProjects']);
        
        return view('client.quotes.show', compact('quote'));
    }

    /**
     * Accept quote
     */
    public function accept(Quote $quote): RedirectResponse
    {
        // Verificar se o orçamento pertence ao cliente logado
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        // Verificar se o orçamento está pendente
        if (!$quote->is_pending) {
            return redirect()->back()->with('error', 'Este orçamento não pode ser aceito no momento.');
        }
        
        try {
            $quote->accept();
            
            // Notificar o admin
            Notification::create([
                'user_id' => $quote->created_by,
                'title' => 'Orçamento Aceito',
                'message' => "O cliente {$quote->user->full_name} aceitou o orçamento '{$quote->title}'.",
                'type' => Notification::TYPE_NEW_PROJECT,
                'url' => route('admin.quotes.show', $quote->id),
                'data' => [
                    'quote_id' => $quote->id,
                    'quote_title' => $quote->title,
                    'client_id' => $quote->user_id,
                    'action_taken' => 'accepted'
                ]
            ]);
            
            return redirect()->back()->with('success', 'Orçamento aceito com sucesso! Nossa equipe entrará em contato para iniciar o projeto.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao aceitar orçamento: ' . $e->getMessage());
        }
    }

    /**
     * Reject quote
     */
    public function reject(Request $request, Quote $quote): RedirectResponse
    {
        // Verificar se o orçamento pertence ao cliente logado
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        // Verificar se o orçamento está pendente
        if (!$quote->is_pending) {
            return redirect()->back()->with('error', 'Este orçamento não pode ser rejeitado no momento.');
        }
        
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);
        
        try {
            $quote->reject($request->input('reason'));
            
            // Notificar o admin
            Notification::create([
                'user_id' => $quote->created_by,
                'title' => 'Orçamento Rejeitado',
                'message' => "O cliente {$quote->user->full_name} rejeitou o orçamento '{$quote->title}'.",
                'type' => Notification::TYPE_NEW_PROJECT,
                'url' => route('admin.quotes.show', $quote->id),
                'data' => [
                    'quote_id' => $quote->id,
                    'quote_title' => $quote->title,
                    'client_id' => $quote->user_id,
                    'action_taken' => 'rejected',
                    'rejection_reason' => $request->input('reason')
                ]
            ]);
            
            return redirect()->back()->with('success', 'Orçamento rejeitado. Nossa equipe entrará em contato para discutir alterações.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao rejeitar orçamento: ' . $e->getMessage());
        }
    }

    /**
     * Add client notes to quote
     */
    public function addNotes(Request $request, Quote $quote): RedirectResponse
    {
        // Verificar se o orçamento pertence ao cliente logado
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }
        
        $request->validate([
            'client_notes' => 'required|string|max:1000'
        ]);
        
        $quote->update([
            'client_notes' => $request->input('client_notes')
        ]);
        
        // Notificar o admin
        Notification::create([
            'user_id' => $quote->created_by,
            'title' => 'Comentário em Orçamento',
            'message' => "O cliente {$quote->user->full_name} adicionou comentários ao orçamento '{$quote->title}'.",
            'type' => Notification::TYPE_NEW_PROJECT,
            'url' => route('admin.quotes.show', $quote->id),
            'data' => [
                'quote_id' => $quote->id,
                'quote_title' => $quote->title,
                'client_id' => $quote->user_id,
                'action_taken' => 'commented'
            ]
        ]);
        
        return redirect()->back()->with('success', 'Comentários adicionados com sucesso!');
    }

    /**
     * Download quote as PDF
     */
    public function downloadPdf(Quote $quote)
    {
        // Verificar se o orçamento pertence ao cliente logado
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        try {
            // Carregar relacionamentos necessários
            $quote->load(['user', 'creator']);

            // Gerar PDF
            $pdf = Pdf::loadView('pdf.quote', compact('quote'));
            
            // Configurar o PDF
            $pdf->setPaper('A4', 'portrait');
            
            // Nome do arquivo
            $filename = 'Proposta-' . str_pad($quote->id, 4, '0', STR_PAD_LEFT) . '-' . 
                       \Str::slug($quote->title) . '.pdf';

            // Download do arquivo
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }

    /**
     * View quote as PDF in browser
     */
    public function viewPdf(Quote $quote)
    {
        // Verificar se o orçamento pertence ao cliente logado
        if ($quote->user_id !== Auth::id()) {
            abort(403, 'Acesso negado.');
        }

        try {
            // Carregar relacionamentos necessários
            $quote->load(['user', 'creator']);

            // Gerar PDF
            $pdf = Pdf::loadView('pdf.quote', compact('quote'));
            
            // Configurar o PDF
            $pdf->setPaper('A4', 'portrait');

            // Exibir no navegador
            return $pdf->stream('Proposta-' . str_pad($quote->id, 4, '0', STR_PAD_LEFT) . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao gerar PDF: ' . $e->getMessage());
        }
    }
} 