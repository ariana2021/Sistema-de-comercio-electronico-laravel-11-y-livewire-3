@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-95 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Mi carrito</h3>
                        <div class="breadcrumb__list">
                            <span><a href="{{ route('index') }}">Inicio</a></span>
                            <span>Mi carrito</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <livewire:cart-page-component />

@endsection
