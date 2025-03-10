@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-95 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Shopping Cart</h3>
                        <div class="breadcrumb__list">
                            <span><a href="#">Home</a></span>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <!-- cart area start -->
    <section class="tp-cart-area pb-120">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="tp-cart-list mb-25 mr-30">
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
                                @foreach ($carts as $cart)
                                    <tr>
                                        <!-- img -->
                                        <td class="tp-cart-img"><a href="#"> <img
                                                    src="{{ $cart['image'] }}" alt=""></a></td>
                                        <!-- title -->
                                        <td class="tp-cart-title">
                                            <a href="#">{{ $cart['name'] }}</a>
                                        </td>
                                        <!-- price -->
                                        <td class="tp-cart-price"><span>S/{{ $cart['price'] }}</span></td>
                                        <!-- quantity -->
                                        <td class="tp-cart-quantity">
                                            <div class="tp-product-quantity mt-10 mb-10">
                                                <span class="tp-cart-minus">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            <input class="tp-cart-input" type="text" value="{{ $cart['quantity'] }}">
                                                <span class="tp-cart-plus">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                            </div>
                                        </td>
                                        <!-- action -->
                                        <td class="tp-cart-action">
                                            <button class="tp-cart-action-btn">
                                                <i class="fas fa-remove"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tp-cart-bottom">
                        <div class="row align-items-end">
                            <div class="col-xl-6 col-md-8">
                                <div class="tp-cart-coupon">
                                    <form action="#">
                                        <div class="tp-cart-coupon-input-box">
                                            <label>Coupon Code:</label>
                                            <div class="tp-cart-coupon-input d-flex align-items-center">
                                                <input type="text" placeholder="Enter Coupon Code">
                                                <button type="submit">Apply</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-4">
                                <div class="tp-cart-update text-md-end">
                                    <button type="button" class="tp-cart-update-btn">Update Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="tp-cart-checkout-wrapper">
                        <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                            <span class="tp-cart-checkout-top-title">Subtotal</span>
                            <span class="tp-cart-checkout-top-price">$742</span>
                        </div>
                        <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">Shipping</h4>

                            <div class="tp-cart-checkout-shipping-option-wrapper">
                                <div class="tp-cart-checkout-shipping-option">
                                    <input id="flat_rate" type="radio" name="shipping">
                                    <label for="flat_rate">Flat rate: <span>$20.00</span></label>
                                </div>
                                <div class="tp-cart-checkout-shipping-option">
                                    <input id="local_pickup" type="radio" name="shipping">
                                    <label for="local_pickup">Local pickup: <span> $25.00</span></label>
                                </div>
                                <div class="tp-cart-checkout-shipping-option">
                                    <input id="free_shipping" type="radio" name="shipping">
                                    <label for="free_shipping">Free shipping</label>
                                </div>
                            </div>
                        </div>
                        <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                            <span>Total</span>
                            <span>$724</span>
                        </div>
                        <div class="tp-cart-checkout-proceed">
                            <a href="{{ route('carts.checkout') }}" class="tp-cart-checkout-btn w-100">Proceed to
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart area end -->
@endsection
