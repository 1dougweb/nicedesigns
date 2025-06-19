<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Quote::with(['user', 'creator']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('client')) {
            $query->where('user_id', $request->client);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        // Auto-expire quotes
        Quote::where('status', 'pendente')
            ->where('valid_until', '<', now())
            ->update(['status' => 'expirado']);

        $quotes = $query->latest()->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Quote::count(),
            'pending' => Quote::pending()->count(),
            'accepted' => Quote::accepted()->count(),
            'rejected' => Quote::rejected()->count(),
            'expired' => Quote::where('status', 'expirado')->count(),
        ];

        // Opções para filtros
        $statusOptions = Quote::getStatusLabels();
        $clients = User::clients()->get(['id', 'full_name']);

        return view('admin.quotes.index', compact(
            'quotes', 
            'stats', 
            'statusOptions', 
            'clients'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $clients = User::clients()->get(['id', 'full_name']);
        $statusOptions = Quote::getStatusLabels();

        return view('admin.quotes.create', compact('clients', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'services' => 'nullable|array',
            'services.*' => 'string|max:255',
            'deliverables' => 'nullable|array',
            'deliverables.*' => 'string|max:255',
            'timeline' => 'nullable|integer|min:1',
            'payment_terms' => 'nullable|array',
            'payment_terms.*' => 'string',
            'valid_until' => 'nullable|date|after:today',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'admin_notes' => 'nullable|string',
        ]);

        // Remove empty services and deliverables
        if (isset($validated['services'])) {
            $validated['services'] = array_filter($validated['services']);
        }
        if (isset($validated['deliverables'])) {
            $validated['deliverables'] = array_filter($validated['deliverables']);
        }

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pendente';

        $quote = Quote::create($validated);

        // Notificar o cliente
        $client = User::find($validated['user_id']);
        if ($client) {
            Notification::create([
                'user_id' => $client->id,
                'title' => 'Novo Orçamento Disponível',
                'message' => "Você recebeu um novo orçamento: '{$quote->title}'. Acesse para visualizar e aprovar.",
                'type' => Notification::TYPE_NEW_PROJECT,
                'url' => route('client.quotes.show', $quote->id),
                'data' => [
                    'quote_id' => $quote->id,
                    'quote_title' => $quote->title,
                    'action_required' => 'approval'
                ]
            ]);
        }

        return redirect()
            ->route('admin.quotes.show', $quote)
            ->with('success', 'Orçamento criado com sucesso! O cliente foi notificado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote): View
    {
        $quote->load(['user', 'creator', 'clientProjects']);

        return view('admin.quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote): View
    {
        $clients = User::clients()->get(['id', 'full_name']);
        $statusOptions = Quote::getStatusLabels();

        return view('admin.quotes.edit', compact('quote', 'clients', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:' . implode(',', array_keys(Quote::getStatusLabels())),
            'services' => 'nullable|array',
            'services.*' => 'string|max:255',
            'deliverables' => 'nullable|array',
            'deliverables.*' => 'string|max:255',
            'timeline' => 'nullable|integer|min:1',
            'payment_terms' => 'nullable|array',
            'payment_terms.*' => 'string',
            'valid_until' => 'nullable|date|after:today',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'admin_notes' => 'nullable|string',
        ]);

        // Remove empty services and deliverables
        if (isset($validated['services'])) {
            $validated['services'] = array_filter($validated['services']);
        }
        if (isset($validated['deliverables'])) {
            $validated['deliverables'] = array_filter($validated['deliverables']);
        }

        $quote->update($validated);

        return redirect()
            ->route('admin.quotes.show', $quote)
            ->with('success', 'Orçamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote): RedirectResponse
    {
        // Only allow deletion if quote is not accepted and has no projects
        if ($quote->status === 'aceito' || $quote->clientProjects()->exists()) {
            return redirect()
                ->route('admin.quotes.index')
                ->with('error', 'Não é possível excluir um orçamento aceito ou com projetos vinculados.');
        }

        $quote->delete();

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Orçamento excluído com sucesso!');
    }

    /**
     * Cancel quote
     */
    public function cancel(Quote $quote): RedirectResponse
    {
        if ($quote->status === 'aceito') {
            return redirect()
                ->route('admin.quotes.show', $quote)
                ->with('error', 'Não é possível cancelar um orçamento já aceito.');
        }

        $quote->update(['status' => 'cancelado']);

        return redirect()
            ->route('admin.quotes.show', $quote)
            ->with('success', 'Orçamento cancelado com sucesso!');
    }

    /**
     * Duplicate quote
     */
    public function duplicate(Quote $quote): RedirectResponse
    {
        $newQuote = $quote->replicate();
        $newQuote->title = $quote->title . ' (Cópia)';
        $newQuote->status = 'pendente';
        $newQuote->accepted_at = null;
        $newQuote->rejected_at = null;
        $newQuote->rejection_reason = null;
        $newQuote->created_by = auth()->id();
        $newQuote->save();

        return redirect()
            ->route('admin.quotes.edit', $newQuote)
            ->with('success', 'Orçamento duplicado com sucesso!');
    }

    /**
     * Download quote as PDF
     */
    public function downloadPdf(Quote $quote)
    {
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