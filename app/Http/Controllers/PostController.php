<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the posts with optional search and category filter.
     */
    public function index(Request $request): View
    {
        $query = Post::published()
            ->latest('published_at')
            ->with(['category', 'author']);

        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%");
            });
        }

        // Apply category filter if provided
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $posts = $query->paginate(12);

        // Get categories with post count for the sidebar
        $categories = Category::where('is_active', true)
            ->withCount(['posts' => function($query) {
                $query->published();
            }])
            ->get()
            ->filter(function($category) {
                return $category->posts_count > 0;
            });

        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Display the specified post.
     */
    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with(['category', 'author'])
            ->firstOrFail();

        // Get related posts from the same category
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts filtered by category.
     */
    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $posts = Post::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->with(['category', 'author'])
            ->paginate(12);

        // Get all categories for the sidebar
        $categories = Category::where('is_active', true)
            ->withCount(['posts' => function($query) {
                $query->published();
            }])
            ->get()
            ->filter(function($category) {
                return $category->posts_count > 0;
            });

        return view('posts.category', compact('posts', 'category', 'categories'));
    }
}
