@extends('layouts.app')

@section('title', 'Nosotras')

@section('content')
    <!-- Sección Parallax -->
    <div class="parallax text-center">
        <h1 class="display-4 fw-bold text-white title-us">
            {{ config('app.name') }} 🔩
        </h1>
    </div>

    <!-- Sección de Contenido Dinámico -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center fade-in">
                <div class="col-md-6">
                    <h2 class="section-title text-primary">
                        {{ $historia->title }}
                    </h2>
                    <p class="lead">{!! $historia->content !!}</p>
                </div>
                <div class="col-md-6">
                    @if ($historia->image_url)
                        <img src="{{ Storage::url($historia->image_url) }}" class="img-fluid rounded shadow"
                            alt="Imagen de {{ $historia->type }}" />
                    @else
                        <div class="img-fluid rounded shadow"
                            style="height: 200px; text-align: center; line-height: 200px;">
                            🔧🛠️
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Misión y Visión -->
    @if ($mision || $vision)
        <section class="py-5 parallax">
            <div class="container">
                <div class="row text-center fade-in">
                    <div class="col-md-6 mb-4">
                        <div class="card p-4 shadow card-hover border-0 h-100">
                            <h3 class="text-success">🎯 {{ $mision->title }}</h3>
                            <p>{!! $mision->content !!}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card p-4 shadow card-hover border-0 h-100">
                            <h3 class="text-warning">🌟 {{ $vision->title }}</h3>
                            <p>{!! $vision->content !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Nuestro Equipo (con Slick Carousel) -->

    <section class="tp-testimonial-area grey-bg-7 pt-130 pb-135 efecto-parallax">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="tp-testimonial-slider p-relative z-index-1 card">
                        <h3 class="tp-testimonial-section-title text-center mt-3">Conoce a nuestro equipo</h3>

                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8 col-md-10">
                                <div class="tp-testimonial-slider-active-5 swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($users as $user)
                                            @php
                                                $name = $user->name;
                                                $email = $user->email ?? 'anonymous@example.com';
                                                $gravatar =
                                                    'https://www.gravatar.com/avatar/' .
                                                    md5(strtolower(trim($email))) .
                                                    '?s=100&d=404';
                                                $initials = collect(explode(' ', $name))
                                                    ->map(fn($n) => strtoupper($n[0]))
                                                    ->join('');
                                                $avatar = $user->avatar
                                                    ? Storage::url($user->avatar)
                                                    : (Http::get($gravatar)->successful()
                                                        ? $gravatar
                                                        : null);
                                            @endphp

                                            <div class="tp-testimonial-item text-center mb-20 swiper-slide">
                                                <div
                                                    class="tp-testimonial-user-wrapper d-flex align-items-center justify-content-center">
                                                    <div class="tp-testimonial-user d-flex align-items-center">
                                                        <div class="tp-testimonial-avater mr-10">
                                                            @if ($avatar)
                                                                <img src="{{ $avatar }}" alt="{{ $name }}"
                                                                    loading="lazy">
                                                            @else
                                                                <div class="user-initials">
                                                                    {{ $initials }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="tp-testimonial-user-info tp-testimonial-user-translate">
                                                            <h3 class="tp-testimonial-user-title">{{ $name }}</h3>
                                                            <span
                                                                class="tp-testimonial-designation">{{ $user->getRoleNames()->first() ?? 'Sin rol' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tp-testimonial-arrow d-none d-md-block">
                            <button class="tp-testimonial-slider-button-prev">
                                <svg width="17" height="14" viewBox="0 0 17 14">
                                    <path d="M1.061 6.99959L16 6.99959" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M7.08618 1L1.06079 6.9995L7.08618 13" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </button>
                            <button class="tp-testimonial-slider-button-next">
                                <svg width="17" height="14" viewBox="0 0 17 14">
                                    <path d="M15.939 6.99959L1 6.99959" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M9.91382 1L15.9392 6.9995L9.91382 13" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </button>
                        </div>

                        <div
                            class="tp-testimonial-slider-dot tp-swiper-dot text-center mt-30 tp-swiper-dot-style-darkRed d-md-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="{{ asset('assets/principal/css/nosotras.css') }}">
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.equipo-carousel').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                dots: true,
                arrows: false,
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
            const text = "Nuestro Equipo 👷‍♂️";
            const el = document.getElementById("typed-title");
            let i = 0;

            function typeWriter() {
                if (i < text.length) {
                    el.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                } else {
                    setTimeout(() => {
                        el.innerHTML = "";
                        i = 0;
                        typeWriter();
                    }, 1000);
                }
            }

            typeWriter();
        });
    </script>
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>
@endpush
