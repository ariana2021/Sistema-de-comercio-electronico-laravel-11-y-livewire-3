<section class="tp-checkout-area pb-120" data-bg-color="#EFF1F5">
    <div class="container">
        <div class="row">
            <!-- Detalles de facturación -->
            <div class="col-lg-7">
                <!-- Mensajes -->
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="tp-checkout-bill-area">
                    <h3 class="tp-checkout-bill-title">Detalles de Facturación</h3>
                    <div class="tp-checkout-bill-form">
                        <div class="tp-checkout-bill-inner">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="tp-checkout-input">
                                        <label>Nombre <span>*</span></label>
                                        <input type="text" wire:model.defer="first_name" placeholder="Tu Nombre">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tp-checkout-input">
                                        <label>Apellido <span>*</span></label>
                                        <input type="text" wire:model.defer="last_name" placeholder="Tu Apellido">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp-checkout-input">
                                        <label>Correo Electrónico <span>*</span></label>
                                        <input type="email" wire:model.defer="email" placeholder="Tu Correo">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp-checkout-input">
                                        <label>Teléfono <span>*</span></label>
                                        <input type="text" wire:model.defer="phone" placeholder="Tu Teléfono">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp-checkout-input">
                                        <label>Dirección</label>
                                        <input type="text" wire:model.defer="address"
                                            placeholder="Dirección de la calle">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tp-checkout-input">
                                        <label>Ciudad</label>
                                        <input type="text" wire:model.defer="city" placeholder="Ciudad">
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tp-checkout-input">
                                        <label>Código Postal</label>
                                        <input type="text" wire:model.defer="zip_code" placeholder="Código Postal">
                                        @error('zip_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="order_notes">Nota</label>
                                        <textarea id="order_notes" class="form-control" wire:model.defer="order_notes" placeholder="Nota" rows="3"></textarea>
                                        @error('order_notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" id="confirm" class="form-check-input"
                                            wire:model="isConfirmed">
                                        <label for="confirm" class="form-check-label">Confirmo que mis datos son
                                            correctos</label>
                                    </div>
                                    @error('isConfirmed')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Resumen del Pedido -->
            <div class="col-lg-5">
                <!-- Cupón -->
                <div class="tp-checkout-verify-item">
                    <p class="tp-checkout-verify-reveal">
                        ¿Tienes un cupón?
                        <button type="button" class="tp-checkout-coupon-form-reveal-btn">
                            Haga clic aquí para ingresar su código
                        </button>
                    </p>
                    <div id="tpCheckoutCouponForm" class="tp-return-customer">
                        <form wire:submit.prevent="applyCoupon">
                            <div class="tp-return-customer-input">
                                <label>Código de cupón :</label>
                                <input type="text" wire:model.defer="coupon_code" placeholder="Coupon">
                            </div>
                            <button type="submit" class="tp-return-customer-btn tp-checkout-btn">Aplicar</button>
                        </form>
                    </div>
                </div>
                <div class="tp-checkout-place white-bg">
                    <h3 class="tp-checkout-place-title">Tu pedido</h3>
                    <div class="tp-order-info-list">
                        <ul>
                            <li class="tp-order-info-list-header">
                                <h4>Producto</h4>
                                <h4>Total</h4>
                            </li>
                            @foreach ($carts as $item)
                                <li class="tp-order-info-list-desc">
                                    <p>{{ $item['name'] }} <span>x {{ $item['quantity'] }}</span></p>
                                    <span>{{ config('app.currency_symbol') }}{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </li>
                            @endforeach
                            <li class="tp-order-info-list-subtotal">
                                <span>Subtotal</span>
                                <span>{{ config('app.currency_symbol') }}{{ number_format($subtotal, 2) }}</span>
                            </li>
                            <li class="tp-order-info-list-shipping">
                                <div>
                                    <span>Envío:</span>
                                    <b>{{ $shippingPlace }}</b>
                                </div>
                                <div>
                                    <span>Costo:</span>
                                    <b>{{ config('app.currency_symbol') }}{{ number_format($shippingCost, 2) }}</b>
                                </div>
                            </li>
                            <li></li>
                            <li class="tp-order-info-list-total">
                                <span>Total</span>
                                <span>{{ config('app.currency_symbol') }}{{ number_format($total, 2) }}</span>
                            </li>
                        </ul>
                    </div>

                    <p>Tienes
                        <strong>{{ config('app.currency_symbol') }}{{ number_format($cashbackDisponible, 2) }}</strong>
                        de cashback disponible.
                    </p>

                    <div class="mb-3">
                        <label for="cashback_usado">¿Cuánto cashback quieres usar?</label>
                        <input type="number" id="cashback_usado" wire:model="cashback_usado"
                            wire:change="handleCashbackChange"
                            max="{{ $cashbackDisponible }}" step="0.01" value="0">
                    
                        @error('fail')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <button wire:click="checkoutSuccess" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="checkoutSuccess">Procesar Pago</span>
                        <span wire:loading wire:target="checkoutSuccess">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Procesando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
