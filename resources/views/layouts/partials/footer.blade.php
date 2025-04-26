<div class="redes-sociales">
    @if (!empty($business->facebook_url))
        <a href="{{ $business->facebook_url }}" class="icono facebook" title="Facebook" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>
    @endif

    @if (!empty($business->twitter_url))
        <a href="{{ $business->twitter_url }}" class="icono twitter" title="Twitter" target="_blank">
            <i class="fab fa-twitter"></i>
        </a>
    @endif

    @if (!empty($business->instagram_url))
        <a href="{{ $business->instagram_url }}" class="icono instagram" title="Instagram" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
    @endif

    @if (!empty($business->whatsapp_url))
        <a href="https://wa.me/{{ $business->whatsapp_url }}" class="icono whatsapp" title="WhatsApp" target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>
    @endif
</div>



<footer>
    <div class="tp-footer-area">
        <div class="tp-footer-top pt-95 pb-40 bg-gray-sm">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-1 mb-50">
                            <div class="tp-footer-widget-content">
                                <div class="tp-footer-logo">
                                    <a href="{{ url('/') }}">
                                        <img width="180"
                                            src="{{ asset($business->logo ?? 'assets/principal/img/logo/logo.png') }}"
                                            alt="logo">
                                    </a>
                                </div>
                                <p class="tp-footer-desc">
                                    {{ $business->description ?? 'Bienvenido a nuestra tienda en línea.' }}</p>
                                <div class="tp-footer-social">
                                    @if ($business->facebook_url)
                                        <a href="{{ $business->facebook_url }}" target="_blank"><i
                                                class="fa-brands fa-facebook-f"></i></a>
                                    @endif
                                    @if ($business->twitter_url)
                                        <a href="{{ $business->twitter_url }}" target="_blank"><i
                                                class="fa-brands fa-twitter"></i></a>
                                    @endif
                                    @if ($business->whatsapp_url)
                                        <a href="https://wa.me/{{ $business->whatsapp_url }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif

                                    @if ($business->instagram_url)
                                        <a href="{{ $business->instagram_url }}" target="_blank"><i
                                                class="fa-brands fa-instagram"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-2 mb-50">
                            <h4 class="tp-footer-widget-title">Mi Cuenta</h4>
                            <div class="tp-footer-widget-content">
                                <ul>
                                    <li><a href="{{ route('carts.index') }}">Carrito</a></li>
                                    <li><a href="{{ route('wishlist.index') }}">Lista de deseos</a></li>
                                    <li><a href="{{ route('profile.index') }}">Mi cuenta</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-3 mb-50">
                            <h4 class="tp-footer-widget-title">Información</h4>
                            <div class="tp-footer-widget-content">
                                <ul>
                                    <li><a href="{{ route('privacidad') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('terminos') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('contact') }}">Contactos</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="tp-footer-widget footer-col-4 mb-50">
                            <h4 class="tp-footer-widget-title">Contáctanos</h4>
                            <div class="tp-footer-widget-content">
                                <div class="tp-footer-talk mb-20">
                                    <span>¿Tienes preguntas? Llámanos</span>
                                    <h4><a
                                            href="tel:{{ $business->phone ?? '000-000-0000' }}">{{ $business->phone ?? '000-000-0000' }}</a>
                                    </h4>
                                </div>
                                <div class="tp-footer-contact">
                                    <div class="tp-footer-contact-item d-flex align-items-start">
                                        <div class="tp-footer-contact-icon">
                                            <span>
                                                <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M1 5C1 2.2 2.6 1 5 1H13C15.4 1 17 2.2 17 5V10.6C17 13.4 15.4 14.6 13 14.6H5"
                                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M13 5.40039L10.496 7.40039C9.672 8.05639 8.32 8.05639 7.496 7.40039L5 5.40039"
                                                        stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="tp-footer-contact-content">
                                            <p><a
                                                    href="mailto:{{ $business->email ?? 'info@empresa.com' }}">{{ $business->email ?? 'info@empresa.com' }}</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="tp-footer-contact-item d-flex align-items-start">
                                        <div class="tp-footer-contact-icon">
                                            <span>
                                                <svg width="17" height="20" viewBox="0 0 17 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M8.50001 10.9417C9.99877 10.9417 11.2138 9.72668 11.2138 8.22791C11.2138 6.72915 9.99877 5.51416 8.50001 5.51416C7.00124 5.51416 5.78625 6.72915 5.78625 8.22791C5.78625 9.72668 7.00124 10.9417 8.50001 10.9417Z"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                    <path
                                                        d="M1.21115 6.64496C2.92464 -0.887449 14.0841 -0.878751 15.7889 6.65366C16.7891 11.0722 14.0406 14.8123 11.6313 17.126C9.88298 18.8134 7.11704 18.8134 5.36006 17.126C2.95943 14.8123 0.210885 11.0635 1.21115 6.64496Z"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="tp-footer-contact-content">
                                            @if ($business->latitude && $business->longitude)
                                                <a href="https://www.google.com/maps?q={{ $business->latitude }},{{ $business->longitude }}"
                                                    target="_blank">
                                                @else
                                                    <a href="#"
                                                        onclick="alert('Ubicación no disponible'); return false;">
                                            @endif
                                            {{ $business->address ?? 'Dirección no disponible' }}, <br>
                                            {{ $business->city ?? '' }}, {{ $business->state ?? '' }},
                                            {{ $business->country ?? '' }}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="tp-footer-bottom bg-gray">
            <div class="container">
                <div class="tp-footer-bottom-wrapper">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="tp-footer-copyright">
                                <p class="text-white">© {{ date('Y') }} All Rights Reserved <a href="#">Tu
                                        sitio web</a>.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tp-footer-payment text-md-end">
                                <p>
                                    <img src="{{ asset('assets/principal/img/footer/footer-pay-3.png') }}"
                                        alt="">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
