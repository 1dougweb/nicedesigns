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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|url',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle featured image upload
        if ($request->hasFile('featured_image_file')) {
            $data['featured_image'] = $this->uploadFeaturedImage($request->file('featured_image_file'));
        }

        // Generate slug
        $data['slug'] = Str::slug($data['title']);
        $originalSlug = $data['slug'];
        $counter = 1;
        
        while (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set published_at if publishing
        if ($request->input('action') === 'publish' || $data['is_published']) {
            $data['is_published'] = true;
            $data['published_at'] = now();
        } else {
            $data['is_published'] = false;
            $data['published_at'] = null;
        }

        $data['user_id'] = auth()->id();

        Post::create($data);

        return redirect()->route('admin.posts.index')
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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|url',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        
        // Handle featured image upload
        if ($request->hasFile('featured_image_file')) {
            // Delete old image if it exists and is local
            if ($post->featured_image && $this->isLocalImage($post->featured_image)) {
                $this->deleteOldImage($post->featured_image);
            }
            
            $data['featured_image'] = $this->uploadFeaturedImage($request->file('featured_image_file'));
        }

        // Update slug if title changed
        if ($data['title'] !== $post->title) {
            $data['slug'] = Str::slug($data['title']);
            $originalSlug = $data['slug'];
            $counter = 1;
            
            while (Post::where('slug', $data['slug'])->where('id', '!=', $post->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle publication status
        if ($request->input('action') === 'publish' || $data['is_published']) {
            $data['is_published'] = true;
            if (!$post->published_at) {
                $data['published_at'] = now();
            }
        } elseif ($request->input('action') === 'draft') {
            $data['is_published'] = false;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Delete featured image if it's local
        if ($post->featured_image && $this->isLocalImage($post->featured_image)) {
            $this->deleteOldImage($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post excluído com sucesso!');
    }

    /**
     * Upload featured image and return the URL
     */
    private function uploadFeaturedImage($file)
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = 'blog/featured/' . $filename;
        
        // Create directory if it doesn't exist
        if (!Storage::disk('public')->exists('blog/featured')) {
            Storage::disk('public')->makeDirectory('blog/featured');
        }
        
        // Store the original file
        Storage::disk('public')->put($path, file_get_contents($file));
        
        return '/storage/' . $path;
    }

    /**
     * Check if image is stored locally
     */
    private function isLocalImage($imageUrl)
    {
        return str_starts_with($imageUrl, '/storage/blog/featured/');
    }

    /**
     * Delete old image file
     */
    private function deleteOldImage($imageUrl)
    {
        if ($this->isLocalImage($imageUrl)) {
            $path = str_replace('/storage/', '', $imageUrl);
            Storage::disk('public')->delete($path);
        }
    }
}
