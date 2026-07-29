@extends('layouts.app')

@section('titulo', 'Nueva Orden de Trabajo')

@section('content')

    <h2 class="mb-3">Nueva Orden de Trabajo</h2>

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

            @if ($clientes->isEmpty() || $vehiculos->isEmpty() || $sucursales->isEmpty() || $usuarios->isEmpty())
                <div class="alert alert-warning">
                    Faltan datos base para crear una orden. Ejecuta:
                    <code>php artisan db:seed --class=OrdenesCatalogoSeeder</code>
                    y asegúrate de tener al menos un cliente y un vehículo registrados.
                </div>
            @endif

            <form action="{{ route('ordenes.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cliente</label>
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
                        <label class="form-label">Vehículo</label>
                        <select name="id_vehiculo" class="form-select" required>
                            <option value="">-- Selecciona un vehículo --</option>
                            @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}"
                                    {{ old('id_vehiculo') == $vehiculo->id_vehiculo ? 'selected' : '' }}>
                                    {{ $vehiculo->placa }} — {{ $vehiculo->cliente->nombre ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sucursal</label>
                        <select name="id_sucursal" class="form-select" required>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->id_sucursal }}"
                                    {{ old('id_sucursal') == $sucursal->id_sucursal ? 'selected' : '' }}>
                                    {{ $sucursal->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Registrado por</label>
                        <select name="id_usuario_registro" class="form-select" required>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id_usuario }}"
                                    {{ old('id_usuario_registro') == $usuario->id_usuario ? 'selected' : '' }}>
                                    {{ $usuario->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de entrega estimada</label>
                        <input type="date" name="fecha_entrega_estimada" class="form-control"
                               value="{{ old('fecha_entrega_estimada') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            @foreach (['RECIBIDA', 'EN_PROCESO', 'FINALIZADA', 'ENTREGADA', 'ANULADA'] as $estado)
                                <option value="{{ $estado }}" {{ old('estado', 'RECIBIDA') == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Resultado del diagnóstico (opcional)</label>
                        <select name="resultado_diagnostico" class="form-select">
                            <option value="">-- Aún sin diagnosticar --</option>
                            <option value="REPARABLE" {{ old('resultado_diagnostico') == 'REPARABLE' ? 'selected' : '' }}>Reparable</option>
                            <option value="REQUIERE_REPUESTO" {{ old('resultado_diagnostico') == 'REQUIERE_REPUESTO' ? 'selected' : '' }}>Requiere repuesto</option>
                            <option value="NO_REPARABLE" {{ old('resultado_diagnostico') == 'NO_REPARABLE' ? 'selected' : '' }}>No reparable</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mecánicos asignados</label>
                    <div class="border rounded p-3">
                        @forelse ($mecanicos as $mecanico)
                            <div class="form-check">
                                <input type="checkbox" name="mecanicos[]" value="{{ $mecanico->id_mecanico }}"
                                       class="form-check-input" id="mec{{ $mecanico->id_mecanico }}"
                                       {{ in_array($mecanico->id_mecanico, old('mecanicos', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="mec{{ $mecanico->id_mecanico }}">
                                    {{ $mecanico->nombre }}
                                </label>
                            </div>
                        @empty
                            <span class="text-muted">No hay mecánicos disponibles.</span>
                        @endforelse
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diagnóstico (opcional)</label>
                    <textarea name="diagnostico" class="form-control" rows="2">{{ old('diagnostico') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones (opcional)</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones') }}</textarea>
                </div>

                <p class="text-muted small">
                    El total se calculará automáticamente cuando se agreguen servicios y repuestos a esta orden
                    (siguiente módulo).
                </p>

                <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Orden</button>
            </form>

        </div>
    </div>

@endsection
