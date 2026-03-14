<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'cover', 'is_published', 'published_at', 'meta_title', 'meta_description', 'sort_order'];

    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug')->doNotGenerateSlugsOnUpdate();
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true)->orderByDesc('published_at');
    }
}
