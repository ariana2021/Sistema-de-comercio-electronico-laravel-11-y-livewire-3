@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="tp-slider-area p-relative z-index-1">
        <div class="tp-slider-active tp-slider-variation swiper-container">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="tp-slider-item tp-slider-height d-flex align-items-center swiper-slide green-dark-bg">
                    <div class="tp-slider-shape">
                        <img loading="lazy" class="tp-slider-shape-1"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-1.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-2"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-2.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-3"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-3.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-4"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-4.png') }}" alt="slider-shape">
                    </div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-5 col-lg-6 col-md-6">
                                <div class="tp-slider-content p-relative z-index-1">
                                    <h3 class="tp-slider-title">Taladro Inalámbrico 20V</h3>
                                    <p>Herramienta ideal para trabajos en casa y proyectos profesionales.</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6 col-md-6">
                                <div class="tp-slider-thumb text-end">
                                    <img src="https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?w=600"
                                        alt="Taladro">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="tp-slider-item tp-slider-height d-flex align-items-center swiper-slide green-dark-bg">
                    <div class="tp-slider-shape">
                        <img loading="lazy" class="tp-slider-shape-1"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-1.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-2"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-2.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-3"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-3.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-4"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-4.png') }}" alt="slider-shape">
                    </div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-5 col-lg-6 col-md-6">
                                <div class="tp-slider-content p-relative z-index-1">
                                    <h3 class="tp-slider-title">Juego de Llaves Combinadas</h3>
                                    <p>Incluye 12 piezas de acero reforzado para mecánica y hogar.</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6 col-md-6">
                                <div class="tp-slider-thumb text-end">
                                    <img src="https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?w=600"
                                        alt="Llaves">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="tp-slider-item tp-slider-height d-flex align-items-center swiper-slide green-dark-bg">
                    <div class="tp-slider-shape">
                        <img loading="lazy" class="tp-slider-shape-1"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-1.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-2"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-2.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-3"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-3.png') }}" alt="slider-shape">
                        <img loading="lazy" class="tp-slider-shape-4"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-4.png') }}" alt="slider-shape">
                    </div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-5 col-lg-6 col-md-6">
                                <div class="tp-slider-content p-relative z-index-1">
                                    <h3 class="tp-slider-title">Caja de Clavos y Tornillos</h3>
                                    <p>Kit surtido de alta resistencia para todas tus necesidades.</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6 col-md-6">
                                <div class="tp-slider-thumb text-end">
                                    <img src="https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?w=600"
                                        alt="Clavos y tornillos">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flechas de navegación -->
            <div class="tp-slider-arrow tp-swiper-arrow d-none d-lg-block">
                <button type="button" class="tp-slider-button-prev">
                    <i class="fa-solid fa-left-from-line"></i>
                </button>
                <button type="button" class="tp-slider-button-next">
                    <i class="fa-solid fa-right-to-line"></i>
                </button>
            </div>

            <!-- Paginación -->
            <div class="tp-slider-dot tp-swiper-dot"></div>
        </div>
    </section>

    <!-- breadcrumb area end -->

    <!-- postbox area start -->
    <section class="tp-postbox-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="tp-postbox-wrapper pr-50">
                        @foreach ($posts as $post)
                            <article class="tp-postbox-item format-image mb-50 transition-3">
                                <div class="tp-postbox-thumb w-img">
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('assets/img/blog/blog-big-3.jpg') }}"
                                            alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="tp-postbox-content">
                                    <div class="tp-postbox-meta">
                                        <span><i class="far fa-calendar-check"></i>
                                            {{ $post->created_at->format('d M, Y') }}</span>
                                        <span><a href="#"><i class="far fa-user"></i>
                                                {{ $post->user->name }}</a></span>
                                        <span><a href="#"><i class="fal fa-comments"></i>
                                                {{ $post->comments->count() }} Comentarios</a></span>
                                    </div>
                                    <h3 class="tp-postbox-title">
                                        <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    <div class="tp-postbox-text">
                                        <p>{{ Str::limit($post->content, 150, '...') }}</p>
                                    </div>
                                    <div class="tp-postbox-read-more">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="tp-btn">Leer Más</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        <div>
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4">
                    <div class="tp-sidebar-wrapper tp-sidebar-ml--24">

                        <!-- Formulario de búsqueda -->
                        <div class="tp-sidebar-widget mb-35">
                            <div class="tp-sidebar-search">
                                <form action="{{ route('posts.index') }}" method="GET">
                                    <div class="tp-sidebar-search-input">
                                        <input type="text" name="search" placeholder="Buscar..."
                                            value="{{ request('search') }}">
                                        <button type="submit">
                                            <i class="far fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Últimos posts dinámicos -->
                        <div class="tp-sidebar-widget mb-35">
                            <h3 class="tp-sidebar-widget-title">Últimos Posts</h3>
                            <div class="tp-sidebar-widget-content">
                                <div class="tp-sidebar-blog-item-wrapper">
                                    @foreach ($latestPosts as $latest)
                                        <div class="tp-sidebar-blog-item d-flex align-items-center">
                                            <div class="tp-sidebar-blog-thumb">
                                                <a href="{{ route('posts.show', $latest->slug) }}">
                                                    <img src="{{ $latest->image ? asset('storage/' . $latest->image) : asset('assets/img/blog/sidebar/blog-sidebar-1.jpg') }}"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="tp-sidebar-blog-content">
                                                <div class="tp-sidebar-blog-meta">
                                                    <span>{{ $latest->created_at->format('d M, Y') }}</span>
                                                </div>
                                                <h3 class="tp-sidebar-blog-title">
                                                    <a
                                                        href="{{ route('posts.show', $latest->slug) }}">{{ $latest->title }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Categorías dinámicas -->
                        <div class="tp-sidebar-widget widget_categories mb-35">
                            <h3 class="tp-sidebar-widget-title">Categorías</h3>
                            <div class="tp-sidebar-widget-content">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('posts.index', ['category' => $category->slug]) }}">
                                                {{ $category->name }} <span>({{ $category->posts_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- postbox area end -->
@endsection
