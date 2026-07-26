@extends('layouts.app')

@section('titulo', 'Nuevo Repuesto')

@section('content')

    <h2 class="mb-3">Nuevo Repuesto</h2>

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

            @if ($sucursales->isEmpty())
                <div class="alert alert-warning">
                    No hay sucursales registradas — ejecuta
                    <code>php artisan db:seed --class=OrdenesCatalogoSeeder</code>.
                </div>
            @endif

            <form action="{{ route('repuestos.store') }}" method="POST">
                @csrf

                <h5 class="text-muted mb-3">Datos del repuesto</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca (opcional)</label>
                        <input type="text" name="marca" class="form-control" value="{{ old('marca') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio de compra (Bs)</label>
                        <input type="number" step="0.01" name="precio_compra" class="form-control"
                               value="{{ old('precio_compra', 0) }}" min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio de venta (Bs)</label>
                        <input type="number" step="0.01" name="precio_venta" class="form-control"
                               value="{{ old('precio_venta') }}" min="0" required>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="text-muted mb-3">Stock inicial</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
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
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock actual</label>
                        <input type="number" name="stock_actual" class="form-control"
                               value="{{ old('stock_actual', 0) }}" min="0" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock mínimo</label>
                        <input type="number" name="stock_minimo" class="form-control"
                               value="{{ old('stock_minimo', 5) }}" min="0" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Ubicación</label>
                        <input type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion') }}">
                    </div>
                </div>

                <a href="{{ route('repuestos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Repuesto</button>
            </form>

        </div>
    </div>

@endsection
