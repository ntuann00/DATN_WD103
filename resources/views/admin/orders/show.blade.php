@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Thông tin đơn hàng --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📦 Chi tiết đơn hàng #{{ $order->id }}</h4>
        </div>
        <div class="card-body">
            <p><strong>👤 Khách hàng:</strong> {{ $order->user->name ?? 'Ẩn danh' }}</p>
            <p><strong>📧 Email:</strong> {{ $order->user->email ?? 'Không có' }}</p>
            <p><strong>🕒 Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

            <hr>

            <h5>🚚 Địa chỉ giao hàng</h5>
            <p><strong>Người nhận hàng:</strong> {{ $order->user->name ?? 'Ẩn danh' }}</p>
            <p><strong>📞 SĐT:</strong> {{ $order->user->phone ?? 'Không có dữ liệu' }}</p>
            <p><strong>🏠 Địa chỉ:</strong> {{ $order->address->address ?? 'Không có dữ liệu' }}</p>
        </div>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🛒 Sản phẩm trong đơn</h5>

            {{-- Cập nhật trạng thái --}}
            <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}" class="d-flex align-items-center gap-2">
                @csrf
                @method('PUT')
                <label for="status_id" class="mb-0 fw-bold">Trạng thái:</label>
                <select name="status_id" id="status_id" class="form-select form-select-sm w-auto">
                    @foreach($statuses as $status)
                        @if ($status->id >= $order->status_id)
                            <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-success">Cập nhật</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
<th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($detail->product?->image)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}" width="60" height="60" style="object-fit: cover;" alt="Ảnh">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end px-4 py-3">
                <strong class="fs-5">Tổng cộng:
                    {{ number_format($order->orderDetails->sum(fn($d) => $d->price * $d->quantity), 0, ',', '.') }} đ
                </strong>
            </div>
        </div>
    </div>

    {{-- Nút quay lại --}}
    <div class="mt-4 text-center">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Quay lại danh sách đơn hàng</a>
    </div>
</div>
@endsection