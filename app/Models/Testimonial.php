<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['author', 'location', 'avatar_url', 'content', 'rating', 'product'];

    public function getStarsHtmlAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->rating ? '★' : '☆';
        }
        return $html;
    }
}
