<div class="tp-product-offer-slider fix">
    <div class="tp-product-offer-slider-active swiper-container">
        <div class="swiper-wrapper">
            @foreach ($offers as $offer)
                @php
                    $endDate = \Carbon\Carbon::parse($offer->end_date);
                @endphp
                <div class="tp-product-offer-item tp-product-item transition-3 swiper-slide">
                    <div class="tp-product-thumb p-relative fix m-img">
                        <a href="{{ $offer->button_url }}">
                            <img src="{{ asset('storage/' . $offer->image) }}" alt="product-offer">
                        </a>

                        <!-- product action -->
                        <div class="tp-product-action">
                            <div class="tp-product-action-item d-flex flex-column">
                                <button type="button" class="tp-product-action-btn tp-product-quick-view-btn">
                                    <i class="fal fa-eye"></i>
                                    <span class="tp-product-tooltip">Vista previa</span>
                                </button>
                                <button type="button" class="tp-product-action-btn tp-product-add-to-wishlist-btn">
                                    <i class="fas fa-heart-circle"></i>
                                    <span class="tp-product-tooltip">Añadir a lista de deseos</span>
                                </button>
                            </div>
                        </div>

                        <div class="tp-product-add-cart-btn-large-wrapper">
                            <button type="button" class="tp-product-add-cart-btn-large">
                                <i class="far fa-cart-plus"></i>
                                Añadir al carrito
                            </button>
                        </div>
                    </div>

                    <!-- product content -->
                    <div class="tp-product-content">
                        <div class="tp-product-category">
                            <a href="#">Oferta Especial</a>
                        </div>
                        <h3 class="tp-product-title">
                            <a href="{{ $offer->button_url }}">
                                {{ $offer->title }}
                            </a>
                        </h3>
                        <p>{{ $offer->description }}</p>
                        <div class="tp-product-price-wrapper">
                            <span class="tp-product-price old-price">{{ config('app.currency_symbol') }}{{ number_format($offer->discount, 2) }}</span>
                            <span
                                class="tp-product-price new-price">{{ config('app.currency_symbol') }}{{ number_format($offer->discount * 0.8, 2) }}</span>
                        </div>

                        <!-- Countdown Timer -->
                        <div class="tp-product-countdown" data-countdown="{{ $endDate->format('M d Y H:i:s') }}">
                            <div class="tp-product-countdown-inner">
                                <ul>
                                    <li><span class="days">0</span> Days</li>
                                    <li><span class="hours">0</span> Hrs</li>
                                    <li><span class="minutes">0</span> Min</li>
                                    <li><span class="seconds">0</span> Sec</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="tp-deals-slider-dot tp-swiper-dot text-center mt-40"></div>
    </div>
</div>

@push('scripts')
    <script>
        function startCountdown() {
            document.querySelectorAll('[data-countdown]').forEach(function(el) {
                let targetDate = new Date(el.getAttribute('data-countdown')).getTime();

                function updateCountdown() {
                    let now = new Date().getTime();
                    let timeLeft = targetDate - now;

                    if (timeLeft > 0) {
                        let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        el.querySelector('.days').textContent = days;
                        el.querySelector('.hours').textContent = hours;
                        el.querySelector('.minutes').textContent = minutes;
                        el.querySelector('.seconds').textContent = seconds;
                    } else {
                        el.innerHTML = "<strong>Oferta Expirada</strong>";
                    }
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', startCountdown);
    </script>
@endpush
