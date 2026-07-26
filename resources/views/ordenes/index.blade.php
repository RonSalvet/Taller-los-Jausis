@extends('layouts.app')

@section('titulo', 'Órdenes de Trabajo')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Órdenes de Trabajo</h2>
        <a href="{{ route('ordenes.create') }}" class="btn btn-primary">+ Nueva Orden</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>N° Orden</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>Fecha ingreso</th>
                        <th>Entrega estimada</th>
                        <th>Estado</th>
                        <th>Total (Bs)</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordenes as $orden)
                        <tr>
                            <td>#{{ str_pad($orden->id_orden, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $orden->cliente->nombre ?? '—' }}</td>
                            <td>{{ $orden->vehiculo->placa ?? '—' }}</td>
                            <td>{{ optional($orden->fecha_ingreso)->format('d/m/Y H:i') }}</td>
                            <td>{{ $orden->fecha_entrega_estimada ? \Carbon\Carbon::parse($orden->fecha_entrega_estimada)->format('d/m/Y') : '—' }}</td>
                            <td>
                                @php
                                    $colores = [
                                        'RECIBIDA'   => 'secondary',
                                        'EN_PROCESO' => 'warning text-dark',
                                        'FINALIZADA' => 'info text-dark',
                                        'ENTREGADA'  => 'success',
                                        'ANULADA'    => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $colores[$orden->estado] ?? 'secondary' }}">
                                    {{ $orden->estado }}
                                </span>
                            </td>
                            <td>{{ number_format($orden->total, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('ordenes.edit', $orden->id_orden) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>

                                <form action="{{ route('ordenes.destroy', $orden->id_orden) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar la orden #{{ $orden->id_orden }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay órdenes de trabajo registradas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $ordenes->links() }}
    </div>

@endsection
