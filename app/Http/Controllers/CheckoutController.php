<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\PaymentGateways\PaypalGateway;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $items    = $this->buildCartItems($cart);
        $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        $coupon = session('coupon');
        $discount = 0;
        if ($coupon) {
            $c = Coupon::where('code', $coupon)->first();
            if ($c && $c->isValid($subtotal)) {
                $discount = $c->calculateDiscount($subtotal);
            } else {
                session()->forget('coupon');
                $coupon = null;
            }
        }

        $total = max($subtotal - $discount, 0);

        return view('pages.checkout', compact('items', 'subtotal', 'total', 'discount', 'coupon'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)->first();

        if (! $coupon || ! $coupon->isValid()) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        session(['coupon' => $coupon->code]);

        AuditLog::record('coupon.applied', "Coupon {$coupon->code} applied at checkout", $coupon);

        return back()->with('success', 'Coupon applied!');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|min:2',
            'email'          => 'required|email',
            'payment_method' => 'required|in:card,crypto,paypal,manual',
        ]);

        $cart  = session('cart', []);
        $items = $this->buildCartItems($cart);

        if (empty($items)) {
            return redirect()->route('cart.index');
        }

        $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        $couponCode = session('coupon');
        $discount = 0;
        $coupon = null;
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                $coupon = null;
            }
        }

        $total = max($subtotal - $discount, 0);

        $gateway = match ($data['payment_method']) {
            'card' => 'stripe',
            'paypal' => 'paypal',
            'crypto', 'manual' => 'manual',
        };

        // Sync the buyer with the users table so every order shows up under Admin > Users,
        // even for guest checkouts.
        $user = Auth::user();
        if (! $user) {
            // Only auto-attach to a pre-existing guest-checkout record (never-logged-in,
            // random password) — never silently bind an order to someone's established
            // real account just because they typed that account's email at checkout.
            $user = User::where('email', $data['email'])->where('is_guest', true)->first();
            if (! $user && ! User::where('email', $data['email'])->exists()) {
                $user = User::create([
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'password' => Hash::make(Str::random(24)),
                    'role'     => 'customer',
                    'status'   => 'active',
                    'is_guest' => true,
                ]);
            }
            // If the email belongs to someone else's established account, leave the order
            // unlinked (null user_id) rather than crashing on the unique constraint or
            // silently attaching to an account we can't prove ownership of.
        }

        $order = Order::create([
            'user_id'           => $user?->id,
            'name'              => $data['name'],
            'email'             => $data['email'],
            'payment_method'    => $data['payment_method'],
            'payment_gateway'   => $gateway,
            'status'            => 'pending',
            'subtotal'          => $subtotal,
            'discount'          => $discount,
            'coupon_code'       => $coupon?->code,
            'total'             => $total,
            'items'             => $items,
        ]);

        AuditLog::record('order.placed', "Order #{$order->id} placed by {$order->name} ({$order->email}) for \${$order->total}", $order);

        if ($coupon) {
            $coupon->increment('used_count');
        }

        session()->forget(['cart', 'coupon']);

        try {
            $redirectUrl = PaymentService::charge($order);
        } catch (\Throwable $e) {
            $order->update(['status' => 'failed']);
            AuditLog::record('order.payment_failed', "Payment attempt failed for order #{$order->id}: {$e->getMessage()}", $order);
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        }

        if ($redirectUrl) {
            return redirect()->away($redirectUrl);
        }

        if ($gateway === 'manual') {
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed! Follow the payment instructions to complete your purchase.');
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Your order has been placed successfully!');
    }

    public function paypalReturn(Request $request, Order $order)
    {
        $paypalOrderId = $request->query('token');

        try {
            $result = (new PaypalGateway())->capture($paypalOrderId);
        } catch (\Throwable $e) {
            return redirect()->route('checkout.index')->with('error', $e->getMessage());
        }

        if (($result['status'] ?? null) === 'COMPLETED') {
            PaymentService::markPaid($order);
            return redirect()->route('orders.show', $order->id)->with('success', 'Payment confirmed via PayPal!');
        }

        return redirect()->route('checkout.index')->with('error', 'PayPal payment was not completed.');
    }

    private function buildCartItems(array $cart): array
    {
        if (empty($cart)) return [];

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        return collect($cart)->map(function ($qty, $id) use ($products) {
            $p = $products[$id] ?? null;
            if (!$p) return null;
            return [
                'product_id' => $p->id,
                'name'       => $p->name,
                'slug'       => $p->slug,
                'price'      => (float) $p->price,
                'quantity'   => (int) $qty,
                'image_url'  => $p->image_url,
                'type'       => $p->type,
            ];
        })->filter()->values()->toArray();
    }
}
