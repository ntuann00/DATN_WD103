@extends('user.layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center fw-bold">🛒 Giỏ hàng của bạn</h2>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if ($items->isNotEmpty())
            <form action="{{ route('order.index') }}" method="GET" id="checkoutSelectedForm">
                @csrf
                <div class="table-responsive shadow-sm">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
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
                                    $variant = $detail->variant; // 👈Sửa đúng quan hệ từ cart_detail

                                    // Giá lấy từ biến thể nếu có, ngược lại fallback về product
                                    $unitPrice = $variant?->price ?? $product->price;

                                    // Thành tiền
                                    $lineTotal = $unitPrice * $detail->quantity;
                                    $grandTotal += $lineTotal;

                                    // Lấy mô tả thuộc tính (VD: Màu: Đỏ, Size: M)
                                    $variantDesc = '-';
                                    if ($variant && $variant->attributeValues->isNotEmpty()) {
                                        $variantDesc = $variant->attributeValues
                                            ->map(function ($attrVal) {
                                                // Kiểm tra tồn tại để tránh lỗi nếu thiếu attribute
                                                $attrName = $attrVal->attribute->name ?? '';
                                                return $attrName . ': ' . $attrVal->value;
                                            })
                                            ->join('<br>');
                                    }

                                @endphp
                                <tr data-id="{{ $detail->id }}" data-price="{{ $unitPrice }}">
                                    <td>
                                        <input type="checkbox" class="item-checkbox" name="selected_items[]"
                                            value="{{ $detail->id }}">
                                    </td>
                                    <td>

                                        @if ($detail->variant->defaultImage)
                                            <img src="{{ asset($detail->variant->defaultImage->path) }}"
                                                alt="{{ $detail->variant->name }}" class="img-thumbnail border-0"
                                                style="max-width:60px;">
                                        @else
                                            <img src="{{ asset($detail->variant->images->first()->image_url ?? 'images/no-image.png') }}"
                                                alt="{{ $detail->variant->name }}" class="img-thumbnail border-0"
                                                style="max-width:60px;">
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        <strong>{{ $product->name }}</strong><br>
                                        <small>{!! nl2br($variantDesc) !!}</small>
                                        {{-- <pre>
@php
    dd($variant->attributeValues->pluck('attribute.name', 'value'));
@endphp
</pre> --}}
                                    </td>
                                    <td style="width:160px;">
                                        <div class="input-group justify-content-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm decrement"
                                                data-id="{{ $detail->id }}">-</button>
                                            <input type="text" name="quantities[{{ $detail->id }}]"
                                                value="{{ $detail->quantity }}"
                                                class="form-control text-center quantity-input" style="max-width:50px;"
                                                data-old="{{ $detail->quantity }}" readonly>
                                            <button type="button" class="btn btn-outline-secondary btn-sm increment"
                                                data-id="{{ $detail->id }}">+</button>
                                        </div>
                                    </td>
                                    <td>{{ number_format($unitPrice, 0, ',', '.') }}₫</td>
                                    <td class="line-total">{{ number_format($lineTotal, 0, ',', '.') }}₫</td>


                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btn-remove-item"
                                            data-id="{{ $detail->id }}">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Tổng tiền:</td>
                                <td colspan="2" class="fw-bold text-danger grand-total">
                                    {{ number_format($grandTotal, 0, ',', '.') }}₫
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3 gap-2">
                    <button type="submit" class="btn btn-success btn-lg">🛒 Mua hàng</button>
                </div>
            </form>


            {{-- Form xóa giỏ hàng giữ riêng --}}
            <form action="{{ route('cart.clear') }}" method="POST"
                onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?');" class="d-inline-block mt-2">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg" name="action" value="delete">
                    🗑 Xóa toàn bộ giỏ hàng
                </button>
            </form>
        @else
            <div class="alert alert-warning text-center">🛒 Giỏ hàng của bạn đang trống!</div>
        @endif
    </div>



    <!-- Script tăng giảm và checkbox -->
    <!-- Toastr CSS -->

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function autoUpdateCart() {
            setTimeout(() => {
                document.querySelector('form[action="{{ route('cart.update') }}"]')?.submit();
            }, 500);
        }

        document.querySelectorAll('.increment').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const input = document.querySelector(`input[name="quantities[${id}]"]`);

                const currentValue = parseInt(input.value);
                const newValue = currentValue + 1;

                updateQuantity(id, newValue, 'increment', () => {
                    toastr.error('Không thể tăng số lượng', 'Lỗi');
                }, () => {
                    input.value = newValue;
                    updateLineTotal(id);
                    autoUpdateCart();
                });

            });
        });

        document.querySelectorAll('.decrement').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const input = document.querySelector(`input[name="quantities[${id}]"]`);
                const currentValue = parseInt(input.value);
                if (currentValue <= 1) return;

                const newValue = currentValue - 1;

                updateQuantity(id, newValue, 'decrement', () => {
                    toastr.error('Không thể giảm số lượng', 'Lỗi');
                }, () => {
                    input.value = newValue;
                    updateLineTotal(id);
                    autoUpdateCart();

                });
            });
        });



        function updateQuantity(id, quantity, status = 'increment', onFail = null, onSuccess = null) {

            $.ajax({
                url: '{{ route('cart.update') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status,
                    quantities: parseInt(quantity)
                },

                success: function(response) {
                    if (response.status == 'success') {
                        toastr.success(response.message, 'Thành công');
                        if (onSuccess) onSuccess();
                    } else if (response.status == 'error') {
                        toastr.error(response.message, 'Lỗi');
                    }
                },
                error: function() {
                    toastr.error('Lỗi kết nối server.', 'Lỗi');
                }
            });

        }

        function updateLineTotal(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const price = parseFloat(row.dataset.price);
            const quantity = parseInt(document.querySelector(`input[name="quantities[${id}]"]`).value);
            const total = price * quantity;
            row.querySelector('.line-total').textContent = total.toLocaleString('vi-VN') + '₫';
            updateGrandTotal();
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('tr[data-id]').forEach(row => {
                const price = parseFloat(row.dataset.price);
                const quantity = parseInt(row.querySelector('.quantity-input').value);
                grandTotal += price * quantity;
            });
            document.querySelector('.grand-total').textContent = grandTotal.toLocaleString('vi-VN') + '₫';
        }

        // Check/uncheck all
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = this.checked);
        });

        $(document).ready(function() {
            $('.btn-remove-item').on('click', function() {
                if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;

                const detailId = $(this).data('id');

                $.ajax({
                    url: '/cart/remove/' + detailId, // đúng route GET/POST
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // Ví dụ: reload trang hoặc xóa dòng HTML tương ứng
                        location.reload(); // hoặc dùng $(...).remove();
                    },
                    error: function(xhr) {
                        alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                    }
                });
            });
        });

    </script>
@endsection
