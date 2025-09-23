@extends('user.layouts.app')

@section('content')
    <div class="container py-5">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tiêu đề --}}
        {{--
        <pre>{{ dd($Product->variants) }}</pre> --}}

        {{-- <h2 class="mb-4 text-center fw-bold">{{ $Product->name }}</h2> --}}

        <div class="row">
            {{-- Ảnh chính --}}


            {{-- Thông tin sản phẩm --}}
            <div class="shop-details-top-section">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="shop-details-img">
                            <div class="tab-content" id="view-tabContent">

                                @foreach ($Product->variants as $variant)
                                    @foreach ($variant->images as $image)
                                        <div class="tab-pane fade {{ $loop->first && $loop->parent->first ? 'show active' : '' }}"
                                            id="view-pills-img{{ $loop->parent->index }}-{{ $loop->index }}"
                                            role="tabpanel"
                                            aria-labelledby="view-pills-img{{ $loop->parent->index }}-{{ $loop->index }}-tab">

                                            <div class="shop-details-tab-img">
                                                <img src="{{ asset($image->image_url) }}" alt="{{ $image->alt_text }}">
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach

                                {{-- <div class="tab-pane fade" id="view-pills-img2" role="tabpanel">


                                    <div class="shop-details-tab-img">
                                        <img src="{{ asset('uploads/products/' . $Product->image) }}" alt="Product Image">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="view-pills-img2" role="tabpanel">
                                    <div class="shop-details-tab-img">
                                        <img src="{{ $Product->image }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="view-pills-img3" role="tabpanel">
                                    <div class="shop-details-tab-img">
                                        <img src="{{ asset('user/assets/img/inner-page/shop-details-tab-img3.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="view-pills-img4" role="tabpanel">
                                    <div class="shop-details-tab-img">
                                        <img src="{{ asset('user/assets/img/inner-page/shop-details-tab-img4.png') }}"
                                            alt="">
                                    </div>
                                </div> --}}
                            </div>

                            {{-- <div class="nav nav-pills justify-content-center mt-2" id="view-tab" role="tablist"
                                aria-orientation="horizontal">
                                @foreach ($Product->variants as $variant)
                                    @foreach ($variant->images as $image)
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                            id="view-pills-img{{ $loop->index }}-tab" data-bs-toggle="pill"
                                            data-bs-target="#view-pills-img{{ $loop->index }}" type="button"
                                            role="tab" aria-controls="view-pills-img{{ $loop->index }}"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            <img src="{{ asset($image->image_url) }}" alt="{{ $image->alt_text }}"
                                                width="60px">
                                        </button>
                                    @endforeach
                                @endforeach --}}

                            {{-- <button class="nav-link" id="view-pills-img2-tab" data-bs-toggle="pill"
                                    data-bs-target="#view-pills-img2" type="button" role="tab"
                                    aria-controls="view-pills-img2" aria-selected="false">
                                    <img src="{{ asset('user/assets/img/inner-page/shop-details-nav-img2.png') }}" alt="">
                                </button>
                                <button class="nav-link" id="view-pills-img3-tab" data-bs-toggle="pill"
                                    data-bs-target="#view-pills-img3" type="button" role="tab"
                                    aria-controls="view-pills-img3" aria-selected="false">
                                    <img src="{{ asset('user/assets/img/inner-page/shop-details-nav-img3.png') }}" alt="">
                                </button>
                                <button class="nav-link" id="view-pills-img4-tab" data-bs-toggle="pill"
                                    data-bs-target="#view-pills-img4" type="button" role="tab"
                                    aria-controls="view-pills-img4" aria-selected="false">

                                    <img src="{{ asset('user/assets/img/inner-page/shop-details-nav-img4.png') }}" alt="">
                                </button> --}}

                            {{-- <img src="{{ asset('user/assets/img/inner-page/shop-details-nav-img4.png') }}"
                                        alt="">
                                </button>

                                    <img src="{{ asset('user/assets/img/inner-page/shop-details-nav-img4.png') }}" alt="">
                                </button> --}}

                            {{-- </div> --}}

                        </div>
                        <div class="nav " id="view-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($Product->variants as $variant)
                                @foreach ($variant->images as $image)
                                    <button class="nav-link"
                                        id="view-pills-img{{ $loop->parent->index }}-{{ $loop->index }}-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#view-pills-img{{ $loop->parent->index }}-{{ $loop->index }}"
                                        type="button" role="tab"
                                        aria-controls="view-pills-img{{ $loop->parent->index }}-{{ $loop->index }}"
                                        aria-selected="false">

                                        <img src="{{ asset($image->image_url) }}" alt="{{ $image->alt_text }}"
                                            width="60px">
                                    </button>
                                @endforeach
                            @endforeach

                        </div>
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
                                <input type="hidden" name="product_id" value="{{ $Product->id }}">

                                <div class="quantity-color-area">
                                    @foreach ($attributeGroups as $attrName => $values)
                                        <div class="attribute-group" style="margin-bottom: 16px;">
                                            <label class="attribute-label"
                                                style="font-weight: bold; display: block; margin-bottom: 6px;">
                                                {{ $attrName }}
                                            </label>

                                            <ul class="color-list"
                                                style="display: flex; gap: 8px; list-style: none; padding: 0;">
                                                @foreach ($values as $value)
                                                    <li>
                                                        <input type="radio" name="attribute[{{ $attrName }}]"
                                                            value="{{ $value->id }}" id="attr_{{ $value->id }}"
                                                            data-value="{{ $value->value }}"
                                                            data-attribute="{{ $attrName }}"
                                                            class="btn-check attribute-input" required>
                                                        <label class="btn btn-outline-primary"
                                                            for="attr_{{ $value->id }}">
                                                            {{ $value->value }}
                                                        </label>
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    @endforeach
                                </div>


                                <div class="quantity-color-area">
                                    <div class="quantity-color">
                                        <h6 class="widget-title">Số lượng :</h6>
                                        <div class="quantity-counter">
                                            <a href="#" class="quantity__minus"><i class='bx bx-minus'></i></a>
                                            <input name="quantity" type="number" class="quantity__input" value="1"
                                                min="1">
                                            <a href="#" class="quantity__plus"><i class='bx bx-plus'></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="shop-details-btn">
                                    <form action="{{ route('cart.add', $variant->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="primary-btn1 style-3 hover-btn4 add-to-cart">*Add to
                                            Cart*</button>
                                    </form>
                                </div>

                        </div>

                        <div class="product-info">
                            <p>Số lượng sản phẩm : {{ $variant->quantity }}</p>
                        </div>
                        <ul class="product-shipping-delivers">
                            
                            <li class="product-delivers">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 40 40">
                                    <g clip-path="url(#clip0_1190_20361)">
                                        <path
                                            d="M38.6593 8.87148L38.662 7.15148C38.6386 6.55948 38.75 5.78082 38.4873 5.21082C38.31 4.59815 37.6713 4.10148 37.2633 3.65548L36.038 2.44882L34.7853 1.22348C33.8306 0.334817 32.4386 -0.0358499 31.174 0.0541501C30.096 0.0594834 27.1206 0.0888167 26.0146 0.0934834C23.5433 0.108817 11.0073 0.212817 8.8173 0.22415C7.75197 0.263483 6.24064 0.0961501 5.2573 0.603483C4.19464 0.995484 3.33664 2.18015 2.53264 2.91148L1.3253 4.13615C0.85597 4.56815 0.417304 5.11148 0.33197 5.76748L0.418637 33.3448C0.40797 34.6082 1.31464 35.8115 2.53797 36.1335C3.03997 36.3075 3.81064 36.2202 4.3153 36.2448C11.5406 36.2215 19.384 36.2455 26.5873 36.2868C27.0313 36.7815 27.4806 37.2715 27.9373 37.7508L28.6673 38.4808C29.2053 39.1922 30.4013 39.4048 31.0973 38.7242C35.184 34.7582 39.554 29.9882 39.93 23.9995C39.9793 22.1542 39.4766 20.4335 38.6 18.9535C38.6666 15.6988 38.6413 12.1282 38.6586 8.87082L38.6593 8.87148ZM19.156 14.4008L15.8266 16.4768C15.938 12.8995 16.0846 9.32015 15.94 5.74348C17.1346 5.70682 18.2786 5.67482 19.336 5.65348C20.476 5.63482 21.616 5.62482 22.756 5.61548C22.8826 7.33348 22.944 9.66148 23.0006 11.3335C23.058 13.1688 23.066 15.0042 23.0706 16.8395L19.51 14.4008C19.4576 14.3651 19.3957 14.346 19.3323 14.346C19.2689 14.346 19.207 14.3651 19.1546 14.4008H19.156ZM15.938 4.24415C16.0526 3.11215 16.9726 2.25082 17.19 1.17282L21.6966 1.20748C22.0686 1.77615 22.2626 2.41148 22.36 3.08815C22.4566 3.73082 22.3653 4.43748 22.5633 5.06082C20.3305 5.02501 18.098 4.97234 15.866 4.90282C15.872 4.67815 15.8993 4.45948 15.938 4.24415ZM23.6653 11.3335C23.7093 9.66282 23.794 7.31415 23.912 5.60282C28.3753 5.58015 32.8373 5.65482 37.2973 5.90682C37.3726 6.31348 37.3253 6.77282 37.338 7.15215L37.3406 8.87215C37.3366 11.5875 37.348 14.5248 37.3793 17.3148C35.12 14.8488 31.6506 13.5102 28.1446 14.2675C26.3713 14.6082 24.8353 15.4295 23.5966 16.5495C23.6013 14.8108 23.6106 13.0722 23.6653 11.3335ZM29.454 1.26682C30.324 1.30948 31.9193 1.17215 32.6873 1.44882C33.6006 1.67282 34.4726 2.73948 35.1146 3.37148C35.404 3.66215 36.056 4.33015 36.528 4.80548C33.878 4.94282 31.228 5.01282 28.578 5.05148C27.0493 5.08748 25.4813 5.08682 23.8993 5.07415C23.8646 4.27282 23.2806 3.62482 22.9733 2.91282C22.732 2.36348 22.5686 1.80215 22.5413 1.21415L29.454 1.26682ZM4.31397 2.26082C5.0553 1.47815 6.02664 1.06748 7.0973 1.09748L8.8173 1.11015L15.8366 1.16282C15.7173 1.72882 15.7786 2.34548 15.6933 2.91282C15.5913 3.62282 15.38 4.28748 14.9693 4.87748C10.5113 4.74548 6.05864 4.62548 1.82064 4.72082C2.60864 3.90948 3.62397 2.96815 4.31397 2.26082ZM4.3153 35.7555H3.4553C2.10997 35.8388 0.896637 34.6842 0.916637 33.3428L0.93797 19.5855C0.955303 17.3242 0.994637 11.4555 1.01197 9.26682L1.02397 7.54682C1.0633 7.04882 0.97997 6.45815 1.06064 5.93682C5.00197 6.09482 10.1393 5.92415 14.72 5.78015C14.6386 7.63082 14.6513 9.48149 14.698 11.3328C14.74 13.3328 14.7926 15.3328 14.8673 17.3328C14.8473 17.6988 15.2966 17.9442 15.5926 17.7208L19.342 15.0528L22.8346 17.3182C20.452 20.0128 19.5693 23.9715 20.9786 27.5482C22.0893 30.6282 23.9646 33.2802 26.084 35.7162C19.012 35.7708 11.3833 35.7588 4.31597 35.7548L4.3153 35.7555ZM36.5646 30.9608C36.4806 30.6693 36.3722 30.3855 36.2406 30.1122C36.0546 29.7122 35.826 29.3008 35.62 28.9982C35.414 28.6948 35.23 28.5002 35.134 28.5342C35.0877 28.5436 35.0471 28.571 35.021 28.6104C34.9949 28.6498 34.9854 28.6978 34.9946 28.7442C35.1778 29.4733 35.4787 30.1678 35.8853 30.8002C36.0146 31.0015 36.1573 31.1955 36.3086 31.3848C36.1426 31.6602 35.9713 31.9328 35.7933 32.2028C35.7347 32.0585 35.6668 31.9183 35.59 31.7828C35.5166 31.6508 35.44 31.5128 35.358 31.3795C35.2013 31.1248 35.0466 30.8868 34.9606 30.7482C34.8006 30.4888 34.6133 30.2535 34.442 30.0342C34.236 29.7702 34.0406 29.5482 33.8613 29.4242C33.8444 29.4123 33.8248 29.4049 33.8043 29.4027C33.7838 29.4005 33.763 29.4035 33.744 29.4115C33.674 29.4408 33.63 29.5042 33.634 29.5715C33.6357 29.6036 33.6422 29.6353 33.6533 29.6655C33.8593 30.1942 34.1144 30.7024 34.4153 31.1835C34.7139 31.6692 35.0534 32.1287 35.43 32.5568C35.4653 32.5802 35.494 32.5922 35.524 32.6075C35.3453 32.8682 35.162 33.1248 34.9753 33.3802C34.9127 33.2669 34.846 33.1559 34.7753 33.0475C34.6731 32.8896 34.5678 32.7338 34.4593 32.5802C34.2246 32.2508 34.006 31.9562 33.9326 31.8468C33.728 31.5422 33.4786 31.2728 33.248 31.0035C32.9993 30.7122 32.7526 30.4455 32.4993 30.2395C32.4771 30.2213 32.45 30.2101 32.4214 30.2073C32.3928 30.2044 32.364 30.2101 32.3386 30.2235C32.2626 30.2628 32.226 30.3482 32.2533 30.4228C32.2653 30.4555 32.2793 30.4895 32.2966 30.5228C32.6369 31.1752 33.0298 31.7988 33.4713 32.3875C33.7954 32.825 34.1447 33.2432 34.5173 33.6402C34.584 33.6948 34.6366 33.7288 34.6913 33.7668C34.5046 34.0135 34.3153 34.2582 34.1226 34.4982C34.07 34.4182 34.0157 34.3393 33.96 34.2615C33.54 33.6742 32.9773 33.0175 32.904 32.8955C32.6226 32.5695 32.344 32.2408 32.0533 31.9222C31.764 31.6002 31.458 31.2935 31.1366 31.0035C31.1059 30.9751 31.0659 30.9588 31.0241 30.9576C30.9822 30.9563 30.9413 30.9703 30.909 30.9969C30.8767 31.0235 30.855 31.0608 30.8481 31.1021C30.8412 31.1434 30.8494 31.1858 30.8713 31.2215C31.5626 32.3176 32.3561 33.3457 33.2413 34.2922C33.4266 34.4902 33.6233 34.6788 33.8166 34.8695C33.568 35.1708 33.3166 35.4668 33.062 35.7575C32.9814 35.6345 32.8965 35.5144 32.8073 35.3975C32.5542 35.0695 32.2916 34.749 32.02 34.4362C31.8773 34.2695 31.7646 34.1322 31.7026 34.0608C31.4186 33.7315 31.1166 33.4182 30.826 33.1148C30.7495 33.0347 30.6721 32.9553 30.594 32.8768C30.3709 32.6509 30.1397 32.4332 29.9006 32.2242C29.838 32.1702 29.7666 32.1548 29.7113 32.1722C29.6106 32.2035 29.56 32.2748 29.5906 32.3495C29.79 32.8395 30.3146 33.4675 30.8646 34.1102C31.3022 34.6226 31.7592 35.118 32.2346 35.5955C32.4286 35.7882 32.6026 35.9522 32.7626 36.0995C32.5 36.3928 32.236 36.6822 31.9706 36.9635C31.8718 36.8161 31.7666 36.6731 31.6553 36.5348C31.3925 36.212 31.1197 35.8974 30.8373 35.5915C30.708 35.4495 30.5926 35.3208 30.5026 35.2262C30.1336 34.8372 29.7561 34.4562 29.3706 34.0835C29.0973 33.8222 28.8526 33.6002 28.666 33.4448C28.596 33.3862 28.5306 33.3535 28.4913 33.3608C28.37 33.3835 28.302 33.4082 28.3106 33.4775C28.3573 33.8368 28.9686 34.5388 29.6373 35.2662C30.1018 35.7713 30.5818 36.262 31.0766 36.7375C31.3086 36.9575 31.51 37.1402 31.6686 37.2782C31.394 37.5648 31.12 37.8442 30.8473 38.1168C30.604 37.7608 30.1553 37.2615 29.6546 36.7475C29.1513 36.2315 28.596 35.7015 28.146 35.2908C27.696 34.8802 27.352 34.5888 27.2713 34.5502C26.6033 34.4115 27.4026 35.3895 28.4093 36.4222C28.8986 36.9216 29.4017 37.4073 29.918 37.8788C30.1686 38.1075 30.3793 38.2922 30.5373 38.4242C30.01 38.7322 29.4753 38.5635 29.0566 38.0828L28.3286 37.3695C25.5026 34.5048 22.8993 31.1688 21.5846 27.3502C19.7066 22.1688 22.8873 16.3188 28.36 15.4095C33.56 14.3875 38.74 18.7282 38.736 24.0042C38.684 26.4115 37.828 28.7662 36.564 30.9648L36.5646 30.9608Z">
                                        </path>
                                        <path
                                            d="M15.3333 23.4033L4.552 23.7007C3.71733 23.7613 3.02667 24.5213 3.054 25.3513L3.05933 26.024C3.07333 27.5887 3.076 29.8167 3.04333 31.404C2.89333 32.5133 3.43067 33.6213 4.668 33.6533L15.4687 33.9067C16.1153 33.8773 16.7293 33.4867 17.0427 32.9147C17.3307 32.4573 17.2787 31.8187 17.2967 31.31C17.34 29.2833 17.3653 27.2487 17.302 25.2213C17.2553 24.2167 16.332 23.3693 15.3347 23.4033H15.3333ZM15.3867 32.7507L4.66667 33.0133C4.14267 33.0367 3.65733 32.586 3.634 32.0593L3.624 31.404C3.61267 29.8247 3.57333 27.58 3.60733 26.024L3.61267 25.3513C3.60067 24.8107 4.05533 24.314 4.594 24.3093L15.3333 24.5973C15.706 24.608 16.0253 24.9247 16.0247 25.294L16.0133 25.93C15.9973 26.8267 15.988 27.7233 15.9967 28.62C15.9967 29.5167 16.0247 30.4133 16.0373 31.31L16.0493 31.9827C16.0581 32.1713 15.9942 32.3561 15.8708 32.4989C15.7474 32.6418 15.5745 32.7319 15.3867 32.7507Z">
                                        </path>
                                        <path
                                            d="M14 28L5.99996 28.1234C5.29929 28.136 5.30263 29.1974 5.99996 29.21L14 29.3334C14.8913 29.33 14.8873 28.0027 14 28ZM30 18.0874C24.9653 18.154 22.438 24.4747 26.0413 27.9587C29.572 31.4994 35.838 29.0654 35.93 24C36.1166 20.7847 33.1946 17.9287 30 18.0874ZM26.4166 27.584C23.32 24.4854 25.6406 19.09 30 19.2467C32.5386 19.2854 34.67 21.5054 34.7366 24.0007C34.918 28.3327 29.4726 30.7434 26.4166 27.584Z">
                                        </path>
                                    </g>
                                </svg>
                                <p>Giao Hàng Trong : 3-7 ngày</p>
                            </li>
                        </ul>
                        {{-- <div class="compare-wishlist-area">
                            <ul>
                                <li>
                                    <a href="whistlist.html">
                                        <span>
                                            <svg width="11" height="11" viewBox="0 0 18 18"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_168_378)">
                                                    <path
                                                        d="M16.528 2.20919C16.0674 1.71411 15.5099 1.31906 14.8902 1.04859C14.2704 0.778112 13.6017 0.637996 12.9255 0.636946C12.2487 0.637725 11.5794 0.777639 10.959 1.048C10.3386 1.31835 9.78042 1.71338 9.31911 2.20854L9.00132 2.54436L8.68352 2.20854C6.83326 0.217151 3.71893 0.102789 1.72758 1.95306C1.63932 2.03507 1.5541 2.12029 1.47209 2.20854C-0.490696 4.32565 -0.490696 7.59753 1.47209 9.71463L8.5343 17.1622C8.77862 17.4201 9.18579 17.4312 9.44373 17.1868C9.45217 17.1788 9.46039 17.1706 9.46838 17.1622L16.528 9.71463C18.4907 7.59776 18.4907 4.32606 16.528 2.20919ZM15.5971 8.82879H15.5965L9.00132 15.7849L2.40553 8.82879C0.90608 7.21113 0.90608 4.7114 2.40553 3.09374C3.76722 1.61789 6.06755 1.52535 7.5434 2.88703C7.61505 2.95314 7.68401 3.0221 7.75012 3.09374L8.5343 3.92104C8.79272 4.17781 9.20995 4.17781 9.46838 3.92104L10.2526 3.09438C11.6142 1.61853 13.9146 1.52599 15.3904 2.88767C15.4621 2.95378 15.531 3.02274 15.5971 3.09438C17.1096 4.71461 17.1207 7.2189 15.5971 8.82879Z" />
                                                </g>
                                            </svg>
                                        </span>
                                        Add to wishlist
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
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
                                <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-description" type="button" role="tab"
                                    aria-controls="nav-description" aria-selected="true">Recomment</button>
                                <button class="nav-link" id="nav-add-info-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-add-info" type="button" role="tab"
                                    aria-controls="nav-add-info" aria-selected="false">Additional Information</button>
                                <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-reviews" type="button" role="tab"
                                    aria-controls="nav-reviews" aria-selected="false">Reviews (15)</button>
                            </div>
                        </nav>
                    </div>
                    <div class="shop-details-description-tab">
                        <div class="tab-content" id="nav-tabContent">
                            <!-- description- chuyển thành recomment -->
                            <div class="tab-pane fade show active" id="nav-description" role="tabpanel"
                                aria-labelledby="nav-description-tab">
                                <div class="row gy-5">

                                    <!-- content -->
                                    hehe

                                    {{-- Sản phẩm liên quan --}}
                                    @if (isset($Related) && $Related->count())
                                        <hr class="my-5">
                                        <h4 class="mb-4">Sản phẩm liên quan</h4>

                                        <div id="relatedCarousel" class="carousel slide position-relative"
                                            data-bs-ride="carousel" data-bs-interval="5000">
                                            <div class="carousel-inner">
                                                @php $chunks = $Related->chunk(4); @endphp
                                                @foreach ($chunks as $index => $group)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <div class="row row-cols-1 row-cols-md-4 g-4">
                                                            @foreach ($group as $item)
                                                                @php
                                                                    $relVariant = $item->variants->first();
                                                                    $path = $item->image;
                                                                    $img =
                                                                        $path && file_exists(public_path($path))
                                                                            ? asset($path)
                                                                            : 'https://product.hstatic.net/1000006063/product/3ce_blush_lighter_atf_-_02_b483e7c8fa3b4c12b167fbade4e7537d_1024x1024.jpg';
                                                                @endphp
                                                                @if (!$relVariant)
                                                                    @continue
                                                                @endif
                                                                <div class="col">
                                                                    <a href="{{ route('u.product_detail', $item->id) }}"
                                                                        class="text-decoration-none text-dark">
                                                                        <div class="card h-100 shadow-sm">
                                                                            @php
                                                                                $firstVariant = $Product->variants->first();
                                                                                $firstImage =
                                                                                    $firstVariant?->images->first() ??
                                                                                    $Product->images->first();

                                                                            @endphp
                                                                            <a
                                                                                href="{{ route('u.product_detail', $Product->id) }}">
                                                                                <img src="{{ asset($firstImage->image_url) }}"
                                                                                    alt="" style="height: 250px">
                                                                                <div class="card-body d-flex flex-column">
                                                                                    <h6 class="card-title">
                                                                                        {{ Str::limit($item->name, 30) }}
                                                                                    </h6>
                                                                                    <p class="text-danger fw-bold mt-auto">
                                                                                        {{ number_format($relVariant->price, 0, ',', '.') }}₫
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
                                            <button
                                                class="position-absolute top-50 start-0 translate-middle-y btn btn-light btn-lg rounded-circle"
                                                style="width:3rem; height:3rem; background-color:#f0f0f0;" type="button"
                                                data-bs-target="#relatedCarousel" data-bs-slide="prev">
                                                <i class="bi bi-chevron-left text-dark fs-3"></i>
                                            </button>
                                            <button
                                                class="position-absolute top-50 end-0 translate-middle-y btn btn-light btn-lg rounded-circle"
                                                style="width:3rem; height:3rem; background-color:#f0f0f0;" type="button"
                                                data-bs-target="#relatedCarousel" data-bs-slide="next">
                                                <i class="bi bi-chevron-right text-dark fs-3"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.attribute-input');
            const attributeQuantity = @json($attributeQuantity); // { "White-S-": 10, "White-M-": 0, ... }

            const allAttributes = {}; // { Color: Set(), Size: Set(), ... }

            // Gom tất cả thuộc tính
            inputs.forEach(input => {
                const attr = input.dataset.attribute;
                const val = input.dataset.value;

                if (!allAttributes[attr]) allAttributes[attr] = new Set();
                allAttributes[attr].add(val);

                input.addEventListener('change', handleChange);
            });

            function handleChange() {
                const selected = {};

                // Lấy các thuộc tính đang được chọn
                Object.keys(allAttributes).forEach(attr => {
                    const checked = document.querySelector(
                        `.attribute-input[data-attribute="${attr}"]:checked`);
                    if (checked) selected[attr] = checked.dataset.value;
                });

                // Reset tất cả trước
                inputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('text-muted', 'unselectable');
                });

                const selectedAttrKeys = Object.keys(selected);
                if (selectedAttrKeys.length === 0) return;

                // Khi chọn 1 thuộc tính, kiểm tra tổ hợp có hợp lệ với các thuộc tính còn lại
                const selectedAttr = selectedAttrKeys[0];
                const selectedValue = selected[selectedAttr];

                const remainingAttrs = Object.keys(allAttributes).filter(attr => attr !== selectedAttr);

                remainingAttrs.forEach(attr => {
                    allAttributes[attr].forEach(option => {
                        const selector =
                            `.attribute-input[data-attribute="${attr}"][data-value="${option}"]`;
                        const input = document.querySelector(selector);
                        if (!input) return;

                        const comboKeyParts = [selectedValue, option];
                        const comboKey = comboKeyParts.join('-') + '-';

                        const quantity = attributeQuantity[comboKey];

                        if (!quantity || quantity <= 0) {
                            input.disabled = true;
                            input.classList.add('text-muted', 'unselectable');

                            // Nếu đang được chọn mà bị loại => bỏ chọn
                            if (input.checked) input.checked = false;
                        }
                    });
                });
            }

            // CSS để làm mờ và không thể click
            const style = document.createElement('style');
            style.textContent = `

            .text-muted {
                opacity: 0.4 !important;
            }
            .unselectable {
                pointer-events: none !important;
            }
        `;

            document.head.appendChild(style);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.attribute-input');
            const attributeQuantity = @json($attributeQuantity);

            // Chuẩn bị dữ liệu variants trong PHP trước
            @php
                $variantsData = $Product->variants
                    ->map(function ($v) {
                        return [
                            'id' => $v->id,
                            'price' => $v->price,
                            'quantity' => $v->quantity,
                            'attributes' => $v->attributeValues->pluck('value', 'attribute.name')->toArray(),
                            'images' => $v->images
                                ->map(function ($img) {
                                    return ['url' => $img->image_url, 'alt' => $img->alt_text];
                                })
                                ->toArray(),
                        ];
                    })
                    ->toArray();
            @endphp

            const variants = @json($variantsData);

            const allAttributes = {};

            // Gom tất cả thuộc tính
            inputs.forEach(input => {
                const attr = input.dataset.attribute;
                const val = input.dataset.value;

                if (!allAttributes[attr]) allAttributes[attr] = new Set();
                allAttributes[attr].add(val);

                input.addEventListener('change', handleChange);
            });

            function handleChange() {
                const selected = {};

                // Lấy các thuộc tính đang được chọn
                Object.keys(allAttributes).forEach(attr => {
                    const checked = document.querySelector(
                        `.attribute-input[data-attribute="${attr}"]:checked`);
                    if (checked) selected[attr] = checked.dataset.value;
                });

                // Reset tất cả trước
                inputs.forEach(input => {
                    input.disabled = false;
                    input.classList.remove('text-muted', 'unselectable');
                });

                // Chuyển ảnh theo biến thể được chọn
                changeImageByVariant(selected);

                const selectedAttrKeys = Object.keys(selected);
                if (selectedAttrKeys.length === 0) return;

                // Logic kiểm tra tổ hợp hợp lệ (giữ nguyên code cũ của bạn)
                const selectedAttr = selectedAttrKeys[0];
                const selectedValue = selected[selectedAttr];

                const remainingAttrs = Object.keys(allAttributes).filter(attr => attr !== selectedAttr);

                remainingAttrs.forEach(attr => {
                    allAttributes[attr].forEach(option => {
                        const selector =
                            `.attribute-input[data-attribute="${attr}"][data-value="${option}"]`;
                        const input = document.querySelector(selector);
                        if (!input) return;

                        const comboKeyParts = [selectedValue, option];
                        const comboKey = comboKeyParts.join('-') + '-';

                        const quantity = attributeQuantity[comboKey];

                        if (!quantity || quantity <= 0) {
                            input.disabled = true;
                            input.classList.add('text-muted', 'unselectable');

                            if (input.checked) input.checked = false;
                        }
                    });
                });
            }

            function changeImageByVariant(selectedAttributes) {
                // Tìm variant phù hợp với các thuộc tính đã chọn
                const matchedVariant = variants.find(variant => {
                    const variantAttrs = variant.attributes;

                    // Kiểm tra xem tất cả thuộc tính được chọn có khớp với variant không
                    for (let [attrName, attrValue] of Object.entries(selectedAttributes)) {
                        if (!variantAttrs[attrName] || variantAttrs[attrName] !== attrValue) {
                            return false;
                        }
                    }
                    return true;
                });                

                if (matchedVariant && matchedVariant.images.length > 0) {
                    // Tìm index của variant trong danh sách
                    const variantIndex = variants.indexOf(matchedVariant);

                    // Active tab ảnh đầu tiên của variant này
                    const targetTabId = `view-pills-img${variantIndex}-0`;
                    const targetTab = document.getElementById(targetTabId);
                    const targetTabButton = document.getElementById(`${targetTabId}-tab`);

                    if (targetTab && targetTabButton) {
                        // Ẩn tất cả các tab hiện tại
                        document.querySelectorAll('.tab-pane').forEach(pane => {
                            pane.classList.remove('show', 'active');
                        });

                        // Bỏ active tất cả các nút
                        document.querySelectorAll('#view-tab .nav-link').forEach(btn => {
                            btn.classList.remove('active');
                            btn.setAttribute('aria-selected', 'false');
                        });

                        // Active tab mới
                        targetTab.classList.add('show', 'active');
                        targetTabButton.classList.add('active');
                        targetTabButton.setAttribute('aria-selected', 'true');

                        // Scroll đến nút được chọn trong danh sách thumbnail
                        targetTabButton.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }

                    // Cập nhật giá
                    const priceElement = document.querySelector('.price-area .price');
                    if (priceElement && matchedVariant.price) {
                        priceElement.innerHTML = `${new Intl.NumberFormat('vi-VN').format(matchedVariant.price)}Đ`;
                    }

                    // Cập nhật số lượng tồn kho
                    const quantityElement = document.querySelector('.product-info p');
                    if (quantityElement && matchedVariant.quantity !== undefined) {
                        quantityElement.textContent = `Số lượng sản phẩm : ${matchedVariant.quantity}`;
                    }
                }
            }

            // CSS để làm mờ và không thể click
            const style = document.createElement('style');
            style.textContent = `
        .text-muted {
            opacity: 0.4 !important;
        }
        .unselectable {
            pointer-events: none !important;
        }
        #view-tab {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
        }
        #view-tab .nav-link {
            border: 2px solid transparent;
            padding: 5px;
            transition: all 0.3s;
        }
        #view-tab .nav-link.active {
            border-color: #000;
        }
        #view-tab .nav-link:hover {
            border-color: #ccc;
        }
    `;
            document.head.appendChild(style);
        });
    </script>
@endsection
