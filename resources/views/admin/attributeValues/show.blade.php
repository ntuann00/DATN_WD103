@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết giá trị thuộc tính</h1>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">ID: {{ $AttributeValue->id }}</h5>

            <p class="card-text">
                <strong>Biến thể:</strong> {{ $AttributeValue->attribute->name }} <br>
                <strong>Biến thể con:</strong> {{ $AttributeValue->value }} <br>
                <strong>Ngày tạo:</strong> {{ $AttributeValue->created_at->format('d/m/Y H:i') }} <br>
                <strong>Cập nhật lần cuối:</strong> {{ $AttributeValue->updated_at->format('d/m/Y H:i')}}
            </p>

            <a href="{{ route('attributeValues.edit', $AttributeValue->id) }}" class="btn btn-warning">Sửa</a>
            <a href="{{ route('attributeValues.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection
