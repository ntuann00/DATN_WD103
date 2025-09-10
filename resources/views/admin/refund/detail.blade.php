@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
<h2>Chi tiết đơn hoàn</h2>
<form action="{{ route('admin.refund.detail', $refund->id) }}" method="POST">
    <div class="row">
        <div class="col-lg-6">
            <h4>Chi tiết yêu cầu hoàn hàng</h4>
           <label>Lý do hoàn hàng</label>
            <span type="text" name="code" class="form-control" readonly>{{ $refund->reason }} </span>
       
            <label>Mô tả</label>
            <span name="description" class="form-control" readonly>{{ $refund->description }}</span>
            
            <label>Ngày yêu cầu</label>
            <!-- <input type="date" name="start_date" class="form-control" value="{{ \Carbon\Carbon::parse($refund->create_at)->format('Y-m-d') }}"> -->
            <p class="fs-3">{{ \Carbon\Carbon::parse($refund->create_at)->format('d-m-Y') }}</p>

            <label>Cập nhật lần cuối</label>
            <!-- <input type="date" name="end_date" class="form-control" value="{{ \Carbon\Carbon::parse($refund->end_date)->format('Y-m-d') }}"> -->
            <p class="fs-3">{{ \Carbon\Carbon::parse($refund->update_at)->format('d-m-Y') }}</p>
        </div>

        <div class="col-lg-6">
            <h4>Thông tin hoàn tiền</h4>
            <label>Họ và tên chủ thẻ</label>
            <span name="description" class="form-control" readonly>{{ $refund_info->bank_holder ? $refund_info : 'Không có dữ liệu' }}</span>

            <label>Ngân hàng</label>
            <span type="text" name="bank" class="form-control" readonly>{{ $refund_info->bank ? $refund_info : 'Không có dữ liệu' }}</span>

            <label>Số tài khoản</label>
            <div class="row">
                <div class="col-md-10">
                <span name="bank_number" class="form-control" readonly class="fs-4 fw-bold text-primary">
                    {{ $refund_info->bank_number ? $refund_info : 'Không có dữ liệu' }}
                </span></div>
            </div>
        </div>
    </div>
    <div class="row pb-3 pt-3">
        <div class="col-lg-6">
            <h4>Thông tin khách hàng</h4>
            <label>Họ và tên</label>
            <span name="name" class="form-control" readonly>{{ $user->name}}</span>

            <label>Email</label>
            <span type="text" name="email" class="form-control" readonly>{{ $user->email}}</span>

            <label>Số điện thoại</label>
            <span type="text" name="phone" class="form-control" readonly>{{ $user->phone}}</span>
        </div>
    </div>

    <a href="{{ route('admin.refund.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
</div>

@endsection
@push('scripts')
<script>
function copy() {
  var copyText = document.getElementById("bank_number");
  copyText.select();
  navigator.clipboard.writeText(copyText.value);
}
</script>
@endpush