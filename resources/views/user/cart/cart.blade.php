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
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="delete-icon">
                                            <i class="bi bi-x-lg"></i>
                                        </div>
                                    </td>
                                    <td data-label="Product" class="table-product">
                                        <div class="product-img">
                                            <img src="assets/img/inner-page/whistlist-img1.png" alt="">
                                        </div>
                                        <div class="product-content">
                                            <h6><a href="#">Eau De Blue Perfume</a></h6>
                                        </div>
                                    </td>
                                    <td data-label="Price">
                                        <p class="price">
                                            <del>$40.00</del>
                                            $30.00
                                        </p>
                                    </td>
                                    <td data-label="Quantity">
                                        <div class="quantity-counter">
                                            <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                            <input name="quantity" type="text" class="quantity__input" value="01">
                                            <a href="#" class="quantity__plus"><i class='bx bx-plus' ></i></a>
                                        </div>
                                    </td>
                                    <td data-label="Total">
                                        $30.00
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="delete-icon">
                                            <i class="bi bi-x-lg"></i>
                                        </div>
                                    </td>
                                    <td data-label="Product" class="table-product">
                                        <div class="product-img">
                                            <img src="assets/img/inner-page/whistlist-img2.png" alt="">
                                        </div>
                                        <div class="product-content">
                                            <h6><a href="#">Smooth Makeup Box</a></h6>
                                        </div>
                                    </td>
                                    <td data-label="Price">
                                        <p class="price">
                                            <del>$40.00</del>
                                            $25.00
                                        </p>
                                    </td>
                                    <td data-label="Quantity">
                                        <div class="quantity-counter">
                                            <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                            <input name="quantity" type="text" class="quantity__input" value="01">
                                            <a href="#" class="quantity__plus"><i class='bx bx-plus' ></i></a>
                                        </div>
                                    </td>
                                    <td data-label="Total">
                                        $50.00
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="delete-icon">
                                            <i class="bi bi-x-lg"></i>
                                        </div>
                                    </td>
                                    <td data-label="Product" class="table-product">
                                        <div class="product-img">
                                            <img src="assets/img/inner-page/whistlist-img3.png" alt="">
                                        </div>
                                        <div class="product-content">
                                            <h6><a href="#">Modern Red Lipstick</a></h6>
                                        </div>
                                    </td>
                                    <td data-label="Price">
                                        <p class="price">
                                            <del>$40.00</del>
                                            $32.00
                                        </p>
                                    </td>
                                    <td data-label="Quantity">
                                        <div class="quantity-counter">
                                            <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                            <input name="quantity" type="text" class="quantity__input" value="01">
                                            <a href="#" class="quantity__plus"><i class='bx bx-plus' ></i></a>
                                        </div>
                                    </td>
                                    <td data-label="Total">
                                        $30.00
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="coupon-area">
                        <div class="cart-coupon-input">
                            <h5>Coupon Code</h5>
                            <form>
                                <div class="form-inner">
                                    <input type="text" placeholder="Coupon Code">
                                    <button type="submit" class="primary-btn1 hover-btn3">Apply Code</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Cart Totals</th>
                                <th></th>
                                <th>$128.70</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Shipping</td>
                                <td>
                                    <ul class="cost-list text-start">
                                        <li>Shipping Fee</li>
                                        <li>Total ( tax excl.)</li>
                                        <li>Total ( tax incl.)</li>
                                        <li>Taxes</li>
                                        <li>Shipping Enter your address to view shipping options. <br> <a href="#">Calculate
                                                shipping</a>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="single-cost text-center">
                                        <li>Fee</li>
                                        <li>$15</li>
                                        <li></li>
                                        <li>$15</li>
                                        <li>$15</li>
                                        <li>$5</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td></td>
                                <td>$162.70</td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="primary-btn1 hover-btn3">Product Checkout</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Whistlist section -->
@endsection
