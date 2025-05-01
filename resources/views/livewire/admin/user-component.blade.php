@section('title', 'Usuarios')

<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <button wire:click="create()" class="btn btn-outline-primary btn-sm"><i class="fas fa-plus-circle"></i>
                        Nuevo
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <input type="text" class="form-control mt-3 mb-2" placeholder="Buscar..."
                        wire:model.live="search">

                    @if ($users->count())

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered align-middle"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col"><i class="fas fa-user"></i> Nombre</th>
                                        <th scope="col"><i class="fas fa-envelope"></i> Correo</th>
                                        <th scope="col"><i class="fas fa-phone"></i> Télefono</th>
                                        <th scope="col"><i class="fas fa-map-marker-alt"></i> Estado</th>
                                        <th scope="col"><i class="fas fa-coins"></i> CashBack</th>
                                        <th scope="col"><i class="fas fa-user-tag"></i> Rol</th>
                                        <th scope="col"><i class="fas fa-cogs"></i> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                @if ($loading)
                                                    <span class="badge bg-secondary">Cargando...</span>
                                                @else
                                                    <select
                                                        wire:change="changeStatus({{ $user->id }}, $event.target.value)"
                                                        class="form-control">
                                                        <option value="Activo"
                                                            {{ $user->status === 'Activo' ? 'selected' : '' }}>Activo
                                                        </option>
                                                        <option value="Inactivo"
                                                            {{ $user->status === 'Inactivo' ? 'selected' : '' }}>
                                                            Inactivo</option>
                                                    </select>
                                                @endif
                                            </td>
                                            <td>💰 {{ $user->cashbacks->sum('amount') }}</td>
                                            <td>
                                                @if ($user->getRoleNames()->isEmpty())
                                                    <span class="badge bg-secondary">Cliente</span>
                                                @else
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <span class="badge bg-info text-dark">{{ $role }}</span>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>
                                                <button wire:click="edit({{ $user->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $user->id }})"
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
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="mt-2 alert alert-border-danger" role="alert">
                            <strong>No hay usuarios</strong>
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
                    <h5 class="modal-title">{{ $user_id ? 'Editar Usuario' : 'Crear Usuario' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row">
                        <div class="form-group col-md-12 mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name"
                                placeholder="Nombre" wire:model="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="email">Correo</label>
                            <input type="text" class="form-control" id="email"
                                placeholder="Correo" wire:model="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6 mb-3">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address"
                                placeholder="Dirección" wire:model="address">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="password">Contraseña <span
                                    class="text-primary">{{ $opcional }}</span></label>
                            <input type="password" class="form-control" id="password"
                                placeholder="Contraseña" wire:model="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                placeholder="Confirmar Contraseña" wire:model="password_confirmation">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Roles -->
                        <div class="form-group col-md-12">
                            <label for="roles">Roles</label>
                            <div>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" value="{{ $role->name }}"
                                            wire:model="selectedRoles">
                                        <label class="form-check-label"
                                            for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedRoles')
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

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {

            Livewire.on('show-delete-confirmation', id => {
                Swal.fire({
                    title: 'Esta seguro de eliminar?',
                    text: "El carpeta se eliminará de forma permanente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatchTo('admin.user-component', 'delete', {
                            valor: id
                        });
                    }
                })
            });
        });
    </script>
@endpush
