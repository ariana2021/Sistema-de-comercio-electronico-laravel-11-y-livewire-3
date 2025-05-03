@section('title', 'Historial Ventas')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Historial Ventas</h5>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-outline-primary btn-sm" href="{{ route('sales.index') }}"><i
                        class="fas fa-plus-circle"></i>
                    Nuevo
                </a>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="from_date" class="form-label">Desde</label>
                        <input type="date" id="from_date" class="form-control" wire:model.live="fromDate">
                    </div>
                    <div class="col-md-6">
                        <label for="to_date" class="form-label">Hasta</label>
                        <input type="date" id="to_date" class="form-control" wire:model.live="toDate">
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('sales.export', [
                            'search' => $search,
                            'fromDate' => $fromDate,
                            'toDate' => $toDate,
                        ]) }}"
                            target="_blank" class="btn btn-outline-success btn-sm mt-3">
                            <i class="fas fa-file-excel"></i> Exportar a Excel
                        </a>
                    </div>
                </div>


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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <input type="text" class="form-control mt-3" placeholder="Buscar..." wire:model.live="search">

                @if ($sales->count())

                    <div class="table-responsive">
                        <table class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Acciones</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Forma Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>
                                            <button wire:click="confirmDelete({{ $sale->id }})"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <a onclick="abrirVentanaEmergente('{{ route('sale.generate.ticket', Crypt::encrypt($sale->id)) }}')"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                        <td>{{ $sale->date }}</td>
                                        <td>{{ $sale->total }}</td>
                                        <td>{{ optional($sale->client)->name ?? '' }}</td>

                                        <td>{{ optional($sale->paymentMethod)->name ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="mt-2">
                        {{ $sales->links() }}
                    </div>
                @else
                    <div class="alert alert-warning mt-3" role="alert">
                        <strong>No hay ventas</strong>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            Livewire.on('show-delete-confirmation', id => {
                Swal.fire({
                    title: 'Esta seguro de anular?',
                    text: "Se anulará la venta forma permanente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatchTo('admin.sale-detail-component', 'delete', {
                            valor: id
                        });
                    }
                })
            });
        });
    </script>
@endpush
