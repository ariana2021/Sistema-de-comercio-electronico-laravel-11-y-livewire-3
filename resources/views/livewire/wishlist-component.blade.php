<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-cart-list mb-45 mr-30">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="tp-cart-header-product">Producto</th>
                                <th class="tp-cart-header-price">Precio</th>
                                <th>Acción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($wishlists) > 0)
                                @foreach ($wishlists as $item)
                                    <tr>
                                        <!-- img -->
                                        <td class="tp-cart-img">
                                            <a href="{{ route('product.detail', $item['slug']) }}">
                                                <img loading="lazy" src="{{ Storage::url($item['image']) }}" alt="">
                                            </a>
                                        </td>
                                        <!-- title -->
                                        <td class="tp-cart-title">
                                            <a href="{{ route('product.detail', $item['slug']) }}">
                                                {{ $item['name'] }}
                                            </a>
                                        </td>
                                        <!-- price -->
                                        <td class="tp-cart-price">
                                            <span>{{ config('app.currency_symbol') }}{{ $item['price'] }}</span>
                                        </td>
                                        <!-- Add to cart -->
                                        <td class="tp-cart-add-to-cart">
                                            <button wire:click="moveToCart({{ $item['id'] }})"
                                                class="tp-btn tp-btn-2 tp-btn-blue">
                                                <i class="far fa-cart-plus"></i>
                                            </button>
                                        </td>
                                        <!-- Remove -->
                                        <td class="tp-cart-action">
                                            <button wire:click="removeFromWishlist({{ $item['id'] }})"
                                                class="tp-cart-action-btn">
                                                <i class="far fa-times-circle"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="alert alert-info">
                                            <i class="far fa-heart-broken"></i> Tu lista de deseos está vacía.
                                            <br>
                                            <a href="{{ route('shop') }}" class="tp-btn tp-btn-blue mt-2">
                                                <i class="fas fa-store"></i> Explorar productos
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
                <div class="tp-cart-bottom">
                    <div class="row align-items-end">
                        <div class="col-xl-6 col-md-4">
                            <div class="tp-cart-update">
                                <a href="{{ route('carts.index') }}" class="tp-cart-update-btn">Ir al carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
