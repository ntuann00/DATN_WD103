@extends('user.layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center fw-bold">🛒 Giỏ hàng của bạn</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if (count($cart) > 0)
            <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Tổng cộng</th>
                                <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cart as $id => $item)
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $total += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset($item['image']) }}" class="img-thumbnail border-0"
                                            style="max-width: 60px;">
                                    </td>
                                    <td class="text-start fw-medium">{{ $item['name'] }}</td>
                                    <td style="width: 160px;">
                                        <div class="input-group justify-content-center">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm quantity-btn decrement"
                                                data-id="{{ $id }}">-</button>
                                            <input type="text" name="quantities[{{ $id }}]"
                                                value="{{ $item['quantity'] }}"
                                                class="form-control text-center quantity-input" style="max-width: 50px;"
                                                readonly>
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm quantity-btn increment"
                                                data-id="{{ $id }}">+</button>
                                        </div>
                                    </td>
                                    <td class="fw-semibold">{{ number_format($item['price'], 0, ',', '.') }}₫</td>
                                    <td class="fw-semibold">{{ number_format($itemTotal, 0, ',', '.') }} VND</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                                <td colspan="2" class="fw-bold text-danger">{{ number_format($total, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        💾 Cập nhật giỏ hàng
                    </button>
                    {{-- Xóa toàn bộ giỏ hàng --}}
                    <form action="{{ route('cart.clear') }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg">
                            🗑 Xóa toàn bộ giỏ hàng
                        </button>
                    </form>
                   <form action="{{ route('order.index') }}" method="GET">
    <button type="submit" class="primary-btn1 hover-btn3">Mua hàng</button>
</form>
    </div>
    </form>
@else
    <div class="alert alert-warning text-center">
        🛒 Giỏ hàng của bạn đang trống!
    </div>
    @endif
    </div>

    <!-- Script tăng giảm số lượng -->
    <script>
        document.querySelectorAll('.increment').forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.parentElement.querySelector('.quantity-input');
                input.value = parseInt(input.value) + 1;
            });
        });

        document.querySelectorAll('.decrement').forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.parentElement.querySelector('.quantity-input');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
    </script>
@endsection
