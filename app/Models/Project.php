<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'client_name',
        'project_url',
        'featured_image',
        'images',
        'technologies',
        'completion_date',
        'is_featured',
        'is_published',
        'category_id',
        'user_id',
        'seo',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'technologies' => 'array',
            'completion_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'seo' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the meta title for SEO.
     */
    public function getMetaTitleAttribute(): string
    {
        return $this->seo['meta_title'] ?? $this->title;
    }

    /**
     * Get the meta description for SEO.
     */
    public function getMetaDescriptionAttribute(): string
    {
        return $this->seo['meta_description'] ?? Str::limit($this->description, 160);
    }

    /**
     * Get the Open Graph image URL.
     */
    public function getOgImageAttribute(): ?string
    {
        return $this->seo['og_image'] ?? $this->featured_image;
    }
} 