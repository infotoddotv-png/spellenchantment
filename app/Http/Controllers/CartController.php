<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart  = session('cart', []);
        $items = $this->buildCartItems($cart);
        $subtotal = collect($items)->sum(fn($i) => $i['price'] * $i['quantity']);
        $total    = $subtotal;

        return view('pages.cart', compact('items', 'subtotal', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);

        $cart       = session('cart', []);
        $productId  = $request->product_id;
        $qty        = $request->quantity ?? 1;

        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;
        session(['cart' => $cart]);

        return back()->with('success', 'Added to your satchel!');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);

        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed.');
    }

    public function update(Request $request)
    {
        $request->validate(['product_id' => 'required', 'quantity' => 'required|integer|min:1']);

        $cart = session('cart', []);
        $cart[$request->product_id] = $request->quantity;
        session(['cart' => $cart]);

        return back();
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
                'price'      => $p->price,
                'quantity'   => $qty,
                'image_url'  => $p->image_url,
                'type'       => $p->type,
            ];
        })->filter()->values()->toArray();
    }
}
