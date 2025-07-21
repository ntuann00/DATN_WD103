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
                        <th>Rating</th>
                        <th>Bình luận</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        @php
                            $bannedWords = ['đm', 'lồn', 'ngu', 'vãi', 'xxx', 'quảng cáo', 'chết'];
                            $isBad = false;
                            foreach ($bannedWords as $word) {
                                if (stripos($review->comment, $word) !== false) {
                                    $isBad = true;
                                    break;
                                }
                            }
                        @endphp
                        <tr class="{{ $isBad ? 'table-warning' : '' }}">
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->user->name ?? 'Ẩn danh' }}</td>
                            <td>{{ $review->product->name ?? '[Sản phẩm đã xóa]' }}</td>
                            <td class="text-center">{{ $review->rating }} ★</td>
                            <td>{{ $review->comment }}</td>
                            <td>
                                @if ($isBad)
                                    <span class="badge bg-danger">Ẩn với người dùng</span>
                                @else
                                    <span class="badge bg-success">Bình thường</span>
                                @endif
                            </td>
                            <td>{{ $review->created_at->format('d-m-Y H:i') }}</td>
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
