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
<<<<<<< Updated upstream
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Thương hiệu</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
    <label class="form-label">SKU</label>
    {{-- Sync to first variant --}}
    <input type="hidden" name="variants[0][id]" value="{{ optional($product->variants->first())->id }}">
    <input type="text" name="variants[0][sku]" value="{{ old('variants.0.sku', optional($product->variants->first())->sku) }}" class="form-control">
</div>
                    <div class="col-md-4">
    <label class="form-label">Giá</label>
    <input type="number" name="variants[0][price]" value="{{ old('variants.0.price', optional($product->variants->first())->price) }}" class="form-control">
</div>
                    <div class="col-md-4">
    <label class="form-label">Số lượng</label>
    <input type="number" name="variants[0][quantity]" value="{{ old('variants.0.quantity', optional($product->variants->first())->quantity) }}" class="form-control">
</div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Ảnh sản phẩm</label>
                        <input type="file" name="images[]" multiple class="form-control">
                        <div class="form-text">Chọn để thay thế hoặc thêm mới ảnh sản phẩm.</div>
                        <div class="mt-2 d-flex flex-wrap gap-2">
                            @foreach($product->images as $img)
                                <img src="{{ asset($img->image_url) }}" class="img-thumbnail" style="max-width:100px;">
=======

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
>>>>>>> Stashed changes
                            @endforeach
                        </div>
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
