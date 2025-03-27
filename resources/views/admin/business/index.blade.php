@extends('admin.layouts.app')

@section('title', 'Empresa')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Configuración de la Empresa</h5>
            <hr>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('business.update') }}" method="POST" enctype="multipart/form-data"
                class="card p-4 shadow-sm">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la Empresa</label>
                        <input type="text" name="business_name" class="form-control"
                            value="{{ old('business_name', $business->business_name ?? '') }}" required>
                        @error('business_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $business->email ?? '') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $business->phone ?? '') }}">
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sitio Web</label>
                        <input type="url" name="website" class="form-control"
                            value="{{ old('website', $business->website ?? '') }}">
                        @error('website')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @error('logo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h4 class="mt-4">Ubicación</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $business->address ?? '') }}">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $business->city ?? '') }}">
                        @error('city')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado/Provincia</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ old('state', $business->state ?? '') }}">
                        @error('state')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Código Postal</label>
                        <input type="text" name="zip_code" class="form-control"
                            value="{{ old('zip_code', $business->zip_code ?? '') }}">
                        @error('zip_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">País</label>
                        <input type="text" name="country" class="form-control"
                            value="{{ old('country', $business->country ?? '') }}">
                        @error('country')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitud</label>
                        <input type="text" name="latitude" class="form-control"
                            value="{{ old('latitude', $business->latitude ?? '') }}">
                        @error('latitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitud</label>
                        <input type="text" name="longitude" class="form-control"
                            value="{{ old('longitude', $business->longitude ?? '') }}">
                        @error('longitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h4 class="mt-4">Configuraciones de Envío</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Habilitar Envío</label>
                        <select name="shipping_enabled" class="form-select" required>
                            <option value="1"
                                {{ old('shipping_enabled', $business->shipping_enabled ?? 0) == 1 ? 'selected' : '' }}>Sí
                            </option>
                            <option value="0"
                                {{ old('shipping_enabled', $business->shipping_enabled ?? 0) == 0 ? 'selected' : '' }}>No
                            </option>
                        </select>
                        @error('shipping_enabled')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">Costo por Kilómetro</label>
                        <input type="number" name="cost_per_km" class="form-control"
                            value="{{ old('cost_per_km', $business->cost_per_km ?? 0) }}" required>
                        @error('cost_per_km')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h4 class="mt-4">Impuestos</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Porcentaje de Impuestos (%)</label>
                        <input type="number" name="tax_percentage" class="form-control"
                            value="{{ old('tax_percentage', $business->tax_percentage ?? 0) }}" min="0"
                            max="100">
                        @error('tax_percentage')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection
