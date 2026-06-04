@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-section-header label="Member Area" title="Dashboard" description="Selamat datang, {{ Auth::user()->name }}" />

    <div class="pb-20">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="card p-4">
                    <p class="text-xs text-white/30 mb-2">Total Pesanan</p>
                    <p class="text-2xl font-semibold text-white">{{ $totalOrders }}</p>
                </div>
                <div class="card p-4">
                    <p class="text-xs text-white/30 mb-2">Pesanan Aktif</p>
                    <p class="text-2xl font-semibold text-white">{{ $totalPaid }}</p>
                </div>
                <div class="card p-4">
                    <p class="text-xs text-white/30 mb-2">Menunggu Bayar</p>
                    <p class="text-2xl font-semibold text-white">{{ $totalPending }}</p>
                </div>
                <div class="card p-4">
                    <p class="text-xs text-white/30 mb-2">Total Pengeluaran</p>
                    <p class="text-lg font-semibold text-white">Rp {{ number_format($totalSpending, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Chart --}}
                <div class="lg:col-span-2 card p-5">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Pengeluaran 6 Bulan Terakhir
                    </p>
                    <canvas id="spendingChart" height="120"></canvas>
                </div>

                {{-- Quick Links --}}
                <div class="card p-5">
                    <p class="text-xs font-medium text-white/40 uppercase tracking-widest mb-4">Menu Cepat</p>
                    <div class="space-y-1">
                        <a href="{{ route('user.orders.index') }}" wire:navigate
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-receipt text-xs text-white/30 w-3.5"></i>
                                <span class="text-xs text-white/60 group-hover:text-white transition-colors">Pesanan
                                    Saya</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-white/20"></i>
                        </a>
                        <a href="{{ route('user.profile') }}" wire:navigate
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-user text-xs text-white/30 w-3.5"></i>
                                <span class="text-xs text-white/60 group-hover:text-white transition-colors">Edit
                                    Profile</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-white/20"></i>
                        </a>
                        <a href="{{ route('courses.index') }}" wire:navigate
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-play-circle text-xs text-white/30 w-3.5"></i>
                                <span class="text-xs text-white/60 group-hover:text-white transition-colors">Jelajahi
                                    Kelas</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-white/20"></i>
                        </a>
                        <a href="{{ route('products.index') }}" wire:navigate
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-box text-xs text-white/30 w-3.5"></i>
                                <span class="text-xs text-white/60 group-hover:text-white transition-colors">Jelajahi
                                    Produk</span>
                            </div>
                            <i class="fas fa-chevron-right text-[10px] text-white/20"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="mt-6 card">
                <div class="card-header flex items-center justify-between">
                    <p class="text-xs font-medium text-white/50">Pesanan Terbaru</p>
                    <a href="{{ route('user.orders.index') }}" wire:navigate
                        class="text-xs text-white/30 hover:text-white transition-colors">Lihat semua</a>
                </div>
                @if ($recentOrders->count() > 0)
                    <div class="table-wrapper rounded-t-none border-t-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('user.orders.show', $order->invoice_number) }}" wire:navigate
                                                class="text-xs font-mono text-white/60 hover:text-white transition-colors">
                                                {{ $order->invoice_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-xs text-white/40">{{ $order->items->count() }} item</span>
                                        </td>
                                        <td>
                                            <span class="text-xs text-white/60">Rp
                                                {{ number_format($order->total, 0, ',', '.') }}</span>
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
                                        <td>
                                            <span
                                                class="text-xs text-white/30">{{ $order->created_at->format('d M Y') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-receipt text-2xl text-white/10 mb-2 block"></i>
                        <p class="text-xs text-white/30">Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            if (window._userDashboardController) {
                window._userDashboardController.abort();
            }
            window._userDashboardController = new AbortController();

            window.spendingData = @json($chartData);

            function initSpendingChart() {
                const canvas = document.getElementById('spendingChart');
                if (!canvas) return;

                if (window._spendingChart) {
                    window._spendingChart.destroy();
                    window._spendingChart = null;
                }

                // Load Chart.js kalau belum ada
                if (typeof Chart === 'undefined') {
                    if (!window._chartJsLoaded) {
                        window._chartJsLoaded = true;
                        const script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
                        script.onload = () => buildSpendingChart();
                        document.head.appendChild(script);
                    }
                } else {
                    buildSpendingChart();
                }
            }

            function buildSpendingChart() {
                const canvas = document.getElementById('spendingChart');
                if (!canvas) return;

                window._spendingChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: window.spendingData.map(d => d.label),
                        datasets: [{
                            label: 'Pengeluaran',
                            data: window.spendingData.map(d => d.total),
                            borderColor: 'rgba(255,255,255,0.4)',
                            backgroundColor: 'rgba(255,255,255,0.03)',
                            borderWidth: 1.5,
                            pointBackgroundColor: 'rgba(255,255,255,0.6)',
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            fill: true,
                            tension: 0.4,
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
                                    color: 'rgba(255,255,255,0.03)'
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

            initSpendingChart();

            document.addEventListener('livewire:navigated', () => {
                window.spendingData = @json($chartData);
                initSpendingChart();
            }, {
                signal: window._userDashboardController.signal
            });
        </script>
    @endpush
@endsection
