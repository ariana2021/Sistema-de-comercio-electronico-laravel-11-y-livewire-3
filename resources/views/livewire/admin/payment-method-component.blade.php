@section('title', 'Forma Pagos')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <button wire:click="create()" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo Forma Pago
                </button>

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

                @if ($payment_methods->count())

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment_methods as $payment_method)
                                    <tr>
                                        <td>{{ $payment_method->name }}</td>
                                        <td>
                                            <button wire:click="edit({{ $payment_method->id }})"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="confirmDelete({{ $payment_method->id }})"
                                                class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $payment_methods->links() }}
                    </div>
                @else
                    <div class="alert alert-warning mt-3" role="alert">
                        <strong>No hay datos</strong>
                    </div>
                @endif


            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade @if ($isOpen) show d-block @endif" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content bg-gray">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $payment_method_id ? 'Editar Forma Pago' : 'Crear Forma Pago' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal()" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name">Nombre del Forma Pago</label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Nombre del Forma Pago" wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            wire:click="closeModal()">Cancelar</button>
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            wire:click="store()">Guardar</button>
                    </div>
                </div>
            </div>
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
                        Livewire.dispatchTo('admin.payment-method-component', 'delete', {
                            valor: id
                        });
                    }
                })
            });
        });
    </script>
@endpush
