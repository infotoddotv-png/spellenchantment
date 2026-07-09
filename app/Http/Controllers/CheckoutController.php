<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $total    = $subtotal;

        return view('pages.checkout', compact('items', 'subtotal', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|min:2',
            'email'          => 'required|email',
            'payment_method' => 'required|in:card,crypto,paypal',
        ]);

        $cart  = session('cart', []);
        $items = $this->buildCartItems($cart);

        if (empty($items)) {
            return redirect()->route('cart.index');
        }

        $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            'name'           => $data['name'],
            'email'          => $data['email'],
            'payment_method' => $data['payment_method'],
            'status'         => 'confirmed',
            'subtotal'       => $subtotal,
            'total'          => $subtotal,
            'items'          => $items,
        ]);

        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Your order has been placed successfully!');
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
