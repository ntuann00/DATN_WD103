@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="my-4 fw-bold">📊 Thống kê hệ thống</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tổng khách hàng</h5>
                        <p class="card-text fs-4">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tổng đơn hàng</h5>
                        <p class="card-text fs-4">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Doanh thu</h5>
                        <p class="card-text fs-4">{{ number_format($totalRevenue) }} đ</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tổng bình luận</h5>
                        <p class="card-text fs-4">{{ $totalReviews }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biểu đồ --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">📈 Doanh thu theo tháng</div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">🔥 Top 5 sản phẩm bán chạy</div>
                    <div class="card-body">
                        <canvas id="productChart"></canvas>
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
            // Doanh thu theo tháng
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 
                            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: [
                            @for ($m = 1; $m <= 12; $m++)
                                {{ $revenueByMonth[$m] ?? 0 }}{{ $m < 12 ? ',' : '' }}
                            @endfor
                        ],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                                }
                            }
                        }
                    }
                }
            });

            // Top sản phẩm
            const productCtx = document.getElementById('productChart').getContext('2d');
            const productNames = @json($topProducts->pluck('name_product'));
            const productSold = @json($topProducts->pluck('total_sold'));
            
            new Chart(productCtx, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [{
                        label: 'Số lượng bán',
                        data: productSold,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush