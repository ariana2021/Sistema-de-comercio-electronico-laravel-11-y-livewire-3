@section('title', 'Nueva venta')

<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    @if (session()->has('error'))
                        <div class="mt-2 alert alert-danger border-0 bg-grd-danger alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><span
                                        class="material-icons-outlined fs-2">error_outline</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Respuesta</h6>
                                    <div class="text-white">{{ session('error') }}!</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <div class="col-md-12">

                    <!-- Categorías elegantes arriba -->
                    <ul class="nav justify-content-center mb-4 menu-categorias">
                        @foreach ($categorias as $categoria)
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    wire:click.prevent="filterByCategory({{ $categoria->id }})">
                                    {{ $categoria->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Marcas a la izquierda y productos a la derecha -->
                    <div class="d-flex gap-4">
                        <!-- Marcas verticales -->
                        <div class="menu-marcas d-flex flex-column">
                            @foreach ($marcas as $marca)
                                <a href="#" class="mb-2"
                                    wire:click.prevent="filterByBrand({{ $marca->id }})">
                                    {{ $marca->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Productos intactos -->
                        <div class="flex-grow-1">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Buscar..."
                                    wire:model.live="search" wire:keydown.enter="agregarAlCarrito">
                                <button class="btn btn-danger" wire:click="resetFilters">
                                    Todos
                                </button>
                            </div>

                            <div class="table-responsive">
                                @if ($products->isEmpty())
                                    <div class="alert alert-warning" role="alert">
                                        No se encontraron productos.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($products as $product)
                                            <div class="col-md-4 mb-3">
                                                <div class="product-card position-relative">
                                                    <span class="badge badge-stock">
                                                        @if ($product->stock > 0)
                                                            {{ $product->stock }} disponibles
                                                        @else
                                                            Agotado
                                                        @endif
                                                    </span>
                                                    <img src="{{ $product->image ? Storage::url($product->image) : asset('assets/admin/images/default_image.png') }}"
                                                        class="product-img" alt="{{ $product->name }}">

                                                    <div class="overlay">
                                                        <h5 class="product-title">{{ strtoupper($product->name) }}</h5>
                                                        <p class="product-price">
                                                            {{ config('app.currency_symbol') }}
                                                            {{ number_format($product->price, 2) }}
                                                        </p>
                                                        <button class="btn btn-primary btn-sm"
                                                            wire:click="addToCart({{ $product->id }})">
                                                            Añadir
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div>
                                        {{ $products->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if (!empty($cart))
                    <button wire:click="openModalProcesar()"
                        class="btn btn-primary rounded-circle shadow-lg position-fixed"
                        style="bottom: 80px; right: 20px; width: 65px; height: 65px; z-index: 1050;"
                        title="Guardar Venta">
                        <i class="fas fa-cash-register fa-lg"></i>
                    </button>
                @endif

            </div>
        </div>
    </div>

    <div class="modal fade @if ($isOpenProcesar) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title">🧾 Completar Venta</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModalProcesar()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if (session()->has('error'))
                        <div class="mt-2 alert alert-danger border-0 bg-grd-danger alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><span
                                        class="material-icons-outlined fs-2">error_outline</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Respuesta</h6>
                                    <div class="text-white">{{ session('error') }}!</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (!empty($cart))
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-end">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart as $item)
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="btn-group btn-group-sm mx-3" role="group">
                                                        <button class="btn btn-outline-success"
                                                            wire:click="incrementQuantity({{ $item['id'] }})">+</button>
                                                        <button class="btn btn-outline-warning"
                                                            wire:click="decrementQuantity({{ $item['id'] }})">-</button>
                                                        <button class="btn btn-outline-danger"
                                                            wire:click="removeFromCart({{ $item['id'] }})">x</button>
                                                    </div>
                                                    <b>{{ $item['quantity'] }}</b> x {{ $item['name'] }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <input type="number" id="price-{{ $item['id'] }}"
                                                    wire:blur="updatePrice({{ $item['id'] }}, $event.target.value)"
                                                    value="{{ $item['price'] }}"
                                                    class="form-control form-control-sm text-end"
                                                    style="max-width: 80px; margin-left: auto;">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            El carrito está vacío.
                        </div>
                    @endif

                    {{-- Datos de pago --}}
                    <div class="row g-2">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input class="form-control" type="text" wire:model="name_client"
                                    placeholder="Nombre de Cliente" disabled>
                                <button class="btn btn-outline-primary" type="button"
                                    wire:click="openModalCliente()">Cliente</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" wire:model="payment_method_id">
                                <option value="">Forma Pago</option>
                                @foreach ($paymentmethods as $paymentmethod)
                                    <option value="{{ $paymentmethod->id }}">{{ $paymentmethod->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="small mb-1">Pago Con</label>
                            <input class="form-control text-end" type="number" wire:model.live="paid_with">
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="small mb-1">Vuelto</label>
                            <input class="form-control text-end" type="text" value="{{ $returned }}"
                                disabled>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="small mb-1">Cashback</label>
                            <input class="form-control text-end" type="text" value="{{ $cashback }}"
                                disabled>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="small mb-1">Uso Cashback</label>
                            <input class="form-control text-end" type="number" step="0.01" min="0"
                                wire:model.live="use_cashback">
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info text-center mt-2">
                                <h5>Total: {{ config('app.currency_symbol') }}{{ $total }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        wire:click="closeModalProcesar()">Cancelar</button>
                    @if (!empty($cart))
                        <button type="button" class="btn btn-primary" wire:click="saveSale()">💾 Guardar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade @if ($isOpenCliente) show d-block @endif" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Clientes
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModalCliente()"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="text" class="form-control mt-3" placeholder="Buscar..."
                        wire:model.live="searchCustomer">

                    @if ($clients->count())
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Dirrecion</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->address }}</td>
                                            <td>
                                                <button wire:click="setClient({{ $client->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    Seleccionar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            {{ $clients->links() }}
                        </div>
                    @else
                        <div class="alert alert-warning mt-3" role="alert">
                            <strong>No hay datos</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('livewire:init', function() {
        Livewire.on('ticket-generated', respuesta => {
            abrirVentanaEmergente(respuesta[0].url);
        });
    });
</script>
