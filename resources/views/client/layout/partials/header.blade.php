<!-- header -->
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <div class="site-logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets-client/img/logo.png') }}" alt="">
                        </a>
                    </div>
                    <!-- logo -->

                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class=""><a href="{{ route('home') }}">Trang chủ</a>
                            </li>
                            <li><a href="{{ route('product.list') }}">Sản phẩm</a> </li>
                            <li><a href="about.html">Về chúng tôi</a></li>
                            <li><a href="contact.html">Liên hệ</a></li>
                            <li>
                                <div class="header-icons">
                                    <a class="shopping-cart" href="{{ route('cart') }}"><i
                                            class="fas fa-shopping-cart"></i></a>
                                    <a class="mobile-hide search-bar-icon" href="#"><i
                                            class="fas fa-search"></i></a>
                                    <a href="{{ route('login') }}" class="dropdown-toggle" data-toggle="dropdown"><i
                                            class="fas fa-user"></i></a>
                                    <div class="dropdown-menu">
                                        @if (Auth::user())
                                            @if (Auth::user()->role === 'admin')
                                                <a class="dropdown-item text-secondary" href="{{ route('dashboard') }}">Trang quản trị</a>
                                            @endif
                                            <a class="dropdown-item text-secondary" href="">Tài khoản</a>
                                            <form action="{{ route('logout') }}" method="post">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-secondary"
                                                    href="">Đăng xuất</button>
                                            </form>
                                        @else
                                            <a class="dropdown-item text-secondary" href="{{ route('login') }}">Đăng
                                                nhập</a>
                                            <a class="dropdown-item text-secondary" href="{{ route('register') }}">Đăng
                                                ký</a>
                                        @endif

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                    <div class="mobile-menu"></div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->

<!-- search area -->
<div class="search-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="close-btn"><i class="fas fa-window-close"></i></span>
                <div class="search-bar">
                    <div class="search-bar-tablecell">
                        <h3>Search For:</h3>
                        <input type="text" placeholder="Keywords">
                        <button type="submit">Search <i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end search area -->
