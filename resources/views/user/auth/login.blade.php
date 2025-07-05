@extends('user.layouts.app')

@section('content')
<!-- Star Order-tracking section -->
    <div class="order-tracking">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="order-traking-area two mt-110 mb-110">
                        <div class="section-title text-center">
                            <h2>Đăng nhập</h2>
                        </div>
                       <!-- HIỂN THỊ THÔNG BÁO LỖI TỔNG QUÁT -->
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ url('/login') }}">
    @csrf

    <div class="row justify-content-center">
        <!-- EMAIL -->
        <div class="col-md-9 mb-25">
            <div class="form-inner">
                <label for="email">Email</label>
                <input name="email" type="text" placeholder="Enter your email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="col-md-9 mb-25">
            <div class="form-inner">
                <label for="password">Password</label>
                <input name="password" type="password" placeholder="Enter your password"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- REMEMBER ME -->
        <div class="col-md-9">
            <div class="form-remember-forget">
                <div class="remember">
                    <input type="checkbox" class="custom-check-box" id="check1" name="remember">
                    <label for="check1">Nhớ đăng nhập</label>
                </div>
                <a href="#" class="forget-pass hover-underline">Quên mật khẩu?</a>
            </div>
        </div>

        <!-- NÚT ĐĂNG NHẬP -->
        <div class="col-md-9 mt-3">
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </div>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Order-tracking section -->
@endsection
