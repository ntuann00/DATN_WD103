@extends('user.layouts.app')

@section('content')
    <div class="dashboard-section mt-110 mb-110">
        <div class="container">
            <div class="form-wrapper">
                <!-- action -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row align-items">
                        <!-- data -->
                        <div class="col-6">
                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <div class="form-inner">
                                    <label for="">Tên tài khoản:</label>
                                    <input type="text" name="name" value="{{ $user->name }}">
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>

                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <div class="form-inner">
                                    <label for="">Số điện thoại:</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}">
                                    @if ($errors->has('phone'))
                                        <div class="text-danger">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <div class="form-inner">
                                    <label for="">Ngày sinh:</label>
                                    <input type="text" name="birthday" value="{{ $user->birthday->format('d/m/Y') }}">
                                    @if ($errors->has('birthday'))
                                        <div class="text-danger">{{ $errors->first('birthday') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 mb-25">
                                <!-- <input type="text" value="{{ $user->gender == 'male' ? 'Nam' : 'Nữ' }}"> -->
                                <div class="form-inner">
                                    <select name="gender">
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Nữ
                                        </option>
                                    </select>

                                </div>
                            </div>


                        </div>

                        <!-- data -->

                        <!-- avatar -->
                        <div class="col-6">
                            <div class="col-xl-6 col-lg-18 col-md-6 mb-25">
                                <div class="form-inner">
                                    <p>Ảnh đại diện</p>
                                    <img src="{{ asset('storage/' . $user->img) }}" alt="" width="150"
                                        style="margin-bottom: 10px">
                                    <input type="file" name="img" accept="image/*">
                                    @if ($errors->has('img'))
                                        <div class="text-danger">{{ $errors->first('img') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- avatar -->
                    </div>

                    <div class="col-12">
                        <div class="button-group">
                            <button type="submit" class="primary-btn3 black-bg  hover-btn5 hover-white">Update
                                Profile</button>
                            <button type="button" class="primary-btn3 hover-btn5">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
