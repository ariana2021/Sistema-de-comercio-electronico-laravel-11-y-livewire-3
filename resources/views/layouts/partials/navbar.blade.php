<div id="header-sticky-2" class="tp-header-sticky-area">
    <div class="container">
        <div class="tp-mega-menu-wrapper p-relative">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="logo">
                        <a href="index.html">
                            <img src="{{ asset('assets/principal/img/logo/logo.png') }}" width="150" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 d-none d-md-block">
                    <div class="tp-header-sticky-menu main-menu menu-style-1">
                        <nav id="mobile-menu">
                            <ul>
                                <li>
                                    <a href="{{ url('/') }}">Inicio</a>
                                </li>
                                <li>
                                    <a href="{{ route('shop') }}">Productos</a>
                                </li>
                                <li><a href="{{ route('contact') }}">Contacto</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                    <div class="tp-header-action d-flex align-items-center justify-content-end ml-50">
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
