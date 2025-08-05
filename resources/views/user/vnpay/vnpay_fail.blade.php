@extends('user.layouts.app') {{-- hoặc layout của vợ --}}

@section('content')
    @php
        session()->forget('selected_items');
    @endphp
    <div class="container text-center py-5">
        <h2 class="text-danger">Thanh toán thất bại!</h2>
        <p>{{ $message ?? 'Có lỗi xảy ra trong quá trình thanh toán.' }}</p>
        <a href="{{ route('cart.view') }}" class="btn btn-primary mt-3">Quay lại giỏ hàng</a>
    </div>
@endsection
