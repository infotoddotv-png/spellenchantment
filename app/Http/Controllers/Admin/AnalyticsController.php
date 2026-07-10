<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $days = collect(range(29, 0))->map(fn($i) => Carbon::today()->subDays($i));

        $revenueByDay = $days->map(function ($day) {
            return [
                'label' => $day->format('M j'),
                'revenue' => (float) Order::whereDate('created_at', $day)->where('status', 'confirmed')->sum('total'),
                'orders' => Order::whereDate('created_at', $day)->count(),
            ];
        });

        $totalRevenue = Order::where('status', 'confirmed')->sum('total');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0 ? Order::where('status', 'confirmed')->avg('total') : 0;
        $conversion = $totalOrders > 0 ? round((Order::where('status', 'confirmed')->count() / $totalOrders) * 100, 1) : 0;

        $topProducts = Order::where('status', 'confirmed')
            ->get()
            ->flatMap(fn($o) => collect($o->items))
            ->groupBy('name')
            ->map(fn($group, $name) => [
                'name' => $name,
                'qty' => $group->sum('quantity'),
                'revenue' => $group->sum(fn($i) => $i['price'] * $i['quantity']),
            ])
            ->sortByDesc('revenue')
            ->take(5)
            ->values();

        $statusBreakdown = Order::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');

        return view('admin.analytics.index', compact(
            'revenueByDay', 'totalRevenue', 'totalOrders', 'avgOrderValue', 'conversion', 'topProducts', 'statusBreakdown'
        ));
    }
}
