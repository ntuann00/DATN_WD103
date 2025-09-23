@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 border-start border-primary border-4">
            <h3 class="mb-1 text-dark fw-bold">
                <i class="fas fa-shopping-cart text-primary me-2"></i>
                Danh sách đơn hàng
            </h3>
            <p class="text-muted mb-0 small">Quản lý tất cả đơn hàng của khách hàng</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm border-top border-primary border-3 h-100">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold text-primary mb-1">{{ $orders->count() }}</h2>
                    <p class="text-muted small text-uppercase mb-0">Tổng đơn hàng</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm border-top border-warning border-3 h-100">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold text-warning mb-1">{{ $orders->where('status.name', 'Chờ xử lý')->count() }}</h2>
                    <p class="text-muted small text-uppercase mb-0">Đã hoàn thành</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm border-top border-success border-3 h-100">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold text-success mb-1">{{ $orders->where('status.name', 'Hoàn tất')->count() }}</h2>
                    <p class="text-muted small text-uppercase mb-0">Chưa hoàn thành</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Mã đơn</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Khách hàng</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Trạng thái</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Sản phẩm</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Tổng tiền</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Ngày đặt</th>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $statusClass = match($order->status ?? '') {
                                    '0' => 'warning',
                                    '1' => 'success',
                                    default => 'secondary'
                                };
                            @endphp
                            <tr>
                                <td class="px-4">
                                    <span class="fw-bold text-primary">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-gradient bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <span class="fw-bold">{{ substr($order->user->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $order->user->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <span class="badge rounded-pill bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2" >
                                        @if($statusClass == '0')
                                            <i class="fas fa-clock me-1"></i>
                                        @elseif($statusClass == '1')
                                            <i class="fas fa-check-circle me-1"></i>
                                        @else
                                            <i class="fas fa-spinner me-1"></i>
                                        @endif
                                        {{ $order->status == 0 ? 'Chưa hoàn thành' : 'Đã hoàn thành' }}
                                    </span>
                                </td>
                                <td class="px-4">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($order->orderDetails->take(2) as $detail)
                                            <li class="mb-1">
                                                <span class="text-dark">📦 {{ Str::limit($detail->product->name ?? 'N/A', 20) }}</span>
                                                <span class="badge bg-secondary ms-1">x{{ $detail->quantity }}</span>
                                            </li>
                                        @endforeach
                                        @if($order->orderDetails->count() > 2)
                                            <li>
                                                <small class="text-muted">+{{ $order->orderDetails->count() - 2 }} sản phẩm khác</small>
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                                <td class="px-4">
                                    <span class="fw-bold text-primary fs-6">{{ number_format($order->total, 0, ',', '.') }}₫</span>
                                </td>
                                <td class="px-4">
                                    <div>
                                        <div class="text-dark">{{ $order->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <a href="{{ route('orders.show', $order->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <p>Không có đơn hàng nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->count() > 0)
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@push('styles')
<style>
    /* Minimal custom CSS chỉ cho những gì Bootstrap không hỗ trợ */
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
        transform: scale(1.01);
        transition: all 0.3s ease;
    }
    
    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }

    /* Custom badge colors với opacity */
    .bg-opacity-10 {
        opacity: 0.1,
    }
    
    .bg-warning.bg-opacity-10 {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    .bg-success.bg-opacity-10 {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }
    
    .bg-danger.bg-opacity-10 {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    
    .bg-primary.bg-opacity-10 {
        background-color: rgba(0, 123, 255, 0.1) !important;
    }
</style>
@endpush
@endsection