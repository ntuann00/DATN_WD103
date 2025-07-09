{{-- resources/views/user/checkout/summary.blade.php --}}
@extends('user.layouts.app')

@section('content')
<div class="container py-5">
  <h2 class="mb-4 text-center">Cảm ơn bạn! Đơn #{{ $order->id }} đã được đặt</h2>
  <p><strong>Khách hàng:</strong> {{ $order->name }}</p>
  <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
  @if($order->description)
    <p><strong>Ghi chú:</strong> {{ $order->description }}</p>
  @endif
  <hr>

  <h5>Chi tiết đơn hàng</h5>
  <table class="table">
    <thead>
      <tr>
        <th>Sản phẩm</th>
        <th>Đơn giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      @foreach($details as $d)
      <tr>
        <td>{{ $d->product_name }}</td>
        <td>{{ number_format($d->price,0,',','.') }}₫</td>
        <td>{{ $d->quantity }}</td>
        <td>{{ number_format($d->total,0,',','.') }}₫</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">Tổng đơn hàng:</th>
        <th>{{ number_format($order->total,0,',','.') }}₫</th>
      </tr>
    </tfoot>
  </table>
</div>
@endsection
