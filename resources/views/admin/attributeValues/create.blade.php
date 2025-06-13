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
        <form action="{{ route('attributeValues.store') }}" method="POST">
            @csrf
            <label for="attribute_id">Vai trò:</label>
            <select name="attribute_id" class="form-control">
                <option value="">-- Chọn vai trò --</option>
                @foreach ($attributes as $attribute)
                    <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                        {{ $attribute->name }}
                    </option>
                @endforeach
            </select>

            <div class="mb-3">
                <label for="value" class="form-label">Tên biến thể con </label>
                <input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('attributeValues.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
