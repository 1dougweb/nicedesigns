<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::published()
            ->latest()
            ->with(['category'])
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->withCount('projects')
            ->get();

        return view('projects.index', compact('projects', 'categories'));
    }

    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->published()
            ->with(['category'])
            ->firstOrFail();

        $relatedProjects = Project::published()
            ->where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->latest()
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
