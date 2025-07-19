<!-- Start Top-selling section -->
    <div class="top-selling-section mb-110">
        <div class="container">
            <div class="section-title3">
                <h3>Sản phẩm đề xuất <span>cho bạn</span></h3>
                <div class="slider-btn2">
                    <div class="top-sell-prev-btn">
                        <i class='bx bxs-chevron-left'></i>
                    </div>
                    <div class="top-sell-next-btn">
                        <i class='bx bxs-chevron-right'></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="swiper top-selling-slider">
                        <div class="swiper-wrapper">
                            @foreach($Tsell as $product)
                            <div class="swiper-slide">
                                <div class="product-card2">
                                    <div class="product-card-img">
                                        <a href="shop-list.html">
                                            <!-- img -->
                                            <img src="{{ asset('user/assets/img/home2/product-img-13.png')}}" alt="" class="img1">
                                        </a>
                                        <div class="cart-btn-area">
                                            <div class="cart-btn">
                                                <a href="cart.html" class="add-cart-btn2 round hover-btn5"><i class="bi bi-bag-check"></i> Add To Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-card-content">
                                        <p><a href="{{ route('u.category_product',$product->category->id) }}">{{ $product->category->name }}</a></p>
                                        <h6><a href="{{ route('u.product_detail',$product->id) }}" class="hover-underline">{{$product->name}}</a></h6>
                                        
                                        @foreach ($product->variants as $variant)
                                            <span>Giá: {{ number_format($variant->price) }} VNĐ</span> @break
                                        @endforeach

                                        <!-- <div class="rating">
                                            <ul>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                            </ul>
                                            <span>(50)</span>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Top-selling section -->
