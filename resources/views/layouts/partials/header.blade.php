<!--[if lte IE 9]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->

<!-- pre loader area start -->
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <!-- loading content here -->
            <div class="tp-preloader-content">
                <div class="tp-preloader-logo">
                    <div class="tp-preloader-circle">
                        <svg width="190" height="190" viewBox="0 0 380 380" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle stroke="#D9D9D9" cx="190" cy="190" r="180" stroke-width="6"
                                stroke-linecap="round"></circle>
                            <circle stroke="red" cx="190" cy="190" r="180" stroke-width="6"
                                stroke-linecap="round"></circle>
                        </svg>
                    </div>
                    <img src="{{ asset('assets/principal/img/logo/preloader/preloader-icon.svg') }}" alt="">
                </div>
                <h3 class="tp-preloader-title">{{ config('app.name') }}</h3>
                <p class="tp-preloader-subtitle">Loading</p>
            </div>
        </div>
    </div>
</div>
<!-- pre loader area end -->

<!-- back to top start -->
<div class="back-to-top-wrapper">
    <button id="back_to_top" type="button" class="back-to-top-btn">
        <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
</div>
<!-- back to top end -->

<!-- offcanvas area start -->
<div class="offcanvas__area offcanvas__radius">
    <div class="offcanvas__wrapper">
        <div class="offcanvas__close">
            <button class="offcanvas__close-btn offcanvas-close-btn">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <div class="offcanvas__content">
            <div class="offcanvas__top mb-70 d-flex justify-content-between align-items-center">
                <div class="offcanvas__logo logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('assets/principal/img/logo/logo.png') }}" width="180" alt="logo">
                    </a>
                </div>
            </div>
            <div class="offcanvas__category pb-40">
                <button class="tp-offcanvas-category-toggle">
                    <i class="fa-solid fa-bars"></i>
                    Categorias
                </button>
                <div class="tp-category-mobile-menu">

                </div>
            </div>
            <div class="tp-main-menu-mobile fix d-lg-none mb-40"></div>

            <div class="offcanvas__contact align-items-center d-none">
                <div class="offcanvas__contact-icon mr-20">
                    <span>
                        <img src="{{ asset('assets/principal/img/icon/contact.png') }}" alt="">
                    </span>
                </div>
                <div class="offcanvas__contact-content">
                    <h3 class="offcanvas__contact-title">
                        <a href="tel:098-852-987">{{$business->phone}}</a>
                    </h3>
                </div>
            </div>
            <div class="offcanvas__btn">
                <a href="{{ route('contact') }}" class="tp-btn-2 tp-btn-border-2">Contacto</a>
            </div>
        </div>
    </div>
</div>
<div class="body-overlay"></div>
<!-- offcanvas area end -->

<!-- mobile menu area start -->
<div id="tp-bottom-menu-sticky" class="tp-mobile-menu d-lg-none">
    <div class="container">
        <div class="row row-cols-5">
            <div class="col">
                <div class="tp-mobile-item text-center">
                    <a href="{{ route('shop') }}" class="tp-mobile-item-btn">
                        <i class="flaticon-store"></i>
                        <span>Store</span>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="tp-mobile-item text-center">
                    <button class="tp-mobile-item-btn tp-search-open-btn">
                        <i class="flaticon-search-1"></i>
                        <span>Buscar</span>
                    </button>
                </div>
            </div>
            <div class="col">
                <div class="tp-mobile-item text-center">
                    <a href="{{ route('wishlist.index') }}" class="tp-mobile-item-btn">
                        <i class="flaticon-love"></i>
                        <span>Lista de deseos</span>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="tp-mobile-item text-center">
                    <a href="{{ route('profile.index') }}" class="tp-mobile-item-btn">
                        <i class="flaticon-user"></i>
                        <span>Mi Cuenta</span>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="tp-mobile-item text-center">
                    <button class="tp-mobile-item-btn tp-offcanvas-open-btn">
                        <i class="flaticon-menu-1"></i>
                        <span>Menu</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile menu area end -->

<!-- search area start -->
<section class="tp-search-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-search-form">
                    <div class="tp-search-close text-center mb-20">
                        <button class="tp-search-close-btn tp-search-close-btn"></button>
                    </div>
                    <form action="#">
                        <div class="tp-search-input mb-10">
                            <input type="text" class="search-products" placeholder="Buscar productos...">
                            <button type="button"><i class="flaticon-search-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- search area end -->

<!-- cart mini area start -->
<livewire:cart-component />
<!-- cart mini area end -->

<header>
    <div class="tp-header-area p-relative z-index-11">
        <!-- header top start  -->
        <div class="tp-header-top black-bg p-relative z-index-1 d-none d-md-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="tp-header-welcome d-flex align-items-center">
                            <span>
                                <i class="fas fa-truck text-danger-full"></i>
                            </span>
                            <p>{{ $business->business_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tp-header-top-right d-flex align-items-center justify-content-end">
                            <div class="tp-header-top-menu d-flex align-items-center justify-content-end">

                                <div class="tp-header-top-menu-item tp-header-setting">
                                    <span class="tp-header-setting-toggle"
                                        id="tp-header-setting-toggle">Configuración</span>
                                    <ul>
                                        @auth
                                            <li>
                                                <a href="{{ route('profile.index') }}">Mi Perfil</a>
                                            </li>
                                        @endauth

                                        <li>
                                            <a href="{{ route('wishlist.index') }}">Lista de deseos</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('carts.index') }}">Carrito</a>
                                        </li>

                                        @auth
                                            <li>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="#"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Salir
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('login') }}">Iniciar Sesión</a>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- header main start -->
        <div class="tp-header-main tp-header-sticky bg-warning">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2 col-md-4 col-6">
                        <div class="logo">
                            <a href="{{ route('index') }}">
                                <img src="{{ asset('assets/principal/img/logo/logo.png') }}" width="180"
                                    alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7 d-none d-lg-block">
                        <div class="tp-header-search pl-70">
                            <form action="#">
                                <div class="tp-header-search-wrapper d-flex align-items-center">
                                    <div class="tp-header-search-box">
                                        <input type="text" class="search-products"
                                            placeholder="Buscar productos...">
                                    </div>
                                    <div class="tp-header-search-btn">
                                        <button type="button">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-8 col-6">
                        <div class="tp-header-main-right d-flex align-items-center justify-content-end">
                            <div class="tp-header-login d-none d-lg-block">
                                @auth
                                    <a href="{{ route('profile.index') }}" class="d-flex align-items-center">
                                        <!-- Cambia 'profile' según tu ruta -->
                                        <div class="tp-header-login-icon">
                                            <span class="overflow-hidden">
                                                @if (auth()->user()->avatar)
                                                    <img id="profile-login"
                                                        src="{{ Storage::url(auth()->user()->avatar) }}"
                                                        alt="Foto de perfil" width="30">
                                                @else
                                                    <svg width="17" height="21" viewBox="0 0 17 21"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="8.57894" cy="5.77803" r="4.77803"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M1.00002 17.2014C0.998732 16.8655 1.07385 16.5337 1.2197 16.2311C1.67736 15.3158 2.96798 14.8307 4.03892 14.611C4.81128 14.4462 5.59431 14.336 6.38217 14.2815C7.84084 14.1533 9.30793 14.1533 10.7666 14.2815C11.5544 14.3367 12.3374 14.4468 13.1099 14.611C14.1808 14.8307 15.4714 15.27 15.9291 16.2311C16.2224 16.8479 16.2224 17.564 15.9291 18.1808C15.4714 19.1419 14.1808 19.5812 13.1099 19.7918C12.3384 19.9634 11.5551 20.0766 10.7666 20.1304C9.57937 20.2311 8.38659 20.2494 7.19681 20.1854C6.92221 20.1854 6.65677 20.1854 6.38217 20.1304C5.59663 20.0773 4.81632 19.9641 4.04807 19.7918C2.96798 19.5812 1.68652 19.1419 1.2197 18.1808C1.0746 17.8747 0.999552 17.5401 1.00002 17.2014Z"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                @endif

                                            </span>
                                        </div>
                                        <div class="tp-header-login-content d-none d-xl-block">
                                            <span>Hola, {{ Auth::user()->name }}</span>
                                            <!-- Muestra el nombre del usuario -->
                                            <h5 class="tp-header-login-title">Tu cuenta</h5>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="d-flex align-items-center">
                                        <div class="tp-header-login-icon">
                                            <span>
                                                <svg width="17" height="21" viewBox="0 0 17 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="8.57894" cy="5.77803" r="4.77803"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M1.00002 17.2014C0.998732 16.8655 1.07385 16.5337 1.2197 16.2311C1.67736 15.3158 2.96798 14.8307 4.03892 14.611C4.81128 14.4462 5.59431 14.336 6.38217 14.2815C7.84084 14.1533 9.30793 14.1533 10.7666 14.2815C11.5544 14.3367 12.3374 14.4468 13.1099 14.611C14.1808 14.8307 15.4714 15.27 15.9291 16.2311C16.2224 16.8479 16.2224 17.564 15.9291 18.1808C15.4714 19.1419 14.1808 19.5812 13.1099 19.7918C12.3384 19.9634 11.5551 20.0766 10.7666 20.1304C9.57937 20.2311 8.38659 20.2494 7.19681 20.1854C6.92221 20.1854 6.65677 20.1854 6.38217 20.1304C5.59663 20.0773 4.81632 19.9641 4.04807 19.7918C2.96798 19.5812 1.68652 19.1419 1.2197 18.1808C1.0746 17.8747 0.999552 17.5401 1.00002 17.2014Z"
                                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="tp-header-login-content d-none d-xl-block">
                                            <span>Hola</span>
                                            <h5 class="tp-header-login-title">Iniciar sesión</h5>
                                        </div>
                                    </a>
                                @endauth
                            </div>

                            <div class="tp-header-action d-flex align-items-center ml-50">
                                <div class="tp-header-action-item d-none d-lg-block">
                                    <livewire:wishlist-icon />
                                </div>
                                <div class="tp-header-action-item">
                                    <livewire:cart-icon />
                                </div>
                                <div class="tp-header-action-item d-lg-none">
                                    <button type="button" class="tp-header-action-btn tp-offcanvas-open-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="16"
                                            viewBox="0 0 30 16">
                                            <rect x="10" width="20" height="2" fill="currentColor" />
                                            <rect x="5" y="7" width="25" height="2" fill="currentColor" />
                                            <rect x="10" y="14" width="20" height="2" fill="currentColor" />
                                        </svg>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- header bottom start -->
        <div class="tp-header-bottom tp-header-bottom-border d-none d-lg-block bg-gray">
            <div class="container">
                <div class="tp-mega-menu-wrapper p-relative">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="tp-header-category tp-category-menu tp-header-category-toggle">
                                <button class="tp-category-menu-btn tp-category-menu-toggle">
                                    <span>
                                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 1C0 0.447715 0.447715 0 1 0H15C15.5523 0 16 0.447715 16 1C16 1.55228 15.5523 2 15 2H1C0.447715 2 0 1.55228 0 1ZM0 7C0 6.44772 0.447715 6 1 6H17C17.5523 6 18 6.44772 18 7C18 7.55228 17.5523 8 17 8H1C0.447715 8 0 7.55228 0 7ZM1 12C0.447715 12 0 12.4477 0 13C0 13.5523 0.447715 14 1 14H11C11.5523 14 12 13.5523 12 13C12 12.4477 11.5523 12 11 12H1Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    Categorias
                                </button>
                                <nav class="tp-category-menu-content">
                                    <ul>
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{ route('category', $category->slug) }}">
                                                    <span style="display: inline-block; width: 30px;">
                                                        <img src="{{ Storage::url($category->image) }}"
                                                            alt="{{ $category->name }}"
                                                            style="width: 100%; height: auto;">
                                                    </span>
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="main-menu menu-style-1">
                                <nav class="tp-main-menu-content">
                                    <ul>
                                        <li><a class="text-white" href="{{ url('/') }}">Inicio</a></li>
                                        <li><a class="text-white" href="{{ route('shop') }}">Productos</a></li>
                                        <li><a class="text-white" href="{{ route('posts.index') }}">Blog</a></li>
                                        <li><a class="text-white" href="{{ route('us') }}">Quienes Somos</a></li>
                                        <li><a class="text-white" href="{{ route('contact') }}">Contacto</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <div class="tp-header-contact d-flex align-items-center justify-content-end">
                                <div class="tp-header-contact-icon">
                                    <span>
                                        <i class="fas fa-phone text-white"></i>
                                    </span>
                                </div>
                                <div class="tp-header-contact-content">
                                    <h5 class="text-white">Línea directa:</h5>
                                    <p><a href="tel:{{ $business->phone }}" class="text-white">+{{ $business->phone }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
