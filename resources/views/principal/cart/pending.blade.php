@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column align-items-center justify-content-center vh-100 text-center">
    <i class="fa-solid fa-hourglass-half text-warning" style="font-size: 100px;"></i>
    <h1 class="text-warning mt-3">Pago Pendiente</h1>
    <p class="text-muted">Tu pago está en proceso. Te notificaremos cuando se confirme.</p>
    <a href="{{ route('home') }}" class="btn btn-warning mt-3">
        <i class="fa-solid fa-house"></i> Volver al Inicio
    </a>
</div>
@endsection
