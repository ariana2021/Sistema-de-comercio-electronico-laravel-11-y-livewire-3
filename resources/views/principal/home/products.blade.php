@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Nuestros Productos</h3>
                        <div class="breadcrumb__list">
                            <span><a href="#">Inicio</a></span>
                            <span>Nuestros Productos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <!-- category area start -->
    <section class="tp-product-area pb-55">
        <div class="container">
            <div class="row">
                <livewire:product-component />
            </div>
        </div>
    </section>
    <!-- category area end -->
@endsection
