@extends('layouts.auth')

@section('titulo', 'Recuperar contraseña')

@section('content')

    <h5 class="mb-2 text-center">Recuperar contraseña</h5>
    <p class="text-muted small text-center mb-3">
        Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.
    </p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('enlace_recuperacion'))
        <div class="alert alert-info small">
            <strong>Modo demostración</strong> — el proyecto aún no tiene un servidor de correo
            configurado, así que aquí está tu enlace de recuperación (normalmente llegaría a tu email):
            <br><br>
            <a href="{{ session('enlace_recuperacion') }}">{{ session('enlace_recuperacion') }}</a>
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Enviar Enlace</button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="small">&larr; Volver al inicio de sesión</a>
        </div>
    </form>

@endsection
