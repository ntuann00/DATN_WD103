@extends('admin.layouts.app')

@section('content')
<div class="container py-4">

    {{-- Thông tin đơn hàng --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết đơn hàng #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'Ẩn danh' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'Không có' }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    {{-- Địa chỉ nhận hàng --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">📦 Địa chỉ nhận hàng</h5>
        </div>
        <div class="card-body">
            @if($order->address)
                <p><strong>Địa chỉ:</strong> {{ $order->address->full_address }}</p>
                <p><strong>Tỉnh:</strong> {{ $order->address->province }}</p>
                <p><strong>Quận/Huyện:</strong> {{ $order->address->district }}</p>
                <p><strong>Phường/Xã:</strong> {{ $order->address->ward }}</p>
            @else
                <p class="text-danger">Chưa có địa chỉ nhận hàng cho đơn này.</p>
            @endif
        </div>
    </div>

    {{-- Chi tiết sản phẩm --}}
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">🛒 Chi tiết sản phẩm</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Tạm tính</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $key => $detail)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $detail->product->name ?? 'N/A' }}</td>
                            <td>
                                @if ($detail->product && $detail->product->image)
                                    <img src="{{ asset('storage/' . $detail->product->image) }}" alt="image" width="60">
                                @else
                                    <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td>{{ $detail->product->description ?? 'Không có mô tả' }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <strong class="fs-5">Tổng cộng: 
                    {{ number_format($order->orderDetails->sum(fn($d) => $d->price * $d->quantity), 0, ',', '.') }} đ
                </strong>
            </div>
        </div>
    </div>

    {{-- Nút quay lại --}}
    <div class="mt-4 text-center">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            ← Quay lại danh sách đơn hàng
        </a>
    </div>

</div>
@endsection
