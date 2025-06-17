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
                        <form method="POST" action="{{ url('/login') }}">
    @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Email/Username</label>
                                        <input type="text" placeholder="Enter your email/username">
                                    </div>
                                </div>
                                <div class="col-md-9 mb-25">
                                    <div class="form-inner">
                                        <label>Password</label>
                                        <input type="password" placeholder="Enter your password">
                                    </div>
                                </div>

                                <div class="col-md-9 ">
                                    <div class="form-remember-forget">
                                        <div class="remember">
                                            <input type="checkbox" class="custom-check-box" id="check1">
                                            <label for="check1">Nhớ đăng nhập</label>
                                        </div>

                                        <a href="#" class="forget-pass hover-underline"> Quên mật khẩu? </a>
                                        |
                                        <a href="#" class="forget-pass hover-underline"> Đăng ký </a>

                                    </div>
                                </div>
                                <div class="col-md-9 d-flex justify-content-center">
                                    <div class="button-group">
                                        <button type="submit"
                                            class="primary-btn3 black-bg hover-btn5 hover-white">Login</button>
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