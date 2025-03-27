<div>
    <section class="tp-product-details-area">
        <div class="tp-product-details-top pb-45">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="tp-product-details-thumb-wrapper tp-tab d-sm-flex">
                            <nav>
                                <div class="nav nav-tabs flex-sm-column" id="productDetailsNavThumb" role="tablist">
                                    @foreach ($product->images as $index => $image)
                                        <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                            id="nav-{{ $index }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-{{ $index }}" type="button" role="tab"
                                            aria-controls="nav-{{ $index }}"
                                            aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                            <img src="{{ Storage::url($image->url) }}" alt="">
                                        </button>
                                    @endforeach
                                </div>
                            </nav>

                            <div class="tab-content m-img" id="productDetailsNavContent">
                                @foreach ($product->images as $index => $image)
                                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                        id="nav-{{ $index }}" role="tabpanel"
                                        aria-labelledby="nav-{{ $index }}-tab" tabindex="0">
                                        <div class="tp-product-details-nav-main-thumb d-flex justify-content-center align-items-center"
                                            style="height: 400px;">
                                            <img src="{{ Storage::url($image->url) }}" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </div> <!-- col end -->
                    <div class="col-xl-5 col-lg-6">
                        <div class="tp-product-details-wrapper">
                            <!-- Categoría -->
                            <div class="tp-product-details-category">
                                <span>{{ $product->category->name ?? 'Sin categoría' }}</span>
                            </div>
                            <h3 class="tp-product-details-title">{{ $product->name }}</h3>

                            <!-- Inventario y Calificación -->
                            <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                                <div class="tp-product-details-stock mb-10">
                                    <span>{{ $product->stock > 0 ? 'En stock' : 'Agotado' }}</span>
                                </div>
                                <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">
                                    <div class="tp-product-details-rating">
                                        @php
                                            $rating = round($product->rating ?? 5);
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span><i
                                                    class="fa-solid fa-star {{ $i <= $rating ? 'text-warning' : 'text-muted' }}"></i></span>
                                        @endfor
                                    </div>
                                    <div class="tp-product-details-reviews">
                                        <span>({{ $product->reviews_count ?? 0 }} Reseñas)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <p>{{ Str::limit($product->description, 100) }} <span>Ver más</span></p>

                            <!-- Precio -->
                            <div class="tp-product-details-price-wrapper mb-20">
                                @if ($product->discount_price)
                                    <span
                                        class="tp-product-details-price old-price">{{ config('app.currency_symbol') }}{{ number_format($product->price, 2) }}</span>
                                @endif
                                <span
                                    class="tp-product-details-price new-price">{{ config('app.currency_symbol') }}{{ number_format($product->discount_price, 2) }}</span>
                            </div>

                            <!-- Acciones -->
                            <div class="tp-product-details-action-wrapper">
                                <h3 class="tp-product-details-action-title">Cantidad</h3>
                                <div class="tp-product-details-action-item-wrapper d-flex align-items-center">
                                    <div class="tp-product-details-quantity">
                                        <div class="tp-product-quantity mb-15 mr-15">
                                            <span class="tp-cart-minus" wire:click="decreaseQuantity">-</span>
                                            <input class="tp-cart-input" type="text" value="1">
                                            <span class="tp-cart-plus" wire:click="increaseQuantity">+</span>
                                        </div>
                                    </div>
                                    <div class="tp-product-details-add-to-cart mb-15 w-100">
                                        <button class="tp-product-details-add-to-cart-btn w-100"
                                            wire:click="addToCart({{ $product->id }})">
                                            Añadir al carrito
                                        </button>
                                    </div>
                                </div>
                                <button class="tp-product-details-buy-now-btn w-100">Comprar ahora</button>
                            </div>

                            <!-- Lista de deseos -->
                            <div class="tp-product-details-action-sm">
                                <button type="button" class="tp-product-details-action-sm-btn"
                                    wire:click="addToWishlist({{ $product->id }})">
                                    <i class="fas fa-heart-circle"></i> Añadir a favoritos
                                </button>
                            </div>

                            <!-- SKU y Categoría -->
                            <div class="tp-product-details-query">
                                <div class="tp-product-details-query-item d-flex align-items-center">
                                    <span>SKU: </span>
                                    <p>{{ $product->sku ?? 'N/A' }}</p>
                                </div>
                                <div class="tp-product-details-query-item d-flex align-items-center">
                                    <span>Categoría: </span>
                                    <p>{{ $product->category->name ?? 'Sin categoría' }}</p>
                                </div>
                            </div>

                            <!-- Redes Sociales -->
                            <div class="tp-product-details-social">
                                <span>Compartir: </span>
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#"><i class="fa-brands fa-vimeo-v"></i></a>
                            </div>

                            <!-- Mensajes -->
                            <div class="tp-product-details-msg mb-15">
                                <ul>
                                    <li>Devoluciones fáciles en 30 días</li>
                                    <li>Ordena antes de las 2:30 p.m. para envío el mismo día</li>
                                </ul>
                            </div>

                            <!-- Métodos de pago -->
                            <div
                                class="tp-product-details-payment d-flex align-items-center flex-wrap justify-content-between">
                                <p>Pago seguro y garantizado</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="tp-product-details-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tp-product-details-tab-nav tp-tab">
                            <nav>
                                <div class="nav nav-tabs justify-content-center p-relative tp-product-tab"
                                    id="navPresentationTab" role="tablist">

                                    @auth
                                        <button class="nav-link active" id="nav-review-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-review" type="button" role="tab"
                                            aria-controls="nav-review" aria-selected="true">
                                            Reseñas ({{ $ratings->count() ?? 0 }})
                                        </button>
                                    @endauth

                                    <button class="nav-link {{ Auth::check() ? '' : 'active' }}" id="nav-addInfo-tab"
                                        data-bs-toggle="tab" data-bs-target="#nav-addInfo" type="button"
                                        role="tab" aria-controls="nav-addInfo"
                                        aria-selected="{{ Auth::check() ? 'false' : 'true' }}">
                                        Información adicional
                                    </button>

                                    <span id="productTabMarker" class="tp-product-details-tab-line"></span>
                                </div>
                            </nav>

                            <div class="tab-content" id="navPresentationTabContent">
                                <!-- TAB de Reseñas (Solo si el usuario está logueado) -->
                                @auth
                                    <div class="tab-pane fade show active" id="nav-review" role="tabpanel"
                                        aria-labelledby="nav-review-tab" tabindex="0">
                                        <div class="tp-product-details-review-wrapper pt-60">
                                            <div class="row">
                                                <!-- Resumen de calificaciones -->
                                                <div class="col-lg-6">
                                                    <div class="tp-product-details-review-statics">
                                                        <div class="tp-product-details-review-number d-inline-block mb-50">
                                                            <h3 class="tp-product-details-review-number-title">Comentarios
                                                                de
                                                                clientes
                                                            </h3>
                                                            <div
                                                                class="tp-product-details-review-summery d-flex align-items-center">
                                                                <div class="tp-product-details-review-summery-value">
                                                                    <span>{{ number_format($product->average_rating ?? 0, 1) }}</span>
                                                                </div>
                                                                <div
                                                                    class="tp-product-details-review-summery-rating d-flex align-items-center">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <span><i
                                                                                class="fa-solid fa-star {{ $product->average_rating >= $i ? 'text-warning' : '' }}"></i></span>
                                                                    @endfor
                                                                    <p>({{ $ratings->count() }} Reseñas)</p>
                                                                </div>
                                                            </div>
                                                            <div class="tp-product-details-review-rating-list">
                                                                @php
                                                                    $percentages = $this->getRatingPercentages();
                                                                @endphp

                                                                @foreach ($percentages as $stars => $percentage)
                                                                    <div
                                                                        class="tp-product-details-review-rating-item d-flex align-items-center">
                                                                        <span>{{ $stars }}
                                                                            Star{{ $stars > 1 ? 's' : '' }}</span>
                                                                        <div class="tp-product-details-review-rating-bar">
                                                                            <span
                                                                                class="tp-product-details-review-rating-bar-inner"
                                                                                style="width: {{ $percentage }}%;"></span>
                                                                        </div>
                                                                        <div
                                                                            class="tp-product-details-review-rating-percent">
                                                                            <span>{{ $percentage }}%</span>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- Lista de reseñas -->
                                                    <div class="tp-product-details-review-list pr-110">
                                                        <h3 class="tp-product-details-review-title">Calificación y revisión
                                                        </h3>
                                                        @foreach ($ratings as $rating)
                                                            <div
                                                                class="tp-product-details-review-avater d-flex align-items-start">
                                                                <div class="tp-product-details-review-avater-thumb">
                                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($rating->user->name) }}"
                                                                        alt="">
                                                                </div>
                                                                <div class="tp-product-details-review-avater-content">
                                                                    <div
                                                                        class="tp-product-details-review-avater-rating d-flex align-items-center">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <span>
                                                                                <i
                                                                                    class="fa-solid fa-star {{ $rating->rating >= $i ? 'text-warning' : 'text-secondary' }}"></i>
                                                                            </span>
                                                                        @endfor
                                                                    </div>

                                                                    <h3 class="tp-product-details-review-avater-title">
                                                                        {{ $rating->user->name }}</h3>
                                                                    <span
                                                                        class="tp-product-details-review-avater-meta">{{ $rating->created_at->format('d M, Y') }}</span>
                                                                    <div class="tp-product-details-review-avater-comment">
                                                                        <p>{{ $rating->comment }}</p>
                                                                    </div>

                                                                    @if (Auth::id() == $rating->user_id)
                                                                        <div class="mt-2">
                                                                            <button
                                                                                wire:click="editRating({{ $rating->id }})"
                                                                                class="btn btn-sm btn-primary"><i
                                                                                    class="fas fa-edit"></i></button>
                                                                            <button
                                                                                wire:click="deleteRating({{ $rating->id }})"
                                                                                class="btn btn-sm btn-danger"><i
                                                                                    class="fas fa-times-circle"></i></button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Formulario de reseña -->
                                                <div class="col-lg-6">
                                                    <div class="tp-product-details-review-form">
                                                        <h3 class="tp-product-details-review-form-title">
                                                            {{ $editingRatingId ? 'Editar tu reseña' : 'Revisar este producto' }}
                                                        </h3>

                                                        @if (session()->has('message'))
                                                            <div class="alert alert-success">{{ session('message') }}
                                                            </div>
                                                        @endif

                                                        <form wire:submit.prevent="submit">
                                                            <div
                                                                class="tp-product-details-review-form-rating d-flex align-items-center">
                                                                <p>Tu calificación:</p>
                                                                <div
                                                                    class="tp-product-details-review-form-rating-icon d-flex align-items-center">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <span wire:click="setRating({{ $i }})"
                                                                            style="cursor: pointer;">
                                                                            <i
                                                                                class="fa-solid fa-star {{ $i <= $qualification ? 'text-warning' : 'text-secondary' }}"></i>
                                                                        </span>
                                                                    @endfor
                                                                </div>

                                                                <input type="hidden" wire:model="qualification">
                                                            </div>

                                                            @error('qualification')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                            <div class="tp-product-details-review-input-wrapper">
                                                                <textarea wire:model="comment" placeholder="Escribe tu reseña aquí..."></textarea>
                                                                @error('comment')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="tp-product-details-review-btn-wrapper">
                                                                <button type="submit"
                                                                    class="tp-product-details-review-btn">
                                                                    {{ $editingRatingId ? 'Actualizar' : 'Enviar' }}
                                                                </button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endauth

                                <!-- TAB de Información Adicional -->
                                <div class="tab-pane fade {{ Auth::check() ? '' : 'show active' }}" id="nav-addInfo"
                                    role="tabpanel" aria-labelledby="nav-addInfo-tab" tabindex="0">
                                    <div class="tp-product-details-additional-info">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-10">
                                                falta
                                            </div>
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

    <section class="tp-related-product pt-35">
        <div class="container">
            <div class="row">
                <div class="tp-section-title-wrapper-6 text-center mb-40">
                    <span class="tp-section-title-pre-6">Productos del día siguiente</span>
                    <h3 class="tp-section-title-6">Productos relacionados</h3>
                </div>
            </div>
            <div class="row">
                <div class="tp-product-related-slider">
                    <div class="mb-10">
                        <div class="row">
                            @foreach ($relatedProducts as $related)
                                <div class="col-md-3">
                                    <div class="tp-product-item-3 tp-product-style-primary mb-50">
                                        <div class="tp-product-thumb-3 mb-15 fix p-relative z-index-1">
                                            <a href="{{ route('product.delete', $related->slug) }}">
                                                <img src="{{ Storage::url($related->image) }}"
                                                    alt="{{ $related->name }}">
                                            </a>

                                            <!-- Etiqueta de descuento si aplica -->
                                            @if ($related->discount)
                                                <div class="tp-product-badge">
                                                    <span class="product-offer">-{{ $related->discount }}%</span>
                                                </div>
                                            @endif

                                            <!-- Acciones del producto -->
                                            <div
                                                class="tp-product-action-3 tp-product-action-4 has-shadow tp-product-action-primaryStyle">
                                                <div class="tp-product-action-item-3 d-flex flex-column">
                                                    <button type="button"
                                                        class="tp-product-action-btn-3 tp-product-add-cart-btn"
                                                        wire:click="addToCart({{ $related->id }})">
                                                        <i class="far fa-cart-plus"></i>
                                                        <span class="tp-product-tooltip">Añadir al carrito</span>
                                                    </button>
                                                    <button type="button"
                                                        class="tp-product-action-btn-3 tp-product-quick-view-btn"
                                                        wire:click="openModal({{ $related->id }})">
                                                        <i class="fal fa-eye"></i>
                                                        <span class="tp-product-tooltip">Vista rápida</span>
                                                    </button>
                                                    <button type="button"
                                                        class="tp-product-action-btn-3 tp-product-add-to-wishlist-btn"
                                                        wire:click="addToWishlist({{ $related->id }})">
                                                        <i class="fas fa-heart-circle"></i>
                                                        <span class="tp-product-tooltip">Añadir a la lista de
                                                            deseos</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="tp-product-add-cart-btn-large-wrapper" wire:click="addToCart({{ $related->id }})">
                                                <button type="button" class="tp-product-add-cart-btn-large">
                                                    Añadir a la cesta
                                                </button>
                                            </div>
                                        </div>
                                        <div class="tp-product-content-3">
                                            <div class="tp-product-tag-3">
                                                <span>{{ $related->category->name }}</span>
                                            </div>
                                            <h3 class="tp-product-title-3">
                                                <a
                                                    href="{{ route('product.detail', $related->slug) }}">{{ $related->name }}</a>
                                            </h3>
                                            <div class="tp-product-price-wrapper-3">
                                                <span
                                                    class="tp-product-price-3 new-price">{{ config('app.currency_symbol') }}{{ number_format($related->discount_price, 2) }}</span>
                                                @if ($related->discount_price)
                                                    <span
                                                        class="tp-product-price-3 old-price">{{ config('app.currency_symbol') }}{{ number_format($related->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
