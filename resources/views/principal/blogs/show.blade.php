@extends('layouts.app')

@section('content')
    <section class="tp-postbox-details-area pb-120 pt-95">
        <div class="container">
            <div class="row g-4"> <!-- Agregado g-4 para espaciado -->
                <div class="col-xl-9 col-lg-8">
                    <div class="tp-postbox-details-top pr-lg-5"> <!-- Agregado padding derecho -->
                        <article class="blog-post">
                            <h1>{{ $post->title }}</h1>
                            <p class="text-muted">Publicado el {{ $post->created_at->format('d M, Y') }} por
                                <strong>{{ $post->user->name }}</strong>
                            </p>

                            <!-- Imagen del post -->
                            <div class="post-image">
                                <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('assets/img/blog/default.jpg') }}"
                                    alt="{{ $post->title }}" class="img-fluid">
                            </div>

                            <!-- Contenido del post -->
                            <div class="post-content mt-4">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </article>

                        <!-- Sección de comentarios con Livewire -->
                        <div class="comments mt-5 mb-3">
                            <livewire:comment-component :post="$post" />
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-xl-3 col-lg-4">
                    <div class="tp-sidebar-wrapper ps-lg-4"> <!-- Agregado padding izquierdo -->
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
@endsection
