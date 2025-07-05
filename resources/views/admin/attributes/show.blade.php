@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Thuộc tính {{ $attribute->name }}</h2>

    @if ($attribute->values->count())
        <form action="{{ route('attributeValues.update') }}" method="POST">
            @csrf
            @method('PUT')

nhanhcuahoang
        <a href="{{ route('attributes.index') }}" class="btn btn-secondary mt-3">← Quay lại</a>
        <a href="{{ route('attributeValues.create') }}" class="btn btn-secondary mt-3">Thêm giá trị</a>
    </div>
=======
            @foreach ($attribute->values as $val)
                <div style="margin-bottom: 20px;">
                    <input type="hidden" name="values[{{ $val->id }}][id]" value="{{ $val->id }}">
                    <input type="text" class="form-control" name="values[{{ $val->id }}][value]" value="{{ $val->value }}">
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
        </form>
    @else
        <p><em>Không có biến thể con nào.</em></p>
    @endif

    <a href="{{ route('attributes.index') }}" class="btn btn-secondary mt-3">← Quay lại</a>
    <a href="{{ route('attributeValues.create', ['attribute_id' => $attribute->id]) }}" class="btn btn-secondary mt-3">Thêm giá trị</a>
</div>
 main
@endsection
