@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Danh sách đơn hàng</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người mua</th>
                <th>Trạng thái</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Thời gian đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                @php
                    $badgeClass = match($order->status->name ?? '') {
                        'Chờ xử lý' => 'badge bg-warning text-dark',
                        'Đang xử lý' => 'badge bg-primary',
                        'Hoàn tất' => 'badge bg-success',
                        'Đã hủy' => 'badge bg-danger',
                        default => 'badge bg-secondary'
                    };
                    $totalAmount = $order->orderDetails->sum(function ($item) {
                        return $item->price * $item->quantity;
                    });
                @endphp
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td><span class="{{ $badgeClass }}">{{ $order->status->name ?? 'Không rõ' }}</span></td>
                    <td>
                        <ul class="mb-0">
                            @foreach ($order->orderDetails as $detail)
                                <li>{{ $detail->product->name ?? 'N/A' }} x {{ $detail->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ number_format($totalAmount, 0, ',', '.') }} đ</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Chi tiết</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
