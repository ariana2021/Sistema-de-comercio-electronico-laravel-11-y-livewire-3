<div>
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="tp-shop-sidebar me-3">
                <!-- Categorías -->
                <div class="tp-shop-widget mb-3">
                    <h3 class="tp-shop-widget-title">Categorías</h3>
                    <div class="tp-shop-widget-content">
                        <ul class="list-unstyled">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="#" 
                                       class="d-block py-2 px-3 rounded text-dark text-decoration-none transition {{ $category->id == $categorySelected ? 'active-link' : '' }}"
                                       wire:click.prevent="setCategory({{ $category->id }})">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
        
                <!-- Marcas -->
                <div class="tp-shop-widget">
                    <h3 class="tp-shop-widget-title">Marca</h3>
                    <div class="tp-shop-widget-content">
                        <ul class="list-unstyled">
                            @foreach ($brands as $brand)
                                <li>
                                    <a href="#" 
                                       class="d-block py-2 px-3 rounded text-dark text-decoration-none transition {{ $brand->id == $brandSelected ? 'active-link' : '' }}"
                                       wire:click.prevent="setBrand({{ $brand->id }})">
                                        {{ $brand->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-8">
            <div class="tp-shop-main-wrapper">
                <!-- Opciones de vista y ordenamiento -->
                <div class="tp-shop-top mb-45">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="tp-shop-top-left d-flex align-items-center">
                                <div class="tp-shop-top-tab tp-tab">
                                    <ul class="nav nav-tabs" id="productTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $viewMode == 'grid' ? 'active' : '' }}"
                                                wire:click="$set('viewMode', 'grid')">
                                                <i class="fa-solid fa-grid-2"></i>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $viewMode == 'list' ? 'active' : '' }}"
                                                wire:click="$set('viewMode', 'list')">
                                                <i class="fa-regular fa-list-radio"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tp-shop-top-result">
                                    <p>Mostrando {{ $products->firstItem() }}–{{ $products->lastItem() }} de
                                        {{ $products->total() }} resultados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="tp-shop-top-right d-sm-flex align-items-center justify-content-xl-end">
                                <select wire:model.live="sortBy">
                                    <option value="default">Orden por defecto</option>
                                    <option value="low_high">Menor a mayor</option>
                                    <option value="high_low">Mayor a menor</option>
                                    <option value="new">Nuevos agregados</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tp-shop-items-wrapper tp-shop-item-primary">
                    <div class="tab-content" id="productTabContent">
                        @if ($viewMode == 'grid')
                            <div class="tab-pane fade show active" id="grid-tab-pane">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-xl-4 col-md-6 col-sm-6">
                                            <div class="tp-product-item-2 mb-40">
                                                <div class="tp-product-thumb-2 p-relative z-index-1 fix w-img">
                                                    <a href="{{ route('product.detail', $product->slug) }}">
                                                        <img loading="lazy" src="{{ Storage::url($product->image) }}" alt="">
                                                    </a>
                                                    <!-- product action -->
                                                    <div class="tp-product-action-2 tp-product-action-blackStyle">
                                                        <div class="tp-product-action-item-2 d-flex flex-column">
                                                            <button type="button"
                                                                class="tp-product-action-btn-2 tp-product-add-cart-btn"
                                                                wire:click="addToCart({{ $product->id }})">
                                                                <i class="far fa-cart-plus"></i>
                                                                <span
                                                                    class="tp-product-tooltip tp-product-tooltip-right">Agregar
                                                                    al carrito</span>
                                                            </button>
                                                            <button type="button"
                                                                class="tp-product-action-btn-2 tp-product-quick-view-btn"
                                                                wire:click="openModal({{ $product->id }})">
                                                                <i class="fal fa-eye"></i>
                                                                <span
                                                                    class="tp-product-tooltip tp-product-tooltip-right">Vista
                                                                    previa</span>
                                                            </button>
                                                            <button type="button"
                                                                wire:click="addToWishlist({{ $product->id }})"
                                                                class="tp-product-action-btn-2 tp-product-add-to-wishlist-btn">
                                                                <i class="fas fa-heart-circle"></i>
                                                                <span
                                                                    class="tp-product-tooltip tp-product-tooltip-right">Agregar
                                                                    a lista de deseo</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tp-product-content-2 pt-15">
                                                    <div class="tp-product-tag-2">
                                                        <a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a>
                                                    </div>
                                                    <h3 class="tp-product-title-2">
                                                        <a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                    </h3>
                                                    <div class="tp-product-price-wrapper-2">
                                                        <span class="tp-product-price-2 new-price">
                                                            {{ config('app.currency_symbol') }}{{ number_format($product->discount_price, 2) }}
                                                        </span>
                                                        @if ($product->price)
                                                            <span class="tp-product-price-2 old-price">
                                                                {{ config('app.currency_symbol') }}{{ number_format($product->price, 2) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="tab-pane fade show active" id="list-tab-pane">
                                <div class="tp-shop-list-wrapper tp-shop-item-primary mb-70">
                                    <div class="row">
                                        @foreach ($products as $product)
                                            <div class="col-xl-12">
                                                <div class="tp-product-list-item d-md-flex">
                                                    <div class="tp-product-list-thumb p-relative fix">
                                                        <a href="{{ route('product.detail', $product->slug) }}">
                                                            <img loading="lazy" src="{{ Storage::url($product->image) }}"
                                                                alt="">
                                                        </a>
                                                        <!-- product action -->
                                                        <div class="tp-product-action-2 tp-product-action-blackStyle">
                                                            <div class="tp-product-action-item-2 d-flex flex-column">
                                                                <button type="button"
                                                                    class="tp-product-action-btn-2 tp-product-add-cart-btn"
                                                                    wire:click="addToCart({{ $product->id }})">
                                                                    <i class="far fa-cart-plus"></i>
                                                                    <span
                                                                        class="tp-product-tooltip tp-product-tooltip-right">Agregar
                                                                        al carrito</span>
                                                                </button>
                                                                <button type="button"
                                                                    class="tp-product-action-btn-2 tp-product-quick-view-btn"
                                                                    wire:click="openModal({{ $product->id }})">
                                                                    <i class="fal fa-eye"></i>
                                                                    <span
                                                                        class="tp-product-tooltip tp-product-tooltip-right">Vista
                                                                        previa</span>
                                                                </button>
                                                                <button type="button"
                                                                    wire:click="addToWishlist({{ $product->id }})"
                                                                    class="tp-product-action-btn-2 tp-product-add-to-wishlist-btn">
                                                                    <i class="fas fa-heart-circle"></i>
                                                                    <span
                                                                        class="tp-product-tooltip tp-product-tooltip-right">Agregar
                                                                        a lista de deseo</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tp-product-list-content">
                                                        <div class="tp-product-content-2 pt-15">
                                                            <div class="tp-product-tag-2">
                                                                <a
                                                                    href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a>
                                                            </div>
                                                            <h3 class="tp-product-title-2">
                                                                <a
                                                                    href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a>
                                                            </h3>
                                                            <div class="tp-product-price-wrapper-2">
                                                                <span class="tp-product-price-2 new-price">
                                                                    {{ config('app.currency_symbol') }}{{ number_format($product->price, 2) }}
                                                                </span>
                                                                @if ($product->old_price)
                                                                    <span class="tp-product-price-2 old-price">
                                                                        {{ config('app.currency_symbol') }}{{ number_format($product->old_price, 2) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p>{{ $product->description }}</p>
                                                            <div class="tp-product-list-add-to-cart">
                                                                <button class="tp-product-list-add-to-cart-btn"
                                                                    wire:click="addToCart({{ $product->id }})">
                                                                    Añadir al carrito
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="tp-shop-pagination mt-20">
                    {{ $products->links() }}
                </div>
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
                                        <img loading="lazy" src="{{ Storage::url($image) }}" alt="" class="img-fluid">
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
                                        <img loading="lazy" src="{{ Storage::url($image) }}" alt=""
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
