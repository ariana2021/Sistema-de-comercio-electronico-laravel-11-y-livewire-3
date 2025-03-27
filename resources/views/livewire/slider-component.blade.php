<section class="tp-slider-area p-relative z-index-1">
    <div class="tp-slider-active tp-slider-variation swiper-container">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                <div class="tp-slider-item tp-slider-height d-flex align-items-center swiper-slide green-dark-bg">
                    <div class="tp-slider-shape">
                        <img class="tp-slider-shape-1"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-1.png') }}" alt="slider-shape">
                        <img class="tp-slider-shape-2"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-2.png') }}" alt="slider-shape">
                        <img class="tp-slider-shape-3"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-3.png') }}"
                            alt="slider-shape">
                        <img class="tp-slider-shape-4"
                            src="{{ asset('assets/principal/img/slider/shape/slider-shape-4.png') }}"
                            alt="slider-shape">
                    </div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-5 col-lg-6 col-md-6">
                                <div class="tp-slider-content p-relative z-index-1">
                                    <span>A partir de
                                        <b>{{ config('app.currency_symbol') }}{{ $slider->discount ?? '0.00' }}</b></span>
                                    <h3 class="tp-slider-title">{{ $slider->title }}</h3>
                                    <p>{{ $slider->description }}</p>

                                    <div class="tp-slider-btn">
                                        <button type="button" wire:click="addToCart({{ $slider->id }})" class="tp-btn tp-btn-2 tp-btn-white">
                                            Añadir al carrito
                                            <i class="far fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6 col-md-6">
                                <div class="tp-slider-thumb text-end">
                                    <img src="{{ Storage::url($slider->image) }}" alt="slider-img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="tp-slider-arrow tp-swiper-arrow d-none d-lg-block">
            <button type="button" class="tp-slider-button-prev">
                <i class="fa-solid fa-left-from-line"></i>
            </button>
            <button type="button" class="tp-slider-button-next">
                <i class="fa-solid fa-right-to-line"></i>
            </button>
        </div>
        <div class="tp-slider-dot tp-swiper-dot"></div>
    </div>
</section>