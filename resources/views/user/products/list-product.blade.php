@extends('user.layouts.app')

@section('content')


<!-- Star Shop List section -->
    <div class="filter-sidebar">
        <div class="sidebar-area">
            <div class="shop-widget mb-30">
                <h5 class="shop-widget-title">Price Filter</h5>
                <div class="range-wrap">
                    <div class="row">
                        <div class="col-sm-12">
                        <form>
                            <input type="hidden" name="min-value" value="">
                            <input type="hidden" name="max-value" value="">
                        </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                        <div id="slider-range"></div>
                        </div>
                    </div>
                    <div class="slider-labels">
                        <div class="caption">
                            <span id="slider-range-value1"></span>
                        </div>
                        <a href="#">Apply</a>
                        <div class="caption">
                            <span id="slider-range-value2"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shop-widget mb-30">
                <div class="check-box-item">
                    <h5 class="shop-widget-title">Categories</h5>
                    <ul class="shop-item">
                        <li>
                            <a href="shop-list.html">All Product</a>
                        </li>
                        <li>
                            <a href="shop-list.html">Healthy & Natural</a>
                        </li>
                        <li>
                            <a href="shop-list.html">Beauty & Cosmetics</a>
                        </li>
                        <li>
                            <a href="shop-list.html">Selfcare Veggies</a>
                        </li>
                        <li>
                            <a href="shop-list.html">Personal Care</a>
                        </li>
                        <li>
                            <a href="shop-list.html">Men’s Collections</a>
                        </li>
                        <li>
                            <a href="shop-list.html">kids & Baby Set</a>
                        </li>
                        <li>
                            <a href="shop-list.html">Summer product</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="shop-widget mb-30">
                <div class="check-box-item">
                    <h5 class="shop-widget-title">Our Brand </h5>
                    <ul class="shop-item">
                        <li class="brand-list">
                            <a href="shop-list.html">Nivea
                                <span>50</span>
                            </a>
                        </li>
                        <li class="brand-list">
                            <a href="shop-list.html">Loreal
                                <span>35</span>
                            </a>
                        </li>
                        <li class="brand-list">
                            <a href="shop-list.html">Gillette
                                <span>20</span>
                            </a>
                        </li>
                        <li class="brand-list">
                            <a href="shop-list.html">Garnier
                                <span>18</span>
                            </a>
                        </li>
                        <li class="brand-list">
                            <a href="shop-list.html">Cetaphil
                                <span>06</span>
                            </a>
                        </li>
                        <li class="brand-list">
                            <a href="shop-list.html">Aveeno
                                <span>08</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="shop-widget">
                <h5 class="shop-widget-title">Top Rated Product</h5>
                <div class="top-product-widget mb-20">
                     <div class="top-product-img">
                         <a href="product-default.html"><img src="assets/img/inner-page/top-product1.png" alt=""></a>
                     </div>
                     <div class="top-product-content">
                         <h6><a href="product-default.html">Estee Lauder new Body Lotion</a></h6>
                         <span>$150.00 <del>$200.00</del></span>
                     </div>
                </div>
                <div class="top-product-widget mb-20">
                     <div class="top-product-img">
                        <a href="product-default.html"><img src="assets/img/inner-page/top-product2.png" alt=""></a>
                     </div>
                     <div class="top-product-content">
                         <h6><a href="product-default.html">Argan & Olive Nature organ Oil</a></h6>
                         <span>$130.00 <del>$200.00</del></span>
                     </div>
                </div>
                <div class="top-product-widget">
                     <div class="top-product-img">
                        <a href="product-default.html"><img src="assets/img/inner-page/top-product3.png" alt=""></a>
                     </div>
                     <div class="top-product-content">
                         <h6><a href="product-default.html">Char Pull black & gray Face Mask</a></h6>
                         <span>$110.00 <del>$200.00</del></span>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop-list-section mt-110 mb-110">
        <div class="container-lg container-fluid">
            <div class="shop-columns-title-section mb-40">
                <p>Showing 1–12 of 101 results</p>
                <div class="filter-selector">
                    <div class="filter">
                        <div class="filter-icon">
                            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_456_25)">
                                    <path
                                        d="M0.5625 3.17317H9.12674C9.38486 4.34806 10.4341 5.2301 11.6853 5.2301C12.9366 5.2301 13.9858 4.3481 14.2439 3.17317H17.4375C17.7481 3.17317 18 2.92131 18 2.61067C18 2.30003 17.7481 2.04817 17.4375 2.04817H14.2437C13.9851 0.873885 12.9344 -0.00871277 11.6853 -0.00871277C10.4356 -0.00871277 9.38545 0.873744 9.12695 2.04817H0.5625C0.251859 2.04817 0 2.30003 0 2.61067C0 2.92131 0.251859 3.17317 0.5625 3.17317ZM10.191 2.61215L10.191 2.6061C10.1935 1.78461 10.8638 1.11632 11.6853 1.11632C12.5057 1.11632 13.1761 1.78369 13.1796 2.6048L13.1797 2.61306C13.1784 3.43597 12.5086 4.10513 11.6853 4.10513C10.8625 4.10513 10.1928 3.43663 10.191 2.61422L10.191 2.61215ZM17.4375 14.8268H14.2437C13.985 13.6525 12.9344 12.7699 11.6853 12.7699C10.4356 12.7699 9.38545 13.6524 9.12695 14.8268H0.5625C0.251859 14.8268 0 15.0786 0 15.3893C0 15.7 0.251859 15.9518 0.5625 15.9518H9.12674C9.38486 17.1267 10.4341 18.0087 11.6853 18.0087C12.9366 18.0087 13.9858 17.1267 14.2439 15.9518H17.4375C17.7481 15.9518 18 15.7 18 15.3893C18 15.0786 17.7481 14.8268 17.4375 14.8268ZM11.6853 16.8837C10.8625 16.8837 10.1928 16.2152 10.191 15.3928L10.191 15.3908L10.191 15.3847C10.1935 14.5632 10.8638 13.8949 11.6853 13.8949C12.5057 13.8949 13.1761 14.5623 13.1796 15.3834L13.1797 15.3916C13.1785 16.2146 12.5086 16.8837 11.6853 16.8837ZM17.4375 8.43751H8.87326C8.61514 7.26262 7.56594 6.38062 6.31466 6.38062C5.06338 6.38062 4.01418 7.26262 3.75606 8.43751H0.5625C0.251859 8.43751 0 8.68936 0 9.00001C0 9.31068 0.251859 9.56251 0.5625 9.56251H3.75634C4.01498 10.7368 5.06559 11.6194 6.31466 11.6194C7.56439 11.6194 8.61455 10.7369 8.87305 9.56251H17.4375C17.7481 9.56251 18 9.31068 18 9.00001C18 8.68936 17.7481 8.43751 17.4375 8.43751ZM7.80901 8.99853L7.80898 9.00458C7.80652 9.82607 7.13619 10.4944 6.31466 10.4944C5.49429 10.4944 4.82393 9.82699 4.82038 9.00591L4.82027 8.99769C4.8215 8.17468 5.49141 7.50562 6.31466 7.50562C7.13753 7.50562 7.80718 8.17408 7.80905 8.99653L7.80901 8.99853Z" />
                                </g>
                            </svg>
                        </div>
                         <span>Filters</span>
                    </div>
                    <div class="selector">
                        <select>
                            <option>Mặc định</option>
                            <option>Giá từ thấp đến cao</option>
                            <option>Giá từ cao đến thấp</option>
                          </select>
                    </div>
                    <ul class="grid-view">
                        <li class="column-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="20" viewBox="0 0 12 20">
                                <g>
                                    <rect width="4.88136" height="5.10638" rx="2.44068" />
                                    <rect y="7.44678" width="4.88136" height="5.10638" rx="2.44068" />
                                    <rect y="14.8937" width="4.88136" height="5.10638" rx="2.44068" />
                                    <rect x="7.11865" width="4.88136" height="5.10638" rx="2.44068" />
                                    <rect x="7.11865" y="7.44678" width="4.88136" height="5.10638" rx="2.44068" />
                                    <rect x="7.11865" y="14.8937" width="4.88136" height="5.10638" rx="2.44068" />
                                </g>
                            </svg>
                        </li>
                        <li class="column-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                <g clip-path="url(#clip0_1610_1442)">
                                    <rect width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect y="7.44678" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect y="14.8937" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect x="7.44678" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect x="7.44678" y="7.44678" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect x="7.44678" y="14.8937" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect x="14.8936" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect x="14.8936" y="7.44678" width="5.10638" height="5.10638" rx="2.55319" />
                                    <rect x="14.8936" y="14.8937" width="5.10638" height="5.10638" rx="2.55319" />
                                </g>
                            </svg>
                        </li>
                        <li class="column-4 active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                <g clip-path="url(#clip0_1610_1453)">
                                  <rect width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect y="8.17627" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect y="16" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="5.31909" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="5.31909" y="8.17627" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="5.31909" y="16" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="10.6382" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="16.3525" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="10.6384" y="8.17627" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="16.3525" y="8.17627" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="10.6382" y="16" width="3.64741" height="3.64741" rx="1.8237"/>
                                  <rect x="16.3525" y="16" width="3.64741" height="3.64741" rx="1.8237"/>
                                </g>
                              </svg>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="all-products list-grid-product-wrap">
                <div class="row gy-4 mb-80 ">
                    <!-- single item -->

                    @foreach($Products as $product)
                        @php
                            // Lấy variant đầu tiên (có thể null)
                            $variant = $product->variants->first();
                        @endphp

                        {{-- Nếu không có variant, bỏ qua luôn hoặc hiển thị message --}}
                        @if(! $variant)
                            {{-- bỏ qua sản phẩm này --}}
                            @continue
                        @endif

                        <div class="col-lg-3 col-md-4 col-sm-6 item">
                            <div class="product-card style-3 hover-btn">
                                <div class="product-card-img">
                                    <a href="{{ route('u.product_detail', $product->id) }}">
                                        {{-- <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img1"> --}}
                                        <img src="https://product.hstatic.net/1000006063/product/3ce_blush_lighter_atf_-_02_b483e7c8fa3b4c12b167fbade4e7537d_1024x1024.jpg" alt="">
                                    </a>
                                    <div class="overlay">
                                        <div class="cart-area">
                                            @auth
                                            <form action="{{ route('cart.add', $variant->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="hover-btn3 add-cart-btn">
                                                    <i class="bi bi-bag-check"></i> Thêm vào giỏ
                                                </button>
                                            </form>
                                            @else
                                            <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập để thêm vào giỏ</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                <div class="product-card-content">
                                    <h6>
                                        <a href="{{ route('u.product_detail', $product->id) }}" class="hover-underline">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    <p>{{ $product->brand }}</p>
                                    <p class="price">
                                        {{ number_format($variant->price, 0, ',', '.') }}₫
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
            @foreach($Products as $product)
                @php
                    // Lấy variant đầu tiên (có thể null)
                    $variant = $product->variants->first();
                @endphp

                {{-- Nếu không có variant, bỏ qua luôn hoặc hiển thị message --}}
                @if(! $variant)
                    {{-- bỏ qua sản phẩm này --}}
                    @continue
                @endif

                <div class="col-lg-3 col-md-4 col-sm-6 item">
                    <div class="product-card style-3 hover-btn">
                        <div class="product-card-img">
                            <a href="{{ route('u.product_detail', $product->id) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img1">
                            </a>
                            <div class="overlay">
                                <div class="cart-area">
                                    @auth
                                    <form action="{{ route('cart.add', $variant->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="hover-btn3 add-cart-btn">
                                            <i class="bi bi-bag-check"></i> Thêm vào giỏ
                                        </button>
                                    </form>
                                    @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập để thêm vào giỏ</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="product-card-content">
                            <h6>
                                <a href="{{ route('u.product_detail', $product->id) }}" class="hover-underline">
                                    {{ $product->name }}
                                </a>
                            </h6>
                            <p>{{ $product->brand }}</p>
                            <p class="price">
                                {{ number_format($variant->price, 0, ',', '.') }}₫
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
                    <!-- single item -->
                </div>
            </div>
            <nav class="shop-pagination">
                <ul class="pagination-list">
                    <li>
                        <a href="#" class="shop-pagi-btn"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li>
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#" class="active">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#"><i class="bi bi-three-dots"></i></a>
                    </li>
                    <li>
                        <a href="#">6</a>
                    </li>
                    <li>
                        <a href="#" class="shop-pagi-btn"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- End Shop List section -->


    <!-- Star Gift section section -->
    <div class="gift-section">
        <img src="assets/img/home1/gift-card-img1.png" alt="" class="gift-img1">
        <img src="assets/img/home1/gift-card-img2.png" alt="" class="gift-img2">
        <div class="container-lg container-fluid">
            <div class="gift-wrapper">
                <h5>BEAUTICO GIFT CARD</h5>
                <div class="gift-card-content">
                    <p>Whatever your summer looks like, bring your own heat with up to 25% off Lumin Brand.Pellentesque ipsum dui.</p>
                </div>
                <a href="gift-card.html" class="primary-btn1 hover-btn3">*Shop Gift Cards*</a>
            </div>
        </div>
    </div>
    <!-- End Gift section section -->
@endsection
