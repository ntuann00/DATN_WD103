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
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Email:</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Số điện thoại:</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Tỉnh/Thành phố:</label>
                                <input id="provinceInput" type="text" name="province" placeholder="VD: Hà Nội" value="{{ old('province') }}" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Quận/Huyện/Xã:</label>
                                <input type="text" name="district" value="{{ old('district') }}" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Số nhà, tên đường:</label>
                                <input type="text" name="address_detail" value="{{ old('address_detail') }}" required>
                            </div>
                        </div>

                        <!-- Thông tin đơn hàng -->
                        <div class="col-6">
                            <div class="form-inner mb-3">
                                <label>Đơn hàng:</label>
                                <div class="order-summary p-3 border rounded bg-light">
                                    @foreach ($cartItems as $item)
                                        <p>
                                            <strong>{{ $item->product->name }}</strong><br>
                                            Biến thể: {{ optional($item->product->variant)->sku ?? 'Không có' }}<br>
                                            Số lượng: {{ $item->quantity }}<br>
                                            Đơn giá: {{ number_format($item->product->price, 0, ',', '.') }} đ<br>
                                            Thành tiền: {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }} đ
                                        </p>
                                        <hr>
                                    @endforeach

                                    <p>Phí ship: <span id="shippingFee">{{ number_format($shippingFee, 0, ',', '.') }} đ</span></p>
                                    <p>Tổng tiền: <strong id="totalAmount">{{ number_format($total, 0, ',', '.') }} đ</strong></p>
                                </div>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Phương thức thanh toán:</label>
                                <select name="payment_method" required>
                                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                    <option value="visa">Thẻ Visa</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Nút thanh toán -->
                    <div class="col-12 mt-4 text-center">
                        <button type="submit" class="primary-btn3 black-bg hover-btn5 hover-white">
                            Thanh toán
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script tự động tính phí ship và cập nhật tổng -->
    <script>
        (() => {
            const provinceInput   = document.getElementById('provinceInput');
            const shippingFeeEl   = document.getElementById('shippingFee');
            const totalAmountEl   = document.getElementById('totalAmount');
            // Tổng tiền hàng tính trước (đã bao gồm phí ship ban đầu)
            const baseTotal       = {{ $total - $shippingFee }};

            provinceInput.addEventListener('input', function() {
                const prov = this.value.toLowerCase();
                const fee = (prov.includes('hà nội') || prov.includes('ha noi')) ? 0 : 30000;
                shippingFeeEl.innerText = fee.toLocaleString('vi-VN') + ' đ';
                totalAmountEl.innerText = (baseTotal + fee).toLocaleString('vi-VN') + ' đ';
            });
        })();
    </script>
@endsection
