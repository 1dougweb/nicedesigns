<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProjects = Project::published()
            ->featured()
            ->latest()
            ->take(6)
            ->get();

        $latestPosts = Post::published()
            ->latest('published_at')
            ->take(3)
            ->with(['category', 'author'])
            ->get();

        return view('home', compact('featuredProjects', 'latestPosts'));
    }
}
