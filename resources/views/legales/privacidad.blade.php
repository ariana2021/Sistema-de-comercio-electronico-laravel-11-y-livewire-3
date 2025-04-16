@extends('layouts.app')

@section('title', 'Política de Privacidad')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 border-0 rounded-4" style="max-width: 800px; width: 100%;">
        <h1 class="mb-3 text-success fw-bold">Política de Privacidad</h1>
        <p class="text-muted mb-4">Última actualización: {{ now()->format('d M Y') }}</p>

        <div class="text-body-secondary">
            <h5 class="fw-semibold mt-4">1. Datos Recopilados</h5>
            <p>Recopilamos tu nombre, correo y datos necesarios para ofrecerte nuestros servicios.</p>

            <h5 class="fw-semibold mt-4">2. Cómo usamos tus datos</h5>
            <p>Utilizamos tu información para mejorar tu experiencia y procesar tus solicitudes.</p>

            <h5 class="fw-semibold mt-4">3. Seguridad</h5>
            <p>Mantenemos tus datos seguros mediante tecnologías modernas de protección.</p>

            <h5 class="fw-semibold mt-4">4. Cookies</h5>
            <p>Usamos cookies para mejorar el rendimiento del sitio. Puedes desactivarlas desde tu navegador.</p>
        </div>
    </div>
</div>
@endsection
