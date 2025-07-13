@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Danh sách người dùng</h2>

        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">+ Thêm người dùng</a>

<div style="overflow-x: auto;">
        <table class="table" >
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
                        <td><img src="{{ asset('storage/' . $user->img) }}" alt="avatar" width="100"></td>

                        <td> {{ $user->birthday}}</td>

                        <td>{{ ucfirst($user->gender) }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            @if ($user->status)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Khóa</span>
                            @endif
                        </td>
                        <td> {{ $user->created_at->format('d-m-Y') }}</td>
                        <td>{{ $user->updated_at->format('d/m/y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ url('/users/' . $user->id . '/toggle-status') }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')

                                    @if ($user->status == 1)
                                        <button type="submit" class="btn btn-secondary">Khóa</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Kích hoạt</button>
                                    @endif
                                </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
         <div>
         {{ $users->links() }}
    </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Bạn chắc chắn muốn xóa?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
    
</script>
