<div class="row">
    @foreach ($products as $product)
        <div class="col-xl-3 col-lg-3 col-sm-6">
            <div class="tp-product-item p-relative transition-3 mb-25">
                <div class="tp-product-thumb p-relative fix m-img">
                    <a href="product-details.html">
                        <img src="{{ $product->image }}" alt="product-electronic">
                    </a>

                    <!-- product badge -->
                    <div class="tp-product-badge">
                        <span class="product-hot">Nuevo</span>
                    </div>

                    <!-- product action -->
                    <div class="tp-product-action">
                        <div class="tp-product-action-item d-flex flex-column">
                            <button type="button" wire:click="addToCart({{ $product->id }})"
                                class="tp-product-action-btn tp-product-add-cart-btn">
                                <i class="far fa-cart-plus"></i>
                                <span class="tp-product-tooltip">Agregar</span>
                            </button>

                            <button type="button" class="tp-product-action-btn tp-product-quick-view-btn"
                                data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                <i class="fal fa-eye"></i>
                                <span class="tp-product-tooltip">Vista previa</span>
                            </button>

                            <button type="button" class="tp-product-action-btn tp-product-add-to-wishlist-btn">
                                <i class="fas fa-heart-circle"></i>
                                <span class="tp-product-tooltip">Agregar a lista de deseos</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- product content -->
                <div class="tp-product-content">
                    <div class="tp-product-category">
                        <a href="shop.html">{{ $product->category->name }}</a>
                    </div>
                    <h3 class="tp-product-title">
                        <a href="product-details.html">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <div class="tp-product-rating d-flex align-items-center">
                        <div class="tp-product-rating-icon">
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star"></i></span>
                            <span><i class="fa-solid fa-star-half-stroke"></i></span>
                        </div>
                        <div class="tp-product-rating-text">
                            <span>(7 Review)</span>
                        </div>
                    </div>
                    <div class="tp-product-price-wrapper">
                        <span class="tp-product-price old-price">S/{{ $product->price }}</span>
                        <span class="tp-product-price new-price">${{ $product->discount_price }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
