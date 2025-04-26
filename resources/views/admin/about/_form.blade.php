@csrf

<div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text" name="title" value="{{ old('title', $about->title ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Tipo</label>
    <select name="type" class="form-control" required>
        <option value="historia" {{ (old('type', $about->type ?? '') == 'historia') ? 'selected' : '' }}>Historia</option>
        <option value="mision" {{ (old('type', $about->type ?? '') == 'mision') ? 'selected' : '' }}>Misión</option>
        <option value="vision" {{ (old('type', $about->type ?? '') == 'vision') ? 'selected' : '' }}>Visión</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Contenido</label>
    <textarea id="editor" name="content" class="form-control" rows="8">{{ old('content', $about->content ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Imagen (opcional)</label>
    <input type="file" name="image" class="form-control" accept="image/*">
</div>

<div class="text-end">
    <button type="submit" class="btn btn-success">Guardar</button>
</div>
