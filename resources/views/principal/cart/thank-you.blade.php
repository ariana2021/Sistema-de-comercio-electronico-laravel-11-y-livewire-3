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
    @if (session('niubiz'))
        @php
            $response = session('niubiz')['response'];
            $fecha = \Carbon\Carbon::createFromFormat('ymdHis', $response['dataMap']['TRANSACTION_DATE'] ?? '');
        @endphp


        <div class="alert alert-success" role="alert">
            <p>{{ $response['dataMap']['ACTION_DESCRIPTION'] ?? 'Descripción no disponible' }}</p>
            <p><b>N° Pedido: </b>{{ $response['order']['purchaseNumber'] ?? '---' }}</p>
            <p><b>Fecha y Hora: </b>{{ $fecha ? $fecha->format('d/m/Y H:i') : 'Fecha inválida' }}</p>
            <p><b>Tarjeta: </b>{{ $response['dataMap']['CARD'] ?? '---' }} ({{ $response['dataMap']['BRAND'] ?? '' }})</p>
            <p><b>Importe: </b>{{ $response['order']['amount'] ?? '0.00' }} ({{ $response['order']['currency'] ?? '' }})</p>
        </div>
    @endif
@endsection
