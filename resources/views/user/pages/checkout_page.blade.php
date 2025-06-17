@extends('user.layouts.app')

@section('content')
<!-- ========== Checkout Section Start============= -->
    <div class="checkout-section pt-110 mb-110">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-7">
                    <div class="form-wrap mb-30">
                        <h4>Billing Details</h4>
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>First Name</label>
                                        <input type="text" name="fname" placeholder="Your first name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>Last Name</label>
                                        <input type="text" name="fname" placeholder="Your last name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>Country / Region</label>
                                        <input type="text" name="fname" placeholder="Your country name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>Street Address</label>
                                        <input type="text" name="fname" placeholder="House and street name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <select>
                                            <option>Town / City</option>
                                            <option>Dhaka</option>
                                            <option>Saidpur</option>
                                            <option>Newyork</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="text" name="fname" placeholder="Post Code">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>Additional Information</label>
                                        <input type="text" name="fname" placeholder="Your Phone Number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="email" name="email" placeholder="Your Email Address">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="text" name="postcode" placeholder="Post Code">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <textarea name="message" placeholder="Order Notes (Optional)" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-wrap box--shadow">
                        <h4>Ship to a Different Address?</h4>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>First Name</label>
                                        <input type="text" name="fname" placeholder="Your first name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Last Name</label>
                                        <input type="text" name="fname" placeholder="Your last name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <textarea name="message" placeholder="Order Notes (Optional)" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="added-product-summary mb-30">
                        <h5>Order Summary</h5>
                        <ul class="added-products">
                            <li class="single-product">
                                <div class="product-area">
                                    <div class="product-img">
                                        <img src="assets/img/inner-page/checkout-product-img1.png" alt="">
                                    </div>
                                    <div class="product-info">
                                        <h5><a href="#">Brand new Nail Polish</a></h5>
                                        <div class="product-total">
                                            <div class="quantity-counter">
                                                <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                                <input name="quantity" type="text" class="quantity__input" value="01">
                                                <a href="#" class="quantity__plus"><i class='bx bx-plus'></i></a>
                                            </div>
                                            <strong> <i class="bi bi-x-lg px-2"></i>
                                                <span class="product-price">$39.00</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="delete-btn">
                                    <i class='bx bx-x'></i>
                                </div>
                            </li>
                            <li class="single-product">
                                <div class="product-area">
                                    <div class="product-img">
                                        <img src="assets/img/inner-page/checkout-product-img2.png" alt="">
                                    </div>
                                    <div class="product-info">
                                        <h5><a href="#">Brand new Face Product</a></h5>
                                        <div class="product-total">
                                            <div class="quantity-counter">
                                                <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                                <input name="quantity" type="text" class="quantity__input" value="01">
                                                <a href="#" class="quantity__plus"><i class='bx bx-plus'></i></a>
                                            </div>
                                            <strong> <i class="bi bi-x-lg px-2"></i>
                                                <span class="product-price">$60.00</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="delete-btn">
                                    <i class='bx bx-x'></i>
                                </div>
                            </li>
                            <li class="single-product">
                                <div class="product-area">
                                    <div class="product-img">
                                        <img src="assets/img/inner-page/checkout-product-img3.png" alt="">
                                    </div>
                                    <div class="product-info">
                                        <h5><a href="#">Brand new Shampoo</a></h5>
                                        <div class="product-total">
                                            <div class="quantity-counter">
                                                <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                                <input name="quantity" type="text" class="quantity__input" value="01">
                                                <a href="#" class="quantity__plus"><i class='bx bx-plus'></i></a>
                                            </div>
                                            <strong> <i class="bi bi-x-lg px-2"></i>
                                                <span class="product-price">$40.00</span>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="delete-btn">
                                    <i class='bx bx-x'></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="cost-summary mb-30">
                        <table class="table cost-summary-table">
                            <thead>
                                <tr>
                                    <th>Subtotal</th>
                                    <th>$128.70</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tax">Tax</td>
                                    <td>$5</td>
                                </tr>
                                <tr>
                                    <td>Total ( tax excl.)</td>
                                    <td>$15</td>
                                </tr>
                                <tr>
                                    <td>Total ( tax incl.)</td>
                                    <td>$15</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cost-summary total-cost mb-30">
                        <table class="table cost-summary-table total-cost">
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <th>$162.70</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <form class="payment-form">
                        <div class="payment-methods mb-30">
                            <ul class="payment-list">
                                <li class="check-payment">
                                    <div class="form-check payment-check">
                                        <h6>Check payments</h6>
                                        <p class="para">Please send a check to Store Name, Store Street, Store State / Country, Store Postcode.</p>
                                    </div>
                                    <div class="checked">
                                    </div>
                                </li>
                                <li class="cash-delivary">
                                    <div class="form-check payment-check">
                                        <h6>Cash on delivery</h6>
                                        <p class="para">Pay with cash upon delivery.</p>
                                    </div>
                                    <div class="checked">
                                    </div>
                                </li>
                                <li class="paypal">
                                    <div class="form-check payment-check paypal">
                                        <h6>Paypal</h6>
                                        <img src="assets/img/inner-page/payment.png" alt="">
                                        <a href="#" class="about-paypal">What is PayPal?</a>
                                    </div>
                                    <div class="checked">
                                    </div>
                                </li>
                                <li class="stripe">
                                    <h6>Card</h6>
                                    <div class="checked">
                                    </div>
                                </li>
                            </ul>
                            <div class="choose-payment-method pt-25 pb-25" id="strip-payment" style="display: none;">
                                <h5>Select Your Payment Method</h5>
                                <div class="row gy-4 g-4">
                                    <div class="col-md-12">
                                        <div class="input-area">
                                            <label>Card Number</label>
                                            <div class="input-field">
                                                <input type="text" placeholder="1234 1234 1234 1234">
                                                <img src="assets/img/inner-page/payment.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="input-area">
                                            <label>Expiration Date</label>
                                            <div class="row gy-4">
                                                <div class="col-sm-6">
                                                    <select>
                                                        <option>Month</option>
                                                        <option>January</option>
                                                        <option>February</option>
                                                        <option>March</option>
                                                        <option>April</option>
                                                        <option>May</option>
                                                        <option>June</option>
                                                        <option>July</option>
                                                        <option>August</option>
                                                        <option>September</option>
                                                        <option>October</option>
                                                        <option>November</option>
                                                        <option>December</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <select>
                                                        <option>Day</option>
                                                        <option>01</option>
                                                        <option>02</option>
                                                        <option>03</option>
                                                        <option>04</option>
                                                        <option>05</option>
                                                        <option>06</option>
                                                        <option>07</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="input-area">
                                            <label>CVC</label>
                                            <input type="text" placeholder="123">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="payment-form-bottom d-flex align-items-start">
                                <input type="checkbox" class="custom-check-box" id="terms">
                                <label for="terms">I have read and agree to the website <a href="#">Terms and
                                        conditions</a></label>
                            </div>
                        </div>
                        <div class="place-order-btn">
                            <button type="submit" class="primary-btn1 hover-btn3">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- ========== Checkout Section end============= -->
@endsection
