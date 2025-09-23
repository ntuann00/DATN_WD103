@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h2 class="my-4 fw-bold">Quản lý hoàn hàng/ hoàn tiền</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Khách hàng</th>
                                <th width="25%">Thông tin hoàn tiền</th>
                                <th width="15%">QR</th>
                                <th width="15%">Lý do</th>
                                <th width="5%">Ngày yêu cầu</th>
                                <th width="8%">Trạng thái</th>
                                <th width="12%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refunds as $refund)
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-semibold">{{ $refund->order->name }}</div>
                                                <small class="text-muted d-block">{{ $refund->order->phone }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="bank-info">
                                            <div class="mb-1">
                                                <i class="fas fa-user text-primary"></i>
                                                <strong>{{ $refund->refundInfo->bank_holder }}</strong>
                                            </div>
                                            <div class="mb-1">
                                                <i class="fas fa-university text-primary"></i>
                                                <span class="text-uppercase">{{ $refund->refundInfo->bank_name }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-credit-card text-primary me-1"></i>
                                                <code class="fs-6">{{ $refund->refundInfo->bank_number }}</code>
                                                <button class="btn btn-sm btn-link p-0 ms-2">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div style="width:200px; height:200px; margin:auto;">
                                            {!! QrCode::size(100)->encoding('UTF-8')->generate(
                                                    $refund->refundInfo->bank_name .
                                                        ' - ' .
                                                        $refund->refundInfo->bank_number .
                                                        ' - Thanh toán đơn hàng #001' .
                                                        $refund->order->id .
                                                        ' - ' .
                                                        $refund->total .
                                                        'VND',
                                                ) !!}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-inline-block text-truncate" data-bs-toggle="tooltip"
                                            title="{{ $refund->reson }}">
                                            {{ $refund->description }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small>{{ date('d/m/Y', strtotime($refund->created_at)) }}</small>
                                        <small class="text-muted d-block">{{ $refund->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning">{{ $refund->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('refund.detail', $refund->id) }}" method="GET">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </form>
                                            @if ($refund->status == 'Đang xử lý')
                                                <button class="btn-action btn-approve" title="Duyệt"
                                                    onclick="updateRefundStatus({{ $refund->id }}, 'approved')">
                                                    <i class="fas fa-check"></i>
                                                </button>

                                                <button class="btn-action btn-reject" title="Từ chối"
                                                    onclick="updateRefundStatus({{ $refund->id }}, 'rejected')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{ $refunds->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Copy bank number
        function copyBankNumber(bankNumber) {
            navigator.clipboard.writeText(bankNumber).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Đã sao chép!',
                    text: 'Số tài khoản: ' + bankNumber,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        }

        // Update refund status function
        function updateRefundStatus(refundId, status) {
            let title = '';
            let text = '';
            let icon = '';
            let confirmButtonText = '';
            let confirmButtonColor = '';

            // Set dialog content based on status
            if (status === 'approved') {
                title = 'Duyệt yêu cầu hoàn tiền?';
                text = 'Bạn có chắc chắn muốn duyệt yêu cầu hoàn tiền này?';
                icon = 'question';
                confirmButtonText = 'Duyệt';
                confirmButtonColor = '#28a745';
            } else if (status === 'rejected') {
                title = 'Từ chối yêu cầu hoàn tiền?';
                text = 'Bạn có chắc chắn muốn từ chối yêu cầu hoàn tiền này?';
                icon = 'warning';
                confirmButtonText = 'Từ chối';
                confirmButtonColor = '#dc3545';
            } else if (status === 'completed') {
                title = 'Hoàn thành hoàn tiền?';
                text = 'Xác nhận đã hoàn tiền thành công cho khách hàng?';
                icon = 'info';
                confirmButtonText = 'Xác nhận';
                confirmButtonColor = '#007bff';
            }
            
            // Show confirmation dialog
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Đang xử lý...',
                        text: 'Vui lòng chờ trong giây lát',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send AJAX request
                    $.ajax({
                        url: '{{ route('refund.update') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            refund_id: refundId,
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: response.message || 'Cập nhật trạng thái thành công',
                                    confirmButtonColor: '#28a745'
                                }).then(() => {
                                    // Reload page to see updates
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: response.message || 'Có lỗi xảy ra',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);

                            let errorMessage = 'Có lỗi xảy ra khi cập nhật trạng thái';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.status === 422) {
                                errorMessage = 'Dữ liệu không hợp lệ';
                            } else if (xhr.status === 404) {
                                errorMessage = 'Không tìm thấy yêu cầu hoàn tiền';
                            } else if (xhr.status === 500) {
                                errorMessage = 'Lỗi server, vui lòng thử lại sau';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: errorMessage,
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                }
            });
        }

        // Alternative: If you want to add reason when rejecting
        function rejectWithReason(refundId) {
            Swal.fire({
                title: 'Từ chối yêu cầu hoàn tiền',
                input: 'textarea',
                inputLabel: 'Lý do từ chối',
                inputPlaceholder: 'Nhập lý do từ chối...',
                inputAttributes: {
                    'aria-label': 'Nhập lý do từ chối'
                },
                showCancelButton: true,
                confirmButtonText: 'Từ chối',
                confirmButtonColor: '#dc3545',
                cancelButtonText: 'Hủy',
                reverseButtons: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Vui lòng nhập lý do từ chối!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX with rejection reason
                    $.ajax({
                        url: '{{ route('refund.update') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            refund_id: refundId,
                            status: 'rejected',
                            reason: result.value
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã từ chối!',
                                text: 'Yêu cầu hoàn tiền đã bị từ chối',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush

@push('styles')
    <style>
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 16px;
            font-weight: bold;
        }

        .qr-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border: 1px solid #dee2e6;
            padding: 2px;
            border-radius: 4px;
            transition: transform 0.2s;
        }

        .qr-thumbnail:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .bank-info {
            font-size: 0.9rem;
        }

        .bank-info i {
            width: 20px;
            text-align: center;
        }

        code {
            background-color: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            color: #e83e8c;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }

        .modal-xl {
            max-width: 90%;
        }

        .img-thumbnail {
            max-height: 150px;
            object-fit: contain;
            cursor: pointer;
        }
    </style>
@endpush
