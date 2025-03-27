@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg text-center pt-95 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Mantente en contacto con nosotros</h3>
                        <div class="breadcrumb__list">
                            <span><a href="#">Inicio</a></span>
                            <span>Contacto</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->


    <!-- contact area start -->
    <section class="tp-contact-area pb-100">
        <div class="container">
            <div class="tp-contact-inner">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="tp-contact-wrapper">
                            <h3 class="tp-contact-title">Envió un mensaje</h3>

                            <div class="tp-contact-form">
                                <form action="{{ route('contact.store') }}" method="POST">
                                    @csrf
                                    <div class="tp-contact-input-wrapper">
                                        <div class="tp-contact-input-box">
                                            <div class="tp-contact-input">
                                                <input name="name" id="name" type="text"
                                                    placeholder="Ingrese su nombre" value="{{ old('name') }}">
                                            </div>
                                            <div class="tp-contact-input-title">
                                                <label for="name">Su nombre</label>
                                            </div>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="tp-contact-input-box">
                                            <div class="tp-contact-input">
                                                <input name="email" id="email" type="email"
                                                    placeholder="Ingrese su correo electrónico" value="{{ old('email') }}">
                                            </div>
                                            <div class="tp-contact-input-title">
                                                <label for="email">Su correo electrónico</label>
                                            </div>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="tp-contact-input-box">
                                            <div class="tp-contact-input">
                                                <input name="subject" id="subject" type="text"
                                                    placeholder="Ingrese el asunto" value="{{ old('subject') }}">
                                            </div>
                                            <div class="tp-contact-input-title">
                                                <label for="subject">Asunto</label>
                                            </div>
                                            @error('subject')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="tp-contact-input-box">
                                            <div class="tp-contact-input">
                                                <textarea id="message" name="message" placeholder="Escriba su mensaje aquí...">{{ old('message') }}</textarea>
                                            </div>
                                            <div class="tp-contact-input-title">
                                                <label for="message">Su mensaje</label>
                                            </div>
                                            @error('message')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="tp-contact-suggetions mb-20">
                                        <div class="tp-contact-remeber">
                                            <input id="remeber" type="checkbox">
                                            <label for="remeber">Guardar mi nombre, correo electrónico y sitio web en este
                                                navegador para la próxima vez que comente.</label>
                                        </div>
                                    </div>

                                    <div class="tp-contact-btn">
                                        <button type="submit">Enviar mensaje</button>
                                    </div>

                                    @if (session('success'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </form>


                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="tp-contact-info-wrapper">
                            <!-- Contacto -->
                            <div class="tp-contact-info-item">
                                <div class="tp-contact-info-icon">
                                    <span>
                                        <img src="{{ asset('assets/principal/img/contact/contact-icon-1.png') }}"
                                            alt="">
                                    </span>
                                </div>
                                <div class="tp-contact-info-content">
                                    <p data-info="mail">
                                        <a href="mailto:{{ $business->email }}">{{ $business->email }}</a>
                                    </p>
                                    <p data-info="phone">
                                        <a href="tel:{{ $business->phone }}">{{ $business->phone }}</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="tp-contact-info-item">
                                <div class="tp-contact-info-icon">
                                    <span>
                                        <img src="{{ asset('assets/principal/img/contact/contact-icon-2.png') }}"
                                            alt="">
                                    </span>
                                </div>
                                <div class="tp-contact-info-content">
                                    <p>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $business->latitude }},{{ $business->longitude }}"
                                            target="_blank">
                                            {{ $business->address }}, <br>
                                            {{ $business->city }}, {{ $business->state }} - {{ $business->zip_code }},
                                            {{ $business->country }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <!-- Redes Sociales -->
                            <div class="tp-contact-info-item">
                                <div class="tp-contact-info-icon">
                                    <span>
                                        <img src="{{ asset('assets/principal/img/contact/contact-icon-3.png') }}"
                                            alt="">
                                    </span>
                                </div>
                                <div class="tp-contact-info-content">
                                    <div class="tp-contact-social-wrapper mt-5">
                                        <h4 class="tp-contact-social-title">Encuéntranos en redes</h4>
                                        <div class="tp-contact-social-icon">
                                            @if ($business->facebook_url)
                                                <a href="{{ $business->facebook_url }}" target="_blank"><i
                                                        class="fa-brands fa-facebook-f"></i></a>
                                            @endif
                                            @if ($business->twitter_url)
                                                <a href="{{ $business->twitter_url }}" target="_blank"><i
                                                        class="fa-brands fa-twitter"></i></a>
                                            @endif
                                            @if ($business->linkedin_url)
                                                <a href="{{ $business->linkedin_url }}" target="_blank"><i
                                                        class="fa-brands fa-linkedin-in"></i></a>
                                            @endif
                                            @if ($business->instagram_url)
                                                <a href="{{ $business->instagram_url }}" target="_blank"><i
                                                        class="fa-brands fa-instagram"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- contact area end -->

    <!-- map area start -->
    <section class="tp-map-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-map-wrapper">
                        <div class="tp-map-hotspot">
                            <span class="tp-hotspot tp-pulse-border">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6" cy="6" r="6" fill="#821F40" />
                                </svg>
                            </span>
                        </div>
                        <div class="tp-map-iframe">
                            <div class="tp-map-iframe">
                                <iframe 
                                    src="https://www.google.com/maps?q={{ $business->latitude }},{{ $business->longitude }}&hl=es&z=15&output=embed" 
                                    width="100%" 
                                    height="450" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy">
                                </iframe>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- map area end -->
@endsection
