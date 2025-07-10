@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    {{-- Tiêu đề --}}
    <h2 class="mb-4 text-center fw-bold">{{ $Product->name }}</h2>

    <div class="row">
        {{-- Ảnh chính --}}
        <div class="col-md-6">
            @php
                $imgPath = $Product->image;
                $imgUrl  = $imgPath && file_exists(public_path($imgPath))
                           ? asset($imgPath)
                           : 'https://product.hstatic.net/1000006063/product/3ce_blush_lighter_atf_-_02_b483e7c8fa3b4c12b167fbade4e7537d_1024x1024.jpg';
            @endphp
            <img src="{{ $imgUrl }}"
                 alt="{{ $Product->name }}"
                 class="img-fluid w-100 rounded shadow-sm">
        </div>

        {{-- Thông tin sản phẩm --}}
        <div class="col-md-6">
            <p class="text-muted mb-1">Thương hiệu: {{ $Product->brand }}</p>
            @php $variant = $Product->variants->first(); @endphp
            @if($variant)
                <h3 class="text-danger mb-4">{{ number_format($variant->price, 0, ',', '.') }}₫</h3>

                @auth
                <form action="{{ route('cart.add', $variant->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="input-group" style="max-width: 150px;">
                        <button type="button" class="btn btn-outline-secondary decrement">-</button>
                        <input type="text" name="quantity" value="1" class="form-control text-center" readonly>
                        <button type="button" class="btn btn-outline-secondary increment">+</button>
                    </div>
                </div>
                <!-- end img hinh-anh -->

                <div class="col-lg-6">
                    <div class="shop-details-content">
                        <!-- name -->
                        <h1>{{$Product->name}}</h1>

                         <!-- review -->
                        <div class="rating-review">
                            <div class="rating">
                                <div class="star">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <p><a href="#reviews">(50 customer review)</a></p>
                            </div>
                        </div>
                        <!-- end review -->
                        <p>{{$Product->description}}</p>
                        <div class="price-area">
                            <p class="price">$150.00 <del>$200.00</del></p>
                        </div>
                        <div class="quantity-color-area">
                            <!-- số lượng -->
                            <div class="quantity-color">
                                <h6 class="widget-title">Quantity**</h6>
                                <div class="quantity-counter">
                                    <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                    <input name="quantity" type="text" class="quantity__input" value="01">
                                    <a href="#" class="quantity__plus"><i class='bx bx-plus' ></i></a>
                                </div>
                            </div>
                            <!-- biến thể -->
                            <div class="quantity-color">
                                <h6 class="widget-title">Color**</h6>
                                <ul class="color-list">
                                    <li class="select-wrap selected"><span></span></li>
                                    <li class="select-wrap"><span></span></li>
                                    <li class="select-wrap"><span></span></li>
                                    <li class="select-wrap"><span></span></li>
                                    <li class="select-wrap"><span></span></li>
                                    <li class="select-wrap"><span></span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="shop-details-btn">
                            <!-- add cart -->
                            <a href="#" class="primary-btn1 hover-btn3">*Add to Cart*</a>
                            <!-- check out / buy now-->
                            <a href="{{ route('checkout.form') }}" class="primary-btn1 style-3 hover-btn4">*Buy Now*</a>
                        </div>

                        <div class="product-info">
                            <ul class="product-info-list">
                                <li> <span>SKU:</span> *** </li>
                                <li> <span>Brand:</span> <a href="shop-4-columns.html">{{$Product->brand}}</a></li>
                                <li> <span>Category:</span> 
                                    <a href="shop-slider.html">{{$Product->category_id}}</a>
                                </li>
                            </ul>
                        </div>
                    <button type="submit" class="btn btn-success mt-3">
                        <i class="bi bi-cart-plus me-1"></i>Thêm vào giỏ
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary mb-4">Đăng nhập để mua</a>
                @endauth
            @else
                <div class="alert alert-warning">Sản phẩm hiện không có biến thể để bán.</div>
            @endif

            {{-- Mô tả --}}
            <h5 class="mt-4">Mô tả sản phẩm</h5>
            <p>{{ $Product->description }}</p>
        </div>
    </div>
    <!-- End Shop Details top section -->

<!-- Start Shop Details description section -->
    <div class="shop-details-description mb-110" id="reviews">
        <div class="container-xl container-lg-fluid container">
            <div class="row">
                <div class="col-12">
                    <div class="shop-details-description-nav mb-50">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">Recomment</button>
                              <button class="nav-link" id="nav-add-info-tab" data-bs-toggle="tab" data-bs-target="#nav-add-info" type="button" role="tab" aria-controls="nav-add-info" aria-selected="false">Additional Information</button>
                              <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab" aria-controls="nav-reviews" aria-selected="false">Reviews (15)</button>
                            </div>
                          </nav>
                    </div>
                    <div class="shop-details-description-tab">
                        <div class="tab-content" id="nav-tabContent">
                            <!-- description- chuyển thành recomment -->
                            <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                                <div class="row gy-5">
                                    
                                    <!-- content -->
                                     hehe

    {{-- Sản phẩm liên quan --}}
    @if(isset($Related) && $Related->count())
        <hr class="my-5">
        <h4 class="mb-4">Sản phẩm liên quan</h4>

        <div id="relatedCarousel" class="carousel slide position-relative" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @php $chunks = $Related->chunk(4); @endphp
                @foreach($chunks as $index => $group)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            @foreach($group as $item)
                                @php
                                    $relVariant = $item->variants->first();
                                    $path = $item->image;
                                    $img = ($path && file_exists(public_path($path)))
                                           ? asset($path)
                                           : 'https://product.hstatic.net/1000006063/product/3ce_blush_lighter_atf_-_02_b483e7c8fa3b4c12b167fbade4e7537d_1024x1024.jpg';
                                @endphp
                                @if(!$relVariant) @continue @endif
                                <div class="col">
                                    <a href="{{ route('u.product_detail', $item->id) }}" class="text-decoration-none text-dark">
                                        <div class="card h-100 shadow-sm">
                                        <img src="{{ $img }}"
                                            class="card-img-top"
                                            alt="{{ $item->name }}"
                                            style="height:180px; object-fit:cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title">
                                            {{ \Illuminate\Support\Str::limit($item->name, 30) }}
                                            </h6>
                                            <p class="text-danger fw-bold mt-auto">
                                            {{ number_format($relVariant->price,0,',','.') }}₫
                                            </p>
                                        </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Custom Controls with larger buttons --}}
            <button class="position-absolute top-50 start-0 translate-middle-y btn btn-light btn-lg rounded-circle" style="width:3rem; height:3rem; background-color:#f0f0f0;" type="button" data-bs-target="#relatedCarousel" data-bs-slide="prev">
                <i class="bi bi-chevron-left text-dark fs-3"></i>
            </button>
            <button class="position-absolute top-50 end-0 translate-middle-y btn btn-light btn-lg rounded-circle" style="width:3rem; height:3rem; background-color:#f0f0f0;" type="button" data-bs-target="#relatedCarousel" data-bs-slide="next">
                <i class="bi bi-chevron-right text-dark fs-3"></i>
            </button>
        </div>
    @endif
</div>

{{-- Script tăng giảm số lượng --}}
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
