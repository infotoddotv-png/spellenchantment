<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'email', 'payment_method', 'status', 'subtotal', 'total', 'items',
    ];

    protected $casts = [
        'items'    => 'array',
        'subtotal' => 'float',
        'total'    => 'float',
    ];
}
