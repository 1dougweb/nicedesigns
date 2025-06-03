<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use App\Models\ClientProject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Invoice::with(['user', 'clientProject']);

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
                  ->orWhere('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->latest()->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Invoice::count(),
            'pending' => Invoice::pending()->count(),
            'paid' => Invoice::paid()->count(),
            'overdue' => Invoice::overdue()->count(),
            'total_amount' => Invoice::sum('total_amount'),
            'pending_amount' => Invoice::pending()->sum('total_amount'),
        ];

        // Opções para filtros
        $statusOptions = Invoice::getStatusLabels();
        $clients = User::clients()->get(['id', 'full_name']);

        return view('admin.invoices.index', compact(
            'invoices', 
            'stats', 
            'statusOptions', 
            'clients'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $clients = User::clients()->get(['id', 'full_name']);
        $clientProjects = [];
        
        // Se um cliente foi pré-selecionado, buscar seus projetos
        if ($request->filled('client_id')) {
            $clientProjects = ClientProject::where('user_id', $request->client_id)
                ->get(['id', 'name']);
        }

        $statusOptions = Invoice::getStatusLabels();
        $paymentMethods = Invoice::getPaymentMethodLabels();

        return view('admin.invoices.create', compact(
            'clients', 
            'clientProjects',
            'statusOptions', 
            'paymentMethods'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'client_project_id' => 'nullable|exists:client_projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:' . implode(',', array_keys(Invoice::getStatusLabels())),
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'payment_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Gerar número da fatura
        $validated['invoice_number'] = Invoice::generateInvoiceNumber();

        // Calcular valores
        $discount = $validated['discount'] ?? 0;
        $taxRate = $validated['tax_rate'] ?? 0;
        $taxAmount = ($validated['subtotal'] - $discount) * ($taxRate / 100);
        $totalAmount = $validated['subtotal'] - $discount + $taxAmount;

        $validated['discount'] = $discount;
        $validated['tax_rate'] = $taxRate;
        $validated['tax_amount'] = $taxAmount;
        $validated['total_amount'] = $totalAmount;

        $invoice = Invoice::create($validated);

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Fatura criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice): View
    {
        $invoice->load(['user', 'clientProject']);

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice): View
    {
        $clients = User::clients()->get(['id', 'full_name']);
        $clientProjects = ClientProject::where('user_id', $invoice->user_id)
            ->get(['id', 'name']);
        $statusOptions = Invoice::getStatusLabels();
        $paymentMethods = Invoice::getPaymentMethodLabels();

        return view('admin.invoices.edit', compact(
            'invoice',
            'clients', 
            'clientProjects',
            'statusOptions', 
            'paymentMethods'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'client_project_id' => 'nullable|exists:client_projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:' . implode(',', array_keys(Invoice::getStatusLabels())),
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'payment_method' => 'nullable|in:' . implode(',', array_keys(Invoice::getPaymentMethodLabels())),
            'payment_reference' => 'nullable|string|max:255',
            'payment_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Calcular valores
        $discount = $validated['discount'] ?? 0;
        $taxRate = $validated['tax_rate'] ?? 0;
        $taxAmount = ($validated['subtotal'] - $discount) * ($taxRate / 100);
        $totalAmount = $validated['subtotal'] - $discount + $taxAmount;

        $validated['discount'] = $discount;
        $validated['tax_rate'] = $taxRate;
        $validated['tax_amount'] = $taxAmount;
        $validated['total_amount'] = $totalAmount;

        // Se status mudou para "paga", definir data de pagamento
        if ($validated['status'] === 'paga' && $invoice->status !== 'paga') {
            $validated['paid_date'] = now();
        }

        $invoice->update($validated);

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Fatura atualizada com sucesso!');
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(Request $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:' . implode(',', array_keys(Invoice::getPaymentMethodLabels())),
            'payment_reference' => 'nullable|string|max:255',
            'payment_notes' => 'nullable|string',
        ]);

        $invoice->markAsPaid(
            $validated['payment_method'],
            $validated['payment_reference']
        );

        if (isset($validated['payment_notes'])) {
            $invoice->update(['payment_notes' => $validated['payment_notes']]);
        }

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Fatura marcada como paga!');
    }

    /**
     * Get client projects for AJAX
     */
    public function getClientProjects(Request $request)
    {
        $clientId = $request->get('client_id');
        
        if (!$clientId) {
            return response()->json([]);
        }

        $projects = ClientProject::where('user_id', $clientId)
            ->get(['id', 'name']);

        return response()->json($projects);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Fatura removida com sucesso!');
    }

    /**
     * Gerar cobrança PagarMe para fatura
     */
    public function generatePagarMeCharge(Request $request, Invoice $invoice)
    {
        try {
            $validated = $request->validate([
                'payment_method' => 'required|in:pix,boleto,multi',
                'send_email' => 'boolean'
            ]);

            $paymentMethod = $validated['payment_method'];
            $sendEmail = $validated['send_email'] ?? true;

            // Verificar se fatura pode ter cobrança gerada
            if ($invoice->status !== 'pendente') {
                $message = 'Apenas faturas pendentes podem ter cobrança gerada.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return back()->with('error', $message);
            }

            if ($invoice->hasPagarMeCharge()) {
                $message = 'Esta fatura já possui uma cobrança PagarMe ativa.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return back()->with('error', $message);
            }

            // Disparar job para processar
            \App\Jobs\ProcessInvoicePayment::dispatch($invoice, [$paymentMethod], $sendEmail);

            $message = 'Cobrança PagarMe sendo processada. Aguarde alguns instantes.';
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Erro ao gerar cobrança: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
    }

    /**
     * Habilitar cobrança automática
     */
    public function enableAutoCharge(Request $request, Invoice $invoice)
    {
        try {
            $validated = $request->validate([
                'auto_charge_date' => 'nullable|date|after_or_equal:today'
            ]);

            $autoChargeDate = $validated['auto_charge_date'] ?? now()->addDays(7)->format('Y-m-d');
            $invoice->enableAutoCharge(new \DateTime($autoChargeDate));

            $message = 'Cobrança automática habilitada para ' . 
                \Carbon\Carbon::parse($autoChargeDate)->format('d/m/Y');
            
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Erro ao habilitar cobrança automática: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
    }

    /**
     * Desabilitar cobrança automática
     */
    public function disableAutoCharge(Request $request, Invoice $invoice)
    {
        try {
            $invoice->disableAutoCharge();

            $message = 'Cobrança automática desabilitada.';
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Erro ao desabilitar cobrança automática: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
    }

    /**
     * Consultar status no PagarMe
     */
    public function checkPagarMeStatus(Request $request, Invoice $invoice)
    {
        try {
            if (!$invoice->hasPagarMeCharge()) {
                $message = 'Esta fatura não possui cobrança PagarMe.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return back()->with('error', $message);
            }

            $pagarmeService = new \App\Services\PagarMeService();
            $chargeId = $invoice->pagarme_charge_id ?? $invoice->pagarme_transaction_id;
            
            $status = $pagarmeService->getChargeStatus($chargeId);
            $oldStatus = $invoice->pagarme_status;
            
            // Atualizar dados da fatura
            $invoice->update([
                'pagarme_status' => $status['status'],
                'pagarme_data' => $status,
                'webhook_received_at' => now()
            ]);

            $message = 'Status atualizado: ' . $invoice->pagarme_status_label;
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => $message,
                    'status' => $status['status'],
                    'status_changed' => $oldStatus !== $status['status']
                ]);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Erro ao consultar status: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
    }

    /**
     * Cancelar cobrança PagarMe
     */
    public function cancelPagarMeCharge(Request $request, Invoice $invoice)
    {
        try {
            if (!$invoice->hasPagarMeCharge()) {
                $message = 'Esta fatura não possui cobrança PagarMe.';
                if ($request->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                return back()->with('error', $message);
            }

            $pagarmeService = new \App\Services\PagarMeService();
            $chargeId = $invoice->pagarme_charge_id ?? $invoice->pagarme_transaction_id;
            
            $result = $pagarmeService->cancelCharge($chargeId);
            
            // Atualizar dados da fatura
            $invoice->update([
                'pagarme_status' => $result['status'],
                'pagarme_data' => $result,
                'status' => 'cancelada'
            ]);

            $message = 'Cobrança PagarMe cancelada com sucesso.';
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            $message = 'Erro ao cancelar cobrança: ' . $e->getMessage();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }
    }
} 