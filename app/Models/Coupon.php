<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'usage_limit', 'used_count',
        'min_order_total', 'expires_at', 'active',
    ];

    protected $casts = [
        'value' => 'float',
        'min_order_total' => 'float',
        'expires_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function isValid(float $orderTotal = 0): bool
    {
        if (! $this->active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) return false;
        if ($this->min_order_total !== null && $orderTotal < $this->min_order_total) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percent') {
            return round($subtotal * ($this->value / 100), 2);
        }
        return min($this->value, $subtotal);
    }
}
