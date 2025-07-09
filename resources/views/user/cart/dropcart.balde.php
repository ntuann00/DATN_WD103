@extends('user.layouts.header')
<!-- chưa tác dụng -->
<!-- start cart -->
@section('cart')
<!-- start cart -->
                <div class="dropdown">
                    <!-- cart button -->
                    <button type="button" class="modal-btn header-cart-btn">
                        <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.0139 18H3.98532C1.86389 18 0.128174 16.2643 0.128174 14.1429V14.0143L0.513888 3.72857C0.578174 1.60714 2.31389 0 4.37103 0H13.6282C15.6853 0 17.421 1.60714 17.4853 3.72857L17.871 14.0143C17.9353 15.0429 17.5496 16.0071 16.8425 16.7786C16.1353 17.55 15.171 18 14.1425 18H14.0139ZM4.37103 1.28571C2.95675 1.28571 1.86389 2.37857 1.7996 3.72857L1.41389 14.1429C1.41389 15.5571 2.57103 16.7143 3.98532 16.7143H14.1425C14.8496 16.7143 15.4925 16.3929 15.9425 15.8786C16.3925 15.3643 16.6496 14.7214 16.6496 14.0143L16.2639 3.72857C16.1996 2.31429 15.1067 1.28571 13.6925 1.28571H4.37103Z" />
                            <path
                                d="M8.99951 7.71427C6.49237 7.71427 4.49951 5.72141 4.49951 3.21427C4.49951 2.82855 4.75665 2.57141 5.14237 2.57141C5.52808 2.57141 5.78523 2.82855 5.78523 3.21427C5.78523 5.01427 7.19951 6.42855 8.99951 6.42855C10.7995 6.42855 12.2138 5.01427 12.2138 3.21427C12.2138 2.82855 12.4709 2.57141 12.8567 2.57141C13.2424 2.57141 13.4995 2.82855 13.4995 3.21427C13.4995 5.72141 11.5067 7.71427 8.99951 7.71427Z" />
                        </svg>
                        <span>01</span> <!-- number in cart -->
                    </button>
                    <!-- cart button -->

                    <div class="cart-menu">
                        <!-- cart-item -->
                        <div class="cart-body">
                            <ul>
                                <li class="single-item">
                                    <div class="item-area">
                                        <div class="item-img">
                                            <img src="{{ asset('user/assets/img/home1/cart-img-1.png')}}" alt="">
                                            <!-- hình -->
                                        </div>
                                        <div class="content-and-quantity">
                                            <div class="content">
                                                <div class="price-and-btn d-flex align-items-center justify-content-between">
                                                    <span>giá <del>$giảm</del></span>
                                                    <button class="close-btn">
                                                         <i class="bi bi-x"></i> <!-- phim x -->
                                                    </button>
                                                </div>
                                                <p><a href="#">Tên sản phẩm</a></p>
                                            </div>
                                            <div class="quantity-area">
                                                <div class="quantity">
                                                    <a class="quantity__minus"><span><i class="bi bi-dash"></i></span></a>
                                                    <input name="quantity" type="text" class="quantity__input" value="01">
                                                    <a class="quantity__plus"><span><i class="bi bi-plus"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- end cart-item -->

                        <div class="cart-footer">

                            <!-- star cart price -->
                            <div class="pricing-area">
                                <ul class="total">
                                    <li><span>Tổng :</span><span>.Đ</span></li>
                                </ul>
                            </div>
                            <!-- end cart price  -->

                             <!-- cart-button  -->
                            <div class="footer-button">
                                <ul>
                                    <li><a class="primary-btn1 hover-btn4" href="{{ route('u.product') }}">Mua sắm thêm</a></li>
                                    <li><a class="primary-btn1 hover-btn3" href="{{ route('u.checkout') }}">Mua hàng</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end-cart -->
@endsection
