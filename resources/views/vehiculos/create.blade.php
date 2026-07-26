@extends('layouts.app')

@section('titulo', 'Nuevo Vehículo')

@section('content')

    <h2 class="mb-3">Nuevo Vehículo</h2>

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

            @if ($clientes->isEmpty() || $modelos->isEmpty())
                <div class="alert alert-warning">
                    @if ($clientes->isEmpty())
                        No hay clientes registrados — primero crea uno en el módulo de Clientes.<br>
                    @endif
                    @if ($modelos->isEmpty())
                        No hay modelos de vehículo cargados — ejecuta el seeder
                        <code>php artisan db:seed --class=VehiculoCatalogoSeeder</code>.
                    @endif
                </div>
            @endif

            <form action="{{ route('vehiculos.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cliente propietario</label>
                        <select name="id_cliente" class="form-select" required>
                            <option value="">-- Selecciona un cliente --</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}"
                                    {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}>
                                    {{ $cliente->nombre }} ({{ $cliente->ci_nit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca / Modelo</label>
                        <select name="id_modelo" class="form-select" required>
                            <option value="">-- Selecciona un modelo --</option>
                            @foreach ($modelos as $modelo)
                                <option value="{{ $modelo->id_modelo }}"
                                    {{ old('id_modelo') == $modelo->id_modelo ? 'selected' : '' }}>
                                    {{ $modelo->marca->nombre ?? '' }} {{ $modelo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Placa</label>
                        <input type="text" name="placa" class="form-control"
                               value="{{ old('placa') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="anio" class="form-control"
                               value="{{ old('anio') }}" min="1950" max="{{ date('Y') + 1 }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" value="{{ old('color') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kilometraje</label>
                        <input type="number" name="kilometraje" class="form-control"
                               value="{{ old('kilometraje', 0) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">N° de chasis (opcional)</label>
                    <input type="text" name="nro_chasis" class="form-control" value="{{ old('nro_chasis') }}">
                </div>

                <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Vehículo</button>
            </form>

        </div>
    </div>

@endsection
