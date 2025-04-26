@extends('admin.layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Editar Página: {{ ucfirst($page->slug) }}</h5>
            <hr>
            <form method="POST" action="{{ route('admin.pages.update', $page->slug) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $page->title }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="editor" class="form-label">Contenido</label>
                    <textarea name="content" id="editor" rows="10" class="form-control">{{ $page->content }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- CKEditor 5 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'alignment', 'undo', 'redo'
                ],
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                mediaEmbed: {
                    previewsInData: true
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
