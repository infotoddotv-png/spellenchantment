<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentSetting;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $secret = PaymentSetting::get('stripe_webhook_secret');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            if ($secret) {
                $event = Webhook::constructEvent($payload, $sigHeader, $secret);
            } else {
                $event = json_decode($payload, false);
            }
        } catch (\Throwable $e) {
            return response('Invalid webhook', 400);
        }

        $type = is_object($event) && isset($event->type) ? $event->type : null;

        if ($type === 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId && ($order = Order::find($orderId))) {
                PaymentService::markPaid($order);
            }
        }

        return response('OK', 200);
    }
}
