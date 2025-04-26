@extends('layouts.app')

@section('title', 'Términos y Condiciones')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/principal/css/page.css') }}">
@endpush

@section('content')

    <section class="parallax-section">
        <div class="content-wrapper">
            <h1 class="page-title">{{ $page->title }}</h1>
            <p class="updated-at">Última actualización: {{ $page->updated_at->format('d \d\e F \d\e Y') }}</p>
            <div class="contenido-pagina">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endsection
