@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nuevo contenido</h5>
            <hr>
            <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.about._form')
            </form>
        </div>
    </div>
@endsection
