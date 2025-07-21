@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Danh sách mã giảm giá</h2>
    <a href="{{ route('promotions.create') }}" class="btn btn-primary mb-3">Thêm mã giảm giá</a>
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
            @foreach($promotions as $Promotion)
                <tr>
                    <td>{{ $Promotion->id }}</td>
                    <td>{{ $Promotion->code }}</td>
                    <td>
                        @if($Promotion->discount_type === 'amount')
                            Giảm theo số tiền
                        @elseif($Promotion->discount_type === 'percent')
                            Giảm theo phần trăm
                        @else
                            Không rõ
                        @endif
                    </td>
                    <td>
                        @if($Promotion->discount_type === 'percent')
                            {{ $Promotion->discount_value }}%
                        @else
                            {{ number_format($Promotion->discount_value, 0, ',', '.') }} đ
                        @endif
                    </td>
                    <td>{{ $Promotion->quantity }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($Promotion->start_date)->format('d/m/Y') }}
                        đến
                        {{ \Carbon\Carbon::parse($Promotion->end_date)->format('d/m/Y') }}
                    </td>
                    <td>
                        <a href="{{ route('promotions.edit', $Promotion->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('promotions.destroy', $Promotion->id) }}" method="POST" style="display:inline-block;">
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
