@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Thêm mã giảm giá</h2>

    <form action="{{ route('admin.discounts.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Mã giảm giá</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Giá trị giảm</label>
            <input type="number" name="discount_value" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Loại giảm giá</label>
            <select name="discount_type" class="form-control" required>
                <option value="percent">Giảm theo phần trăm (%)</option>
                <option value="amount">Giảm theo số tiền (VNĐ)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Giá trị đơn hàng tối thiểu</label>
            <input type="number" name="minimum_order_value" class="form-control">
        </div>

        <div class="mb-3">
            <label>Giá trị giảm tối đa</label>
            <input type="number" name="max_discount_value" class="form-control">
        </div>

        <div class="mb-3">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Tạo mới</button>
        <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
