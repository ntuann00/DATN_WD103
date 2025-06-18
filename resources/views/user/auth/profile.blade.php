{{-- @extends('user.layouts.app') 

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">👤 Hồ sơ cá nhân</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Họ và tên:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
            <p><strong>Ngày sinh:</strong> {{ $user->birthday->format('d/m/Y') }}</p>
            <p><strong>Giới tính:</strong> {{ $user->gender == 'male' ? 'Nam' : 'Nữ' }}</p>
            <p><strong>Ngày tham gia:</strong> {{ $user->created_at->format('d/m/Y') }}</p>

            <a href="" class="btn btn-primary mt-3">✏️ Chỉnh sửa hồ sơ</a>
        </div>
    </div>
</div>
@endsection --}}

@extends('user.layouts.app')

@section('content')
    <div class="dashboard-section mt-110 mb-110">
        <div class="container">

            <div class="table-title-area">
                <h3>
                    @if (Auth::check())
                        <span class="dropdown-item-text">Hồ sơ của {{ Auth::user()->name }}</span>
                    @endif


                </h3>

            </div>
            <div class="form-wrapper">
                <form action="#">

                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Tên tài khoản :</p>
                            <input type="text" value="{{ $user->name }}" style="width: 130%;" readonly>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Email :</p>
                            <input type="text" value="{{ $user->email }}" style="width: 130%;"readonly>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Số điện thoại :</p>
                            <input type="text" value="{{ $user->phone }}" style="width: 130%"readonly>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Ngày sinh :</p>
                            <input type="text" value="{{ $user->birthday->format('d/m/Y') }}"style="width: 130%"
                                readonly>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Giới tính :</p>
                            <input type="text" value="{{ $user->gender == 'male' ? 'Nam' : 'Nữ' }}"
                                style="width: 130%;"readonly>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Ngày tạo tài khoản :</p>
                            <input type="text" value="{{ $user->created_at->format('d/m/Y') }}"
                                style="width: 130%;"readonly>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Ảnh đại diện</p>
                            <img src="{{ asset('storage/' . $user->img) }}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                        <div class="form-inner">
                            <p>Ngày tạo tài khoản :</p>
                            <input type="text" value="{{ $user->created_at->format('d/m/Y') }}"
                                style="width: 130%;"readonly>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="button-group">
                            <button type="submit" class="primary-btn3 black-bg  hover-btn5 hover-white">Update
                                Profile</button>
                            <button class="primary-btn3 hover-btn5">Cancel</button>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
