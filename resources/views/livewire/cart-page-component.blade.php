<section class="tp-cart-area pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-6">
                <div class="tp-cart-list mb-25 mr-30">
                    @if (empty($carts))
                        <div class="alert alert-warning text-center">
                            No hay productos en el carrito.
                        </div>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2" class="tp-cart-header-product">Producto</th>
                                    <th class="tp-cart-header-price">Precio</th>
                                    <th class="tp-cart-header-quantity">Cantidad</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $id => $cart)
                                    <tr>
                                        <td class="tp-cart-img">
                                            <a href="#"><img loading="lazy" src="{{ Storage::url($cart['image']) }}"
                                                    alt=""></a>
                                        </td>
                                        <td class="tp-cart-title p-2">
                                            <a href="#">{{ $cart['name'] }}</a>
                                        </td>
                                        <td class="tp-cart-price">
                                            <span>{{ config('app.currency_symbol') }}{{ number_format($cart['price'], 2) }}</span>
                                        </td>
                                        <td class="tp-cart-quantity">
                                            <div class="tp-product-quantity mt-10 mb-10">
                                                <button class="tp-cart-minus"
                                                    wire:click="updateQuantity({{ $id }}, -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input class="tp-cart-input" type="text"
                                                    value="{{ $cart['quantity'] }}" readonly>
                                                <button class="tp-cart-plus"
                                                    wire:click="updateQuantity({{ $id }}, 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="tp-cart-action">
                                            <button class="tp-cart-action-btn"
                                                wire:click="removeItem({{ $id }})">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>

                <!-- Campo de cupón -->
                <div class="tp-cart-bottom">
                    <div class="row align-items-end">
                        <div class="col-xl-6 col-md-8">
                            @if (session()->has('error'))
                                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success mt-3">{{ session('success') }}</div>
                            @endif
                            <div class="tp-cart-coupon">
                                <form wire:submit.prevent="applyCoupon">
                                    <div class="tp-cart-coupon-input-box">
                                        <label>Código de cupón:</label>
                                        <div class="tp-cart-coupon-input d-flex align-items-center">
                                            <input type="text" wire:model="couponCode"
                                                placeholder="Ingresa tu cupón">
                                            <button type="submit">Aplicar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-4">
                            <div class="tp-cart-update text-md-end">
                                <button type="button" wire:click="calculateTotals()"
                                    class="tp-cart-update-btn">Actualizar Carrito</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout -->
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div class="tp-cart-checkout-wrapper">
                    <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                        <span class="tp-cart-checkout-top-title">Subtotal</span>
                        <span
                            class="tp-cart-checkout-top-price">{{ config('app.currency_symbol') }}{{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if ($business->shipping_enabled)
                        <!-- Dirección y cálculo de envío -->
                        <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">Dirección de Envío</h4>
                            <input type="text" id="shipping-address" placeholder="Ingresa tu dirección">
                            <p>Costo de envío: <span
                                    id="shipping-cost">{{ config('app.currency_symbol') }}{{ number_format($shippingCost, 2) }}</span>
                            </p>
                            <div id="map" wire:ignore style="height: 300px; width: 100%;"></div>
                        </div>
                    @else
                        <!-- Alternativa cuando el envío está desactivado -->
                        <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">Envío no disponible</h4>
                            <p>El envío no está habilitado para este negocio. Por favor, recoge tu pedido en la tienda.
                            </p>
                        </div>
                    @endif

                    <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                        <span>Total</span>
                        <span>{{ config('app.currency_symbol') }}{{ number_format($total, 2) }}</span>
                    </div>

                    @if (!empty($carts))
                        <div class="tp-cart-checkout-proceed">
                            <a href="{{ route('carts.checkout') }}" class="tp-cart-checkout-btn w-100">Proceder al
                                Pago</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    @if ($business->shipping_enabled)
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                initMap();
            });

            let map, marker, autocomplete, service, directionsService, directionsRenderer;
            const costPerKm = {{ $business->cost_per_km ?? 0 }};
            const origin = {
                lat: {{ $business->latitude ?? 0 }},
                lng: {{ $business->longitude ?? 0 }}
            };

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: origin,
                    zoom: 14
                });

                marker = new google.maps.Marker({
                    map,
                    position: origin
                });

                autocomplete = new google.maps.places.Autocomplete(document.getElementById("shipping-address"));
                autocomplete.bindTo("bounds", map);

                service = new google.maps.DistanceMatrixService();
                directionsService = new google.maps.DirectionsService();
                directionsRenderer = new google.maps.DirectionsRenderer({
                    map
                });

                autocomplete.addListener("place_changed", function() {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    const destination = place.geometry.location;
                    marker.setPosition(destination);
                    map.setCenter(destination);

                    calcularCosto(origin, destination);
                    trazarRuta(origin, destination);
                });
            }

            function calcularCosto(origen, destino) {
                service.getDistanceMatrix({
                    origins: [origen],
                    destinations: [destino],
                    travelMode: "DRIVING"
                }, function(response, status) {
                    if (status === "OK" && response.rows[0].elements[0].status === "OK") {
                        let distanciaKm = response.rows[0].elements[0].distance.value / 1000;
                        let costoEnvio = (distanciaKm * costPerKm).toFixed(2);

                        // Usamos Livewire.dispatch para actualizar el shippingCost en Livewire
                        Livewire.dispatch('updateShippingCost', {
                            cost: costoEnvio
                        });

                        // También lo mostramos en el HTML
                        document.getElementById("shipping-cost").innerText =
                            `{{ config('app.currency_symbol') }}${costoEnvio}`;
                    } else {
                        alert("No se pudo calcular la distancia.");
                    }
                });
            }

            function trazarRuta(origen, destino) {
                directionsService.route({
                    origin: origen,
                    destination: destino,
                    travelMode: "DRIVING"
                }, function(result, status) {
                    if (status === "OK") {
                        directionsRenderer.setDirections(result);
                    } else {
                        alert("No se pudo trazar la ruta.");
                    }
                });
            }
        </script>
    @endif
@endpush
