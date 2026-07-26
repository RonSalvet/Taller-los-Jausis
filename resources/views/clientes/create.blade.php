@extends('layouts.app')

@section('titulo', 'Nuevo Cliente')

@section('content')

    <h2 class="mb-3">Nuevo Cliente</h2>

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

            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control"
                           value="{{ old('nombre') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CI / NIT</label>
                        <input type="text" name="ci_nit" class="form-control"
                               value="{{ old('ci_nit') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control"
                               value="{{ old('telefono') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (opcional)</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección (opcional)</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha de registro</label>
                        <input type="date" name="fecha_registro" class="form-control"
                               value="{{ old('fecha_registro', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox" name="estado" value="1" class="form-check-input"
                                   id="estado" checked>
                            <label class="form-check-label" for="estado">Cliente activo</label>
                        </div>
                    </div>
                </div>

                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
            </form>

        </div>
    </div>

@endsection
