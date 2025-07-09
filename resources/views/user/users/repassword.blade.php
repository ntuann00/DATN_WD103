@extends('user.layouts.app')

@section('content')
    <div class="dashboard-section mt-110 mb-110">
        <div class="container">
            <div class="form-wrapper">
                <form method="POST" action="{{ route('repassword.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            {{-- Mật khẩu hiện tại --}}
                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <div class="form-inner" style="position: relative;">
                                    <label for="password">Mật khẩu hiện tại:</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-control" placeholder="Mật khẩu hiện tại">
                                    @if ($errors->has('current_password'))
                                        <div class="text-danger">{{ $errors->first('current_password') }}</div>
                                    @endif

                                </div>
                               
                            </div>

                            {{-- Mật khẩu mới --}}
                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <div class="form-inner position-relative">
                                    <label for="new_password">Mật khẩu mới:</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        required>

                                    @if ($errors->has('new_password'))
                                        <div class="text-danger">{{ $errors->first('new_password') }}</div>
                                    @endif
                                </div>

                              
                            </div>



                            {{-- Xác nhận mật khẩu mới --}}
                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <div class="form-inner" style="position: relative;">
                                    <label for="new_password_confirmation">Xác nhận mật khẩu mới:</label>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        required>
                                  
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    {{-- Thông báo --}}
                    @if (session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @elseif (session('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                    @endif

                    {{-- Nút --}}
                    <div class="col-12 mt-3">
                        <div class="button-group">
                            <button type="submit" class="primary-btn3 black-bg hover-btn5 hover-white">Cập nhật mật
                                khẩu</button>
                            <a href="{{ route('profile') }}" class="primary-btn3 hover-btn5">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
