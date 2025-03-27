@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100 text-center">
        <i class="fa-solid fa-circle-check text-success" style="font-size: 100px;"></i>
        <h1 class="text-success mt-3">¡Gracias por tu compra!</h1>
        <p class="text-muted">Hemos recibido tu pedido y estamos procesándolo.</p>
        <div class="btn-group" role="group" aria-label="Button group">
            <a href="{{ route('home') }}" class="btn btn-success mt-3">
                <i class="fa-solid fa-store"></i> Seguir Comprando
            </a>
            <a href="{{ route('profile.index') }}" class="btn btn-info mt-3">
                <i class="fa-solid fa-box-open"></i> Ver Pedido
            </a>
        </div>
        
    </div>
@endsection
