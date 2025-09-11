@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h2>

    {{-- Thông tin đơn hàng --}}
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> 
                @if($order->status_id == 7)
                    <span class="badge bg-success">Giao hàng thành công</span>
                @else
                    <span class="badge bg-secondary">{{ $order->status->name ?? 'Đang xử lý' }}</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="card mb-4">
        <div class="card-header">Sản phẩm trong đơn</div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->name ?? 'N/A' }}</td>
                            <td>{{ number_format($detail->price) }} đ</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price * $detail->quantity) }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Nếu đơn đã giao thành công thì cho phép user xác nhận --}}
    @if($order->status_id == 7)
        @if(!$order->is_received) 
            {{-- Chưa xác nhận --}}
            <form method="POST" action="{{ route('orders.confirm', $order->id) }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    ✅ Tôi đã nhận được hàng
                </button>
            </form>
        @else
            {{-- Đã xác nhận => hiện form đánh giá --}}
            <div class="card mt-4">
                <div class="card-header">Đánh giá sản phẩm</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        
                        <div class="mb-3">
                            <label for="rating">Đánh giá sao:</label>
                            <select name="rating" class="form-select" required>
                                <option value="5">⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <textarea name="comment" class="form-control" required placeholder="Nhập bình luận..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                    </form>
                </div>
            </div>
        @endif
    @endif

</div>
@endsection
