@extends('user.layouts.app') 

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
@endsection
