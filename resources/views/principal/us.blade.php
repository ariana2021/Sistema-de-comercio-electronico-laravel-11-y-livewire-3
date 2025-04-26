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

    <section class="py-5">

        <h2 class="section-title text-center mb-5">
            <span id="typed-title" class="text-primary"></span>
        </h2>
        <div class="container">
            <ul class="row mt-4 justify-content-around equipo-carousel">
                @foreach ($users as $user)
                    <li class="col-sm-6 col-lg-4 py-4 text-center team-item">
                        <!-- Avatar dinámico -->
                        <div class="team-img d-flex justify-content-center align-items-center"
                            style="width: 150px; height: 150px; border-radius: 50%; background-color: #ddd; overflow: hidden; margin: 0 auto;">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                    class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                            @else
                                <span class="d-flex justify-content-center align-items-center"
                                    style="font-size: 36px; font-weight: bold; width: 100%; height: 100%;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div class="title mt-3">
                            <!-- Nombre y título del usuario -->
                            <h3 class="name">{{ $user->name }}</h3>
                            <h5 class="sep">{{ $user->getRoleNames()->first() ?? 'Sin rol' }}</h5>
                        </div>
                        <br>
                        <span class="social py-3 px-3">
                            <i class="fa-brands fa-facebook-f" style="color: #ff4848;"></i>
                            <i class="fa-brands fa-twitter" style="color: #ff4848;"></i>
                            <i class="fa-brands fa-instagram" style="color: #ff4848;"></i>
                            <i class="fa-brands fa-github" style="color: #ff4848;"></i>
                        </span>
                    </li>
                @endforeach
            </ul>
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
