<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Page;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Estatísticas gerais
        $stats = [
            'posts' => [
                'total' => Post::count(),
                'published' => Post::published()->count(),
                'drafts' => Post::where('is_published', false)->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'published' => Project::published()->count(),
                'featured' => Project::featured()->count(),
            ],
            'contacts' => [
                'total' => Contact::count(),
                'new' => Contact::where('status', 'new')->count(),
                'in_progress' => Contact::where('status', 'in_progress')->count(),
                'completed' => Contact::where('status', 'completed')->count(),
            ],
            'categories' => Category::count(),
            'pages' => Page::count(),
        ];

        // Atividades recentes
        $recentPosts = Post::with(['category', 'author'])
            ->latest()
            ->take(5)
            ->get();

        $recentProjects = Project::with(['category', 'creator'])
            ->latest()
            ->take(5)
            ->get();

        $recentContacts = Contact::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'recentProjects',
            'recentContacts'
        ));
    }
}
