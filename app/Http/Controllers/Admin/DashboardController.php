<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
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

        $ticketStats = [
            'open' => Ticket::where('status', 'open')->count(),
            'waiting_admin' => Ticket::where('status', 'waiting_admin')->count(),
            'replied' => Ticket::where('status', 'replied')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $recentActivity = AuditLog::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'ticketStats', 'recentOrders', 'recentUsers', 'recentActivity'));
    }

    public function profile()
    {
        return view('admin.profile.index', ['user' => Auth::user()]);
    }
}
