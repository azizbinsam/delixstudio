<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total');
        $totalPending = Order::where('status', 'pending')->count();

        // Chart: revenue per bulan (12 bulan terakhir)
        $revenueChart = Order::where('status', 'paid')
            ->selectRaw('MONTH(paid_at) as month, YEAR(paid_at) as year, SUM(total) as total')
            ->whereRaw('paid_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)')
            ->groupByRaw('YEAR(paid_at), MONTH(paid_at)')
            ->orderByRaw('YEAR(paid_at), MONTH(paid_at)')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => \Carbon\Carbon::create($item->year, $item->month)->format('M Y'),
                    'total' => (float) $item->total,
                ];
            });

        // Chart: produk terlaris
        $bestSellers = \App\Models\OrderItem::selectRaw('item_name, COUNT(*) as total_sold')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->groupBy('item_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Order terbaru
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCourses',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'totalPending',
            'revenueChart',
            'bestSellers',
            'recentOrders'
        ));
    }
}
