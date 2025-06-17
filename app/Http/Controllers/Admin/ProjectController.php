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
use Illuminate\Support\Facades\Storage;

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
            'featured_image' => 'nullable|image|max:2048',
            'featured_image_url' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'completion_date' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            // SEO fields
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:70',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|image|max:2048',
            'og_image_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('projects/featured', 'public');
            $validated['featured_image'] = Storage::url($path);
        } elseif ($request->filled('featured_image_url')) {
            $validated['featured_image'] = $request->input('featured_image_url');
        }
        
        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('projects/og', 'public');
            $validated['og_image'] = Storage::url($path);
        } elseif ($request->filled('og_image_url')) {
            $validated['og_image'] = $request->input('og_image_url');
        }
        
        // Create SEO metadata
        $seoData = [
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'og_title' => $request->input('og_title'),
            'og_description' => $request->input('og_description'),
            'og_image' => $validated['og_image'] ?? $validated['featured_image'] ?? null,
        ];
        
        // Filter out null values
        $seoData = array_filter($seoData, function ($value) {
            return !is_null($value);
        });
        
        // Add SEO data to project
        $validated['seo'] = !empty($seoData) ? $seoData : null;
        
        // Remove temporary fields
        unset($validated['featured_image_url']);
        unset($validated['og_image_url']);
        unset($validated['meta_title']);
        unset($validated['meta_description']);
        unset($validated['meta_keywords']);
        unset($validated['og_title']);
        unset($validated['og_description']);

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
            'featured_image' => 'nullable|image|max:2048',
            'featured_image_url' => 'nullable|url',
            'images' => 'nullable|array',
            'images.*' => 'url',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'completion_date' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            // SEO fields
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:70',
            'og_description' => 'nullable|string|max:200',
            'og_image' => 'nullable|image|max:2048',
            'og_image_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if it exists and is in our storage
            if ($project->featured_image && Str::startsWith($project->featured_image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $project->featured_image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('featured_image')->store('projects/featured', 'public');
            $validated['featured_image'] = Storage::url($path);
        } elseif ($request->filled('featured_image_url')) {
            $validated['featured_image'] = $request->input('featured_image_url');
        }
        
        // Handle OG image upload
        $ogImage = null;
        if ($request->hasFile('og_image')) {
            // Delete old OG image if it exists and is in our storage
            if (isset($project->seo['og_image']) && Str::startsWith($project->seo['og_image'], '/storage/')) {
                $oldPath = str_replace('/storage/', '', $project->seo['og_image']);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('og_image')->store('projects/og', 'public');
            $ogImage = Storage::url($path);
        } elseif ($request->filled('og_image_url')) {
            $ogImage = $request->input('og_image_url');
        } elseif (isset($project->seo['og_image'])) {
            $ogImage = $project->seo['og_image'];
        }
        
        // Create SEO metadata
        $seoData = [
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'og_title' => $request->input('og_title'),
            'og_description' => $request->input('og_description'),
            'og_image' => $ogImage ?? $validated['featured_image'] ?? null,
        ];
        
        // Filter out null values
        $seoData = array_filter($seoData, function ($value) {
            return !is_null($value);
        });
        
        // Add SEO data to project
        $validated['seo'] = !empty($seoData) ? $seoData : null;
        
        // Remove temporary fields
        unset($validated['featured_image_url']);
        unset($validated['og_image_url']);
        unset($validated['meta_title']);
        unset($validated['meta_description']);
        unset($validated['meta_keywords']);
        unset($validated['og_title']);
        unset($validated['og_description']);

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
        // Delete featured image if it exists and is in our storage
        if ($project->featured_image && Str::startsWith($project->featured_image, '/storage/')) {
            $path = str_replace('/storage/', '', $project->featured_image);
            Storage::disk('public')->delete($path);
        }
        
        // Delete OG image if it exists and is in our storage
        if (isset($project->seo['og_image']) && Str::startsWith($project->seo['og_image'], '/storage/')) {
            $path = str_replace('/storage/', '', $project->seo['og_image']);
            Storage::disk('public')->delete($path);
        }
        
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }
}
