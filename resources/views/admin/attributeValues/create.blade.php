@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Thêm mới giá trị</h2>

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
        <form action="{{ route('attributeValues.store') }}" method="POST">
            @csrf
            <label for="attribute_id">Thuộc tính</label>
            <select name="attribute_id" class="form-control">
                <option value=""> -- Chọn thuộc tính--</option>
                @foreach ($attributes as $attribute)
                
                    <option value="{{ $attribute->id }}"
                        
                        {{ old('attribute_id', $attribute_id ?? '') == $attribute->id ? 'selected' : '' }}>{{ $attribute->name }}</option>
                @endforeach
            </select>

            <div class="mb-3">
                <label for="value" class="form-label">Giá trị thuộc tính</label>
                <input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('attributes.index', request('attributed')) }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
