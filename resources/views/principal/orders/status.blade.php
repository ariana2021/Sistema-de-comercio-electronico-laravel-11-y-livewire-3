@extends('layouts.app')

@section('content')
    <div class="container pt-50">
        <article class="card-custom">
            <header class="card-custom-header"> Mis Órdenes / Seguimiento </header>
            <div class="card-custom-body p-3">
                <h6>Order ID: #{{ $order->id }}</h6>
                <article class="card-custom">
                    <div class="card-custom-body row">
                        <div class="col"> <strong>Fecha de Creación:</strong>
                            <br>{{ $order->created_at->format('d M Y') }}
                        </div>
                        <div class="col"> <strong>Estado Actual:</strong> <br> {{ ucfirst($order->status) }} </div>
                        <div class="col"> <strong>Número de Seguimiento:</strong> <br>
                            {{ $order->tracking_number ?? 'No asignado' }} </div>
                    </div>
                </article>

                <!-- Seguimiento de estado -->
                <div class="track">
                    @php
                        $statuses = [
                            'pendiente' => 'fa-clock',
                            'procesando' => 'fa-cogs',
                            'enviado' => 'fa-truck',
                            'entregado' => 'fa-box',
                        ];

                        // Obtener historial de estados ordenado por fecha
                        $history = $order->statusHistory->sortBy('created_at');

                        // Obtener el estado más reciente
                        $latestStatus = strtolower(optional($history->last())->status ?? 'pendiente');

                        // Determinar el índice del estado actual en el array de estados
                        $currentStatus = array_search($latestStatus, array_keys($statuses));
                    @endphp

                    @if ($latestStatus === 'cancelado')
                        <div class="step text-center w-100">
                            <span class="icon bg-danger text-white">
                                <i class="fa fa-times-circle"></i>
                            </span>
                            <span class="text text-danger fw-bold">Cancelado</span>
                        </div>
                    @else
                        @foreach ($statuses as $status => $icon)
                            <div
                                class="step {{ $currentStatus >= array_search($status, array_keys($statuses)) ? 'active' : '' }}">
                                <span class="icon"> <i class="fa {{ $icon }}"></i> </span>
                                <span class="text">{{ ucfirst($status) }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>


                <hr>

                <h5 class="mt-3"><i class="fa fa-history me-2 text-primary"></i>Historial de Estado
                </h5>
                <ul class="list-group list-group-flush">
                    @foreach ($order->statusHistory as $history)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">
                                <i class="fa {{ $statuses[$history->status] ?? 'fa-info-circle' }} text-muted me-2"></i>
                                {{ ucfirst($history->status) }}
                            </span>
                            <span class="badge bg-secondary">{{ $history->created_at->format('d/m/Y H:i') }}</span>
                        </li>
                    @endforeach
                </ul>

                <!-- Productos en la orden -->
                <ul class="row">
                    @foreach ($order->items as $item)
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside">
                                    <img src="{{ Storage::url($item->product->image) }}" class="img-sm border">
                                </div>
                                <figcaption class="info align-self-center">
                                    <p class="title">{{ $item->name ?? 'Producto no disponible' }}</p>
                                    <span
                                        class="text-muted">{{ config('app.currency_symbol') }}{{ number_format($item->price, 2) }}
                                        x
                                        {{ $item->quantity }}</span>
                                </figcaption>
                            </figure>
                        </li>
                    @endforeach
                </ul>

                <hr>

                <a href="{{ route('profile.index') }}" class="btn btn-warning">
                    <i class="fa fa-chevron-left"></i> Volver a órdenes
                </a>
            </div>
        </article>
    </div>
@endsection
