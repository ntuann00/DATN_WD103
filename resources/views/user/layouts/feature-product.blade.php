<!-- Start Home2 Feature product section -->
    <div class="feature-product-section mb-110">
         <div class="container">

            <div class="section-title3">
                <h3>Sản phẩm <span>Mới lên kệ</span> </h3>
                <div class="view-all">
                    <a href="{{ route('u.product') }}">Xem tất cả
                        <svg width="33" height="13" viewBox="0 0 33 13" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M25.5083 7.28L0.491206 7.25429C0.36093 7.25429 0.23599 7.18821 0.143871 7.0706C0.0517519 6.95299 0 6.79347 0 6.62714C0 6.46081 0.0517519 6.3013 0.143871 6.18369C0.23599 6.06607 0.36093 6 0.491206 6L25.5088 6.02571C25.6391 6.02571 25.764 6.09179 25.8561 6.2094C25.9482 6.32701 26 6.48653 26 6.65286C26 6.81919 25.9482 6.9787 25.8561 7.09631C25.764 7.21393 25.6386 7.28 25.5083 7.28Z" />
                            <path
                                d="M33.0001 6.50854C29.2204 7.9435 24.5298 10.398 21.623 13L23.9157 6.50034L21.6317 0C24.5358 2.60547 29.2224 5.06539 33.0001 6.50854Z" />
                        </svg>
                    </a> 
                </div>
            </div>


            <div class="row g-4 justify-content-center">

                @foreach ($FProducts as $product)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                     <div class="product-card2">
                        <div class="batch">
                            <span>Mới</span>
                            <!-- <span>-15%</span> -->
                        </div>
                        <div class="product-card-img">
                           <a href="{{ route('u.product_detail',$product->id) }}">
                            <img src="{{ asset('user/assets/img/home2/product-img-1.png')}}" alt="">
                           </a>
                           <div class="cart-btn-area">
                               <div class="cart-btn">
                                   <a href="{{ route('u.product_detail',$product->id) }}" class="add-cart-btn2 round hover-btn5">Chi tiết</a>
                               </div>
                           </div>
                           <div class="view-and-favorite-area">
                                <ul>
                                    <li>
                                        <a data-bs-toggle="modal" data-bs-target="#product-view">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                <g clip-path="url(#clip0_1106_264)">
                                                  <path d="M15.3226 7.54747C15.1932 7.37042 12.1093 3.21228 8.17072 3.21228C4.23211 3.21228 1.14813 7.37042 1.01884 7.5473C0.959103 7.62915 0.92691 7.72785 0.92691 7.82918C0.92691 7.9305 0.959103 8.02921 1.01884 8.11105C1.14813 8.28811 4.23211 12.4462 8.17072 12.4462C12.1093 12.4462 15.1932 8.28808 15.3226 8.1112C15.3824 8.02939 15.4147 7.93068 15.4147 7.82933C15.4147 7.72799 15.3824 7.62928 15.3226 7.54747ZM8.17072 11.491C5.26951 11.491 2.75676 8.73117 2.01293 7.82894C2.75579 6.92591 5.26329 4.16751 8.17072 4.16751C11.0718 4.16751 13.5844 6.92687 14.3285 7.82959C13.5857 8.73259 11.0782 11.491 8.17072 11.491Z"/>
                                                  <path d="M8.17073 4.9635C6.5906 4.9635 5.30501 6.2491 5.30501 7.82923C5.30501 9.40936 6.5906 10.695 8.17073 10.695C9.75087 10.695 11.0365 9.40936 11.0365 7.82923C11.0365 6.2491 9.75087 4.9635 8.17073 4.9635ZM8.17073 9.73969C7.11726 9.73969 6.26027 8.88268 6.26027 7.82923C6.26027 6.77578 7.11728 5.91876 8.17073 5.91876C9.22418 5.91876 10.0812 6.77578 10.0812 7.82923C10.0812 8.88268 9.22421 9.73969 8.17073 9.73969Z"/>
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                           </div>
                        </div>
                        <div class="product-card-content">
                            <!-- danh muc -->
                            <p><a href="{{ route('u.product_detail',$product->id) }}">{{ $product->category->name }}</a></p> 
                            <!-- san pham -->
                            <h6><a href="{{ route('u.product_detail',$product->id) }}" class="hover-underline">{{$product->name}}</a></h6>
                            <span>
                            @foreach ($product->variants as $variant)
                                <p>Giá: {{ number_format($variant->price) }} VNĐ</p> @break
                            @endforeach
                            </span>
                            
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
         </div>
    </div>
    <!-- End Home2 Feature product section -->
