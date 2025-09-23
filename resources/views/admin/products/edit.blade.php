@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Chỉnh sửa sản phẩm</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Thông tin sản phẩm cơ bản --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Thương hiệu</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

            </div>
        </div>

        {{-- Biến thể --}}
        <div id="variantSection">
            @foreach($product->variants as $idx => $variant)
            <div class="card variant-card mb-4 border-start border-primary border-3 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3 text-primary">Biến thể #{{ $idx + 1 }}</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label>SKU</label>
                            <input type="hidden" name="variants[{{ $idx }}][id]" value="{{ $variant->id }}">
                            <input type="text" name="variants[{{ $idx }}][sku]" value="{{ old('variants.'.$idx.'.sku', $variant->sku) }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Giá</label>
                            <input type="number" name="variants[{{ $idx }}][price]" value="{{ old('variants.'.$idx.'.price', $variant->price) }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Số lượng</label>
                            <input type="number" name="variants[{{ $idx }}][quantity]" value="{{ old('variants.'.$idx.'.quantity', $variant->quantity) }}" class="form-control">
                        </div>
                    </div>
                    @if($attributes->isNotEmpty())
                    <div class="row g-3 mb-3">
                        @foreach($attributes as $attr)
                        <div class="col-md-6">
                            <label>{{ $attr->name }}</label>
                            <select name="variants[{{ $idx }}][attributes][{{ $attr->id }}]" class="form-select">
                                <option value="">-- Chọn {{ $attr->name }} --</option>
                                @foreach($attr->values as $val)
                                    <option value="{{ $val->id }}" {{ old('variants.'.$idx.'.attributes.'.$attr->id, $variant->variantValues->pluck('attribute_value_id')->contains($val->id)) ? 'selected' : '' }}>{{ $val->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="mb-2">
                        <label>Ảnh biến thể</label>
                        <input type="file" name="variant_images[{{ $idx }}][]" multiple class="form-control">
                        <div class="form-text">Tải lên để thay thế hoặc thêm mới ảnh biến thể.</div>
                        <div class="mt-2 d-flex flex-wrap gap-2">
                            @foreach($variant->images as $vimg)
                                <img src="{{ asset($vimg->image_url) }}" class="img-thumbnail" style="max-width:80px;">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Nút thêm biến thể --}}
        <div class="mb-4 text-center">
            <button type="button" id="addVariantsBtn" class="btn btn-secondary">➕ Thêm 2 biến thể sản phẩm</button>
        </div>

        {{-- Nút submit & quay lại --}}
        <div class="text-end">
            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">Quay lại</a>
            <button type="submit" class="btn btn-success">💾 Cập nhật sản phẩm</button>
        </div>
    </form>

    {{-- Template clone giống create --}}
    <template id="variantTemplate">
        @for($k=0; $k<2; $k++)
        <div class="card variant-card mb-4 border-start border-primary border-3 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3 text-primary">Biến thể #<span class="variant-number"></span></h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label>SKU</label>
                        <input type="text" data-name="variants[INDEX][sku]" class="form-control" placeholder="Nhập SKU">
                    </div>
                    <div class="col-md-4">
                        <label>Giá</label>
                        <input type="number" data-name="variants[INDEX][price]" class="form-control" placeholder="Nhập giá">
                    </div>
                    <div class="col-md-4">
                        <label>Số lượng</label>
                        <input type="number" data-name="variants[INDEX][quantity]" class="form-control" placeholder="Nhập số lượng">
                    </div>
                </div>
                @if($attributes->isNotEmpty())
                <div class="row g-3 mb-3">
                    @foreach($attributes as $attr)
                    <div class="col-md-6">
                        <label>{{ $attr->name }}</label>
                        <select data-name="variants[INDEX][attributes][{{ $attr->id }}]" class="form-select">
                            <option value="">-- Chọn {{ $attr->name }} --</option>
                            @foreach($attr->values as $val)
                                <option value="{{ $val->id }}">{{ $val->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endforeach
                </div>
                @endif
                <div class="mb-2">
                    <label>Ảnh biến thể</label>
                    <input type="file" data-name="variant_images[INDEX][]" multiple class="form-control">
                    <div class="form-text">Tải lên để thêm hoặc thêm mới ảnh biến thể.</div>
                </div>
            </div>
        </div>
        @endfor
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let variantIndex = {{ $product->variants->count() }};
            const btn = document.getElementById('addVariantsBtn');
            const section = document.getElementById('variantSection');
            const tpl = document.getElementById('variantTemplate');
            btn.addEventListener('click', function() {
                const clone = document.importNode(tpl.content, true);
                clone.querySelectorAll('.variant-card').forEach(card => {
                    const idx = variantIndex++;
                    card.querySelector('.variant-number').textContent = idx + 1;
                    card.querySelectorAll('[data-name]').forEach(el => el.name = el.getAttribute('data-name').replace(/INDEX/g, idx));
                });
                section.appendChild(clone);
            });
        });
    </script>
</div>
@endsection
