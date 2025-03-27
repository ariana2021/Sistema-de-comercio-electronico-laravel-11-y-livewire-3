@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area breadcrumb__style-2 include-bg pt-50 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <div class="breadcrumb__list has-icon">
                            <span class="breadcrumb-icon">
                                <i class="fa-solid fa-house-heart"></i>
                            </span>
                            <span><a href="#">Inicio</a></span>
                            <span><a href="#">{{ $product->category->name }}</a></span>
                            <span>{{ $product->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <livewire:product-detail-component :productId="$product->id"/>

@endsection
