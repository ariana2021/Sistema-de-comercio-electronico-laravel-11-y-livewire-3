<div>

    <div class="row">
        <div class="col-xl-12">
            <div class="tp-product-tab-2 tp-tab mb-50 text-center">
                <nav>
                    <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">

                        @foreach ($categories as $category)
                            <button class="nav-link @if ($loop->first) active @endif"
                                id="nav-{{ $category->slug }}-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-{{ $category->slug }}" type="button" role="tab"
                                aria-controls="nav-{{ $category->slug }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $category->name }}
                                <span class="tp-product-tab-tooltip">{{ $category->products->count() }}</span>
                            </button>
                        @endforeach

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="tab-content" id="nav-tabContent">
                @foreach ($categories as $category)
                    <div class="tab-pane fade show @if ($loop->first) active @endif"
                        id="nav-{{ $category->slug }}" role="tabpanel" aria-labelledby="nav-{{ $category->slug }}-tab"
                        tabindex="0">
                        <div class="row">
                            @foreach ($category->products as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                    <div class="tp-product-item p-relative transition-3 mb-25">
                                        <div class="tp-product-thumb p-relative fix m-img">
                                            <a href="{{ route('product.detail', $product->slug) }}">
                                                <img src="{{ Storage::url($product->image) }}" alt="product-electronic">
                                            </a>
                                            <div class="tp-product-badge">
                                                <span class="product-hot">Nuevo</span>
                                            </div>
                                            <div class="tp-product-action">
                                                <div class="tp-product-action-item d-flex flex-column">
                                                    <button type="button" wire:click="addToCart({{ $product->id }})"
                                                        class="tp-product-action-btn tp-product-add-cart-btn">
                                                        <i class="far fa-cart-plus"></i>
                                                        <span class="tp-product-tooltip">Agregar</span>
                                                    </button>
                                                    <button type="button"
                                                        class="tp-product-action-btn tp-product-quick-view-btn"
                                                        wire:click="openModal({{ $product->id }})">
                                                        <i class="fal fa-eye"></i>
                                                        <span class="tp-product-tooltip">Vista previa</span>
                                                    </button>
                                                    <button type="button"
                                                        class="tp-product-action-btn tp-product-add-to-wishlist-btn"
                                                        wire:click="addToWishlist({{ $product->id }})">
                                                        <i class="fas fa-heart-circle"></i>
                                                        <span class="tp-product-tooltip">Agregar a lista de
                                                            deseos</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tp-product-content">
                                            <div class="tp-product-category">
                                                <a
                                                    href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a>
                                            </div>
                                            <h3 class="tp-product-title">
                                                <a href="{{ route('product.detail', $product->slug) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>
                                            <div class="tp-product-rating d-flex align-items-center">
                                                <div class="tp-product-rating-icon">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $product->average_rating)
                                                            <span><i class="fa-solid fa-star"></i></span>
                                                        @elseif ($i - 0.5 == $product->average_rating)
                                                            <span><i class="fa-solid fa-star-half-stroke"></i></span>
                                                        @else
                                                            <span><i class="fa-regular fa-star"></i></span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="tp-product-rating-text">
                                                    <span>({{ $product->ratings->count() }} Reseñas)</span>
                                                </div>
                                            </div>
                                            <div class="tp-product-price-wrapper">
                                                <span
                                                    class="tp-product-price old-price">{{ config('app.currency_symbol') }}{{ $product->price }}</span>
                                                <span
                                                    class="tp-product-price new-price">{{ config('app.currency_symbol') }}{{ $product->discount_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade tp-product-modal @if ($isOpen) show d-block @endif"
        id="producQuickViewModal" tabindex="-1" aria-labelledby="producQuickViewModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="tp-product-modal-content d-lg-flex align-items-start">
                    <button type="button" class="tp-product-modal-close-btn" wire:click="closeModal"><i
                            class="fa-regular fa-xmark"></i></button>

                    <!-- Galería de imágenes -->
                    <div class="tp-product-details-thumb-wrapper tp-tab d-sm-flex">
                        <nav>
                            <div class="nav nav-tabs flex-sm-column" id="productDetailsNavThumb" role="tablist">
                                @foreach ($images as $index => $image)
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="nav-{{ $index }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-{{ $index }}" type="button" role="tab"
                                        aria-controls="nav-{{ $index }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        <img src="{{ Storage::url($image) }}" alt="" class="img-fluid">
                                    </button>
                                @endforeach
                            </div>
                        </nav>

                        <div class="tab-content m-img d-flex align-items-center justify-content-center w-100"
                            id="productDetailsNavContent">
                            @foreach ($images as $index => $image)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="nav-{{ $index }}" role="tabpanel"
                                    aria-labelledby="nav-{{ $index }}-tab" tabindex="0">
                                    <div class="tp-product-details-nav-main-thumb text-center">
                                        <img src="{{ Storage::url($image) }}" alt=""
                                            class="img-fluid mx-auto d-block">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- Información del Producto -->
                    <div class="tp-product-details-wrapper">
                        @if ($productView)
                            <div class="tp-product-details-category">
                                <span>{{ $productView->category->name ?? 'Sin categoría' }}</span>
                            </div>
                            <h3 class="tp-product-details-title">{{ $productView->name }}</h3>

                            <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                                <div class="tp-product-details-stock mb-10">
                                    <span>{{ $productView->stock > 0 ? 'En Stock' : 'Agotado' }}</span>
                                </div>
                            </div>

                            <p>{{ $productView->description }}</p>

                            <div class="tp-product-details-price-wrapper mb-20">
                                @if ($productView->discount_price)
                                    <span
                                        class="tp-product-details-price old-price">{{ config('app.currency_symbol') }}{{ number_format($productView->price, 2) }}</span>
                                    <span
                                        class="tp-product-details-price new-price">{{ config('app.currency_symbol') }}{{ number_format($productView->discount_price, 2) }}</span>
                                @else
                                    <span
                                        class="tp-product-details-price new-price">{{ config('app.currency_symbol') }}{{ number_format($productView->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="tp-product-details-action-wrapper">
                                <h3 class="tp-product-details-action-title">Cantidad</h3>
                                <div class="tp-product-details-action-item-wrapper d-sm-flex align-items-center">
                                    <div class="tp-product-details-quantity">
                                        <div class="tp-product-quantity mb-15 mr-15">
                                            <span class="tp-cart-minus" wire:click="decreaseQuantity">-</span>
                                            <input class="tp-cart-input" type="text" wire:model="quantity" />
                                            <span class="tp-cart-plus" wire:click="increaseQuantity">+</span>
                                        </div>
                                    </div>
                                    <div class="tp-product-details-add-to-cart mb-15 w-100">
                                        <button class="tp-product-details-add-to-cart-btn w-100"
                                            wire:click="addToCart({{ $productView->id }})">
                                            Agregar al Carrito
                                        </button>
                                    </div>
                                </div>
                                <button class="tp-product-details-buy-now-btn w-100">Comprar Ahora</button>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let activeTab = sessionStorage.getItem("activeTab");

            if (activeTab) {
                setTimeout(() => {
                    let tabButton = document.querySelector(`[data-bs-target="#${activeTab}"]`);
                    let tabContent = document.getElementById(activeTab);

                    if (tabButton && tabContent) {
                        document.querySelectorAll(".nav-link").forEach(el => el.classList.remove("active"));
                        document.querySelectorAll(".tab-pane").forEach(el => el.classList.remove("show",
                            "active"));

                        tabButton.classList.add("active");
                        tabContent.classList.add("show", "active");
                    }
                }, 100);
            }

            document.querySelectorAll(".nav-link").forEach(button => {
                button.addEventListener("click", function() {
                    let tabId = this.getAttribute("data-bs-target").replace("#", "");
                    sessionStorage.setItem("activeTab", tabId);
                });
            });

            window.Livewire.on('cartUpdated', () => {
                let activeTab = sessionStorage.getItem("activeTab");

                if (activeTab) {
                    setTimeout(() => {
                        let tabButton = document.querySelector(`[data-bs-target="#${activeTab}"]`);
                        let tabContent = document.getElementById(activeTab);

                        if (tabButton && tabContent) {
                            document.querySelectorAll(".nav-link").forEach(el => el.classList
                                .remove("active"));
                            document.querySelectorAll(".tab-pane").forEach(el => el.classList
                                .remove("show", "active"));

                            tabButton.classList.add("active");
                            tabContent.classList.add("show", "active");
                        }
                    }, 100);
                }
            });
        });
    </script>
@endpush
