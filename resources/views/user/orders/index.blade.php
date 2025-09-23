@extends('user.layouts.app')

@section('content')
    <div class="dashboard-section mt-110 mb-110">
        <div class="container">
            <div class="checkout-header text-center mb-5">
                <h2 class="checkout-title">Thanh Toán</h2>
                <p class="text-muted">Vui lòng kiểm tra thông tin trước khi đặt hàng</p>
            </div>

            <div class="form-wrapper checkout-form-wrapper">
                <form method="POST" action="{{ route('order.store') }}">
                    @csrf

                    <div class="row g-4">
                        <!-- Thông tin người đặt -->
                        <div class="col-lg-6">
                            <div class="checkout-box h-100">
                                <h4 class="box-title mb-4">
                                    <i class="fas fa-user-circle me-2"></i>Thông Tin Khách Hàng
                                </h4>

                                <div class="form-inner mb-4">
                                    <label class="form-label-custom">Họ tên người đặt <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-input-custom" name="name"
                                        value="{{ old('name', auth()->user()->name ?? '') }}" required>
                                </div>

                                <div class="form-inner mb-4">
                                    <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-input-custom" name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                </div>

                                <div class="form-inner mb-4">
                                    <label class="form-label-custom">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-input-custom" name="phone"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                </div>

                                <div class="form-inner mb-4">
                                    <label class="form-label-custom">Nhập địa chỉ nhận hàng cụ thể <span
                                            class="text-danger">*</span></label>
                                    <input id="addressInput" type="text" class="form-input-custom" name="address"
                                        placeholder="VD: Hà Nội" value="{{ old('address', auth()->user()->address ?? '') }}"
                                        required>
                                </div>

                                <div class="form-inner mb-3">
                                    <label for="description" class="form-label-custom">Ghi chú đơn hàng</label>
                                    <textarea name="description" id="description" class="form-control form-textarea-custom" rows="3"
                                        placeholder="Ví dụ: Giao giờ hành chính, sản phẩm dễ vỡ, giao sớm giúp...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin đơn hàng -->
                        <div class="col-lg-6">
                            <div class="checkout-box h-100">
                                <h4 class="box-title mb-4">
                                    <i class="fas fa-shopping-bag me-2"></i>Thông Tin Đơn Hàng
                                </h4>

                                <div class="form-inner mb-4">
                                    <div class="order-summary">
                                        <div class="order-items-wrapper">
                                            @foreach ($cartItems as $item)
                                                <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                                                @php
                                                    $variant = $item->variant;
                                                    $price = $variant ? $variant->price : 0;
                                                @endphp
                                                <input type="hidden" name="items[{{ $loop->index }}][product_id]"
                                                    value="{{ $item->product->id }}">
                                                <input type="hidden" name="items[{{ $loop->index }}][variant_id]"
                                                    value="{{ $variant?->id }}">
                                                <input type="hidden" name="quantities[{{ $item->id }}]"
                                                    value="{{ $item->quantity }}">

                                                <div class="order-item d-flex mb-4">
                                                    <div class="item-image me-4" style="max-width: 30%; max-height: 10em; overflow: hidden;">
                                                        <img style="border-radius: 10px;object-fit: cover"
                                                            src="{{ $item->variant->images->first()->image_url ?? 'images/no-image.png' }}"
                                                            alt="" class="product-thumb">
                                                    </div>
                                                    <div class="item-details">
                                                        <h6 class="item-name">{{ $item->product->name }}</h6>
                                                        <div class="item-variants">
                                                            @foreach ($variant->attributeValues as $attrVal)
                                                                <span class="variant-tag">
                                                                    {{ $attrVal->attribute->name }}: {{ $attrVal->value }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                        <div class="item-quantity-price">
                                                            <span>Số lượng: {{ $item->quantity }} - </span>
                                                            <span>
                                                                Giá: {{ number_format($price, 0, ',', '.') }}đ
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="order-summary-footer">
                                            <div class="summary-row">
                                                <span>Tạm tính</span>
                                                <span>{{ number_format($total - $shippingFee, 0, ',', '.') }}đ</span>
                                            </div>
                                            <div class="summary-row">
                                                <span>Phí vận chuyển</span>
                                                <span
                                                    id="shippingFee">{{ number_format($shippingFee, 0, ',', '.') }}đ</span>
                                            </div>
                                            <div class="summary-row total-row">
                                                <span>Tổng cộng</span>
                                                <span id="totalAmount" class="total-amount">
                                                    {{ number_format($total, 0, ',', '.') }}đ
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-inner mb-3">
                                    <label class="form-label-custom">Phương thức thanh toán <span
                                            class="text-danger">*</span></label>
                                    <select name="payment_id" class="form-select-custom" required>
                                        @foreach ($payments as $payment)
                                            <option value="{{ $payment->id }}">
                                                {{ $payment->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-5 text-center">
                        <button type="submit" class="checkout-btn primary-btn3 black-bg hover-btn5 hover-white">
                            <i class="fas fa-lock me-2"></i>Xác Nhận Thanh Toán
                        </button>
                        <p class="security-note mt-3">
                            <i class="fas fa-shield-alt me-1"></i>
                            Thông tin của bạn được bảo mật an toàn
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .checkout-header {
            margin-bottom: 3rem;
        }

        .checkout-title {
            font-size: 2rem;
            font-weight: 300;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .checkout-form-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }

        .checkout-box {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.3s ease;
        }

        .checkout-box:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .box-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: #333;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 1.5rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .form-input-custom,
        .form-textarea-custom,
        .form-select-custom {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-input-custom:focus,
        .form-textarea-custom:focus,
        .form-select-custom:focus {
            outline: none;
            border-color: #333;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 6px;
            overflow: hidden;
        }

        .order-items-wrapper {
            max-height: 300px;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .item-name {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .item-variants {
            margin-bottom: 0.5rem;
        }

        .variant-tag {
            display: inline-block;
            font-size: 0.75rem;
            color: #666;
            background: #e8e8e8;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            margin-right: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .item-meta {
            font-size: 0.875rem;
            color: #777;
        }

        .item-meta .quantity {
            margin-right: 1rem;
        }

        .item-total {
            font-weight: 600;
            color: #333;
            white-space: nowrap;
        }

        .order-summary-footer {
            background: #fff;
            padding: 1.5rem;
            border-top: 2px solid #e0e0e0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            color: #666;
        }

        .total-row {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .total-amount {
            color: #e74c3c;
        }

        .checkout-btn {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .security-note {
            font-size: 0.875rem;
            color: #666;
        }

        /* Scrollbar styling */
        .order-items-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .order-items-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .order-items-wrapper::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }

        .order-items-wrapper::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .checkout-box {
                margin-bottom: 2rem;
            }
        }
    </style>
@endpush
