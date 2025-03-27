@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Galería de Imágenes</h3>
            <hr>
            <h5 class="text-center text-muted">Producto: <strong>{{ $product->name }}</strong></h5>

            <!-- Dropzone Form -->
            <form action="{{ route('product.upload', $product->id) }}" class="dropzone border rounded p-3"
                id="productDropzone">
                @csrf
                <div class="dz-message text-center text-secondary">
                    <i class="fas fa-cloud-upload-alt fa-3x"></i>
                    <p class="mt-2">Arrastra imágenes aquí o haz clic para subir</p>
                </div>
            </form>

            <!-- Vista previa de imágenes existentes -->
            <h4 class="mt-4 text-center text-secondary">Imágenes Actuales</h4>
            <div id="image-gallery" class="d-flex flex-wrap justify-content-center mt-3">
                @foreach ($product->images as $image)
                    <div class="position-relative shadow-lg rounded overflow-hidden m-2" data-id="{{ $image->id }}">
                        <img src="{{ asset('storage/' . $image->url) }}" width="150" height="150" class="rounded">
                        <button class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image"
                            onclick="deleteImage({{ $image->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    <style>
        /* Personalización de Dropzone */
        .dropzone {
            border: 2px dashed #007bff !important;
            background: #f8f9fa;
        }

        .dz-message i {
            color: #007bff;
        }

        .delete-image {
            background: rgba(255, 0, 0, 0.8);
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
    </style>
@endpush

@push('scripts')
    <!-- Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        Dropzone.options.productDropzone = {
            paramName: "file",
            maxFilesize: 5, // 5MB
            acceptedFiles: "image/*",
            dictDefaultMessage: "Arrastra imágenes aquí o haz clic para subir",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(file, response) {
                let imageHtml = `<div class="position-relative shadow-lg rounded overflow-hidden m-2" data-id="${response.id}">
                                    <img src="${response.url}" width="150" height="150" class="rounded">
                                    <button class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image" 
                                        onclick="deleteImage(${response.id})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>`;
                document.getElementById('image-gallery').insertAdjacentHTML('beforeend', imageHtml);
                file.previewElement.remove(); // Eliminar del Dropzone
            }
        };

        // ✅ Función para eliminar imagen con SweetAlert2
        function deleteImage(imageId) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = '{{ route('product.delete', ':id') }}'.replace(':id',
                    imageId); // ✅ Usar el helper de Laravel

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector(`[data-id="${imageId}"]`).remove();
                                Swal.fire("Eliminado", "La imagen ha sido eliminada.", "success");
                            } else {
                                Swal.fire("Error", data.message || "No se pudo eliminar la imagen.", "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire("Error", "Hubo un problema al eliminar la imagen.", "error");
                        });
                }
            });
        }
    </script>
@endpush
