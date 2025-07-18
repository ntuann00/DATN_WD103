@extends('admin.layouts.app')
@section('content')
<div class="container py-4">
    <h2>🔍 Thông tin chi tiết sản phẩm</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h4>{{ $product->name }}</h4>
            <p><strong>Danh mục:</strong> {{ $product->category->name ?? '—' }}</p>
            <p><strong>Thương hiệu:</strong> {{ $product->brand ?? '—' }}</p>
            <p><strong>Mô tả:</strong> {{ $product->description ?? 'Không có mô tả' }}</p>
            <p><strong>Số lượng:</strong>
                {!! $product->status ? '<span class="badge bg-success">Còn hàng</span>' : '<span class="badge bg-danger">Hết hàng</span>' !!}
            </p>
        </div>
    </div>

    <h5 class="mb-3">🧩 Biến thể sản phẩm</h5>

    @foreach($product->variants as $variant)
        <div class="card mb-3">
            <div class="card-body">
                {{-- Thông tin cơ bản --}}
                <p><strong>Mã sản phẩm:</strong> {{ $variant->sku }}</p>
                <p><strong>ID biến thể:</strong> #{{ $variant->id }}</p>
                <p><strong>Giá:</strong> {{ number_format($variant->price, 0, ',', '.') }} VNĐ</p>
                <p><strong>Số lượng:</strong> {{ $variant->quantity }}</p>

                {{-- Ảnh đại diện --}}
                @if($variant->images->count())
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($variant->images as $image)
                            <img src="{{ asset($image->image_url) }}" width="100" class="img-thumbnail">
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Không có ảnh cho biến thể này.</p>
                @endif

                {{-- Danh sách giá trị thuộc tính --}}
                @if($variant->variantValues->count())
                    <ul class="list-group list-group-flush">
                        @foreach($variant->variantValues as $value)
                            <li class="list-group-item">
                                <strong>{{ $value->attributeValue->attribute->name ?? 'Không xác định' }}:</strong>
                                {{ $value->attributeValue->value ?? '-' }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-4">← Quay lại danh sách</a>
</div>
@endsection
