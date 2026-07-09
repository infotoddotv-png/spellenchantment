<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryEntry extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'content',
        'difficulty', 'tags', 'featured',
    ];

    protected $casts = [
        'tags'     => 'array',
        'featured' => 'boolean',
    ];

    public function getDifficultyColorAttribute(): string
    {
        return match($this->difficulty) {
            'Beginner'     => 'text-green-400 border-green-900/50 bg-green-900/10',
            'Intermediate' => 'text-yellow-400 border-yellow-900/50 bg-yellow-900/10',
            'Advanced'     => 'text-red-400 border-red-900/50 bg-red-900/10',
            default        => 'text-muted-foreground border-white/10 bg-white/5',
        };
    }
}
