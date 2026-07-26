@extends('layouts.app')

@section('titulo', 'Repuestos')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Repuestos — Almacén</h2>
        <a href="{{ route('repuestos.create') }}" class="btn btn-primary">+ Nuevo Repuesto</a>
    </div>

    {{-- KPIs --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Total ítems</div>
                    <div class="fs-3 fw-bold">{{ $totalItems }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <div class="text-muted small">Stock bajo</div>
                    <div class="fs-3 fw-bold text-warning">{{ $stockBajo }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <div class="text-muted small">Sin stock</div>
                    <div class="fs-3 fw-bold text-danger">{{ $sinStock }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <div class="text-muted small">Valor inventario</div>
                    <div class="fs-5 fw-bold text-success">Bs {{ number_format($valorInventario, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Repuesto</th>
                        <th>Marca</th>
                        <th>Stock</th>
                        <th>Mínimo</th>
                        <th>Precio venta (Bs)</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($repuestos as $repuesto)
                        @php
                            $stock = $repuesto->inventarios->sum('stock_actual');
                            $minimo = $repuesto->inventarios->min('stock_minimo') ?? 0;
                            if ($stock == 0) {
                                $estado = ['Sin stock', 'danger'];
                            } elseif ($stock <= $minimo) {
                                $estado = ['Stock bajo', 'warning text-dark'];
                            } else {
                                $estado = ['Disponible', 'success'];
                            }
                        @endphp
                        <tr>
                            <td>{{ $repuesto->codigo }}</td>
                            <td>{{ $repuesto->nombre }}</td>
                            <td>{{ $repuesto->marca ?? '—' }}</td>
                            <td class="fw-bold">{{ $stock }}</td>
                            <td>{{ $minimo }}</td>
                            <td>{{ number_format($repuesto->precio_venta, 2) }}</td>
                            <td><span class="badge bg-{{ $estado[1] }}">{{ $estado[0] }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('repuestos.edit', $repuesto->id_repuesto) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>

                                <form action="{{ route('repuestos.destroy', $repuesto->id_repuesto) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar el repuesto {{ $repuesto->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay repuestos registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $repuestos->links() }}
    </div>

@endsection
