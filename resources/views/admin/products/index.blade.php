@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <h1>Danh sách sản phẩm</h1>
        <style>
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
            th { background-color: #f4f4f4; }
        </style>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Danh mục</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if ($product->variants->first() && $product->variants->first()->images->first())
                            <img src="{{ asset($product->variants->first()->images->first()->image_url) }}"
                                alt="{{ $product->variants->first()->images->first()->alt_text }}"
                                width="70">
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </td>
                    </td>
                    <td>{{ $product->category->name ?? 'Không có danh mục'  }}</td>
                    <td>{{ $product->status ? 'Còn hàng' : 'Hết hàng' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-secondary">Chi tiết</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
@endsection
