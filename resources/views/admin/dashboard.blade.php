@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        <div class="card p-4 col-span-2">
            <p class="text-xs text-white/30 mb-1">Total Revenue</p>
            <p class="text-xl font-semibold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-white/30 mb-1">Users</p>
            <p class="text-xl font-semibold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-white/30 mb-1">Kelas</p>
            <p class="text-xl font-semibold text-white">{{ $totalCourses }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-white/30 mb-1">Produk</p>
            <p class="text-xl font-semibold text-white">{{ $totalProducts }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-white/30 mb-1">Pending</p>
            <p class="text-xl font-semibold text-white">{{ $totalPending }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

        {{-- Revenue Chart --}}
        <div class="lg:col-span-2 card p-5">
            <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Revenue 12 Bulan Terakhir</p>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

        {{-- Best Sellers --}}
        <div class="card p-5">
            <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Produk Terlaris</p>
            @if ($bestSellers->count() > 0)
                <div class="space-y-3">
                    @foreach ($bestSellers as $index => $item)
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-white/20 font-mono w-4">{{ $index + 1 }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-white/60 truncate">{{ $item->item_name }}</p>
                                <div class="mt-1 h-1 bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-white/20 rounded-full"
                                        style="width: {{ ($item->total_sold / $bestSellers->first()->total_sold) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs text-white/30 flex-shrink-0">{{ $item->total_sold }}x</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-white/20">Belum ada data</p>
            @endif
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <p class="text-xs font-medium text-white/50">Pesanan Terbaru</p>
            <a href="{{ route('admin.orders.index') }}" wire:navigate
                class="text-xs text-white/30 hover:text-white transition-colors">Lihat semua</a>
        </div>
        <div class="table-wrapper rounded-t-none border-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->invoice_number) }}" wire:navigate
                                    class="text-xs font-mono text-white/50 hover:text-white transition-colors">
                                    {{ $order->invoice_number }}
                                </a>
                            </td>
                            <td><span class="text-xs text-white/50">{{ $order->user->name ?? '-' }}</span></td>
                            <td><span class="text-xs text-white/60">Rp
                                    {{ number_format($order->total, 0, ',', '.') }}</span></td>
                            <td><span
                                    class="text-xs text-white/40 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = match ($order->status) {
                                        'paid' => 'badge-success',
                                        'pending' => 'badge-warning',
                                        'failed', 'expired' => 'badge-destructive',
                                        default => 'badge-secondary',
                                    };
                                @endphp
                                <span class="{{ $statusClass }} capitalize">{{ $order->status }}</span>
                            </td>
                            <td><span class="text-xs text-white/30">{{ $order->created_at->format('d M Y') }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            // Pakai window agar tidak error "already declared"
            window.revenueData = @json($revenueChart);

            function initRevenueChart() {
                const canvas = document.getElementById('revenueChart');
                if (!canvas) return;

                // Destroy chart lama kalau ada
                if (window._revenueChart) {
                    window._revenueChart.destroy();
                    window._revenueChart = null;
                }

                window._revenueChart = new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: window.revenueData.map(d => d.label),
                        datasets: [{
                            label: 'Revenue',
                            data: window.revenueData.map(d => d.total),
                            backgroundColor: 'rgba(255,255,255,0.08)',
                            borderColor: 'rgba(255,255,255,0.15)',
                            borderWidth: 1,
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0D0D0D',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1,
                                titleColor: 'rgba(255,255,255,0.4)',
                                bodyColor: 'rgba(255,255,255,0.8)',
                                callbacks: {
                                    label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID'),
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: 'rgba(255,255,255,0.25)',
                                    font: {
                                        size: 10
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255,255,255,0.03)'
                                },
                                ticks: {
                                    color: 'rgba(255,255,255,0.25)',
                                    font: {
                                        size: 10
                                    },
                                    callback: val => 'Rp ' + val.toLocaleString('id-ID')
                                }
                            }
                        }
                    }
                });
            }

            function loadChart() {
                if (typeof Chart !== 'undefined') {
                    initRevenueChart();
                    return;
                }
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
                script.onload = () => initRevenueChart();
                document.head.appendChild(script);
            }

            loadChart();

            if (window._dashboardController) window._dashboardController.abort();
            window._dashboardController = new AbortController();

            document.addEventListener('livewire:navigated', () => {
                window.revenueData = @json($revenueChart);
                loadChart();
            }, {
                signal: window._dashboardController.signal
            });
        </script>
    @endpush

@endsection
