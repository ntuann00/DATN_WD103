{{-- resources/views/user/checkout/_summary.blade.php --}}
<div class="order-summary p-4 bg-light rounded">
  {{-- Context checkout --}}
  @isset($cart)
    <h5 class="mb-3">Giỏ hàng</h5>
    <ul class="list-group mb-3">
      @foreach($cart as $item)
        <li class="list-group-item d-flex justify-content-between">
          <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
          <span>{{ number_format($item['price'] * $item['quantity'],0,',','.') }}₫</span>
        </li>
      @endforeach
      <li class="list-group-item d-flex justify-content-between fw-bold">
        <span>Tổng cộng</span>
        <span>{{ number_format($total,0,',','.') }}₫</span>
      </li>
    </ul>

  {{-- Context order-summary full page --}}
  @elseif(isset($order))
    <h5 class="mb-3">Chi tiết đơn hàng</h5>
    <ul class="list-group mb-3">
      @foreach($details as $d)
        <li class="list-group-item d-flex justify-content-between">
          <span>{{ $d->product_name }}</span>
          <span>{{ number_format($d->price * $d->quantity,0,',','.') }}₫</span>
        </li>
      @endforeach
      <li class="list-group-item d-flex justify-content-between fw-bold">
        <span>Tổng đơn</span>
        <span>{{ number_format($order->total,0,',','.') }}₫</span>
      </li>
    </ul>
  @endisset
</div>
