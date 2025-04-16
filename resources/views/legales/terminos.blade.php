@extends('layouts.app')

@section('title', 'Términos y Condiciones')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 border-0 rounded-4" style="max-width: 800px; width: 100%;">
        <h1 class="mb-3 text-primary fw-bold">Términos y Condiciones</h1>
        <p class="text-muted mb-4">Actualizado el {{ now()->format('d M Y') }}</p>

        <div class="text-body-secondary">
            <h5 class="fw-semibold mt-4">1. Uso del Sitio</h5>
            <p>Este sitio es solo para uso informativo. Al acceder, aceptas nuestras condiciones de uso.</p>

            <h5 class="fw-semibold mt-4">2. Derechos de Propiedad</h5>
            <p>Todos los contenidos están protegidos por derechos de autor. No puedes reproducirlos sin permiso.</p>

            <h5 class="fw-semibold mt-4">3. Cambios</h5>
            <p>Nos reservamos el derecho de actualizar los términos en cualquier momento. Las modificaciones se aplican desde su publicación.</p>
        </div>
    </div>
</div>
@endsection
