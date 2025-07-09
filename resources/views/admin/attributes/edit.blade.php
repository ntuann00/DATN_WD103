@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div style="background-color: #61c4b3; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
        <h2 style="color: #1d0066; font-weight: bold;">Sửa biến thể</h2>

        <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 20px;">
                <label for="name">Tên biến thể</label>
                <input type="text" class="form-control" name="name" value="{{ $attribute->name }}" required>
            </div>

            <button type="submit" style="background-color: #3c147a; color: white; padding: 8px 16px; border: none; border-radius: 5px;">
                Lưu
            </button>
            <a href="{{ route('attributes.index') }}" style="margin-left: 10px; background-color: gray; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none;">
                Quay lại
            </a>
        </form>
    </div>
</div>
@endsection
