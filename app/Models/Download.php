<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Download extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'token', 'download_count', 'max_downloads', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isValid(): bool
    {
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->download_count >= $this->max_downloads) return false;
        return true;
    }
}
