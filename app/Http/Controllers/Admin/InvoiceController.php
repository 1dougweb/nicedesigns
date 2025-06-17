<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use App\Models\ClientProject;
use App\Services\AbacatePayService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Exception;

class InvoiceController extends Controller
{
    public function __construct(
        private AbacatePayService $abacatePayService
    ) {}
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
            'invoice_pdf' => 'nullable|file|mimes:pdf|max:10240',
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

        // Processar o upload do arquivo PDF da fatura
        if ($request->hasFile('invoice_pdf')) {
            $pdfPath = $request->file('invoice_pdf')->store('invoices', 'public');
            $validated['pdf_path'] = $pdfPath;
        }

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
            'invoice_pdf' => 'nullable|file|mimes:pdf|max:10240',
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

        // Se o status mudou para "paga", registrar a data de pagamento
        if ($validated['status'] === 'paga' && $invoice->status !== 'paga') {
            $validated['paid_date'] = now();
        } elseif ($validated['status'] !== 'paga') {
            $validated['paid_date'] = null;
        }

        // Processar o upload do arquivo PDF da fatura
        if ($request->hasFile('invoice_pdf')) {
            // Remover arquivo antigo, se existir
            if ($invoice->pdf_path && !filter_var($invoice->pdf_path, FILTER_VALIDATE_URL)) {
                \Storage::disk('public')->delete($invoice->pdf_path);
            }
            
            $pdfPath = $request->file('invoice_pdf')->store('invoices', 'public');
            $validated['pdf_path'] = $pdfPath;
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
     * AbacatePay Methods
     */

    /**
     * Gerar cobrança PIX via AbacatePay
     */
    public function generateAbacatePayPix(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->canGenerateAbacatePayCharge()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fatura não pode gerar cobrança via AbacatePay'
                ], 422);
            }

            $result = $this->abacatePayService->createPix($invoice);

            return response()->json([
                'success' => true,
                'message' => 'Cobrança PIX gerada com sucesso!',
                'data' => [
                    'billing_id' => $result['id'],
                    'payment_url' => $result['payment_url'],
                    'pix_qr_code' => $invoice->fresh()->pix_qr_code,
                    'pix_qr_code_url' => $invoice->fresh()->pix_qr_code_url
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar cobrança PIX: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Gerar cobrança Boleto via AbacatePay
     */
    public function generateAbacatePayBoleto(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->canGenerateAbacatePayCharge()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fatura não pode gerar cobrança via AbacatePay'
                ], 422);
            }

            $result = $this->abacatePayService->createBoleto($invoice);

            return response()->json([
                'success' => true,
                'message' => 'Cobrança Boleto gerada com sucesso!',
                'data' => [
                    'billing_id' => $result['id'],
                    'payment_url' => $result['payment_url'],
                    'boleto_url' => $invoice->fresh()->boleto_url,
                    'boleto_barcode' => $invoice->fresh()->boleto_barcode
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar cobrança Boleto: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Gerar cobrança com múltiplos métodos via AbacatePay
     */
    public function generateAbacatePayCharge(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->canGenerateAbacatePayCharge()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fatura não pode gerar cobrança via AbacatePay'
                ], 422);
            }

            $result = $this->abacatePayService->createCharge($invoice);

            return response()->json([
                'success' => true,
                'message' => 'Cobrança gerada com sucesso!',
                'data' => [
                    'billing_id' => $result['id'],
                    'payment_url' => $result['payment_url']
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar cobrança: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Verificar status da cobrança AbacatePay
     */
    public function checkAbacatePayStatus(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->hasAbacatePayCharge()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fatura não tem cobrança AbacatePay ativa'
                ], 422);
            }

            $status = $this->abacatePayService->getChargeStatus($invoice->abacatepay_billing_id);

            // Atualizar status local
            $invoice->update([
                'abacatepay_status' => $status['status'],
                'abacatepay_data' => json_encode($status['data'])
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'status' => $status['status'],
                    'status_label' => $invoice->fresh()->abacate_pay_status_label,
                    'status_color' => $invoice->fresh()->abacate_pay_status_color,
                    'paid_at' => $status['paid_at']
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao verificar status: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Cancelar cobrança AbacatePay
     */
    public function cancelAbacatePayCharge(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->hasAbacatePayCharge()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fatura não tem cobrança AbacatePay ativa'
                ], 422);
            }

            if ($invoice->isAbacatePayPaid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cobrança já foi paga e não pode ser cancelada'
                ], 422);
            }

            $result = $this->abacatePayService->cancelCharge($invoice->abacatepay_billing_id);

            // Atualizar status local
            $invoice->update([
                'abacatepay_status' => 'cancelled'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cobrança cancelada com sucesso!',
                'data' => $result
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cancelar cobrança: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Upload invoice PDF file
     */
    public function uploadInvoicePdf(Request $request, Invoice $invoice): RedirectResponse
    {
        $request->validate([
            'invoice_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        // Remover arquivo antigo, se existir
        if ($invoice->pdf_path && !filter_var($invoice->pdf_path, FILTER_VALIDATE_URL)) {
            \Storage::disk('public')->delete($invoice->pdf_path);
        }
        
        // Fazer upload do novo arquivo
        $pdfPath = $request->file('invoice_pdf')->store('invoices', 'public');
        $invoice->update(['pdf_path' => $pdfPath]);

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Arquivo da fatura enviado com sucesso!');
    }
} 