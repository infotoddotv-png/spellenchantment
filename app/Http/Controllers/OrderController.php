<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function show(int $id)
    {
        $order = Order::findOrFail($id);
        return view('pages.orders.show', compact('order'));
    }
}
