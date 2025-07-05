@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Lịch sử mua hàng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Số sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Ẩn danh' }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->orderDetails->sum('quantity') }}</td>
                <td>{{ number_format($order->orderDetails->sum(fn($d) => $d->price * $d->quantity), 0, ',', '.') }} đ</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
