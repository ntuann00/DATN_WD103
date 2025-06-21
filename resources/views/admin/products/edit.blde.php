@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Sửa sản phẩm</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrfd
        @method('PUT')

        {{-- Thông tin sản phẩm --}}
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Thương hiệu</label>
            <input type="text" name="brand" value="{{ $product->brand }}" class="form-control">
        </div>

        <hr>
        <h4>Biến thể sản phẩm</h4>

        @foreach($product->variants as $variant)
        <div class="card mb-4">
            <div class="card-body">

                <input type="hidden" name="variants[{{ $variant->id }}][id]" value="{{ $variant->id }}">

                <div class="mb-2">
                    <label>SKU</label>
                    <input type="text" name="variants[{{ $variant->id }}][sku]" value="{{ $variant->sku }}" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Giá</label>
                    <input type="number" name="variants[{{ $variant->id }}][price]" value="{{ $variant->price }}" class="form-control">
                </div>

                <div class="mb-2">
                    <label>Số lượng</label>
                    <input type="number" name="variants[{{ $variant->id }}][quantity]" value="{{ $variant->quantity }}" class="form-control">
                </div>

                {{-- Thuộc tính --}}
                <div class="mb-2">
                    <label>Thuộc tính:</label>
                    <ul class="list-group list-group-flush">
                        @foreach($variant->variantValues as $vv)
                            <li class="list-group-item">
                                <strong>{{ $vv->attributeValue->attribute->name ?? 'Không xác định' }}:</strong>
                                {{ $vv->attributeValue->value ?? '-' }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Ảnh hiện tại --}}
                <div class="mb-3">
                    <label>Ảnh của biến thể:</label><br>

                    @if ($variant->images->count())
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            @foreach ($variant->images as $image)
                                <div style="position: relative; display: inline-block;">
                                    <img src="{{ asset($image->image_url) }}" width="100" class="img-thumbnail mb-1">

                                    {{-- Nút xoá ảnh --}}
                                    <form method="POST" action="{{ route('product-images.destroy', $image->id) }}"
                                          style="position: absolute; top: 0; right: 0;"
                                          onsubmit="return confirm('Bạn có chắc muốn xoá ảnh này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm p-1" style="font-size: 12px;">
                                            ✖
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">Chưa có ảnh nào cho biến thể này.</div>
                    @endif

                    {{-- Form thêm ảnh mới --}}
                    <label>Thêm ảnh mới:</label>
                    <input type="file" name="variant_images[{{ $variant->id }}][]" multiple class="form-control">
                </div>

            </div>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
