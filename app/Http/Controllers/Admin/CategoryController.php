<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::withCount(['posts', 'projects'])
            ->latest()
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        $category->loadCount(['posts', 'projects']);
        $recentPosts = $category->posts()->latest()->take(5)->get();
        $recentProjects = $category->projects()->latest()->take(5)->get();

        return view('admin.categories.show', compact('category', 'recentPosts', 'recentProjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Verificar se a categoria tem posts ou projetos
        if ($category->posts()->count() > 0 || $category->projects()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Não é possível excluir uma categoria que possui posts ou projetos.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
