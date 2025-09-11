@extends('user.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Đánh giá sản phẩm cho đơn hàng #{{ $order->id }}</h4>

    @foreach($order->orderDetails as $detail)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $detail->product->name }}</h5>
                <form method="POST" action="{{ route('orders.review.submit', $order->id) }}">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    
                    <label>Đánh giá:</label>
                    <select name="rating" class="form-select w-auto d-inline" required>
                        <option value="5">5 sao</option>
                        <option value="4">4 sao</option>
                        <option value="3">3 sao</option>
                        <option value="2">2 sao</option>
                        <option value="1">1 sao</option>
                    </select>

                    <textarea name="comment" class="form-control my-2" required placeholder="Nhập bình luận..."></textarea>

                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
