@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">🛍️ Thêm sản phẩm mới</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Thông tin sản phẩm --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <input type="text" name="brand" class="form-control" placeholder="Nhập thương hiệu">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Nhập mô tả chi tiết sản phẩm..."></textarea>
                </div>
            </div>
        </div>

        {{-- Biến thể --}}
        <h4 class="mb-3">🎯 Biến thể sản phẩm</h4>

        @for($i = 0; $i < 2; $i++)
        <div class="card mb-4 border-start border-primary border-3 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3 text-primary">Biến thể #{{ $i + 1 }}</h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">SKU</label>
                        <input type="text" name="variants[{{ $i }}][sku]" class="form-control" placeholder="Nhâp mã sản phẩm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giá</label>
                        <input type="number" name="variants[{{ $i }}][price]" class="form-control" placeholder="Nhâp giá sản phẩm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="variants[{{ $i }}][quantity]" class="form-control" placeholder="Nhâp số lượng sản phẩm">
                    </div>
                </div>

                {{-- Thuộc tính --}}
                <div class="row g-3 mb-3">
                    @foreach($attributes as $attribute)
                        <div class="col-md-6">
                            <label class="form-label">{{ $attribute->name }}</label>
                            <select name="variants[{{ $i }}][attributes][{{ $attribute->id }}]" class="form-select">
                                <option value="">-- Chọn {{ strtolower($attribute->name) }} --</option>
                                @foreach($attribute->values as $value)
                                    <option value="{{ $value->id }}">{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <div class="mb-2">
                    <label class="form-label">Ảnh cho biến thể</label>
                    <input type="file" name="variant_images[{{ $i }}][]" multiple class="form-control">
                    <div class="form-text">Bạn có thể chọn nhiều ảnh.</div>
                </div>
            </div>
        </div>
        @endfor

        <div class="text-end">
            <button type="submit" class="btn btn-success">💾 Thêm sản phẩm</button>
        </div>
    </form>
</div>
@endsection
