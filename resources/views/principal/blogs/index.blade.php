@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-150 pb-150 breadcrumb__overlay breadcrumb__style-3" data-background="{{asset('assets/principal/img/fondos/blog.jpg')}}">
        <div class="container">
           <div class="row">
              <div class="col-xxl-12">
                 <div class="breadcrumb__content text-center p-relative z-index-1">
                    <h3 class="breadcrumb__title">Nuestro Blog</h3>
                    <div class="breadcrumb__list">
                       <span><a href="#">Inicio</a></span>
                       <span>Blog</span>
                    </div>
                 </div>
              </div>
           </div>
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
