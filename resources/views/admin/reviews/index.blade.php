@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="my-4 fw-bold">Quản lý bình luận</h2>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Sản phẩm</th>
                        <th>Số sao</th>
                        <th>Bình luận</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td class="text-center">{{ $review->id }}</td>
                            <td>{{ $review->user->name ?? 'N/A' }}</td>
                            <td>{{ $review->product->ten ?? 'N/A' }}</td>
                            <td class="text-center">{{ $review->rating }}</td>
                            <td>{{ $review->comment }}</td>
                            <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
