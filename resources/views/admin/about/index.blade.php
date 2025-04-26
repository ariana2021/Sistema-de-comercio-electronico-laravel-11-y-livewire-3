@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Sección "Nosotras"</h5>
            <hr>
            <a href="{{ route('about.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Nuevo</a>

            @foreach ($items as $item)
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $item->title }} ({{ ucfirst($item->type) }})</h5>
                        <div>{!! Str::limit(strip_tags($item->content), 100) !!}</div>
                        @if ($item->image_url)
                            <img src="{{ Storage::url($item->image_url) }}" alt="Imagen" class="img-fluid mt-2"
                                style="max-height: 150px;">
                        @endif
                        <div class="mt-2">
                            <a href="{{ route('about.edit', $item) }}" class="btn btn-sm btn-warning"><i
                                    class="fas fa-edit"></i> Editar</a>
                            <form action="{{ route('about.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar este contenido?')"><i class="fas fa-trash"></i>
                                    Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
