@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-95 pb-50" data-bg-color="#EFF1F5">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Procesar Pago</h3>
                        <div class="breadcrumb__list">
                            <span><a href="#">Home</a></span>
                            <span>Procesar Pago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <!-- checkout area start -->
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
                                            <input type="text" value="{{ $first_name }}" placeholder="Tu Nombre"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="tp-checkout-input">
                                            <label>Apellido <span>*</span></label>
                                            <input type="text" value="{{ $last_name }}" placeholder="Tu Apellido"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                            <label>Correo Electrónico <span>*</span></label>
                                            <input type="email" value="{{ $email }}" placeholder="Tu Correo"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                            <label>Teléfono <span>*</span></label>
                                            <input type="text" value="{{ $phone }}" placeholder="Tu Teléfono"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                            <label>Dirección</label>
                                            <input type="text" value="{{ $address }}"
                                                placeholder="Dirección de la calle" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="tp-checkout-input">
                                            <label>Ciudad</label>
                                            <input type="text" value="{{ $city }}" placeholder="Ciudad" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="tp-checkout-input">
                                            <label>Código Postal</label>
                                            <input type="text" value="{{ $zip_code }}" placeholder="Código Postal"
                                                disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Resumen del Pedido -->
                <div class="col-lg-5">
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
                                <li class="tp-order-info-list-shipping">
                                    <span>Uso Cashback</span>
                                    <span>{{ config('app.currency_symbol') }}{{ number_format($cashback_usado, 2) }}</span>
                                </li>
                                <li class="tp-order-info-list-total">
                                    <span>Total</span>
                                    <span>{{ config('app.currency_symbol') }}{{ number_format($total, 2) }}</span>
                                </li>
                            </ul>
                        </div>

                        <h3 class="tp-checkout-place-title">Métodos de Pago</h3>

                        <div class="accordion" id="paymentMethodsAccordion">
                            <!-- Mercado Pago -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#mercadoPagoPayment">
                                        Mercado Pago
                                    </button>
                                </h2>
                                <div id="mercadoPagoPayment" class="accordion-collapse collapse"
                                    data-bs-parent="#paymentMethodsAccordion">
                                    <div class="accordion-body">
                                        <p>Paga con Mercado Pago usando tarjetas o saldo.</p>
                                        <div class="mercado-pago-button"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Niubiz -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#izipayPayment">
                                        Niubiz
                                    </button>
                                </h2>
                                <div id="izipayPayment" class="accordion-collapse collapse"
                                    data-bs-parent="#paymentMethodsAccordion">
                                    <div class="accordion-body">
                                        <p>Paga de forma segura con Niubiz usando tarjetas de débito o crédito.</p>
                                        <!-- Botón elegante para Niubiz -->
                                        <div class="d-grid">
                                            <button class="btn btn-outline-primary" type="button" onclick="openForm()">
                                                <i class="fas fa-credit-card"></i> Pagar con Niubiz
                                            </button>
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

    @push('scripts')
        @if ($preference_id)
            <script src="https://sdk.mercadopago.com/js/v2"></script>
            <script>
                const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}");
                const checkout = mp.checkout({
                    preference: {
                        id: "{{ $preference_id }}"
                    },
                    render: {
                        container: ".mercado-pago-button",
                        label: "Pagar con Mercado Pago"
                    }
                });
            </script>
        @endif

        <script type="text/javascript" src="{{ config('services.niubiz.url_js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let purchasenumber = Math.floor(Math.random() * 1000000000);
                let amount = {{ $total }};
                VisanetCheckout.configure({
                    sessiontoken: '{{ $session_token }}',
                    channel: 'web',
                    merchantid: '{{ config('services.niubiz.merchantId') }}',
                    purchasenumber: purchasenumber,
                    amount: amount,
                    expirationminutes: '20',
                    timeouturl: 'about:blank',
                    merchantlogo: 'img/comercio.png',
                    formbuttoncolor: '#000000',
                    action: "{{ route('checkout.paidNiubiz') }}?amount=" + amount + "&purchaseNumber=" +
                        purchasenumber,
                    complete: function(params) {
                        alert(JSON.stringify(params));
                    }
                });
            });

            function openForm() {
                VisanetCheckout.open();
                //VisanetCheckout.configuration.complete = procesar;
            }

            function procesar(parametros) {
                console.log(parametros);
            }
        </script>
    @endpush
    {{-- <livewire:payment-component /> --}}
    <!-- checkout area end -->
@endsection
