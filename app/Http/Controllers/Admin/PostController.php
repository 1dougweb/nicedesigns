<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::with(['category', 'author'])
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        // Se não especificar data de publicação e estiver publicado, usar agora
        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        $post->load(['category', 'author']);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Se mudou para publicado e não tinha data, definir agora
        if ($validated['is_published'] && !$post->published_at && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post excluído com sucesso!');
    }
}
