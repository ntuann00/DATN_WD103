@extends('user.layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center fw-bold">🛒 Giỏ hàng của bạn</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if ($items->isNotEmpty())
            <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng cộng</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($items as $detail)
                                @php
                                    $product = $detail->product;
                                    $variant = $detail->variant; // 👈 Sửa đúng quan hệ từ cart_detail

                                    // Giá lấy từ biến thể nếu có, ngược lại fallback về product
                                    $unitPrice = $variant?->price ?? $product->price;

                                    // Thành tiền
                                    $lineTotal = $unitPrice * $detail->quantity;
                                    $grandTotal += $lineTotal;

                                    // Lấy mô tả thuộc tính (VD: Màu: Đỏ, Size: M)
                                    $variantDesc =
                                        $variant && $variant->attributeValues->isNotEmpty()
                                            ? $variant->attributeValues
                                                ->map(function ($attrVal) {
                                                    return $attrVal->attribute->name . ': ' . $attrVal->value;
                                                })
                                                ->join(', ')
                                            : '-';
                                @endphp
                                <tr>
                                <tr data-id="{{ $detail->id }}" data-price="{{ $unitPrice }}">
                                    <td>
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            class="img-thumbnail border-0" style="max-width:60px;">
                                    </td>
                                    <td class="text-start">
                                        <strong>{{ $product->name }}</strong><br>
                                        <small>SKU: {{ $variant->sku ?? '-' }}</small><br>
                                        <small>{{ $variantDesc }}</small>
                                    </td>
                                    <td style="width:160px;">
                                        <div class="input-group justify-content-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm decrement"
                                                data-id="{{ $detail->id }}">-</button>
                                            <input type="text" name="quantities[{{ $detail->id }}]"
                                                value="{{ $detail->quantity }}"
                                                class="form-control text-center quantity-input" style="max-width:50px;"
                                                readonly>
                                            <button type="button" class="btn btn-outline-secondary btn-sm increment"
                                                data-id="{{ $detail->id }}">+</button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($unitPrice, 0, ',', '.') }}₫</td>
                                    <td class="line-total">{{ number_format($lineTotal, 0, ',', '.') }}₫</td>


                                    <td>
                                        <form action="{{ route('cart.remove', $detail->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                                <td colspan="2" class="fw-bold text-danger grand-total">
                                    {{ number_format($grandTotal, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                  
                    <form action="{{ route('cart.clear') }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg">🗑 Xóa toàn bộ giỏ hàng</button>
                    </form>
                    <a href="{{ route('order.index') }}" class="btn btn-success btn-lg">Mua hàng</a>
                </div>
            </form>
        @else
            <div class="alert alert-warning text-center">🛒 Giỏ hàng của bạn đang trống!</div>
        @endif
    </div>

    <!-- Script tăng giảm số lượng ngay trên view -->
    <script>
        document.querySelectorAll('.increment').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const input = document.querySelector(`input[name="quantities[${id}]"]`);
                input.value = parseInt(input.value) + 1;
                updateLineTotal(id);
            });
        });

        document.querySelectorAll('.decrement').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const input = document.querySelector(`input[name="quantities[${id}]"]`);
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    updateLineTotal(id);
                }
            });
        });

        // Cập nhật tiền từng dòng
        function updateLineTotal(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const price = parseFloat(row.dataset.price);
            const quantity = parseInt(document.querySelector(`input[name="quantities[${id}]"]`).value);
            const total = price * quantity;

            // Cập nhật hiển thị tiền dòng
            row.querySelector('.line-total').textContent = total.toLocaleString('vi-VN') + '₫';

            // Cập nhật tổng tiền giỏ hàng
            updateGrandTotal();
        }

        // Cập nhật tổng tiền toàn giỏ hàng
        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('tr[data-id]').forEach(row => {
                const price = parseFloat(row.dataset.price);
                const quantity = parseInt(row.querySelector('.quantity-input').value);
                grandTotal += price * quantity;
            });

            // Cập nhật hiển thị
            document.querySelector('.grand-total').textContent = grandTotal.toLocaleString('vi-VN') + '₫';
        }
    </script>

@endsection
