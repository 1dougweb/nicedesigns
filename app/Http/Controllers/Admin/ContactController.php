<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Contact::query();

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Busca por nome ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(15);

        // Estatísticas
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'in_progress' => Contact::where('status', 'in_progress')->count(),
            'completed' => Contact::where('status', 'completed')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): View
    {
        // Marcar como lido se ainda for novo
        if ($contact->status === 'new') {
            $contact->update(['status' => 'in_progress']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        $contact->update($validated);

        return redirect()
            ->route('admin.contacts.show', $contact)
            ->with('success', 'Status do contato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contato excluído com sucesso!');
    }

    public function markAsRead(Contact $contact): RedirectResponse
    {
        $contact->update(['status' => 'in_progress']);

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contato marcado como lido!');
    }

    public function markAsCompleted(Contact $contact): RedirectResponse
    {
        $contact->update(['status' => 'completed']);

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Contato marcado como concluído!');
    }
}
