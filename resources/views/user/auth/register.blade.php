@extends('user.layouts.app')

@section('content')
    <!-- Star Order-tracking section -->
    <div class="order-tracking">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="order-traking-area two mt-110 mb-110">
                        <div class="section-title text-center">
                            <h2>Đăng ký</h2>
                        </div>
                        <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                             @csrf

                            <div class="row justify-content-center">
                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Tên tài khoản</label>
                                        <input type="text" name="name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Số điện thoại</label>
                                        <input type="phone" name="phone" value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Ngày sinh</label>
                                        <input type="date" name="birthday">
                                    </div>
                                </div>
                                <div class=" col-md-9 mb-25 d-flex align-items-center">
                                    <label class="mb-0">Giới tính : </label>
                                    <select name="gender" class="form-select " style="width: auto;">
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                    
                                </div>

                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Mật khẩu</label>
                                        <input type="password" name="password">
                                    </div>
                                </div>

                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Nhập lại mật khẩu</label>
                                        <input type="password" name="password_confirmation">
                                    </div>
                                </div>

                                <div class="col-md-9 ">
                                    <div class="form-remember-forget">
                                        <a href="{{ route('login') }}" class="forget-pass hover-underline"> Đăng nhập </a>

                                    </div>
                                </div>
                                <div class="col-md-9 d-flex justify-content-center">
                                    <div class="button-group">
                                        <button type="submit" class="primary-btn3 black-bg hover-btn5 hover-white">đăng
                                            ký</button>
                                    </div>
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
