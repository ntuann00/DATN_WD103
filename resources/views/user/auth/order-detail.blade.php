@extends('user.layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Chi tiết đơn hàng #<span id="orderId">000{{ $order->id }}</span></h2>
                    <a href="{{ route('profile') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Tên khách hàng:</strong> <span id="customerName">{{ $order->name ?? 'Nguyễn Văn A' }}</span></p>
                        <p class="mb-2"><strong>Số điện thoại:</strong> <span id="customerPhone">{{ $order->phone ?? '0123456789' }}</span></p>
                        <p class="mb-0"><strong>Địa chỉ:</strong> <span id="customerAddress">{{ $order->address->address ?? 'Hà Nội' }}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-credit-card-fill me-2"></i>Thông tin thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Phương thức thanh toán:</strong> <span id="paymentMethod">{{ $order->payment->name ?? 'Thanh toán khi nhận hàng' }}</span></p>
                        <p class="mb-2"><strong>Trạng thái thanh toán:</strong>
                            <span class="badge bg-danger" id="paymentStatus">{{ $order->status_payment == 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}</span>
                        </p>
                        <p class="mb-0"><strong>Ngày đặt hàng:</strong> <span id="orderDate">{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products List -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-cart-fill me-2"></i>Danh sách sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Sản phẩm</th>
                                        <th scope="col">Phân loại</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Đơn giá</th>
                                        <th scope="col">Thành tiền</th>
                                        <th scope="col">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderDetails as $orderDetail)
                                        {{-- @dd($orderDetail) --}}
                                        <tr>
                                            <th scope="row" class="align-middle text-center">
                                                <div class="order-id">
                                                    #{{ $loop->iteration }}
                                                </div>
                                            </th>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="product-image me-3"
                                                        style="width: 80px; height: 80px; flex-shrink: 0;">
                                                        <img src="{{ $orderDetail->productVariant->images->first()->image_url ? asset($orderDetail->productVariant->images->first()->image_url) : asset('images/no-image.png') }}"
                                                            class="img-fluid rounded"
                                                            style="width: 100%; height: 100%; object-fit: cover;"
                                                            alt="{{ $orderDetail->productVariant->images->first()->alt_text ?? 'Không có ảnh' }}" />
                                                    </div>
                                                    <div style="word-wrap: break-word; word-break: break-word;">
                                                        <span>{{ $orderDetail->name_product }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    @php
                                                        $variant_product = @json_decode(
                                                            $orderDetail->variant_product,
                                                            true,
                                                        );
                                                    @endphp

                                                    @foreach ($variant_product as $key_variant => $value_variant)
                                                        {{ $key_variant }}: {{ $value_variant }}
                                                        @if (!$loop->last)
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                </small>
                                            </td>
                                            <td>
                                                <span class="quantity-badge">
                                                    {{ $orderDetail->quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ number_format($orderDetail->price, 0, ',', '.') }}đ
                                                </span>
                                            </td>
                                            <td class="fw-bold">
                                                <span class="badge bg-success">
                                                    {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }}đ
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = 'status-pending';
                                                    if (in_array($orderDetail->status?->id, [1, 2, 3, 4, 5, 6])) {
                                                        $statusClass = 'status-processing';
                                                    } elseif ($orderDetail->status?->id == 7) {
                                                        $statusClass = 'status-success';
                                                    } elseif (in_array($orderDetail->status?->id, [8, 9])) {
                                                        $statusClass = 'status-delivered';
                                                    }
                                                @endphp
                                                <span class="status-badge {{ $statusClass }}">
                                                    {{ $orderDetail->status?->name ?? 'Đang xử lý' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-0">
                                        <td colspan="6" class="text-end border-0">
                                            <strong>Tổng cộng: <span
                                                    class="text-danger">{{ number_format($order->total, 0, ',', '.') }}đ</span></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-chat-left-text-fill me-2"></i>Ghi chú</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" id="orderDescription">{{ $order->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-center gap-3">
                    @php
                        $hasStatus7 = $order->orderDetails->where('status_id', 7)->count() > 0;
                        $hasStatus1 = $order->orderDetails->where('status_id', 1)->count() > 0;
                    @endphp

                    @if ($hasStatus7)
                        <button class="btn btn-warning btn-lg" onclick="showActionSection('return')">
                            <i class="bi bi-arrow-return-left me-2"></i>Hoàn hàng
                        </button>
                    @endif

                    @if ($hasStatus1)
                        <button class="btn btn-danger btn-lg" onclick="showActionSection('cancel')">
                            <i class="bi bi-x-circle me-2"></i>Hủy đơn hàng
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Action Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div id="productActionSection" class="product-action-section" style="display: none;">
                    <h4 class="mb-3" id="actionTitle">Chọn sản phẩm</h4>
                    <div class="alert alert-warning mb-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span id="actionWarning">Vui lòng chọn sản phẩm và nhập lý do</span>
                    </div>

                    <!-- Product Selection List -->
                    <div class="product-selection-list">
                        @foreach ($order->orderDetails as $orderDetail)
                            <!-- Product with status 7 (for return) -->
                            @if ($orderDetail->status_id == 7)
                                <div class="card mb-3 product-item return-product" data-status="7"
                                    style="display: none;">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <input type="checkbox" class="form-check-input product-checkbox"
                                                    id="product{{ $loop->iteration }}"
                                                    onchange="toggleReasonInput('product{{ $loop->iteration }}')">
                                            </div>
                                            <div class="col-md-5">
                                                <div class="d-flex align-items-center">
                                                    <div class="product-image me-3"
                                                        style="width: 60px; height: 60px; flex-shrink: 0;">
                                                        <img src="{{ $orderDetail->productVariant->images->first()->image_url ? asset($orderDetail->productVariant->images->first()->image_url) : asset('images/no-image.png') }}"
                                                            class="img-fluid rounded"
                                                            style="width: 100%; height: 100%; object-fit: cover;"
                                                            alt="{{ $orderDetail->productVariant->images->first()->alt_text ?? 'Không có ảnh' }}" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $orderDetail->name_product }}</h6>
                                                        <small class="text-muted">
                                                            @php
                                                                $variant_product = @json_decode(
                                                                    $orderDetail->variant_product,
                                                                    true,
                                                                );
                                                            @endphp
                                                            @foreach ($variant_product as $key_variant => $value_variant)
                                                                {{ $key_variant }}: {{ $value_variant }}@if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <span>Số lượng: {{ $orderDetail->quantity }}</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="fw-bold">{{ number_format($orderDetail->price, 0, ',', '.') }}đ</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="badge bg-success">{{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                        <div class="reason-input" id="reason-product{{ $loop->iteration }}"
                                            style="display: none;">
                                            <div class="mt-3">
                                                <label class="form-label">Lý do hoàn hàng:</label>
                                                <textarea class="form-control" rows="2" name="reason[{{ $orderDetail->id }}]"
                                                    placeholder="Nhập lý do hoàn hàng..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Product with status 1 (for cancel) -->
                            @if ($orderDetail->status_id == 1)
                                <div class="card mb-3 product-item cancel-product" data-status="1"
                                    style="display: none;">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <input type="checkbox" class="form-check-input product-checkbox"
                                                    id="product{{ $loop->iteration }}"
                                                    onchange="toggleReasonInput('product{{ $loop->iteration }}')">
                                            </div>
                                            <div class="col-md-5">
                                                <div class="d-flex align-items-center">
                                                    <div class="product-image me-3"
                                                        style="width: 60px; height: 60px; flex-shrink: 0;">
                                                        <img src="{{ $orderDetail->productVariant->images->first()->image_url ? asset($orderDetail->productVariant->images->first()->image_url) : asset('images/no-image.png') }}"
                                                            class="img-fluid rounded"
                                                            style="width: 100%; height: 100%; object-fit: cover;"
                                                            alt="{{ $orderDetail->productVariant->images->first()->alt_text ?? 'Không có ảnh' }}" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1">{{ $orderDetail->name_product }}</h6>
                                                        <small class="text-muted">
                                                            @php
                                                                $variant_product = @json_decode(
                                                                    $orderDetail->variant_product,
                                                                    true,
                                                                );
                                                            @endphp
                                                            @foreach ($variant_product as $key_variant => $value_variant)
                                                                {{ $key_variant }}: {{ $value_variant }}@if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <span>Số lượng: {{ $orderDetail->quantity }}</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="fw-bold">{{ number_format($orderDetail->price, 0, ',', '.') }}đ</span>
                                            </div>
                                            <div class="col-md-2">
                                                <span
                                                    class="badge bg-success">{{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') }}đ</span>
                                            </div>
                                        </div>
                                        <div class="reason-input" id="reason-product{{ $loop->iteration }}"
                                            style="display: none;">
                                            <div class="mt-3">
                                                <label class="form-label">Lý do hủy:</label>
                                                <textarea class="form-control" rows="2" name="reason[{{ $orderDetail->id }}]"
                                                    placeholder="Nhập lý do hủy..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <!-- Banking Information Section (for refund) -->
                        <div id="bankingInfoSection" class="card mt-4" style="display: none;">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="bi bi-bank me-2"></i>Thông tin hoàn tiền</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info mb-3">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    Vui lòng cung cấp thông tin tài khoản ngân hàng để nhận tiền hoàn lại
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="bankName" class="form-label">Tên ngân hàng <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="bankName" name="bank_name"
                                            placeholder="VD: Vietcombank, BIDV, Techcombank..." required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="accountNumber" class="form-label">Số tài khoản <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="accountNumber"
                                            name="account_number" placeholder="Nhập số tài khoản" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="accountHolder" class="form-label">Tên chủ tài khoản <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="accountHolder"
                                            name="account_holder"
                                            placeholder="Nhập tên chủ tài khoản (viết hoa không dấu)" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button class="btn btn-secondary" onclick="hideActionSection()">
                                <i class="bi bi-x me-2"></i>Hủy bỏ
                            </button>
                            <button class="btn btn-primary" id="submitActionBtn" onclick="submitAction()">
                                <i class="bi bi-check-circle me-2"></i>Xác nhận
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-action-section {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .reason-input {
            display: none;
            margin-top: 10px;
        }

        .product-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 500;
            white-space: nowrap;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        tbody tr td {
            text-align: center;
            vertical-align: middle;
        }

        .order-id {
            background: linear-gradient(135deg, #FFF8F0 0%, #F5E6D3 100%);
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            color: #A67C52;
            font-size: 13px;
        }

        .quantity-badge {
            background: #F5E6D3;
            color: #6B4423;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentAction = '';

        function showActionSection(action) {
            currentAction = action;
            const section = document.getElementById('productActionSection');
            const actionTitle = document.getElementById('actionTitle');
            const actionWarning = document.getElementById('actionWarning');
            const actionTypes = document.querySelectorAll('.action-type');
            const submitBtn = document.getElementById('submitActionBtn');
            const bankingInfoSection = document.getElementById('bankingInfoSection');

            // Kiểm tra trạng thái thanh toán
            const paymentStatus = {{ $order->status_payment ?? 0 }};
            const shouldShowBankingInfo = (paymentStatus == 1 && (action == 'return' || action == 'cancel'));

            // Ẩn tất cả sản phẩm trước
            document.querySelectorAll('.product-item').forEach(item => {
                item.style.display = 'none';
            });

            // Reset tất cả checkbox
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Ẩn tất cả reason input
            document.querySelectorAll('.reason-input').forEach(input => {
                input.style.display = 'none';
            });

            // Reset banking info
            if (bankingInfoSection) {
                bankingInfoSection.style.display = shouldShowBankingInfo ? 'block' : 'none';
                document.getElementById('bankName').value = '';
                document.getElementById('accountNumber').value = '';
                document.getElementById('accountHolder').value = '';
            }

            if (action === 'return') {
                actionTitle.textContent = 'Chọn sản phẩm cần hoàn';
                actionWarning.textContent = 'Vui lòng chọn sản phẩm bạn muốn hoàn và nhập lý do';
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Xác nhận hoàn hàng';
                submitBtn.className = 'btn btn-warning';
                actionTypes.forEach(el => el.textContent = 'hoàn');

                // Hiển thị sản phẩm có status 7
                document.querySelectorAll('.return-product').forEach(item => {
                    item.style.display = 'block';
                });
            } else if (action === 'cancel') {
                actionTitle.textContent = 'Chọn sản phẩm cần hủy';
                actionWarning.textContent = 'Vui lòng chọn sản phẩm bạn muốn hủy và nhập lý do';
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Xác nhận hủy';
                submitBtn.className = 'btn btn-danger';
                actionTypes.forEach(el => el.textContent = 'hủy');

                // Hiển thị sản phẩm có status 1
                document.querySelectorAll('.cancel-product').forEach(item => {
                    item.style.display = 'block';
                });
            }

            section.style.display = 'block';
            section.scrollIntoView({
                behavior: 'smooth'
            });
        }

        function hideActionSection() {
            const section = document.getElementById('productActionSection');
            section.style.display = 'none';

            // Reset checkboxes and reason inputs
            document.querySelectorAll('.product-checkbox').forEach(cb => {
                cb.checked = false;
            });
            document.querySelectorAll('.reason-input').forEach(input => {
                input.style.display = 'none';
                input.querySelector('textarea').value = '';
            });
        }

        function toggleReasonInput(productId) {
            const checkbox = document.getElementById(productId);
            const reasonInput = document.getElementById('reason-' + productId);

            if (checkbox.checked) {
                reasonInput.style.display = 'block';
                reasonInput.querySelector('textarea').focus();
            } else {
                reasonInput.style.display = 'none';
                reasonInput.querySelector('textarea').value = '';
            }
        }

        function submitAction() {
            // Kiểm tra xem có sản phẩm nào được chọn không
            const checkedProducts = document.querySelectorAll('.product-checkbox:checked');
            const paymentStatus = {{ $order->status_payment ?? 0 }};

            if (checkedProducts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Chưa chọn sản phẩm',
                    text: `Vui lòng chọn ít nhất một sản phẩm để ${currentAction === 'return' ? 'hoàn' : 'hủy'}`,
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Kiểm tra thông tin ngân hàng nếu cần
            if (paymentStatus == 1 && (currentAction == 'return' || currentAction == 'cancel')) {
                const bankName = document.getElementById('bankName').value.trim();
                const accountNumber = document.getElementById('accountNumber').value.trim();
                const accountHolder = document.getElementById('accountHolder').value.trim();

                if (!bankName || !accountNumber || !accountHolder) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thiếu thông tin ngân hàng',
                        text: 'Vui lòng điền đầy đủ thông tin tài khoản ngân hàng để nhận tiền hoàn',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }
            }

            // Kiểm tra xem tất cả sản phẩm đã chọn có nhập lý do không
            let missingReason = false;
            let selectedProducts = [];

            checkedProducts.forEach(checkbox => {
                const productId = checkbox.id;
                const reasonTextarea = document.querySelector(`#reason-${productId} textarea`);
                const productName = checkbox.closest('.card-body').querySelector('h6').textContent;

                if (!reasonTextarea.value.trim()) {
                    missingReason = true;
                } else {
                    selectedProducts.push({
                        id: productId,
                        name: productName,
                        reason: reasonTextarea.value.trim()
                    });
                }
            });

            if (missingReason) {
                Swal.fire({
                    icon: 'error',
                    title: 'Thiếu lý do',
                    text: `Vui lòng nhập lý do ${currentAction === 'return' ? 'hoàn' : 'hủy'} cho tất cả sản phẩm đã chọn`,
                    confirmButtonColor: '#d33'
                });
                return;
            }

            // Hiển thị xác nhận
            const actionText = currentAction === 'return' ? 'hoàn' : 'hủy';
            const actionColor = currentAction === 'return' ? '#ffc107' : '#dc3545';

            let confirmHtml = `
        <div class="text-start">
            <p>Bạn đã chọn ${selectedProducts.length} sản phẩm để ${actionText}:</p>
            <ul>
                ${selectedProducts.map(p => `<li><strong>${p.name}</strong><br>Lý do: ${p.reason}</li>`).join('')}
            </ul>
    `;

            if (paymentStatus == 1 && (currentAction == 'return' || currentAction == 'cancel')) {
                const bankName = document.getElementById('bankName').value.trim();
                const accountNumber = document.getElementById('accountNumber').value.trim();
                const accountHolder = document.getElementById('accountHolder').value.trim();

                confirmHtml += `
            <hr>
            <p><strong>Thông tin hoàn tiền:</strong></p>
            <ul>
                <li>Ngân hàng: ${bankName}</li>
                <li>Số tài khoản: ${accountNumber}</li>
                <li>Chủ tài khoản: ${accountHolder}</li>
            </ul>
        `;
            }

            confirmHtml += '</div>';

            Swal.fire({
                title: `Xác nhận ${actionText} hàng?`,
                html: confirmHtml,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Xác nhận ${actionText}`,
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi request thực tế
                    Swal.fire({
                        title: 'Đang xử lý...',
                        html: 'Vui lòng chờ trong giây lát',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Chuẩn bị data để gửi
                    const formData = new FormData();
                    formData.append('action', currentAction);
                    formData.append('order_id', '{{ $order->id }}');

                    // Thêm thông tin ngân hàng nếu cần
                    if (paymentStatus === 1 && (currentAction == 'return' || currentAction == 'cancel')) {
                        formData.append('bank_name', document.getElementById('bankName').value.trim());
                        formData.append('account_number', document.getElementById('accountNumber').value.trim());
                        formData.append('account_holder', document.getElementById('accountHolder').value.trim());
                    }

                    // Thêm các sản phẩm đã chọn và lý do
                    let productIndex = 0;
                    checkedProducts.forEach(checkbox => {
                        const orderDetailId = checkbox.closest('.product-item').querySelector('textarea')
                            .name.match(/\d+/)[0];
                        const reason = document.querySelector(`#reason-${checkbox.id} textarea`).value
                            .trim();

                        formData.append(`products[${productIndex}][id]`, orderDetailId);
                        formData.append(`products[${productIndex}][reason]`, reason);
                        productIndex++;
                    });

                    // Gửi request
                    fetch('{{ route('order.action') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();

                            if (data.success) {
                                let successMessage = data.message ||
                                    `Yêu cầu ${actionText} hàng đã được gửi thành công`;

                                if (data.refund_amount && data.refund_amount > 0) {
                                    successMessage +=
                                        `<br><br>Số tiền hoàn lại: <strong>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.refund_amount)}</strong>`;
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    html: successMessage,
                                    confirmButtonColor: '#28a745'
                                }).then(() => {
                                    // Reset form và ẩn section
                                    hideActionSection();
                                    // Reload trang sau 1 giây
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: data.message || 'Có lỗi xảy ra, vui lòng thử lại',
                                    confirmButtonColor: '#d33'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.',
                                confirmButtonColor: '#d33'
                            });
                        });
                }
            });
        }

        // Validation cho input ngân hàng
        const accountNumberInput = document.getElementById('accountNumber');
        if (accountNumberInput) {
            accountNumberInput.addEventListener('input', function() {
                // Chỉ cho phép nhập số
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        const accountHolderInput = document.getElementById('accountHolder');
        if (accountHolderInput) {
            accountHolderInput.addEventListener('input', function() {
                // Tự động chuyển thành chữ hoa
                this.value = this.value.toUpperCase();
            });
        }

        // Validation cho textarea
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('.reason-input textarea');

            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    if (this.value.length > 500) {
                        this.value = this.value.substring(0, 500);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: 'Lý do không được quá 500 ký tự',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    </script>
@endpush
