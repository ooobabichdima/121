<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Order::whereDate('created_at', today());
        $week = Order::where('created_at', '>=', now()->subDays(7));

        $stats = [
            'today_orders' => $today->count(),
            'week_orders' => $week->count(),
            'today_revenue' => $today->sum('total'),
            'week_revenue' => $week->sum('total'),
            'paid' => Order::where('status', 'paid')->count(),
            'unpaid' => Order::where('status', '!=', 'paid')->count(),
        ];

        $topProducts = Product::withSum('items as sold', 'qty')->orderByDesc('sold')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'topProducts'));
    }
}
