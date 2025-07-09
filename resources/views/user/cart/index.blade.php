@extends('user.layouts.app')

@section('content')
<div class="cart-section">
    <div class="container">
        <h3>Giỏ Hàng</h3>
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $productId => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <input type="number" name="quantity[{{ $productId }}]" value="{{ $item['quantity'] }}" min="1">
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</td>
                        <td>
                            <a href="{{ route('cart.remove', $productId) }}" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-actions">
                <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
                <a href="{{ route('checkout_page') }}" class="btn btn-success">Tiến hành thanh toán</a>
            </div>
        </form>
    </div>
</div>
@endsection
