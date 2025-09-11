@extends('admin.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-folder2-open"></i> Chi tiết danh mục
                    </h5>
                    <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>ID:</strong> {{ $category->id }}
                        </li>
                        <li class="list-group-item">
                            <strong>Tên danh mục:</strong> {{ $category->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Mô tả:</strong> {{ $category->description }}
                        </li>
                        <li class="list-group-item">
                            <strong>Trạng thái:</strong> {{ $category->status }}
                        </li>
                        <li class="list-group-item">
                            <strong>Ngày tạo:</strong> {{ $category->created_at->format('d/m/Y H:i') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Ngày cập nhật:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}
                        </li>
                    </ul>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Chỉnh sửa
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
