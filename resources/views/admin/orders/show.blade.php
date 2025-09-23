@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-1 text-dark fw-bold">
                                    Chi tiết đơn hàng #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </h3>
                                <p class="text-muted mb-0">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                @php
                                    $statusClass = match ($order->status->name ?? '') {
                                        'Chờ xử lý' => 'warning',
                                        'Đang xử lý' => 'info',
                                        'Hoàn tất' => 'success',
                                        'Đã hủy' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }} px-3 py-2 fs-6">
                                    {{ $order->status == 1 ? 'Đã hoàn thành' : 'Chưa hoàn thành' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Customer & Shipping Info -->
            <div class="col-lg-4">
                <!-- Customer Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom border-2 border-primary py-3">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-user text-primary me-2"></i>Thông tin khách hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-user fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $order->name ?? 'Ẩn danh' }}</h6>
                                <small class="text-muted">Khách hàng</small>
                            </div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted d-block mb-1">Email</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                <span>{{ $order->user->email ?? 'Không có' }}</span>
                            </div>
                        </div>

                        <div>
                            <small class="text-muted d-block mb-1">Số điện thoại</small>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-phone text-muted me-2"></i>
                                <span>{{ $order->phone ?? 'Không có' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom border-2 border-info py-3">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-shipping-fast text-info me-2"></i>Thông tin giao hàng
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Người nhận</small>
                            <span class="fw-semibold">{{ $order->name ?? 'Ẩn danh' }}</span>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Số điện thoại</small>
                            <span>{{ $order->phone ?? 'Không có' }}</span>
                        </div>

                        <div>
                            <small class="text-muted d-block mb-1">Địa chỉ</small>
                            <div class="p-2 bg-light rounded text-dark">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                {{ $order->address->address ?? 'Không có dữ liệu' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom border-2 border-success py-3">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-credit-card text-success me-2"></i>Thanh toán
                        </h5>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Phương thức</small>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                {{ $order->payment->name ?? 'COD' }}
                            </span>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Trạng thái</small>
                            <span
                                class="badge bg-{{ $order->status_payment == 1 ? 'success' : 'warning' }} bg-opacity-10 text-{{ $order->status_payment == 1 ? 'success' : 'warning' }} px-3 py-2">
                                {{ $order->status_payment == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Products -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-shopping-cart text-primary me-2"></i>Sản phẩm trong đơn
                            </h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="px-4 py-3" style="width: 7%;">STT</th>
                                        <th class="px-4 py-3" style="width: 37%;">Sản phẩm</th>
                                        <th class="px-4 py-3 text-center" style="width: 10%;">Số lượng</th>
                                        <th class="px-4 py-3 text-end" style="width: 12%;">Đơn giá</th>
                                        <th class="px-4 py-3 text-end" style="width: 12%;">Thành tiền</th>
                                        <th class="px-4 py-3 text-center" style="width: 22%;">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $index => $detail)
                                        <tr>
                                            <td class="px-4">
                                                <span class="badge bg-secondary rounded-circle">{{ $index + 1 }}</span>
                                            </td>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $productImage = null;
                                                        if (
                                                            $detail->productVariant &&
                                                            $detail->productVariant->images->first()
                                                        ) {
                                                            $productImage = $detail->productVariant->images->first()
                                                                ->image_url;
                                                        } elseif ($detail->product && $detail->product->image) {
                                                            $productImage = $detail->product->image;
                                                        }
                                                    @endphp

                                                    @if ($productImage)
                                                        <img src="{{ asset($productImage) }}" class="rounded me-3 border"
                                                            width="60" height="60" style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">
                                                            {!! wordwrap($detail->name_product ?? 'N/A', 50, '<br>', true) !!}
                                                        </h6>
                                                        @if ($detail->variant_product)
                                                            @php
                                                                $variants =
                                                                    json_decode($detail->variant_product, true) ?: [];
                                                            @endphp
                                                            <div>
                                                                @foreach ($variants as $key => $value)
                                                                    <span
                                                                        class="badge bg-light text-dark me-1">{{ $key }}:
                                                                        {{ $value }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 text-center">
                                                <span class="badge bg-primary">
                                                    {{ $detail->quantity }}
                                                </span>
                                            </td>
                                            <td class="px-4 text-end">
                                                {{ number_format($detail->price, 0, ',', '.') }}đ
                                            </td>
                                            <td class="px-4 text-end fw-bold text-primary">
                                                {{ number_format($detail->total, 0, ',', '.') }}đ
                                            </td>
                                            <td class="px-4 text-center">
                                                @php
                                                    $detailStatus = $detail->status_id ?? 1;
                                                    $detailStatusInfo = $statuses->find($detailStatus);
                                                    $detailStatusName = $detailStatusInfo->name ?? 'Chờ xác nhận';

                                                    $detailStatusClass = match ($detailStatusName) {
                                                        'Chờ xác nhận' => 'warning',
                                                        'Đã xác nhận' => 'info',
                                                        'Đang chuẩn bị' => 'primary',
                                                        'Đang vận chuyển' => 'primary',
                                                        'Giao hàng thành công' => 'success',
                                                        'Đã nhận hàng' => 'success',
                                                        'Hủy' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp

                                                <!-- Thay thế form cũ bằng select này -->
                                                <select class="form-select form-select-sm product-status"
                                                    data-detail-id="{{ $detail->id }}"
                                                    data-order-id="{{ $order->id }}">
                                                    @foreach ($statuses as $status)
                                                        @php
                                                            $canSelectProduct = false;

                                                            // Trạng thái hiện tại
                                                            if ($detailStatus == $status->id) {
                                                                $canSelectProduct = true;
                                                            }
                                                            // Trạng thái kế tiếp (không cho phép chuyển sang hoàn hàng)
                                                            elseif (
                                                                $detailStatus + 1 == $status->id &&
                                                                $status->id != 9
                                                            ) {
                                                                $canSelectProduct = true;
                                                            }
                                                            // Chỉ có thể hủy khi ở trạng thái chờ xác nhận
                                                            elseif ($status->id == 8 && $detailStatus == 1) {
                                                                $canSelectProduct = true;
                                                            }
                                                        @endphp

                                                        @if ($canSelectProduct)
                                                            <option value="{{ $status->id }}"
                                                                {{ $detailStatus == $status->id ? 'selected' : '' }}
                                                                @if ($status->id == 8) class="text-danger" @endif>
                                                                {{ $status->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-end text-dark fw-bold">Tổng cộng:</td>
                                        <td class="px-4 py-3 text-end">
                                            <h4 class="mb-0 text-danger fw-bold">
                                                {{ number_format($order->total, 0, ',', '.') }}đ
                                            </h4>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Note -->
                @if ($order->description)
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-sticky-note text-warning me-2"></i>Ghi chú đơn hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $order->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Thêm CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('change', '.product-status', function() {
            const $select = $(this);
            const $row = $select.closest('tr');
            const detailId = $select.data('detail-id');
            const orderId = $select.data('order-id');
            const statusId = $select.val();
            const originalValue = $select.data('original-value');

            Swal.fire({
                title: 'Xác nhận thay đổi?',
                text: "Bạn có chắc muốn đổi trạng thái sản phẩm này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Disable select khi đang xử lý
                    $select.prop('disabled', true);

                    $.ajax({
                        url: `/admin/orders/${orderId}/details/${detailId}/status`,
                        method: 'POST',
                        data: {
                            status_id: statusId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Hiển thị toast thành công
                                showToast('success', response.message);

                                // Cập nhật options của select với trạng thái mới
                                if (response.next_statuses) {
                                    updateSelectOptions($select, response.next_statuses,
                                        response.status_id);
                                }

                                // Enable lại select
                                $select.prop('disabled', false);

                                // Cập nhật data original value
                                $select.data('original-value', response.status_id);
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Có lỗi xảy ra';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            // Hiển thị toast lỗi
                            showToast('error', errorMessage);

                            // Khôi phục giá trị cũ
                            $select.val(originalValue);

                            // Enable lại select
                            $select.prop('disabled', false);
                        }
                    });
                } else {
                    // Nếu hủy thì khôi phục lại giá trị ban đầu
                    $select.val(originalValue);
                }
            });
        });

        // Cập nhật options của select
        function updateSelectOptions($select, nextStatuses, currentStatusId) {
            $select.empty();

            nextStatuses.forEach(function(status) {
                const $option = $('<option></option>')
                    .attr('value', status.id)
                    .text(status.name);

                if (status.is_cancel) {
                    $option.addClass('text-danger');
                }

                // Select option hiện tại
                if (status.id == currentStatusId) {
                    $option.prop('selected', true);
                }

                $select.append($option);
            });
        }

        // Lưu giá trị gốc khi focus
        $(document).on('focus', '.product-status', function() {
            $(this).data('original-value', $(this).val());
        });

        // Hàm hiển thị toast notification
        function showToast(type, message) {
            // Tạo container cho toast nếu chưa có
            if (!$('#toast-container').length) {
                $('body').append(
                    '<div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>');
            }

            const toastId = 'toast-' + Date.now();
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${icon} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

            $('#toast-container').append(toastHtml);

            // Khởi tạo và hiển thị toast
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });

            toast.show();

            // Xóa toast sau khi ẩn
            toastElement.addEventListener('hidden.bs.toast', function() {
                $(this).remove();
            });
        }

        // Nếu bạn muốn sử dụng Toastify thay vì Bootstrap Toast
        function showToastify(type, message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: type === 'success' ? "#28a745" : "#dc3545",
                },
                onClick: function() {}
            }).showToast();
        }
    </script>
@endpush
@push('styles')
    <style>
        /* Custom badge opacity */
        .bg-opacity-10 {
            --bs-bg-opacity: 0.1;
        }

        /* Select in table */
        .table select.form-select-sm {
            min-width: 140px;
        }

        /* Print styles */
        @media print {

            .btn,
            form,
            .card-header form,
            select {
                display: none !important;
            }
        }
    </style>
@endpush
