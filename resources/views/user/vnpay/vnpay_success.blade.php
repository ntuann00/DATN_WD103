@extends('user.layouts.app')

@section('content')
    @php
        session()->forget('selected_items');
    @endphp
    <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="text-center">
            <div style="font-size: 70px; color: #28a745;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2 class="mt-3 text-success" style="color: #ff5722;"><strong>Đặt hàng thành công!</strong></h2>
            <p class="mt-2">Cảm ơn {{ Auth()->user()->name }} đã mua hàng tại FiveBeauty!</p>
            <p>Chúc quý khách một ngày tốt lành</p>

            <div class="mt-4">
                <a href="{{ route('profile') }}" class="btn btn-outline-secondary me-2">Xem chi tiết đơn hàng</a>
                <a href="{{ route('u.product') }}" class="btn btn-warning text-white">Tiếp tục mua hàng</a>
            </div>
        </div>
    </div>
@endsection
