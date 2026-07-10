<?php

namespace App\Services;

use App\Models\Order;
use App\Services\PaymentGateways\ManualGateway;
use App\Services\PaymentGateways\PaymentGatewayInterface;
use App\Services\PaymentGateways\PaypalGateway;
use App\Services\PaymentGateways\StripeGateway;
use App\Services\DigitalDeliveryService;

class PaymentService
{
    public static function driver(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'stripe' => new StripeGateway(),
            'paypal' => new PaypalGateway(),
            'manual' => new ManualGateway(),
            default => throw new \InvalidArgumentException("Unknown payment gateway: {$gateway}"),
        };
    }

    public static function charge(Order $order): ?string
    {
        return static::driver($order->payment_gateway)->charge($order);
    }

    public static function markPaid(Order $order): void
    {
        if ($order->paid_at) return;

        $order->update([
            'status' => 'confirmed',
            'paid_at' => now(),
        ]);

        DigitalDeliveryService::deliverIfApplicable($order);
    }
}
