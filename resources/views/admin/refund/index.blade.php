@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h2 class="my-4 fw-bold">Quản lý hoàn hàng/ hoàn tiền</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Lý do</th>
                        <th>Ghi chú</th>
                        <th>Ngày yêu cầu</th>
                        <th>Trạng thái</th>
                        <th colspan="2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($refunds as $refund)
                        <tr>
                            <td>{{ $refund->id }}</td>
                            <td>{{ $refund->reason}}</td>
                            <td>{{ $refund->description ?? '...' }}</td>
                            <td>{{ $refund->created_at->format('d-m-Y') }}</td>
                            <td>{{ $refund->status}}</td>

                            <td>
                                <a href="{{ route('admin.refund.detail', $refund->id) }}">Xem chi tiết</a>
                                <a href="">Hoàn thành</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
