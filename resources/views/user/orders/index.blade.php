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
                                <input type="text" name="province" placeholder="VD: Hà Nội" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Quận/Huyện/Xã:</label>
                                <input type="text" name="district" required>
                            </div>

                            <div class="form-inner mb-3">
                                <label>Số nhà, tên đường:</label>
                                <input type="text" name="address_detail" required>
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
                                            Biến thể: {{ $item->variant->name ?? 'Không có' }}<br>
                                            Số lượng: {{ $item->quantity }}<br>
                                            Giá: {{ number_format($item->price) }} đ
                                        </p>
                                        <hr>
                                    @endforeach

                                   
                                        <p>Phí ship: {{ number_format($shippingFee, 0, ',', '.') }}đ</p>

                                   <p>Tổng tiền: <strong id="totalAmount">{{ number_format($total, 0, ',', '.') }}đ</strong></p>
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

    <!-- Script tự động tính phí ship -->
    <script>
        document.querySelector('input[name="province"]').addEventListener('input', function () {
            const province = this.value.toLowerCase();
            const shippingFee = (province.includes('hà nội') || province.includes('ha noi')) ? 0 : 30000;
            document.getElementById('shippingFee').innerText = shippingFee.toLocaleString('vi-VN') + ' đ';

            
        });
    </script>
@endsection
