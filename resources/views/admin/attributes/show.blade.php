@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2>Thuộc tính {{ $attribute->name }}</h2>

        @if ($attribute->values->count())
            <ul>
                @foreach ($attribute->values as $val)
                 <div style="margin-bottom: 20px;">
                <input type="text" class="form-control" name="name" value="{{ $val->value }}" readonly>
            </div>
                  
                @endforeach
            </ul>
        @else
            <p><em>Không có biến thể con nào.</em></p>
        @endif

        <a href="{{ route('attributes.index') }}" class="btn btn-secondary mt-3">← Quay lại</a>
        <a href="{{ route('attributeValues.create') }}" class="btn btn-secondary mt-3">Thêm giá trị</a>
    </div>
@endsection
