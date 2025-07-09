@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách mã giảm giá</h2>
    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary mb-3">Thêm mã giảm giá</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã</th>
                <th>Loại</th>
                <th>Giá trị</th>
                <th>Số lượng</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $discount)
                <tr>
                    <td>{{ $discount->id }}</td>
                    <td>{{ $discount->code }}</td>
                    <td>
                        @if($discount->discount_type === 'amount')
                            Giảm theo số tiền
                        @elseif($discount->discount_type === 'percent')
                            Giảm theo phần trăm
                        @else
                            Không rõ
                        @endif
                    </td>
                    <td>
                        @if($discount->discount_type === 'percent')
                            {{ $discount->discount_value }}%
                        @else
                            {{ number_format($discount->discount_value, 0, ',', '.') }} đ
                        @endif
                    </td>
                    <td>{{ $discount->quantity }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }}
                        đến
                        {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xác nhận xóa?')" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
