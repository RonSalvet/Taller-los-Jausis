@extends('layouts.app')

@section('titulo', 'Editar Orden de Trabajo')

@section('content')

    <h2 class="mb-3">Editar Orden de Trabajo #{{ $orden->id_orden }}</h2>

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

            @php
                $mecanicosAsignados = old('mecanicos', $orden->mecanicos->pluck('id_mecanico')->toArray());
            @endphp

            <form action="{{ route('ordenes.update', $orden->id_orden) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cliente</label>
                        <select name="id_cliente" class="form-select" required>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}"
                                    {{ old('id_cliente', $orden->id_cliente) == $cliente->id_cliente ? 'selected' : '' }}>
                                    {{ $cliente->nombre }} ({{ $cliente->ci_nit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehículo</label>
                        <select name="id_vehiculo" class="form-select" required>
                            @foreach ($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}"
                                    {{ old('id_vehiculo', $orden->id_vehiculo) == $vehiculo->id_vehiculo ? 'selected' : '' }}>
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
                                    {{ old('id_sucursal', $orden->id_sucursal) == $sucursal->id_sucursal ? 'selected' : '' }}>
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
                                    {{ old('id_usuario_registro', $orden->id_usuario_registro) == $usuario->id_usuario ? 'selected' : '' }}>
                                    {{ $usuario->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de entrega estimada</label>
                        <input type="date" name="fecha_entrega_estimada" class="form-control"
                               value="{{ old('fecha_entrega_estimada', $orden->fecha_entrega_estimada) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            @foreach (['RECIBIDA', 'EN_PROCESO', 'FINALIZADA', 'ENTREGADA', 'ANULADA'] as $estado)
                                <option value="{{ $estado }}"
                                    {{ old('estado', $orden->estado) == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Resultado del diagnóstico (opcional)</label>
                        @php $resActual = old('resultado_diagnostico', $orden->resultado_diagnostico); @endphp
                        <select name="resultado_diagnostico" class="form-select">
                            <option value="" {{ $resActual == null ? 'selected' : '' }}>-- Aún sin diagnosticar --</option>
                            <option value="REPARABLE" {{ $resActual == 'REPARABLE' ? 'selected' : '' }}>Reparable</option>
                            <option value="REQUIERE_REPUESTO" {{ $resActual == 'REQUIERE_REPUESTO' ? 'selected' : '' }}>Requiere repuesto</option>
                            <option value="NO_REPARABLE" {{ $resActual == 'NO_REPARABLE' ? 'selected' : '' }}>No reparable</option>
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
                                       {{ in_array($mecanico->id_mecanico, $mecanicosAsignados) ? 'checked' : '' }}>
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
                    <textarea name="diagnostico" class="form-control" rows="2">{{ old('diagnostico', $orden->diagnostico) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones (opcional)</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones', $orden->observaciones) }}</textarea>
                </div>

                <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Orden</button>
            </form>

        </div>
    </div>

@endsection
