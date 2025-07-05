@extends('user.layouts.app')

@section('content')

<!-- banner đầu trang -->
@include('user.layouts.main-banner')

<!-- chọn category với hình  -->
@include('user.layouts.category-section')

<!-- quick view  -->
@include('user.layouts.product-view-modal')

<!-- danh sách vài sản phẩm  -->
@include('user.layouts.feature-product')

<!-- banner dài phụ  -->
@include('user.layouts.product-banner2')

<!-- top selling -->
@include('user.layouts.top-selling')

<!-- 2 banner phụ -->
@include('user.layouts.offer-banner2')

<!-- our brand -->
@include('user.layouts.brand-section')

<!-- nhận gửi tt mới tới mail ??? -->
@include('user.layouts.newletter')

<!-- review -->
@include('user.layouts.review-section')

<!-- 4 mục phụ trên footer -->
@include('user.layouts.sup-footer')


@endsection
