<div class="cartmini__area tp-all-font-roboto" wire:ignore.self>
    <div class="cartmini__wrapper d-flex justify-content-between flex-column">
        <div class="cartmini__top-wrapper">
            <div class="cartmini__top p-relative">
                <div class="cartmini__top-title">
                    <h4>Carrito</h4>
                </div>
                <div class="cartmini__close">
                    <button type="button" class="cartmini__close-btn cartmini-close-btn">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="cartmini__widget">
                @forelse ($cart as $item)
                    <div class="cartmini__widget-item">
                        <div class="cartmini__thumb">
                            <a href="{{ route('product.detail', $item['slug']) }}">
                                <img loading="lazy" src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}">
                            </a>
                        </div>
                        <div class="cartmini__content">
                            <h5 class="cartmini__title"><a
                                    href="{{ route('product.detail', $item['slug']) }}">{{ $item['name'] }}</a></h5>
                            <div class="cartmini__price-wrapper">
                                <span
                                    class="cartmini__price">{{ config('app.currency_symbol') }}{{ $item['price'] }}</span>
                                <span class="cartmini__quantity">x{{ $item['quantity'] }}</span>
                            </div>
                        </div>
                        <button wire:click="removeFromCart({{ $item['id'] }})" class="cartmini__del">
                            <i class="fa-regular fa-xmark"></i>
                        </button>
                    </div>
                @empty
                    <div class="text-center">
                        <img loading="lazy" src="{{ asset('assets/principal/img/product/cartmini/empty-cart.png') }}" alt="">
                        <p>Tu carrito está vacío</p>
                        <a href="{{ route('shop') }}" class="tp-btn">Ir a la tienda</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="cartmini__checkout">
            <div class="cartmini__checkout-title mb-30">
                <h4>Subtotal:</h4>
                <span>{{ config('app.currency_symbol') }}{{ $subtotal }}</span>
            </div>
            <div class="cartmini__checkout-btn">
                <a href="{{ route('carts.index') }}" class="tp-btn mb-10 w-100">Ver carrito</a>
                <a href="{{ route('carts.checkout') }}" class="tp-btn tp-btn-border w-100">Checkout</a>
            </div>
        </div>
    </div>
</div>
