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
                <div class="col-md-12">
                    @if ($business->shipping_enabled)
                        <!-- Dirección y cálculo de envío -->
                        <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">Dirección de Envío</h4>
                            <input type="text" id="shipping-address" placeholder="Ingresa tu dirección">
                            <p>Costo de envío: <span
                                    id="shipping-cost">{{ config('app.currency_symbol') }}{{ number_format($business->shippingCost, 2) }}</span>
                            </p>
                            <div id="map" style="height: 300px; width: 100%;"></div>
                        </div>
                    @else
                        <!-- Alternativa cuando el envío está desactivado -->
                        <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">Envío no disponible</h4>
                            <p>El envío no está habilitado para este negocio. Por favor, recoge tu pedido en la tienda.
                            </p>
                        </div>
                    @endif
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
                            <a href="shop.html" class="tp-btn tp-btn-2 tp-btn-blue">Ver todas las ofertas
                                <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16 6.99976L1 6.99976" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.9502 0.975414L16.0002 6.99941L9.9502 13.0244" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
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
                                                        <div class="tp-testimonial-avater mr-10">
                                                            <img src="{{ optional($rating->user)->avatar ?: asset('assets/principal/img/users/default-avatar.jpg') }}"
                                                                alt="{{ optional($rating->user)->name ?? 'Anonymous' }}">
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
    <div class="tp-instagram-area pb-70 pt-30">
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
            </div>
            <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1">

                <div class="col">
                    <div class="tp-instagram-item p-relative z-index-1 fix mb-30 w-img">
                        <img src="{{ asset('assets/principal/img/instagram/instagram-1.jpg') }}" alt="">
                        <div class="tp-instagram-icon">
                            <a href="{{ asset('assets/principal/img/instagram/instagram-1.jpg') }}"
                                class="popup-image"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="tp-instagram-item p-relative z-index-1 fix mb-30 w-img">
                        <img src="{{ asset('assets/principal/img/instagram/instagram-2.jpg') }}" alt="">
                        <div class="tp-instagram-icon">
                            <a href="{{ asset('assets/principal/img/instagram/instagram-2.jpg') }}"
                                class="popup-image"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="tp-instagram-item p-relative z-index-1 fix mb-30 w-img">
                        <img src="{{ asset('assets/principal/img/instagram/instagram-3.jpg') }}" alt="">
                        <div class="tp-instagram-icon">
                            <a href="{{ asset('assets/principal/img/instagram/instagram-3.jpg') }}"
                                class="popup-image"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="tp-instagram-item p-relative z-index-1 fix mb-30 w-img">
                        <img src="{{ asset('assets/principal/img/instagram/instagram-4.jpg') }}" alt="">
                        <div class="tp-instagram-icon">
                            <a href="{{ asset('assets/principal/img/instagram/instagram-4.jpg') }}"
                                class="popup-image"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="tp-instagram-item p-relative z-index-1 fix mb-30 w-img">
                        <img src="{{ asset('assets/principal/img/instagram/instagram-5.jpg') }}" alt="">
                        <div class="tp-instagram-icon">
                            <a href="{{ asset('assets/principal/img/instagram/instagram-5.jpg') }}"
                                class="popup-image"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- instagram area end -->
@endsection

@push('scripts')
    @if ($business->shipping_enabled)
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                initMap();
            });

            let map, marker, autocomplete, service, directionsService, directionsRenderer;
            const costPerKm = {{ $business->cost_per_km ?? 0 }};
            const origin = {
                lat: {{ $business->latitude ?? 0 }},
                lng: {{ $business->longitude ?? 0 }}
            };

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: origin,
                    zoom: 14
                });

                marker = new google.maps.Marker({
                    map,
                    position: origin
                });

                autocomplete = new google.maps.places.Autocomplete(document.getElementById("shipping-address"));
                autocomplete.bindTo("bounds", map);

                service = new google.maps.DistanceMatrixService();
                directionsService = new google.maps.DirectionsService();
                directionsRenderer = new google.maps.DirectionsRenderer({
                    map
                });

                autocomplete.addListener("place_changed", function() {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    const destination = place.geometry.location;
                    marker.setPosition(destination);
                    map.setCenter(destination);

                    calcularCosto(origin, destination);
                    trazarRuta(origin, destination);
                });
            }

            function calcularCosto(origen, destino) {
                service.getDistanceMatrix({
                    origins: [origen],
                    destinations: [destino],
                    travelMode: "DRIVING"
                }, function(response, status) {
                    if (status === "OK" && response.rows[0].elements[0].status === "OK") {
                        let distanciaKm = response.rows[0].elements[0].distance.value / 1000;
                        let costoEnvio = (distanciaKm * costPerKm).toFixed(2);

                        // También lo mostramos en el HTML
                        document.getElementById("shipping-cost").innerText =
                            `{{ config('app.currency_symbol') }}${costoEnvio}`;
                    } else {
                        alert("No se pudo calcular la distancia.");
                    }
                });
            }

            function trazarRuta(origen, destino) {
                directionsService.route({
                    origin: origen,
                    destination: destino,
                    travelMode: "DRIVING"
                }, function(result, status) {
                    if (status === "OK") {
                        directionsRenderer.setDirections(result);
                    } else {
                        alert("No se pudo trazar la ruta.");
                    }
                });
            }
        </script>
    @endif
@endpush
