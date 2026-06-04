<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik
        $totalOrders = $user->orders()->count();
        $totalPaid = $user->orders()->where('status', 'paid')->count();
        $totalSpending = $user->orders()->where('status', 'paid')->sum('total');
        $totalPending = $user->orders()->where('status', 'pending')->count();

        // Chart: transaksi per bulan (6 bulan terakhir)
        $chartData = Order::where('user_id', $user->id)
            ->where('status', 'paid')
            ->selectRaw('MONTH(paid_at) as month, YEAR(paid_at) as year, SUM(total) as total')
            ->whereRaw('paid_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)')
            ->groupByRaw('YEAR(paid_at), MONTH(paid_at)')
            ->orderByRaw('YEAR(paid_at), MONTH(paid_at)')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => \Carbon\Carbon::create($item->year, $item->month)->format('M Y'),
                    'total' => (float) $item->total,
                ];
            });

        // Order terbaru
        $recentOrders = $user->orders()
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalOrders',
            'totalPaid',
            'totalSpending',
            'totalPending',
            'chartData',
            'recentOrders'
        ));
    }
}
