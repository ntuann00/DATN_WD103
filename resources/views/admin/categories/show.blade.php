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
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm">
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
