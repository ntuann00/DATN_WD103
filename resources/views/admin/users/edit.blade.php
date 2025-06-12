@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa người dùng</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Lỗi!</strong> Vui lòng kiểm tra lại dữ liệu.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Tên:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label for="password">Mật khẩu (để trống nếu không đổi):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="birthday">Ngày sinh:</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', \Carbon\Carbon::parse($user->birthday)->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label for="gender">Giới tính:</label>
            <select name="gender" class="form-control">
                <option value="">-- Chọn --</option>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="role_id">Vai trò:</label>
            <select name="role_id" class="form-control">
                <option value="">-- Chọn vai trò --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status">Trạng thái:</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Hiện</option>
                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="img">Ảnh đại diện:</label><br>
            @if ($user->img)
                <img src="{{ asset('storage/' . $user->img) }}" width="100" class="mb-2"><br>
            @endif
            <input type="file" name="img" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection