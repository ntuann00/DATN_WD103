@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    {{-- Tiêu đề --}}
    <h2 class="mb-4 text-center fw-bold">{{ $Product->name }}</h2>

    <div class="row">
        {{-- Ảnh --}}
        <div class="col-md-6">
            @php
                $imgPath = $Product->image;
                $imgUrl  = $imgPath && file_exists(public_path($imgPath))
                           ? asset($imgPath)
                           : 'https://product.hstatic.net/1000006063/product/3ce_blush_lighter_atf_-_02_b483e7c8fa3b4c12b167fbade4e7537d_1024x1024.jpg';
            @endphp
            <img src="{{ $imgUrl }}" alt="{{ $Product->name }}" class="img-fluid w-100 rounded shadow-sm">
        </div>

        {{-- Thông tin --}}
        <div class="col-md-6">
            <p class="text-muted mb-1">Thương hiệu: {{ $Product->brand }}</p>
            @php $variant = $Product->variants->first(); @endphp

            @if($variant)
                <h3 class="text-danger mb-4">{{ number_format($variant->price, 0, ',', '.') }}₫</h3>

                @auth
                <form action="{{ route('cart.add', $variant->id) }}" method="POST">
                    @csrf
                    <div class="input-group mb-3" style="max-width: 160px;">
                        <button type="button" class="btn btn-outline-secondary decrement">-</button>
                        <input type="text" name="quantity" value="1" class="form-control text-center" readonly>
                        <button type="button" class="btn btn-outline-secondary increment">+</button>
                    </div>

                    <div class="col-lg-6">
                        <div class="shop-details-content">
                            <h1>{{ $Product->name }}</h1>
                            <div class="rating-review">
                                <div class="rating">
                                    <div class="star">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <p>{{ $Product->comment }}</p>
                                </div>
                            </div>
                            <p>{{ $Product->description }}</p>
                            <div class="price-area">
                                <p class="price">{{ number_format($variant->price, 0, ',', '.') }}Đ
                                    <del>{{ number_format($variant->price, 0, ',', '.') }}</del>
                                </p>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                <div class="quantity-color-area">


                                    <ul class="color-list"
                                        style="display: flex; gap: 8px; list-style: none; padding: 0; outline: none; box-shadow: none;">
                                        @foreach ($attributeGroups as $attrName => $values)
                                            <div class="attribute-group" style="margin-bottom: 12px;">
                                                <label class="attribute-label"
                                                    style="font-weight: bold; display: block; margin-bottom: 6px;">
                                                    {{ $attrName }}
                                                </label>
                                                <div class="attribute-values"
                                                    style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                    @foreach ($values as $value)
                                                        <input type="radio"
                                                            name="attribute[{{ $value->attribute_id }}]"
                                                            value="{{ $value->id }}" id="attr_{{ $value->id }}"
                                                            class="btn-check" required>

                                                        <label for="attr_{{ $value->id }}"
                                                            class="btn btn-outline-dark"
                                                            style="min-width: 70px; text-align: center;">
                                                            {{ $value->value }}
                                                            <br>
                                                        </label>
                                                        <br>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach

                                    </ul>

                                </div>

                                 <div class="quantity-color-area">
                                    <div class="quantity-color">
                                        <h6 class="widget-title">Quantity</h6>
                                        <div class="quantity-counter">
                                            <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                            <input name="quantity" type="number" class="quantity__input" value="1"
                                                min="1">
                                            <a href="#" class="quantity__plus"><i class='bx bx-plus'></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="shop-details-btn">
                                    <a href="{{ route('cart.add', $variant->id) }}" class="primary-btn1 hover-btn3">*Buy
                                        Now*</a>
                                    <form action="{{ route('cart.add', $variant->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="primary-btn1 style-3 hover-btn4">*Add to
                                            Cart*</button>
                                    </form>
                                </div>
                            </form>


    {{-- Mô tả và đánh giá --}}
    <div class="shop-details-description mt-5" id="reviews">
        <ul class="nav nav-tabs" id="tabContent">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#description">Mô tả</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#review">Đánh giá</a>
            </li>
        </ul>

        <div class="tab-content p-4 border border-top-0 rounded-bottom">
            {{-- Tab Mô tả --}}
            <div class="tab-pane fade show active" id="description">
                {{ $Product->description }}
            </div>

            {{-- Tab Đánh giá --}}
            <div class="tab-pane fade" id="review">
                <h4>Đánh giá sản phẩm</h4>
                @if($filteredReviews->isEmpty())
                    <p>Chưa có đánh giá nào.</p>
                @else
                    @foreach($filteredReviews as $review)
                        <div class="border rounded p-2 mb-2">
                            <strong>{{ $review->user->name ?? 'Ẩn danh' }}</strong>
                            <span class="text-warning">({{ $review->rating }} ★)</span>
                            <p>{{ $review->comment }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Sản phẩm liên quan --}}
    @if(isset($Related) && $Related->count())
        <hr class="my-5">
        <h4 class="mb-4">Sản phẩm liên quan</h4>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($Related as $item)
                @php
                    $relVariant = $item->variants->first();
                    $path = $item->image;
                    $img = ($path && file_exists(public_path($path))) ? asset($path) : 'https://product.hstatic.net/1000006063/product/3ce_blush_lighter_atf_-_02_b483e7c8fa3b4c12b167fbade4e7537d_1024x1024.jpg';
                @endphp
                @if(!$relVariant) @continue @endif
                <div class="col">
                    <a href="{{ route('u.product_detail', $item->id) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $img }}" class="card-img-top" alt="{{ $item->name }}" style="height:180px; object-fit:cover;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ \Illuminate\Support\Str::limit($item->name, 30) }}</h6>
                                <p class="text-danger fw-bold mt-auto">{{ number_format($relVariant->price,0,',','.') }}₫</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Script tăng/giảm số lượng --}}
<script>
    document.querySelectorAll('.increment').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.previousElementSibling;
            input.value = parseInt(input.value) + 1;
        });
    });
    document.querySelectorAll('.decrement').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.nextElementSibling;
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
</script>
@endsection

