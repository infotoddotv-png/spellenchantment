<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use App\Services\DigitalDeliveryService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('id', $s);
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'revenue' => Order::where('status', 'confirmed')->sum('total'),
            'pending' => Order::where('status', 'pending')->count(),
            'today' => Order::whereDate('created_at', today())->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load('downloads.product');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,pending_payment,confirmed,shipped,fulfilled,cancelled,failed,refunded',
        ]);

        $previousStatus = $order->status;
        $order->update($data);

        if ($data['status'] === 'confirmed' && ! $order->paid_at) {
            $order->update(['paid_at' => now()]);
            DigitalDeliveryService::deliverIfApplicable($order);
        }

        AuditLog::record('order.status_updated', "Order #{$order->id} status changed from {$previousStatus} to {$data['status']}", $order);

        return back()->with('success', 'Order status updated.');
    }
}
