@extends('admin.layouts.app')

@section('content')
    <style>
        :root {
            --primary-beige: #F5E6D3;
            --dark-beige: #D4A574;
            --light-beige: #FFF8F0;
            --brown: #8B6B4A;
            --dark-brown: #5C4033;
            --cream: #FAF6F0;
        }

        body {
            background-color: #FAFAFA;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary-beige) 0%, var(--dark-beige) 100%);
            color: var(--dark-brown);
            padding: 40px;
            margin: -30px -30px 30px -30px;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 5px 20px rgba(212, 165, 116, 0.15);
        }

        .page-header h2 {
            color: var(--dark-brown);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-header p {
            color: var(--brown);
            opacity: 0.9;
            font-size: 15px;
        }

        /* Status Badge in Header */
        .header-status {
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            font-size: 14px;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .status-pending {
            color: #F57C00;
            border: 2px solid #FFB74D;
        }

        .status-approved {
            color: #2E7D32;
            border: 2px solid #66BB6A;
        }

        .status-rejected {
            color: #C62828;
            border: 2px solid #EF5350;
        }

        .status-completed {
            color: #6A1B9A;
            border: 2px solid #AB47BC;
        }

        /* Cards */
        .detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(212, 165, 116, 0.1);
            margin-bottom: 25px;
            border: 1px solid var(--primary-beige);
            overflow: hidden;
        }

        .detail-card .card-header {
            background: linear-gradient(135deg, var(--primary-beige) 0%, var(--dark-beige) 100%);
            color: var(--dark-brown);
            font-weight: 600;
            padding: 18px 25px;
            border: none;
            font-size: 16px;
        }

        .detail-card .card-header i {
            margin-right: 10px;
            color: var(--dark-brown);
        }

        .detail-card .card-body {
            padding: 25px;
        }

        /* Info Labels and Values */
        .info-label {
            font-weight: 600;
            color: var(--brown);
            margin-bottom: 8px;
            margin-top: 20px;
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-label i {
            color: var(--dark-beige);
            margin-right: 5px;
        }

        .info-value {
            display: block;
            padding: 14px;
            background: var(--light-beige);
            border-radius: 10px;
            border: 1px solid var(--primary-beige);
            color: var(--dark-brown);
            font-size: 15px;
        }

        /* Product Table */
        .product-table {
            margin-bottom: 0;
        }

        .product-table thead {
            background: var(--primary-beige);
        }

        .product-table thead th {
            color: var(--dark-brown);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px;
            border: none;
        }

        .product-table tbody tr {
            border-bottom: 1px solid var(--primary-beige);
        }

        .product-table tbody tr:hover {
            background: var(--light-beige);
        }

        .product-table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            color: var(--dark-brown);
        }

        .product-table img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--primary-beige);
        }

        .product-table tfoot {
            background: var(--light-beige);
            font-weight: 600;
        }

        .product-table tfoot td {
            padding: 20px 15px;
            color: var(--dark-brown);
        }

        /* Bank Info Section */
        .bank-info {
            background: linear-gradient(135deg, var(--light-beige) 0%, var(--primary-beige) 100%);
            padding: 25px;
            border-radius: 15px;
            margin-top: 15px;
            border: 1px solid var(--dark-beige);
        }

        .bank-info .info-value {
            background: white;
            font-weight: 600;
        }

        /* Thumbnail Gallery */
        .thumbnail-gallery {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .thumbnail-gallery img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid var(--primary-beige);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .thumbnail-gallery img:hover {
            transform: scale(1.05);
            border-color: var(--dark-beige);
            box-shadow: 0 5px 15px rgba(212, 165, 116, 0.3);
        }

        /* QR Code */
        .qr-code-container {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 15px;
            border: 2px solid var(--primary-beige);
            margin-top: 15px;
        }

        .qr-code-container img {
            max-width: 200px;
            padding: 10px;
            background: white;
            border: 2px solid var(--primary-beige);
            border-radius: 10px;
        }

        /* Back Button */
        .btn-back {
            background: linear-gradient(135deg, var(--primary-beige) 0%, var(--dark-beige) 100%);
            color: var(--dark-brown);
            padding: 14px 30px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(212, 165, 116, 0.3);
            color: white;
        }

        /* Badge Styles */
        .badge {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge.bg-secondary {
            background: var(--primary-beige) !important;
            color: var(--dark-brown);
        }

        /* Price Text */
        .price-text {
            color: var(--dark-beige);
            font-weight: 600;
        }

        .total-price {
            color: #E53935;
            font-size: 20px;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 25px;
                margin: -15px -15px 20px -15px;
            }

            .detail-card {
                margin-bottom: 15px;
            }

            .thumbnail-gallery img {
                width: 80px;
                height: 80px;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">Chi tiết yêu cầu hoàn hàng #{{ $refund->id }}</h2>
                    <p class="mb-0">Ngày tạo: {{ \Carbon\Carbon::parse($refund->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <span class="header-status status-{{ $refund->status }}">
                        @if ($refund->status == 'Đang xử lý')
                            ⏳ Đang xử lý
                        @elseif($refund->status == 'Đã duyệt')
                            ✅ Đã duyệt
                        @elseif($refund->status == 'Đã từ chối')
                            ❌ Đã từ chối
                        @else
                            ✔️ Hoàn thành
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Order Products -->
                <div class="card detail-card">
                    <div class="card-header">
                        <i class="fas fa-shopping-cart"></i>Sản phẩm yêu cầu hoàn
                    </div>
                    <div class="card-body p-0">
                        @if ($refund->order && $refund->order->orderDetails)
                            <div class="table-responsive">
                                <table class="table product-table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Hình ảnh</th>
                                            <th>Sản phẩm</th>
                                            <th>Biến thể</th>
                                            <th class="text-center">SL</th>
                                            <th class="text-end">Đơn giá</th>
                                            <th>Trạng thái</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($refund->order->orderDetails as $detail)
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <img src="{{ asset($detail->productVariant->images->first()->image_url ?? '/images/no-image.png') }}"
                                                        alt="Product">
                                                </td>
                                                <td>
                                                    <strong>{{ $detail->name_product ?? 'N/A' }}</strong>
                                                </td>
                                                <td>
                                                    @if ($detail->variant_product)
                                                        @php
                                                            $variants =
                                                                json_decode($detail->variant_product, true) ?: [];
                                                        @endphp
                                                        @foreach ($variants as $key => $value)
                                                            <span class="badge bg-secondary me-1">{{ $key }}:
                                                                {{ $value }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $detail->quantity }}</td>
                                                <td class="text-end price-text">
                                                    {{ number_format($detail->price, 0, ',', '.') }}đ
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary">{{ $detail->status_id == 8 ? 'Hủy đơn' : 'Hoàn hàng' }}
                                                    </span>
                                                </td>
                                                <td class="text-end price-text">
                                                    {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}đ
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end">Tổng tiền hoàn:</td>
                                            <td class="text-end total-price">
                                                {{ number_format($refund->total, 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <p class="text-muted p-3">Không có thông tin sản phẩm</p>
                        @endif
                    </div>
                </div>

                <!-- Refund Details -->
                <div class="card detail-card">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i>Thông tin yêu cầu hoàn hàng
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="info-label">
                                    <i class="fas fa-question-circle"></i>Lý do hoàn hàng
                                </label>
                                <span class="info-value">{{ $refund->reason ?? 'Không có lý do' }}</span>
                            </div>
                            <div class="col-md-6">
                                <label class="info-label">
                                    <i class="fas fa-clock"></i>Cập nhật lần cuối
                                </label>
                                <span class="info-value">
                                    {{ \Carbon\Carbon::parse($refund->created_at)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <label class="info-label">
                            <i class="fas fa-comment-alt"></i>Mô tả chi tiết
                        </label>
                        <span class="info-value">{{ $refund->description ?? 'Không có mô tả' }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Bank Information -->
                <div class="card detail-card">
                    <div class="card-header">
                        <i class="fas fa-university"></i>Thông tin hoàn tiền
                    </div>
                    <div class="card-body">
                        <div class="bank-info">
                            <label class="info-label">
                                <i class="fas fa-user-circle"></i>Chủ tài khoản
                            </label>
                            <span class="info-value">
                                {{ $refund_info->bank_holder ?? 'Chưa cung cấp' }}
                            </span>

                            <label class="info-label">
                                <i class="fas fa-building"></i>Ngân hàng
                            </label>
                            <span class="info-value">
                                {{ $refund_info->bank_name ?? 'Chưa cung cấp' }}
                            </span>

                            <label class="info-label">
                                <i class="fas fa-credit-card"></i>Số tài khoản
                            </label>
                            <span class="info-value">
                                {{ $refund_info->bank_number ?? 'Chưa cung cấp' }}
                            </span>

                            @if ($refund_info->qr_code)
                                <div class="qr-code-container">
                                    <p class="mb-2"><strong>Mã QR chuyển khoản</strong></p>
                                    <img src="{{ $refund_info->qr_code }}"
                                        onclick="window.open('{{ $refund_info->qr_code }}', '_blank')">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card detail-card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>Thông tin khách hàng
                    </div>
                    <div class="card-body">
                        <label class="info-label">
                            <i class="fas fa-id-card"></i>Họ và tên
                        </label>
                        <span class="info-value">{{ $user->name }}</span>

                        <label class="info-label">
                            <i class="fas fa-phone"></i>Số điện thoại
                        </label>
                        <span class="info-value">
                            <a href="tel:{{ $user->phone }}"
                                style="color: var(--dark-beige);">{{ $user->phone ?? 'Chưa cung cấp' }}</a>
                        </span>

                        @if ($user->created_at)
                            <label class="info-label">
                                <i class="fas fa-calendar"></i>Ngày đăng ký
                            </label>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('refund.index') }}" class="btn btn-primary w-100">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
@endsection
