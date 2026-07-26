@extends('layouts.auth')

@section('titulo', 'Iniciar sesión')

@section('content')

    <h5 class="mb-3 text-center">Iniciar sesión</h5>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Usuario / Correo</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                   placeholder="correo@tallerpro.com" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar Sesión</button>

        <div class="text-center">
            <a href="{{ route('password.request') }}" class="small">¿Olvidaste tu contraseña?</a>
        </div>
    </form>

    <hr>
    <p class="text-muted small text-center mb-0">
        Usuario de prueba: <code>admin@tallerpro.com</code> / <code>password</code>
    </p>

@endsection
