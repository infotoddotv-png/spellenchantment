<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'payment_method', 'payment_gateway', 'payment_reference',
        'status', 'subtotal', 'discount', 'coupon_code', 'total', 'items',
        'paid_at', 'fulfilled_at',
    ];

    protected $casts = [
        'items'    => 'array',
        'subtotal' => 'float',
        'discount' => 'float',
        'total'    => 'float',
        'paid_at' => 'datetime',
        'fulfilled_at' => 'datetime',
    ];

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
