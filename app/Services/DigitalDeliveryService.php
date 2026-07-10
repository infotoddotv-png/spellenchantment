<?php

namespace App\Services;

use App\Models\Download;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;

class DigitalDeliveryService
{
    public static function deliverIfApplicable(Order $order): void
    {
        $productIds = collect($order->items)->pluck('product_id')->filter()->unique();
        $products = Product::whereIn('id', $productIds)->whereNotNull('file_path')->get();

        foreach ($products as $product) {
            Download::firstOrCreate(
                ['order_id' => $order->id, 'product_id' => $product->id],
                [
                    'token' => Str::random(48),
                    'max_downloads' => 5,
                    'expires_at' => now()->addDays(30),
                ]
            );
        }

        $order->update(['fulfilled_at' => now()]);
    }
}
