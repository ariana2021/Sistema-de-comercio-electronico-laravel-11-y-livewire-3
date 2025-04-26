@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Editar contenido</h5>
            <hr>
            <form action="{{ route('about.update', $about) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.about._form')
            </form>
        </div>
    </div>
@endsection
