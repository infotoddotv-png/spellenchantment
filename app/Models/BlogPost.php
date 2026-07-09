<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'author', 'author_avatar',
        'image_url', 'tags', 'featured', 'published_at', 'reading_time',
    ];

    protected $casts = [
        'tags'         => 'array',
        'featured'     => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getFormattedDateAttribute(): string
    {
        return $this->published_at?->format('M d, Y') ?? '';
    }
}
