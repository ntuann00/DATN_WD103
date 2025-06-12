@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Danh sách người dùng</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">+ Thêm người dùng</a>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Ảnh</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Role ID</th>
                    <th>Trạng thái</th>
                    <th>Tạo lúc</th>
                    <th>Cập nhật lúc</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td><img src="{{ asset('storage/' . $user->img) }}" alt="img" width="100"></td>
                         <td> {{ $user->birthday->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($user->gender) }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            @if ($user->status)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                         <td> {{ $user->created_at->format('d-m-Y') }}</td>
                        <td>{{ $user->updated_at->format('d/m/y') }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc muốn xoá?')"
                                    class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
