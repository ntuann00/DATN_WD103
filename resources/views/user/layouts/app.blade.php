<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.egenslab.com/html/beautico/preview/index2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Jun 2025 11:24:35 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
     <link href="{{ asset('user/assets/css/bootstrap.min.css')}}" rel="stylesheet">
     <!-- Bootstrap Icon CSS -->
     <link href="{{ asset('user/assets/css/bootstrap-icons.css')}}" rel="stylesheet">
     
     <!-- font Playfair Display -->
     <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
     
     <!-- Fontawesome all CSS -->
     <link href="{{ asset('user/assets/css/all.min.css')}}" rel="stylesheet">
     <link href="{{ asset('user/assets/css/nice-select.css')}}" rel="stylesheet">
     <link href="{{ asset('user/assets/css/animate.min.css')}}" rel="stylesheet">
     <!--  FancyBox CSS  -->
     <link rel="stylesheet" href="{{ asset('user/assets/css/jquery.fancybox.min.css')}}">
    <!-- {{ asset('admins/assets/img/menu-icon/16.svg')}}')}}  linkasset-->
     <!-- Fontawesome CSS -->
     <link href="{{ asset('user/assets/css/fontawesome.min.css')}}" rel="stylesheet">
     <!-- box icon css -->
     <link rel="stylesheet" href="{{ asset('user/assets/css/boxicons.min.css')}}">
     <!-- slider CSS -->
     <link rel="stylesheet" href="{{ asset('user/assets/css/swiper-bundle.min.css')}}">
     <link rel="stylesheet" href="{{ asset('user/assets/css/slick-theme.css')}}">
     <link rel="stylesheet" href="{{ asset('user/assets/css/slick.css')}}">
     <!--  Style CSS  -->
     <link rel="stylesheet" href="{{ asset('user/assets/css/style.css')}}">
    <title>5 Beauty - Beauty & Cosmetics</title>
    <link rel="icon" href="{{ asset('user/assets/img/sm-logo.svg')}}" type="image/gif">

    <style>
        body {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="style-2 ">
    @include('user.layouts.header')
    
    @yield('content') {{-- nội dung index sẽ hiển thị ở đây --}}

    @include('user.layouts.footer')
</body>
@stack('scripts')
<!--  Main jQuery  -->
<script data-cfasync="false" src="{{ asset('user/assets/js/email-decode.min.js')}}"></script>
<script src="{{ asset('user/assets/js/jquery-3.6.0.min.js')}}   "></script>
<!-- Popper and Bootstrap JS -->
<script src="{{ asset('user/assets/js/popper.min.js')}}"></script>
<script src="{{ asset('user/assets/js/jquery.nice-select.min.js')}}"></script>
<!-- Fancybox JS -->
<script src="{{ asset('user/assets/js/jquery.fancybox.min.js')}}"></script>
<script src="{{ asset('user/assets/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('user/assets/js/slick.js')}}"></script>
<!-- Swiper slider JS -->
<script src="{{ asset('user/assets/js/swiper-bundle.min.js')}}"></script>


<script src="{{ asset('user/assets/js/waypoints.min.js')}}"></script>
<!-- main js  -->
<script src="{{ asset('user/assets/js/main.js')}}"></script>
</html>
