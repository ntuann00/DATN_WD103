<nav class="sidebar vertical-scroll  ps-container ps-theme-default ps-active-y">
    <div class="logo d-flex justify-content-between">
        <a href="index-2.html"><img src="{{ asset('admins/assets/img/logo.png')}}" alt></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">
        <li class="mm-active">
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/dashboard.svg')}}" alt>
                </div>
                <span>Dashboard</span>
            </a>
        </li>
        <li class>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/2.svg')}}" alt>
                </div>
                <span>Quản lí danh mục</span>
            </a>
            <ul>
                <li><a href="{{ route('categories.index')}}">Danh sách danh mục</a></li>
                <li><a href="">Thêm mới danh mục</a></li>
            </ul>
        </li>
        <li class>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/2.svg')}}" alt>
                </div>
                <span>Quản lí biến thể</span>
            </a>
            <ul>
                <li><a href="{{ route('attributes.index')}}">Danh sách biến thể</a></li>
                <li><a href="{{ route('attributes.create')}}">Thêm mới biến thể</a></li>
                <li><a href="{{ route('attributeValues.index')}}">Thêm mới biến thể</a></li>
            </ul>
        </li>
       

        
        
        
        <li class>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/16.svg')}}" alt>
                </div>
                <span>Pages</span>
            </a>
            <ul>
                <li><a href="login.html">Login</a></li>
                <li><a href="resister.html">Register</a></li>
                <li><a href="error_400.html">Error 404</a></li>
                <li><a href="error_500.html">Error 500</a></li>
                <li><a href="forgot_pass.html">Forgot Password</a></li>
                <li><a href="gallery.html">Gallery</a></li>
            </ul>
        </li>
    </ul>
</nav>
