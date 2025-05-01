@section('title', 'Productos')

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

                    <input type="text" class="form-control mt-3" placeholder="Buscar..." wire:model.live="search">

                    @if ($products->count())

                        <div class="table-responsive">
                            <table class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Precio Descuento</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Categoría</th>
                                        <th scope="col">Marca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <button wire:click="edit({{ $product->id }})"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $product->id }})"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <a href="{{ route('product.gallery', $product->id) }}"
                                                    class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-images"></i>
                                                </a>
                                            </td>

                                            <td>
                                                @if ($product->image)
                                                    <img src="{{ Storage::url($product->image) }}"
                                                        alt="Imagen del producto" width="100">
                                                @else
                                                    <span>No hay imagen</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->discount_price }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                                            <td>{{ $product->brand->name ?? 'Sin marca' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="mt-2 alert alert-border-danger">
                            <div class="">No hay datos</div>
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
                    <h5 class="modal-title">{{ $product_id ? 'Editar Producto' : 'Crear Producto' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12 mb-2">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" placeholder="Nombre"
                                    wire:model="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 mb-2">
                                <label for="description">Descripción</label>
                                <textarea class="form-control" id="description" placeholder="Descripción" wire:model="description" rows="3"></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="price">Precio</label>
                                <input type="number" step="0.01" min="0.01" class="form-control" id="price"
                                    wire:model="price">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="discount_price">Precio Descuento</label>
                                <input type="number" class="form-control" step="0.01" min="0.01"
                                    id="discount_price" wire:model="discount_price">
                                @error('discount_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" wire:model="stock">
                                @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <label for="sku">SKU</label>
                                <input type="text" class="form-control" id="sku" wire:model="sku">
                                @error('sku')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-2">
                                <label for="brand_id" class="form-label">Marca</label>
                                <select wire:model="brand_id" id="brand_id" class="form-select">
                                    <option value="">Seleccionar</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-2">
                                <label for="category_id" class="form-label">Categoria</label>
                                <select wire:model="category_id" id="category_id" class="form-select">
                                    <option value="">Seleccionar</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Características con CKEditor 5 -->
                            <div class="form-group col-md-12 mb-2" wire:ignore>
                                <label for="features">Características</label>
                                <textarea class="form-control" id="features" rows="5">{!! $features !!}</textarea>
                                @error('features')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Imagen con preview y loading -->
                            <div class="form-group col-md-12 mb-2">
                                <label for="image">Imagen</label>
                                <input type="file" class="form-control" id="image" wire:model="image">

                                <div wire:loading wire:target="image">
                                    <span class="text-info">Cargando imagen...</span>
                                </div>

                                @if ($image)
                                    <div class="mt-2">
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded"
                                            width="200">
                                    </div>
                                @endif

                                @error('image')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

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
                        Livewire.dispatchTo('admin.product-component', 'delete', {
                            valor: id
                        });
                    }
                })
            });

            let editor;

            function initializeEditor(featureData = '') {
                if (editor) {
                    editor.destroy().then(() => {
                        createEditor(featureData);
                    });
                } else {
                    createEditor(featureData);
                }
            }

            function createEditor(featureData = '') {
                ClassicEditor
                    .create(document.querySelector('#features'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'underline', '|',
                            'bulletedList', 'numberedList', '|',
                            'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ],
                    })
                    .then(newEditor => {
                        editor = newEditor;
                        editor.setData(featureData); // ahora sí seguro

                        editor.model.document.on('change:data', () => {
                            const editorData = editor.getData();
                            if (typeof editorData === 'string') {
                                Livewire.dispatchTo('admin.product-component', 'updateFeatures', {
                                    valor: editorData
                                });
                            } else {
                                console.error("Los datos del editor no son un string válido.");
                            }
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            Livewire.on('modalOpened', (feature) => {
                initializeEditor(feature[0] ?? '');
            });

        });
    </script>
@endpush
