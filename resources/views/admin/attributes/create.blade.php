@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Thêm mới Category</h2>

    {{-- Hiển thị thông báo lỗi (nếu có) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tạo mới category --}}
    <form action="{{ route('attributes.store') }}" method="POST">
        @csrf

         <div class="mb-3">
            <label for="name" class="form-label">Id biến thể</label>
            <input type="text" class="form-control" id="id" name="id" value="{{ old('id') }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Tên biến thể</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
