<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()
            ->latest('published_at')
            ->with(['category', 'author'])
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->withCount('posts')
            ->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with(['category', 'author'])
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

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

        return view('posts.category', compact('posts', 'category'));
    }
}
