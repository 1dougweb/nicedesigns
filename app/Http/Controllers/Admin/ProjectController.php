<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projects = Project::with(['category', 'creator'])
            ->latest()
            ->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url',
            'featured_image' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'completion_date' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): View
    {
        $project->load(['category', 'creator']);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project): View
    {
        $categories = Category::all();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|url',
            'featured_image' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'completion_date' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }
}
