@extends('layouts.app')

@section('content')
    <div class="p-5 efecto-parallax">
        <div class="col-md-4 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="login-container">
                        <div class="login-card">
                            <div class="text-center mb-3">
                                <img src="{{ asset('assets/admin/images/logo.png') }}" class="rounded-circle" alt="Logo"
                                    width="100">
                            </div>

                            <div class="d-grid mb-3">
                                <a href="{{ route('login.google') }}" class="btn btn-danger">
                                    <i class="fab fa-google"></i> Iniciar sesión con Google
                                </a>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Correo Electrónico">
                                    @error('email')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" placeholder="Contraseña">
                                    @error('password')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">INICIAR SESIÓN</button>
                                <div class="mt-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Mantenme registrado</label>
                                </div>
                                <div class="mt-2">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none">¿Olvidaste tu
                                            contraseña?</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
