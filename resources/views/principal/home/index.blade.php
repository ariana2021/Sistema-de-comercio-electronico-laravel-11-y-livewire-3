@extends('layouts.app')

@section('content')
    <!-- slider area start -->
    <livewire:slider-component />
    <!-- slider area end -->

    <!-- product area start -->
    <section class="tp-product-area pb-55 pt-60">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-xl-5 col-lg-6 col-md-5">
                    <div class="tp-section-title-wrapper mb-40">
                        <h3 class="tp-section-title animate__animated animate__bounceInDown">Nuevos Productos

                            <svg width="114" height="35" viewBox="0 0 114 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M112 23.275C1.84952 -10.6834 -7.36586 1.48086 7.50443 32.9053"
                                    stroke="currentColor" stroke-width="4" stroke-miterlimit="3.8637"
                                    stroke-linecap="round" />
                            </svg>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <livewire:shopping-cart />
            </div>

        </div>
    </section>
    <!-- product area end -->

    <!-- feature area start -->
    <section class="tp-feature-area py-5" style="background-color: #f2f6f9;">
        <div class="container">
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-xl-4 col-lg-4 col-md-6 d-flex">
                        <div class="card w-100 d-flex flex-column align-items-center text-center shadow-sm border-0 p-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <i class="{{ $service->icon }} fs-4"></i>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-grow-1 justify-content-center w-100">
                                <h5 class="fw-bold mb-2">{{ $service->name }}</h5>
                                <p class="text-muted small">{{ $service->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- feature area end -->

    <!-- product offer area start -->
    <section class="tp-product-offer grey-bg-2 pt-70 pb-80">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-xl-8 col-md-7 col-sm-6">
                    <div class="tp-section-title-wrapper mb-40">
                        <h3 class="tp-section-title">Las ofertas terminan en

                            <svg width="114" height="35" viewBox="0 0 114 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M112 23.275C1.84952 -10.6834 -7.36586 1.48086 7.50443 32.9053"
                                    stroke="currentColor" stroke-width="4" stroke-miterlimit="3.8637"
                                    stroke-linecap="round" />
                            </svg>
                        </h3>
                    </div>
                </div>
                <div class="col-xl-4 col-md-5 col-sm-6">
                    <div class="tp-product-offer-more-wrapper d-flex justify-content-sm-end p-relative z-index-1">
                        <div class="tp-product-offer-more mb-40 text-sm-end grey-bg-2">
                            <span class="tp-product-offer-more-border"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <livewire:daily-offers-component />
                </div>
            </div>
        </div>
    </section>
    <!-- product deal area end -->

    <!-- testimonial area start -->
    <section class="tp-testimonial-area grey-bg-7 pt-130 pb-135 efecto-parallax">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="tp-testimonial-slider p-relative z-index-1 card">
                        <div class="tp-testimonial-shape">
                            <span class="tp-testimonial-shape-gradient"></span>
                        </div>
                        <h3 class="tp-testimonial-section-title text-center mt-3">Nuestros clientes felices</h3>
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8 col-md-10">
                                <div class="tp-testimonial-slider-active swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($ratings as $rating)
                                            <div class="tp-testimonial-item text-center mb-20 swiper-slide">
                                                <div class="tp-testimonial-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span><i
                                                                class="fa-solid fa-star {{ $i <= $rating->rating ? '' : 'text-muted' }}"></i></span>
                                                    @endfor
                                                </div>
                                                <div class="tp-testimonial-content">
                                                    <p>“ {{ $rating->comment ?? 'No comment provided' }} ”</p>
                                                </div>
                                                <div
                                                    class="tp-testimonial-user-wrapper d-flex align-items-center justify-content-center">
                                                    <div class="tp-testimonial-user d-flex align-items-center">
                                                        @php
                                                            $user = optional($rating->user);
                                                            $name = $user->name ?? 'Anonymous';
                                                            $email = $user->email ?? 'anonymous@example.com';

                                                            // Generar URL de Gravatar (basado en email)
                                                            $gravatar =
                                                                'https://www.gravatar.com/avatar/' .
                                                                md5(strtolower(trim($email))) .
                                                                '?s=100&d=404';

                                                            // Generar iniciales del nombre (ejemplo: "Juan Pérez" -> "JP")
                                                            $initials = collect(explode(' ', $name))
                                                                ->map(fn($n) => strtoupper($n[0]))
                                                                ->join('');

                                                            // Verificar si el usuario tiene avatar personalizado
                                                            $avatar = $user->avatar
                                                                ? Storage::url($user->avatar)
                                                                : (Http::get($gravatar)->successful()
                                                                    ? $gravatar
                                                                    : null);
                                                        @endphp

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
                                                            <h3 class="tp-testimonial-user-title">
                                                                {{ optional($rating->user)->name ?? 'Anonymous' }}</h3>
                                                            <span
                                                                class="tp-testimonial-designation">{{ optional($rating->user)->role ?? 'Customer' }}</span>
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
                                <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.061 6.99959L16 6.99959" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.08618 1L1.06079 6.9995L7.08618 13" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button class="tp-testimonial-slider-button-next">
                                <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.939 6.99959L1 6.99959" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.91382 1L15.9392 6.9995L9.91382 13" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
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
    <!-- testimonial area end -->
@endsection


@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <style>
        /* Estilo principal de las tarjetas */
        .service-card {
            background-color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #e0e0e0;
            /* Borde sutil */
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Garantiza que todas las tarjetas tengan la misma altura */
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        /* Contenedor del icono */
        .icon-container {
            background-color: #3f51b5;
            /* Color primario similar a Material Design */
            color: white;
            padding: 25px;
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .icon-container i {
            color: white;
        }

        .icon-container:hover {
            background-color: #673ab7;
            /* Color de hover */
            transform: scale(1.1);
        }

        /* Estilo del icono */
        .icon {
            font-size: 2.5rem;
            /* Icono más grande */
            transition: color 0.3s ease;
        }

        .icon-container:hover .icon {
            color: white;
        }

        /* Título de la tarjeta */
        .tp-feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333333;
            margin-top: 15px;
            transition: color 0.3s ease;
        }

        .tp-feature-title:hover {
            color: #673ab7;
            /* Color de hover */
        }

        /* Descripción de la tarjeta */
        .service-description {
            color: #757575;
            font-size: 1rem;
            margin-top: 10px;
            transition: color 0.3s ease;
            flex-grow: 1;
            /* Permite que el texto ocupe el espacio disponible sin afectar el alto */
        }

        .service-description:hover {
            color: #333333;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.tp-feature-area .row').on('setPosition', function() {
                let slickTrack = $(this).find('.slick-track');
                let slickSlides = slickTrack.find('.slick-slide');

                let maxHeight = 0;

                slickSlides.each(function() {
                    $(this).css('height', 'auto'); // reset
                    if ($(this).height() > maxHeight) {
                        maxHeight = $(this).height();
                    }
                });

                slickSlides.css('height', maxHeight + 'px');
            });


            $('.tp-feature-area .row').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
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
        });
    </script>
@endpush
