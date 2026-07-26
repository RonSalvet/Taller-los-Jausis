@extends('layouts.app')

@section('titulo', 'Nuevo Usuario')

@section('content')

    <h2 class="mb-3">Nuevo Usuario</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre_completo" class="form-control"
                           value="{{ old('nombre_completo') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rol</label>
                        <select name="id_rol" class="form-select" required>
                            <option value="">-- Selecciona --</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id_rol }}"
                                    {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sucursal</label>
                        <select name="id_sucursal" class="form-select" required>
                            <option value="">-- Selecciona --</option>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->id_sucursal }}"
                                    {{ old('id_sucursal') == $sucursal->id_sucursal ? 'selected' : '' }}>
                                    {{ $sucursal->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="estado" value="1" class="form-check-input" id="estado" checked>
                    <label class="form-check-label" for="estado">Usuario activo</label>
                </div>

                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            </form>

        </div>
    </div>

@endsection
