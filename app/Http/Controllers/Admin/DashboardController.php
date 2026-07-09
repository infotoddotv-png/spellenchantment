<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'activeUsers' => User::where('status', 'active')->count(),
            'products' => Product::count(),
            'orders' => Order::count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }

    public function profile()
    {
        return view('admin.profile.index', ['user' => Auth::user()]);
    }
}
