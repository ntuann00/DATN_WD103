@extends('user.layouts.app')

@section('content')
    <div class="dashboard-section mt-110 mb-110">
        <div class="container">
            <div class="form-wrapper">
                <form method="POST" action="{{ route('order.store') }}">
                    @csrf

                    <div class="row">
                        <!-- Thông tin người đặt -->
                        <div class="col-6">
                            <div class="form-inner mb-3">
                                <label>Họ tên người đặt:</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                    required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Email:</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                    required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Số điện thoại:</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                    required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Tỉnh/Thành phố:</label>
                                <input id="addressInput" type="text" name="address" placeholder="VD: Hà Nội"
                                    value="{{ old('address', auth()->user()->address ?? '') }}" required>
                            </div>
                            <div class="form-inner mb-3">
                                <label for="description">Mô tả đơn hàng:</label>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="Ví dụ: Giao giờ hành chính, sản phẩm dễ vỡ, giao sớm giúp...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <!-- Thông tin đơn hàng -->
                        <!-- Thông tin đơn hàng -->
                        <div class="col-6">
                            <div class="form-inner mb-3">
                                <label>Đơn hàng:</label>
                                <div class="order-summary p-3 border rounded bg-light">
                                    @foreach ($cartItems as $item)
                                        @php
                                            $variant = $item->variant; // dùng quan hệ variant() trong CartDetail
                                            $price = $variant ? $variant->price : 0;
                                        @endphp
                                        <input type="hidden" name="items[{{ $loop->index }}][product_id]"
                                            value="{{ $item->product->id }}">
                                        <input type="hidden" name="items[{{ $loop->index }}][variant_id]"
                                            value="{{ $variant?->id }}">
                                        <input type="hidden" name="items[{{ $loop->index }}][quantity]"
                                            value="{{ $item->quantity }}">
                                        {{-- <pre>{{ dd($item) }}</pre> --}}
                                        <p>
                                            <strong>{{ $item->product->name }}</strong><br>

                                            @foreach ($item->variant_summary as $key => $value)
                                                {{ $key }}: {{ $value }}<br>
                                            @endforeach
                                            Số lượng: {{ $item->quantity }}<br>
                                            Đơn giá: {{ number_format($price, 0, ',', '.') }} đ<br>
                                            Thành tiền: {{ number_format($price * $item->quantity, 0, ',', '.') }} đ
                                        </p>
                                        <hr>
                                    @endforeach

                                    <p>Phí ship: <span id="shippingFee">{{ number_format($shippingFee, 0, ',', '.') }}
                                            đ</span></p>
                                    {{-- <pre>
Shipping: {{ gettype($shippingFee) }} - {{ $shippingFee }}
Total raw: {{ $total }}
</pre> --}}
                                    <p><strong>Tổng cộng:</strong>
                                        <span id="totalAmount">
                                            {{ number_format($total, 0, ',', '.') }} đ
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Phương thức thanh toán:</label>
                                <select name="payment_id" required>
                                    @foreach ($payments as $payment)
                                        <option value="{{ $payment->id }}">
                                            {{ $payment->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="col-12 mt-4 text-center">
                        <button type="submit" class="primary-btn3 black-bg hover-btn5 hover-white">
                            Thanh Toán
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script tự động tính phí ship và cập nhật tổng -->
    {{-- <script>
        (() => {
            const addressInput = document.getElementById('addressInput');
            const shippingFeeEl = document.getElementById('shippingFee');
            const totalAmountEl = document.getElementById('totalAmount');

            // Lấy tổng tiền ban đầu đã render (bao gồm 30k ship mặc định)
            const originalTotal = Number(totalAmountEl.innerText.replace(/[^\d]/g, ''));
            const baseTotal = originalTotal - 30000; // loại bỏ phí ship mặc định

            if (addressInput && shippingFeeEl && totalAmountEl) {
                addressInput.addEventListener('input', function() {
                    const prov = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    const fee = prov.includes('ha noi') ? 0 : 30000;

                    shippingFeeEl.innerText = fee.toLocaleString('vi-VN') + ' đ';
                    totalAmountEl.innerText = (baseTotal + fee).toLocaleString('vi-VN') + ' đ';
                });
            }
        })();
    </script> --}}
@endsection
