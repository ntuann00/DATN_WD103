<nav class="sidebar vertical-scroll  ps-container ps-theme-default ps-active-y">
    <div class="logo d-flex justify-content-between">
        <img src="{{ asset('admins/assets/img/Logo1.png')}}" 
     alt="Logo" 
     class="rounded-circle" 
     style="width: 180px; height: 180px; object-fit: cover;">
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

        <!-- Quản lí danh mục -->
        <li>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/2.svg')}}" alt>
                </div>
                <span>Quản lí danh mục</span>
            </a>
            <ul>
                <li><a href="{{ route('categories.index') }}">Danh sách danh mục</a></li>
                <li><a href="#">Thêm mới danh mục</a></li>
            </ul>
        </li>

        <!-- Quản lí thuộc tính -->
        <li>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/2.svg')}}" alt>
                </div>
                <span>Quản lí thuộc tính</span>
            </a>
            <ul>
                <li><a href="{{ route('attributes.index') }}">Danh sách thuộc tính</a></li>
                <li><a href="{{ route('attributes.create') }}">Thêm mới thuộc tính</a></li>
            </ul>
        </li>

        <!-- Quản lí khách hàng -->
        <li>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/2.svg')}}" alt>
                </div>
                <span>Quản lí khách hàng</span>
            </a>
            <ul>
                <li><a href="{{ route('users.index') }}">Danh sách khách hàng</a></li>
                <li><a href="#">Thêm mới khách hàng</a></li>
            </ul>
        </li>

         <!-- Quản lí sản phẩm -->
        <li>
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/2.svg')}}" alt>
                </div>
                <span>Quản lí sản phẩm</span>
            </a>
            <ul>
                <li><a href="{{ route('products.index') }}">Danh sách sản phẩm</a></li>
                <li><a href="{{ route('products.create') }}">Thêm mới sản phẩm</a></li>
            </ul>
        </li>

        <!-- 🛒 Lịch sử đơn hàng -->
        <li class="{{ request()->is('admin/orders*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.orders.index') }}" aria-expanded="false">
                <div class="icon_menu">
                    <img src="{{ asset('admins/assets/img/menu-icon/16.svg')}}" alt>
                </div>
                <span>Lịch sử đơn hàng</span>
            </a>
        </li>

        <!-- Pages -->
        <li>
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
