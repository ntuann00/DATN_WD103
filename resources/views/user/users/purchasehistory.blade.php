@extends('user.layouts.app')

@section('content')
<!-- Star Whistlist section -->
    <div class="whistlist-section cart mt-110 mb-110">
        <div class="container">
            <div class="row mb-50">
                <div class="col-12">
                    <div class="whistlist-table">
                        <table class="eg-table2">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- for -->
                                    @foreach ($orderDetails as $detail) 
                                    
                                    @php
                                        $product = $products->firstWhere('id', $detail->product_id);
                                        $variant = $variants->firstWhere('id', $detail->variant_id);
                                        $price = $variant->price ?? 0;
                                        $order = $orders->firstWhere('id', $detail->order_id);
                                    @endphp
                                    <!-- tên sp -->
                                    <td data-label="Product" class="table-product">
                                        <div class="product-img">
                                            <img src="assets/img/inner-page/whistlist-img1.png" alt="hình ảnh sản phẩm">
                                            <!-- hình ảnh -->
                                        </div>
                                        <div class="product-content">
                                            <h6><a href="{{ route('u.product_detail',$product->id) }}">
                                                {{ $product->name ?? 'Không rõ' }}
                                            </a></h6>
                                        </div>
                                    </td>

                                    <!-- đơn giá -->
                                    <td data-label="Price">
                                        <p class="price">
                                            {{ number_format($price) }}.đ
                                        </p>
                                    </td>

                                    <!-- số lượng -->
                                    <td data-label="Quantity">
                                        <div class="quantity-counter">
                                            <input name="quantity" type="text" class="quantity__input" value="{{ $detail->quantity }}" disabled>
                                        </div>
                                    </td>

                                    <!-- tổng -->
                                    <td data-label="Total">
                                        {{ number_format(($product->price ?? 0) * $detail->quantity) }}.đ
                                    </td>

                                    <!-- trạng thái -->
                                    <td data-label="Status">
                                        {{ $order->status_id}}
                                        <!-- số là gì nhỉ -->
                                    </td>

                                    <!-- thao tác -->
                                    <td>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('u.product_detail',$product->id) }}" 
                                            class="link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                            mua lại</a>

                                            <a href="{{ route('u.product_detail',$product->id) }}" 
                                            class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                            đánh giá</a>

                                            <a href="{{ route('refund',$order->id) }}" 
                                            class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                            trả hàng/hoàn tiền</a>
                                        </div>
                                    </td>
                                    @endforeach
                                    <!-- end for -->
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Whistlist section -->
@endsection