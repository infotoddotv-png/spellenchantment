<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\PaymentSetting;
use Stripe\StripeClient;

class StripeGateway implements PaymentGatewayInterface
{
    public function charge(Order $order): ?string
    {
        $secret = PaymentSetting::get('stripe_secret_key');

        if (! $secret) {
            throw new \RuntimeException('Stripe is not configured. Set the secret key in Admin > Payments.');
        }

        $stripe = new StripeClient($secret);

        $lineItems = collect($order->items)->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => $item['name']],
                    'unit_amount' => (int) round($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        })->toArray();

        if ($order->discount > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Discount' . ($order->coupon_code ? " ({$order->coupon_code})" : '')],
                    'unit_amount' => -1 * (int) round($order->discount * 100),
                ],
                'quantity' => 1,
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'customer_email' => $order->email,
            'line_items' => $lineItems,
            'success_url' => route('orders.show', $order->id) . '?paid=1',
            'cancel_url' => route('checkout.index'),
            'metadata' => ['order_id' => $order->id],
        ]);

        $order->update(['payment_reference' => $session->id]);

        return $session->url;
    }
}
