@extends('layouts.app')

@section('content')
    <div class="p-5 efecto-parallax">
        <div class="col-md-4 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="login-container">
                        <h4 class="font-weight-bold text-center">Registrarse</h4>
                        <div class="d-grid mb-3">
                            <a href="{{ route('login.google') }}" class="btn btn-outline-danger">
                                <i class="fab fa-google"></i> Iniciar sesión con Google
                            </a>
                        </div>
                        <form method="POST" action="{{ route('register') }}" class="pt-3">
                            @csrf
                            <div class="form-group mb-1">
                                <input id="name" type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1">
                                <input id="email" type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Correo Electrónico">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1 position-relative">
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" placeholder="Contraseña">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1 position-relative">
                                <input id="password-confirm" type="password" class="form-control form-control-lg"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirmar Contraseña">

                            </div>
                            <!-- Checkbox de aceptación de términos y condiciones -->
                            <div class="my-2 d-flex justify-content-center align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                        name="terms" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Acepto los <a href="#" target="_blank">Términos y Condiciones</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-3 d-grid">
                                <button type="submit" class="btn btn-primary font-weight-medium auth-form-btn">
                                    Crear mi cuenta
                                </button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                ¿Ya tienes una cuenta?
                                <br>
                                <a href="{{ route('login') }}" class="text-primary">Inicia sesión aquí</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
