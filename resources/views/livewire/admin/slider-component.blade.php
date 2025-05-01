@section('title', 'Sliders')
<div>
    <div class="card">
        <div class="card-body">
            <!-- Mensajes Flash -->
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

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-primary" wire:click="$set('sliderId', null)" data-bs-toggle="modal"
                    data-bs-target="#sliderModal">
                    Nuevo
                </button>
                <input type="text" class="form-control w-25" placeholder="Buscar Sliders..."
                    wire:model.live="searchSliders">
            </div>

            <!-- Tabla de Sliders -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Producto</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                            <tr>
                                <td><img src="{{ Storage::url($slider->image) }}" width="50"></td>
                                <td>
                                    {{ Str::limit($slider->title, 30, '...') }}
                                </td>
                                <td>
                                    {{ Str::limit(optional($slider->product)->name, 30, '...') }}
                                </td>

                                <td>{{ $slider->discount ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $slider->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $slider->status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" wire:click="edit({{ $slider->id }})"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" wire:click="delete({{ $slider->id }})"><i
                                            class="fas fa-times-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $sliders->links() }}
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="sliderModal" tabindex="-1" aria-labelledby="sliderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Administrar Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Título</label>
                                <input type="text" class="form-control" wire:model="title" placeholder="Título">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" wire:model="description" placeholder="Descripción"></textarea>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Subir imagen</label>
                                <input type="file" class="form-control" wire:model="image">
                                <div wire:loading wire:target="image" class="text-warning">Subiendo...</div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Descuento</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Descuento"
                                    wire:model="discount">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Fecha de inicio</label>
                                <input type="datetime-local" class="form-control" wire:model="start_date">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Fecha de finalización</label>
                                <input type="datetime-local" class="form-control" wire:model="end_date">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <input type="text" class="form-control mb-2" placeholder="Search Products..."
                                wire:model.live="searchProducts">
                            <ul class="list-group">
                                @foreach ($products as $product)
                                    <li class="list-group-item">
                                        <input type="radio" name="selectedProduct" wire:model="product_id"
                                            value="{{ $product->id }}">

                                        {{ $product->name }}
                                    </li>
                                @endforeach
                            </ul>
                            {{ $products->links() }}
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('close-modal', () => {
            var modalEl = document.getElementById('sliderModal');
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
        });

        Livewire.on('show-modal', () => {
            var modalEl = document.getElementById('sliderModal');
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        });
    </script>
@endpush
