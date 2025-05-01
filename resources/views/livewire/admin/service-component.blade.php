<div class="card">
    <div class="card-body">
        <!-- Pestañas -->
        <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="form-tab" data-bs-toggle="tab" href="#form" role="tab"
                    aria-controls="form" aria-selected="true">Registrar Servicio</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="table-tab" data-bs-toggle="tab" href="#table" role="tab"
                    aria-controls="table" aria-selected="false">Servicios</a>
            </li>
        </ul>

        <div class="tab-content" id="serviceTabsContent">
            <!-- Pestaña de formulario -->
            <div class="tab-pane fade show active p-3" id="form" role="tabpanel" aria-labelledby="form-tab">
                @if (session()->has('success'))
                    <div class="mt-2 alert alert-success border-0 bg-grd-success alert-dismissible fade show">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-white"><span
                                    class="material-icons-outlined fs-2">check_circle</span>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-white">Respuesta</h6>
                                <div class="text-white">{{ session('success') }}!</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit.prevent="save" class="mt-3">
                    <div class="mb-3">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" wire:model.defer="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Ingresa el nombre del servicio">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description">Descripción</label>
                        <textarea id="description" wire:model.defer="description"
                            class="form-control @error('description') is-invalid @enderror" placeholder="Ingresa una descripción del servicio"></textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon">Icono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="IconPreview" class="{{ $icon }}"></i></span>
                            <input type="text" id="IconInput"
                                class="form-control @error('icon') is-invalid @enderror"
                                placeholder="Selecciona un icono" readonly wire:model="icon">
                            <button type="button" class="btn btn-primary btn-sm" id="GetIconPicker"
                                data-iconpicker-input="input#IconInput" data-iconpicker-preview="i#IconPreview">
                                Seleccionar Icono
                            </button>
                        </div>

                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>

                    <button class="btn btn-primary">Guardar</button>
                </form>

            </div>

            <!-- Pestaña de tabla -->
            <div class="tab-pane fade p-3" id="table" role="tabpanel" aria-labelledby="table-tab">
                <div class="table-responsive">
                    @if ($services->isEmpty())
                        <div class="mt-2 alert alert-border-danger" role="alert">
                            No hay servicios disponibles. Por favor, agregue un servicio.
                        </div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Icono</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td><i class="{{ $service->icon }}"></i></td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ Str::limit($service->description, 50) }}</td>
                                        <!-- Limitar descripción -->
                                        <td>
                                            <button class="btn btn-warning btn-sm"
                                                wire:click="edit({{ $service->id }})">Editar</button>
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $service->id }})">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const iconInput = document.querySelector('#IconInput');
            const iconPreview = document.querySelector('#IconPreview');

            IconPicker.Init({
                jsonUrl: "{{ asset('assets/admin/plugins/IconPicker/dist/iconpicker-1.5.0.json') }}",
                searchPlaceholder: 'Buscar ícono',
                showAllButton: 'Mostrar todo',
                cancelButton: 'Cancelar',
                noResultsFound: 'No se encontraron resultados',
                borderRadius: '20px',
            });

            IconPicker.Run('#GetIconPicker', function() {
                window.Livewire.dispatch('icon-selected', {
                    icon: iconInput.value
                });
            });
        });
    </script>
@endpush
