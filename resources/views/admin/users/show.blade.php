@extends('admin.layouts.app') 

@section('content')
<div class="container">
    <h1>Chi tiết người dùng</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ $users->name }}</p>
            <p><strong>Email:</strong> {{ $users->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $users->phone }}</p>
            <p><strong>Giới tính:</strong> {{ $users->gender }}</p>
            <p><strong>Ngày sinh:</strong> {{ $users->birthday }}</p>
            <p><strong>Vai trò:</strong> {{ $users->role->name ?? 'Chưa có' }}</p>
            <p><strong>Trạng thái:</strong> {{ $users->status ? 'Đang hoạt động' : 'Tạm khóa' }}</p>
            <p><strong>Ảnh đại diện:</strong></p>
            <td><img src="{{ asset('storage/' . $users->img) }}" alt="avatar" width="100"></td>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection
