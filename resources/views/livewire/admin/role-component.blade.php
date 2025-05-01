@section('title', 'Permisos')

<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <button wire:click="create()" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus-circle"></i> Nuevo Rol
                    </button>

                    @if (session()->has('message'))
                        <div class="mt-2 alert alert-success border-0 bg-grd-success alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white">
                                    <span class="material-icons-outlined fs-2">check_circle</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Respuesta</h6>
                                    <div class="text-white">{{ session('message') }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <input type="text" class="form-control mt-3" placeholder="Buscar rol..."
                        wire:model.live="search">

                    @if ($roles->count())
                        <div class="table-responsive mt-3">
                            <table class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col">Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                <button wire:click="edit({{ $role->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $role->id }})"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>{{ $role->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            {{ $roles->links() }}
                        </div>
                    @else
                        <div class="mt-2 alert alert-border-danger">
                            <div>No hay datos</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade @if ($isOpen) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-gray">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $role_id ? 'Editar Rol' : 'Crear Rol' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">Nombre del Rol</label>
                                <input type="text" class="form-control" id="name" placeholder="Nombre del rol"
                                    wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-12 mt-3">
                                <label for="permissions">Permisos</label>
                                <div>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                id="permission{{ $permission->id }}" wire:model="selectedPermissions"
                                                value="{{ $permission->name }}">
                                            <label class="form-check-label" for="permission{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedPermissions')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-sm"
                            wire:click="closeModal()">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Guardar</button>
                    </div>
                </form>
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
                        Livewire.dispatchTo('admin.role-component', 'delete', {
                            valor: id
                        });
                    }
                })
            });
        });
    </script>
@endpush
