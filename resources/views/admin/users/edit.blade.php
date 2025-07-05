@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa người dùng</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ôi không!</strong> Có lỗi rồi nè <br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $users->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tên -->
        <div class="mb-3">
            <label for="name">Tên:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $users->name) }}">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $users->email) }}">
        </div>

        <!-- Số điện thoại -->
        <div class="mb-3">
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $users->phone) }}">
        </div>

        <!-- Ngày sinh -->
        <div class="mb-3">
            <label for="birthday">Ngày sinh:</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', \Carbon\Carbon::parse($users->birthday)->format('Y-m-d')) }}">
        </div>

        <!-- Giới tính -->
        <div class="mb-3">
            <label for="gender">Giới tính:</label>
            <select name="gender" class="form-control">
                <option value="">-- Chọn --</option>
                <option value="male" {{ old('gender', $users->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender', $users->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <!-- Vai trò -->
        <div class="mb-3">
            <label for="role_id">Vai trò:</label>
            <select name="role_id" class="form-control">
                <option value="">-- Chọn vai trò --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $users->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Trạng thái -->
        <div class="mb-3">
            <label for="status">Trạng thái:</label>
            <select name="status" class="form-control">
                <option value="1" {{ old('status', $users->status) == 1 ? 'selected' : '' }}>Hiện</option>
                <option value="0" {{ old('status', $users->status) == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <!-- Mật khẩu -->
        <div class="mb-3">
            <label for="password">Mật khẩu (để trống nếu không đổi):</label>
            <input type="password" name="password" class="form-control">
        </div>

        <!-- Ảnh -->
        <div class="mb-3">
            <label for="img">Ảnh đại diện:</label><br>
            @if ($users->img)
                <img src="{{ asset('storage/' . $users->img) }}" width="100" class="mb-2"><br>
            @endif
            <input type="file" name="img" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
