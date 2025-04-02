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
    <section class="tp-feature-area tp-feature-border-radius pb-70">
        <div class="container">
            <div class="row gx-1 gy-1 gy-xl-0">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="tp-feature-item d-flex align-items-start">
                        <div class="tp-feature-icon mr-15">
                            <span>
                                <i class="fas fa-truck"></i>
                            </span>
                        </div>
                        <div class="tp-feature-content">
                            <h3 class="tp-feature-title animate__animated animate__fadeInBottomRight">Entrega gratuita</h3>
                            <p>Pedidos de todos los artículos</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="tp-feature-item d-flex align-items-start">
                        <div class="tp-feature-icon mr-15">
                            <span>
                                <i class="fas fa-undo-alt"></i>
                            </span>
                        </div>
                        <div class="tp-feature-content">
                            <h3 class="tp-feature-title animate__animated animate__fadeInLeftBig">Devoluciones y reembolsos
                            </h3>
                            <p>Garantía de devolución de dinero</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="tp-feature-item d-flex align-items-start">
                        <div class="tp-feature-icon mr-15">
                            <span>
                                <i class="fas fa-users"></i>
                            </span>
                        </div>
                        <div class="tp-feature-content">
                            <h3 class="tp-feature-title animate__animated animate__fadeInLeftBig">Descuento para miembros
                            </h3>
                            <p>En cada pedido superior a {{ config('app.currency_symbol') }}140.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="tp-feature-item d-flex align-items-start">
                        <div class="tp-feature-icon mr-15">
                            <span>
                                <i class="fas fa-headset"></i>
                            </span>
                        </div>
                        <div class="tp-feature-content">
                            <h3 class="tp-feature-title animate__animated animate__fadeInDown">Soporte 24/7</h3>
                            <p>Contáctanos las 24 horas del día</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- feature area end -->

    <!-- product offer area start -->
    <section class="tp-product-offer grey-bg-2 pt-70 pb-80">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-xl-4 col-md-5 col-sm-6">
                    <div class="tp-section-title-wrapper mb-40">
                        <h3 class="tp-section-title">Oferta del día

                            <svg width="114" height="35" viewBox="0 0 114 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M112 23.275C1.84952 -10.6834 -7.36586 1.48086 7.50443 32.9053"
                                    stroke="currentColor" stroke-width="4" stroke-miterlimit="3.8637"
                                    stroke-linecap="round" />
                            </svg>
                        </h3>
                    </div>
                </div>
                <div class="col-xl-8 col-md-7 col-sm-6">
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
                                                                ? asset('storage/avatars/' . $user->avatar)
                                                                : (Http::get($gravatar)->successful()
                                                                    ? $gravatar
                                                                    : null);
                                                        @endphp

                                                        <div class="tp-testimonial-avater mr-10">
                                                            @if ($avatar)
                                                                <img src="{{ $avatar }}" alt="{{ $name }}" loading="lazy">
                                                            @else
                                                                <div class="user-initials">
                                                                    {{ $initials }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div
                                                            class="tp-testimonial-user-info tp-testimonial-user-translate">
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
                                    <path d="M7.08618 1L1.06079 6.9995L7.08618 13" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
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


    <!-- instagram area start -->
    {{-- <div class="tp-instagram-area pt-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-5 col-sm-6">
                    <div class="tp-section-title-wrapper mb-40">
                        <h3 class="tp-section-title">Instagram
                            <svg width="114" height="35" viewBox="0 0 114 35" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M112 23.275C1.84952 -10.6834 -7.36586 1.48086 7.50443 32.9053"
                                    stroke="currentColor" stroke-width="4" stroke-miterlimit="3.8637"
                                    stroke-linecap="round" />
                            </svg>
                        </h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- LightWidget WIDGET -->
                    <script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/a680bc773e375d42bfc665eee24fb394.html"
                        scrolling="no" allowtransparency="true" class="lightwidget-widget"
                        style="width:100%;border:0;overflow:hidden;"></iframe>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- instagram area end -->
@endsection
