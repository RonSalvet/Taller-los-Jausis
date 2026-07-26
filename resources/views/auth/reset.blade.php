@extends('layouts.auth')

@section('titulo', 'Nueva contraseña')

@section('content')

    <h5 class="mb-3 text-center">Definir nueva contraseña</h5>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
        </div>

        <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
    </form>

@endsection
