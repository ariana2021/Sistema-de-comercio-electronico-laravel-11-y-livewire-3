@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center vh-100 text-center">
    <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 100px;"></i>
    <h1 class="text-danger mt-3">Pago Fallido</h1>
    <p class="text-muted">Lo sentimos, tu pago no se pudo procesar. Por favor, intenta nuevamente.</p>
    <a href="{{ route('carts.index') }}" class="btn btn-danger mt-3">
        <i class="fa-solid fa-arrow-left"></i> Volver al Checkout
    </a>
</div>
@endsection
