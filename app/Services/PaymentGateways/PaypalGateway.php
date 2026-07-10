<?php

namespace App\Services\PaymentGateways;

use App\Models\Order;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Http;

class PaypalGateway implements PaymentGatewayInterface
{
    protected function baseUrl(): string
    {
        $mode = PaymentSetting::get('paypal_mode', 'sandbox');
        return $mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    protected function getAccessToken(string $clientId, string $secret): string
    {
        $response = Http::asForm()
            ->withBasicAuth($clientId, $secret)
            ->post($this->baseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Unable to authenticate with PayPal.');
        }

        return $response->json('access_token');
    }

    public function charge(Order $order): ?string
    {
        $clientId = PaymentSetting::get('paypal_client_id');
        $secret = PaymentSetting::get('paypal_secret');

        if (! $clientId || ! $secret) {
            throw new \RuntimeException('PayPal is not configured. Set the client ID and secret in Admin > Payments.');
        }

        $token = $this->getAccessToken($clientId, $secret);

        $response = Http::withToken($token)->post($this->baseUrl() . '/v2/checkout/orders', [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => (string) $order->id,
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($order->total, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'return_url' => route('checkout.paypal.return', $order->id),
                'cancel_url' => route('checkout.index'),
            ],
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Unable to create PayPal order: ' . $response->body());
        }

        $data = $response->json();
        $order->update(['payment_reference' => $data['id']]);

        $approveLink = collect($data['links'] ?? [])->firstWhere('rel', 'approve');

        return $approveLink['href'] ?? null;
    }

    public function capture(string $paypalOrderId): array
    {
        $clientId = PaymentSetting::get('paypal_client_id');
        $secret = PaymentSetting::get('paypal_secret');
        $token = $this->getAccessToken($clientId, $secret);

        $response = Http::withToken($token)->post($this->baseUrl() . "/v2/checkout/orders/{$paypalOrderId}/capture");

        return $response->json() ?? [];
    }
}
