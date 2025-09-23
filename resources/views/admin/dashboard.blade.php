@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4">
            <i class="fas fa-chart-line me-2"></i>Dashboard - Thống kê hệ thống
        </h1>

        <!-- Cards thống kê -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Tổng khách hàng</h6>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalUsers ?? 0) }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Tổng đơn hàng</h6>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalOrders ?? 0) }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-shopping-cart text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Doanh thu</h6>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalRevenue ?? 0) }}đ</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-dollar-sign text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Tổng bình luận</h6>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalReviews ?? 0) }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-comments text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            Doanh thu theo tháng
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-fire me-2 text-danger"></i>
                            Top 5 sản phẩm bán chạy
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy"></i> Top 5 Sản Phẩm Bán Chạy Nhất
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-dark">
                                    <th class="text-center" width="10%">Rank</th>
                                    <th width="5%">Hình ảnh</th>
                                    <th width="50%">Sản phẩm</th>
                                    <th class="text-center" width="20%">Đã bán</th>
                                    <th class="text-right" width="15%">Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topProducts as $index => $topProduct)
                                    <tr>
                                        <td class="text-center align-middle">
                                            @if ($index == 0)
                                                {{-- Top 1: Huy chương vàng --}}
                                                <span class="badge badge-warning text-dark rounded-circle p-3"
                                                    style="font-size: 1.2rem;">🥇</span>
                                            @elseif($index == 1)
                                                {{-- Top 2: Huy chương bạc --}}
                                                <span class="badge badge-secondary text-dark rounded-circle p-3"
                                                    style="font-size: 1.2rem;">🥈</span>
                                            @elseif($index == 2)
                                                {{-- Top 3: Huy chương đồng --}}
                                                <span class="badge text-white rounded-circle p-3"
                                                    style="font-size: 1.2rem;">🥉</span>
                                            @else
                                                {{-- Các vị trí khác --}}
                                                <span class="badge badge-light text-dark rounded-circle p-3"
                                                    style="font-size: 1.2rem;">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <img src="{{ asset($topProduct->variants->first()->images->first()->image_url) ?? '' }}"
                                                alt="Product" class="img-thumbnail" style="width: 70px;">
                                        </td>
                                        <td class="align-middle" style="max-width: 250px;">
                                            <h6 class="mb-1 text-wrap text-break">{{ $topProduct->name }}</h6>
                                        </td>
                                        <td class="text-center align-middle">
                                            <h5 class="text-success mb-0">{{ $topProduct->total_sold }} <small
                                                    class="text-muted">sản phẩm</small>
                                            </h5>
                                        </td>
                                        <td class="text-right align-middle">
                                            <h6 class="text-primary mb-0">
                                                {{ number_format($topProduct->total_revenue, 0, ',', '.') }} VND</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cấu hình chung cho Chart.js
            Chart.defaults.font.family = "'Segoe UI', 'Roboto', sans-serif";

            // Doanh thu theo tháng
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueData = @json($revenueByMonth ?? []);


            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                    datasets: [{
                        label: 'Doanh thu',
                        data: [
                            @for ($m = 1; $m <= 12; $m++)
                                {{ $revenueByMonth[$m] ?? 0 }}{{ $m < 12 ? ',' : '' }}
                            @endfor
                        ],
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context
                                        .parsed.y) + 'đ';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(0) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(0) + 'K';
                                    }
                                    return value;
                                }
                            }
                        }
                    }
                }
            });

            // Top sản phẩm
            const productCtx = document.getElementById('productChart').getContext('2d');
            const topProducts = @json($topProducts ?? collect([]));
            const productNames = topProducts.map(p => p.name || 'N/A');
            const productSold = topProducts.map(p => p.total_sold || 0);

            new Chart(productCtx, {
                type: 'doughnut',
                data: {
                    labels: productNames,
                    datasets: [{
                        data: productSold,
                        backgroundColor: [
                            '#0d6efd',
                            '#6610f2',
                            '#6f42c1',
                            '#d63384',
                            '#dc3545'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                },
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            return {
                                                text: label + ' (' + value + ')',
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed + ' sản phẩm';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .bg-opacity-10 {
            opacity: 0.1;
        }
    </style>
@endpush
