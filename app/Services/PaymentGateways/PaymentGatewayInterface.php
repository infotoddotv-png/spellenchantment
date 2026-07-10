<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Start a payment for the given order. Returns a redirect URL (or null if no redirect needed).
     */
    public function charge(Order $order): ?string;
}
