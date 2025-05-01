@section('title', 'Pedidos')

<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <input type="text" class="form-control mt-3 mb-2" placeholder="Buscar pedidos..."
                        wire:model.live="search">

                    @if (session()->has('message'))
                        <div class="mt-2 alert alert-success border-0 bg-grd-success alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><span
                                        class="material-icons-outlined fs-2">check_circle</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Respuesta</h6>
                                    <div class="text-white">{{ session('message') }}!</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($orders->count())

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered align-middle"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col"><i class="fas fa-cogs"></i> Acciones</th>
                                        <th scope="col"><i class="fas fa-hashtag"></i> ID</th>
                                        <th scope="col"><i class="fas fa-user"></i> Cliente</th>
                                        <th scope="col"><i class="fas fa-dollar-sign"></i> Total</th>
                                        <th scope="col"><i class="fas fa-truck"></i> Envío</th>
                                        <th scope="col"><i class="fas fa-info-circle"></i> Estado</th>
                                        <th scope="col"><i class="fas fa-calendar-day"></i> Fecha</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                <button wire:click="openModal({{ $order->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <a href="{{ route('order.invoice.pdf', Crypt::encrypt($order->id)) }}"
                                                    target="_blank" class="btn btn-danger btn-sm">
                                                    Factura
                                                </a>
                                            </td>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ config('app.currency_symbol') }}{{ number_format($order->total - $order->shipping_cost, 2) }}
                                            </td>
                                            <td>{{ ucfirst($order->shipping_cost) }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
                                            </td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="mt-2 alert alert-border-danger" role="alert">
                            <strong>No hay pedidos disponibles</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalles del Pedido -->
    <div class="modal fade @if ($isOpen) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-gray">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Pedido #{{ $order_id }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedOrder)
                        <article class="card-custom">
                            <header class="card-custom-header text-white"> <strong>Detalles de la Orden</strong>
                            </header>
                            <div class="card-body">
                                <h6>Order ID: #{{ $order->id }}</h6>
                                <div class="row">
                                    <div class="col"> <strong>Fecha de Creación:</strong>
                                        <br>{{ $order->created_at->format('d M Y') }}
                                    </div>
                                    <div class="col"> <strong>Estado Actual:</strong> <br>
                                        {{ ucfirst($order->status) }} </div>
                                    <div class="col"> <strong>Número de Seguimiento:</strong> <br>
                                        {{ $order->tracking_number ?? 'No asignado' }} </div>
                                </div>

                                <div class="track">
                                    @php
                                        $statuses = [
                                            'pendiente' => 'fa-clock',
                                            'procesando' => 'fa-cogs',
                                            'enviado' => 'fa-truck',
                                            'entregado' => 'fa-box',
                                        ];

                                        // Obtener historial de estados ordenado por fecha
                                        $history = $selectedOrder->statusHistory->sortBy('created_at');

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


                                <h5 class="mt-3"><i class="fa fa-history me-2 text-primary"></i>Historial de Estado
                                </h5>
                                <ul class="list-group list-group-flush">
                                    @foreach ($selectedOrder->statusHistory as $history)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="fw-semibold">
                                                <i
                                                    class="fa {{ $statuses[$history->status] ?? 'fa-info-circle' }} text-muted me-2"></i>
                                                {{ ucfirst($history->status) }}
                                            </span>
                                            <span
                                                class="badge bg-secondary">{{ $history->created_at->format('d/m/Y H:i') }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <ul class="row">
                                    @foreach ($order->items as $item)
                                        <li class="col-md-4">
                                            <figure class="itemside mb-3">
                                                <div class="aside">
                                                    <img src="{{ Storage::url($item->product->image) }}"
                                                        class="img-sm border">
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

                                <h5 class="mt-4"><i class="fa fa-edit me-2 text-success"></i>Actualizar Estado</h5>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-sync"></i></span>
                                    <select class="form-select" wire:model="new_status">
                                        <option value="">Seleccione un estado</option>
                                        @foreach ($statuses as $status => $icon)
                                            <option value="{{ $status }}">
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                        <option value="cancelado">
                                            Cancelado
                                        </option>
                                    </select>
                                </div>


                                <textarea class="form-control mt-2" wire:model="note" rows="5" placeholder="Nota opcional..."></textarea>

                                <div class="text-end">
                                    <button class="btn btn-outline-primary btn-sm mt-2"
                                        wire:click="updateStatus()">Actualizar</button>
                                </div>
                            </div>
                        </article>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
