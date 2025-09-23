@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">🛍️ Thêm sản phẩm mới</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- 1. Thông tin sản phẩm cơ bản --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <input type="text" name="brand" class="form-control" placeholder="Nhập thương hiệu">
                </div>
                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label">Mã sản phẩm (SKU)</label>
                    <input type="text" name="sku" class="form-control" placeholder="Nhập SKU">
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control" placeholder="Nhập giá" required>
                </div> --}}
                {{-- <div class="mb-3">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="stock" class="form-control" placeholder="Nhập số lượng" required>
                </div> --}}
                <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Nhập mô tả sản phẩm"></textarea>
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label">Ảnh sản phẩm</label>
                    <input type="file" name="images[]" multiple class="form-control">
                </div> --}}
            </div>
        </div>

        {{-- 2. Section chứa biến thể --}}
        <div id="variantSection"></div>

        {{-- 3. Nút thêm biến thể --}}
        <div class="mb-4 text-center">
            <button type="button" id="addVariantsBtn" class="btn btn-secondary">
                ➕ Thêm 2 biến thể sản phẩm
            </button>
        </div>

        {{-- 4. Nút Submit & Quay lại --}}
        <div class="text-end">
            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">← Quay lại</a>
            <button type="submit" class="btn btn-success">💾 Thêm sản phẩm</button>
        </div>
    </form>

    {{-- 5. Template cho biến thể --}}
    <template id="variantTemplate">
        @for($k = 0; $k < 2; $k++)
        <div class="card variant-card mb-4 border-start border-primary border-3 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3 text-primary">Biến thể #<span class="variant-number"></span></h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">SKU</label>
                        <input type="text" data-name="variants[INDEX][sku]" class="form-control" placeholder="Nhập SKU biến thể">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giá</label>
                        <input type="number" data-name="variants[INDEX][price]" class="form-control" placeholder="Nhập giá biến thể">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Số lượng</label>
                        <input type="number" data-name="variants[INDEX][quantity]" class="form-control" placeholder="Nhập số lượng biến thể">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    @foreach($attributes as $attribute)
                        <div class="col-md-6">
                            <label class="form-label">{{ $attribute->name }}</label>
                            <select data-name="variants[INDEX][attributes][{{ $attribute->id }}]" class="form-select">
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
                    <input type="file" data-name="variant_images[INDEX][]" multiple class="form-control">
                    <div class="form-text">Bạn có thể chọn nhiều ảnh.</div>
                </div>
            </div>
        </div>
        @endfor
    </template>

    {{-- 6. Inline JS xử lý clone và mapping tên trường --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let variantIndex = 0;
            const btn = document.getElementById('addVariantsBtn');
            const section = document.getElementById('variantSection');
            const template = document.getElementById('variantTemplate');

            btn.addEventListener('click', () => {
                const clone = document.importNode(template.content, true);
                clone.querySelectorAll('.variant-card').forEach(card => {
                    const idx = variantIndex++;
                    card.querySelector('.variant-number').textContent = idx + 1;
                    card.querySelectorAll('[data-name]').forEach(el => {
                        el.setAttribute('name', el.getAttribute('data-name').replace(/INDEX/g, idx));
                    });
                });
                section.appendChild(clone);
            });
        });
    </script>
</div>
@endsection
