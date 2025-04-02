@section('title', 'Cupones')

<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h4 class="mb-0">Administrar Cupones</h4>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#couponModal">
                    <i class="fas fa-plus"></i> Nuevo Cupón
                </button>
            </div>
            <hr>
            @if (session()->has('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            <input type="text" class="form-control mb-3" placeholder="Buscar cupones..."
                wire:model.live="searchCoupons">
            @if ($coupons->isEmpty())
                <div class="alert alert-warning text-center">
                    <strong>No hay cupones registrados.</strong>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Código</th>
                                <th>Descuento</th>
                                <th>Uso Máximo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Expiración</th>
                                <th>Estado</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>
                                        <button class="btn btn-sm btn-info" wire:click="edit({{ $coupon->id }})"
                                            data-bs-toggle="modal" data-bs-target="#couponModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $coupon->id }})"
                                            onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_value }} ({{ ucfirst($coupon->discount_type) }})</td>
                                    <td>{{ $coupon->max_uses ?? 'Ilimitado' }}</td>
                                    <td>{{ $coupon->start_date ? $coupon->start_date->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                    <td>{{ $coupon->expiration_date ? $coupon->expiration_date->format('d/m/Y H:i') : 'Sin Expiración' }}
                                    </td>
                                    <td>
                                        @if ($coupon->active)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach ($coupon->products as $product)
                                                <li class="d-flex justify-content-start align-items-center">
                                                    <button class="btn btn-sm btn-outline-danger mx-2"
                                                        wire:click="removeProduct({{ $coupon->id }}, {{ $product->id }})">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                    <span>{{ Str::limit($product->name, 25) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $coupons->links() }}
            @endif

        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">{{ $editing ? 'Editar Cupón' : 'Nuevo Cupón' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código</label>
                                <input type="text" class="form-control" wire:model="code" placeholder="Código">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Tipo de descuento</label>
                                <select class="form-select" wire:model="discount_type">
                                    <option value="fixed">Fijo</option>
                                    <option value="percentage">Porcentaje</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Valor de descuento</label>
                                <input type="number" step="0.01" class="form-control" wire:model="discount_value"
                                    placeholder="0.00">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Máximo uso</label>
                                <input type="number" class="form-control" wire:model="max_uses"
                                    placeholder="Máximo uso">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Fecha Inicio</label>
                                <input type="datetime-local" class="form-control" wire:model="start_date">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Fecha Fin</label>
                                <input type="datetime-local" class="form-control" wire:model="expiration_date">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" wire:model="active">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Seleccionar productos</label>
                            <input type="text" class="form-control mb-2" placeholder="Buscar Productos..."
                                wire:model.live="searchProducts">
                            <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                <table class="table table-sm">
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                        wire:click="toggleProduct({{ $product->id }})"
                                                        @if (in_array($product->id, $selectedProducts)) checked @endif>
                                                </td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $products->links() }} <!-- Paginación de productos -->
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">
                                <i class="fas fa-times-circle"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('closeModal', () => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('couponModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endpush
