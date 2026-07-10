<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;

class ManualGateway implements PaymentGatewayInterface
{
    public function charge(Order $order): ?string
    {
        $order->update(['status' => 'pending_payment']);

        return null;
    }
}
