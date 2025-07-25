@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Sửa mã giảm giá</h2>

    <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Mã giảm giá</label>
            <input type="text" name="code" class="form-control" value="{{ $promotion->code }}" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ $promotion->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Giá trị giảm</label>
            <input type="number" name="discount_value" class="form-control" value="{{ $promotion->discount_value }}" required>
        </div>

        <div class="mb-3">
            <label>Loại giảm giá</label>
            <select name="discount_type" class="form-control" required>
                <option value="percent" {{ $promotion->discount_type == 'percent' ? 'selected' : '' }}>
                    Giảm theo phần trăm (%)
                </option>
                <option value="amount" {{ $promotion->discount_type == 'amount' ? 'selected' : '' }}>
                    Giảm theo số tiền (VNĐ)
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" name="quantity" class="form-control" value="{{ $promotion->quantity }}" required>
        </div>

        <div class="mb-3">
            <label>Giá trị đơn hàng tối thiểu</label>
            <input type="number" name="minimum_order_value" class="form-control" value="{{ $promotion->minimum_order_value }}">
        </div>

        <div class="mb-3">
            <label>Giá trị giảm tối đa</label>
            <input type="number" name="max_discount_value" class="form-control" value="{{ $promotion->max_discount_value }}">
        </div>

        <div class="mb-3">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control"
                value="{{ \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d') }}">
        </div>

        <div class="mb-3">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control"
                value="{{ \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d') }}">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('promotions.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
