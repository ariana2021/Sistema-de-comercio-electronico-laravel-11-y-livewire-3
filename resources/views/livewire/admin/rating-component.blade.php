@section('title', 'Calificaciones')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Administrar Calificaciones</h5>
        <hr>
        @if (session()->has('message'))
            <div class="mt-2 alert alert-success border-0 bg-grd-success alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Respuesta</h6>
                        <div class="text-white">{{ session('message') }}!</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Buscar por usuario o producto..."
                    wire:model.live="search">
            </div>
            <div class="col-md-3">
                <select class="form-select" wire:model.live="perPage">
                    <option value="5">5 por página</option>
                    <option value="10">10 por página</option>
                    <option value="20">20 por página</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Calificación</th>
                        <th>Usuario</th>
                        <th>Producto</th>
                        <th>Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                        <tr>
                            <td>
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <button wire:click="toggleFeatured({{ $rating->id }})"
                                        class="btn btn-sm {{ $rating->featured ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $rating->featured ? 'Sí' : 'No' }}
                                    </button>
                                    <button wire:click="confirmDelete({{ $rating->id }})"
                                        class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i></button>
                                </div>
                            </td>
                            <td>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $rating->rating ? 's' : 'r' }} fa-star text-warning"></i>
                                @endfor
                            </td>
                            <td>{{ $rating->user->name }}</td>
                            <td>{{ $rating->product->name }}</td>

                            <td>{{ $rating->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $ratings->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {

            Livewire.on('show-delete-confirmation', id => {
                Swal.fire({
                    title: 'Esta seguro de eliminar?',
                    text: "El registro se eliminará de forma permanente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatchTo('admin.rating-component', 'delete', {
                            valor: id
                        });
                    }
                })
            });
        });
    </script>
@endpush
