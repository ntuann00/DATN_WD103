@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📦 Danh sách sản phẩm</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Thương hiệu</th>
                <th>Danh mục</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

                {{-- Ảnh: ưu tiên ảnh product-level, nếu không có, lấy ảnh đầu tiên trong tất cả ảnh của các variant --}}
                <td>
                    @php
                        // Lấy ảnh chung đầu tiên
                        $img = $product->images->first();
                        if (! $img) {
                            // flatMap tất cả ảnh variant, rồi first
                            $img = $product->variants
                                ->flatMap(fn($v) => $v->images)
                                ->first();
                        }
                    @endphp

                    @if($img)
                        <img
                          src="{{ asset($img->image_url) }}"
                          alt="{{ $product->name }}"
                          class="img-thumbnail"
                          style="max-width:80px; max-height:80px;"
                        >
                    @else
                        <span class="text-muted">Không có ảnh</span>
                    @endif
                </td>

                <td>{{ $product->name }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ $product->category->name ?? '—' }}</td>
                <td>
                    @if($product->status)
                        <span class="badge bg-success">Còn hàng</span>
                    @else
                        <span class="badge bg-secondary">Hết hàng</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
