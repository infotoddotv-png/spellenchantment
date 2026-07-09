<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'lore', 'price', 'original_price',
        'type', 'category_id', 'image_url', 'tags', 'rating', 'review_count',
        'in_stock', 'featured', 'is_new', 'is_bestseller',
    ];

    protected $casts = [
        'tags'       => 'array',
        'price'      => 'float',
        'original_price' => 'float',
        'rating'     => 'float',
        'in_stock'   => 'boolean',
        'featured'   => 'boolean',
        'is_new'     => 'boolean',
        'is_bestseller' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute(): ?string
    {
        return $this->category?->name;
    }

    public function getStarsHtmlAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->rating ? '★' : '☆';
        }
        return $html;
    }
}
