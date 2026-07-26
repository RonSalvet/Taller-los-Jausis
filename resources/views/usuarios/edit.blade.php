@extends('layouts.app')

@section('titulo', 'Editar Usuario')

@section('content')

    <h2 class="mb-3">Editar Usuario</h2>

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

            <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre_completo" class="form-control"
                           value="{{ old('nombre_completo', $usuario->nombre_completo) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Rol</label>
                        <select name="id_rol" class="form-select" required>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id_rol }}"
                                    {{ old('id_rol', $usuario->id_rol) == $rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sucursal</label>
                        <select name="id_sucursal" class="form-select" required>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->id_sucursal }}"
                                    {{ old('id_sucursal', $usuario->id_sucursal) == $sucursal->id_sucursal ? 'selected' : '' }}>
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
                               value="{{ old('email', $usuario->email) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" name="telefono" class="form-control"
                               value="{{ old('telefono', $usuario->telefono) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nueva contraseña</label>
                        <input type="password" name="password" class="form-control" minlength="6"
                               placeholder="Dejar en blanco para no cambiarla">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" minlength="6">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="estado" value="1" class="form-check-input" id="estado"
                           {{ $usuario->estado ? 'checked' : '' }}>
                    <label class="form-check-label" for="estado">Usuario activo</label>
                </div>

                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </form>

        </div>
    </div>

@endsection
