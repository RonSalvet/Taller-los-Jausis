@extends('layouts.app')

@section('titulo', 'Vehículos')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Vehículos</h2>
        <a href="{{ route('vehiculos.create') }}" class="btn btn-primary">+ Nuevo Vehículo</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Cliente</th>
                        <th>Marca / Modelo</th>
                        <th>Año</th>
                        <th>Color</th>
                        <th>Km</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehiculos as $vehiculo)
                        <tr>
                            <td>{{ $vehiculo->id_vehiculo }}</td>
                            <td><span class="badge bg-dark">{{ $vehiculo->placa }}</span></td>
                            <td>{{ $vehiculo->cliente->nombre ?? '—' }}</td>
                            <td>
                                {{ $vehiculo->modelo->marca->nombre ?? '' }}
                                {{ $vehiculo->modelo->nombre ?? '—' }}
                            </td>
                            <td>{{ $vehiculo->anio ?? '—' }}</td>
                            <td>{{ $vehiculo->color ?? '—' }}</td>
                            <td>{{ number_format($vehiculo->kilometraje) }}</td>
                            <td class="text-end">
                                <a href="{{ route('vehiculos.edit', $vehiculo->id_vehiculo) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>

                                <form action="{{ route('vehiculos.destroy', $vehiculo->id_vehiculo) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar el vehículo {{ $vehiculo->placa }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay vehículos registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $vehiculos->links() }}
    </div>

@endsection
