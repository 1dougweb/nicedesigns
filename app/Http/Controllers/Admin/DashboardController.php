<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Models\Contact;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'projects' => Project::count(),
            'published_projects' => Project::published()->count(),
            'contacts' => Contact::count(),
            'unread_contacts' => Contact::unread()->count(),
        ];

        $recentContacts = Contact::latest()
            ->take(5)
            ->get();

        $recentPosts = Post::latest()
            ->take(5)
            ->with(['category', 'author'])
            ->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentPosts'));
    }
}
