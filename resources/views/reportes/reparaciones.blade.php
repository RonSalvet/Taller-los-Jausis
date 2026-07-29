@extends('layouts.app')

@section('titulo', 'Reporte de Reparaciones')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Reporte de Reparaciones</h2>
        <button onclick="window.print()" class="btn btn-outline-danger btn-sm">⬇ Imprimir / PDF</button>
    </div>

    {{-- Filtros --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('reportes.reparaciones') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Desde</label>
                    <input type="date" name="desde" class="form-control" value="{{ $desde }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Hasta</label>
                    <input type="date" name="hasta" class="form-control" value="{{ $hasta }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Mecánico</label>
                    <select name="id_mecanico" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($mecanicosLista as $m)
                            <option value="{{ $m->id_mecanico }}" {{ $idMecanico == $m->id_mecanico ? 'selected' : '' }}>
                                {{ $m->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        @foreach (['RECIBIDA','EN_PROCESO','FINALIZADA','ENTREGADA','ANULADA'] as $e)
                            <option value="{{ $e }}" {{ $estado == $e ? 'selected' : '' }}>{{ $e }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-primary h-100">
                <div class="card-body">
                    <div class="text-muted small">Reparaciones</div>
                    <div class="fs-2 fw-bold text-primary">{{ $totalReparaciones }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-success h-100">
                <div class="card-body">
                    <div class="text-muted small">Completadas</div>
                    <div class="fs-2 fw-bold text-success">{{ $completadas }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-warning h-100">
                <div class="card-body">
                    <div class="text-muted small">En proceso</div>
                    <div class="fs-2 fw-bold text-warning">{{ $enProceso }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-info h-100">
                <div class="card-body">
                    <div class="text-muted small">Ingresos (Bs)</div>
                    <div class="fs-4 fw-bold text-info">{{ number_format($ingresos, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row mb-4">
        <div class="col-md-7 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Reparaciones por mes</h6>
                    @if ($datosMeses->isEmpty())
                        <p class="text-muted text-center py-5">Sin datos en el rango seleccionado.</p>
                    @else
                        <canvas id="graficoMeses" height="200"></canvas>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Top técnicos</h6>
                    @forelse ($topMecanicos as $m)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $m->nombre }}</span>
                            <div class="flex-grow-1 mx-2">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-warning"
                                         style="width: {{ $topMecanicos->max('ordenes_trabajo_count') ? ($m->ordenes_trabajo_count / $topMecanicos->max('ordenes_trabajo_count') * 100) : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            <span class="fw-bold">{{ $m->ordenes_trabajo_count }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Sin datos en el rango seleccionado.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla detalle --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>Orden</th><th>Cliente</th><th>Vehículo</th><th>Mecánico(s)</th>
                        <th>Fecha</th><th>Estado</th><th>Costo (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detalle as $orden)
                        @php
                            $colores = ['RECIBIDA'=>'secondary','EN_PROCESO'=>'warning text-dark','FINALIZADA'=>'info text-dark','ENTREGADA'=>'success','ANULADA'=>'danger'];
                        @endphp
                        <tr>
                            <td>#{{ str_pad($orden->id_orden, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $orden->cliente->nombre ?? '—' }}</td>
                            <td>{{ $orden->vehiculo->placa ?? '—' }}</td>
                            <td>{{ $orden->mecanicos->pluck('nombre')->implode(', ') ?: '—' }}</td>
                            <td>{{ optional($orden->fecha_ingreso)->format('d/m/Y') }}</td>
                            <td><span class="badge bg-{{ $colores[$orden->estado] ?? 'secondary' }}">{{ $orden->estado }}</span></td>
                            <td>{{ number_format($orden->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Sin resultados en el rango seleccionado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $detalle->links() }}</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        @if ($datosMeses->isNotEmpty())
        new Chart(document.getElementById('graficoMeses'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsMeses) !!},
                datasets: [{
                    label: 'Reparaciones',
                    data: {!! json_encode($datosMeses) !!},
                    backgroundColor: '#1B2A41',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
        @endif
    </script>

@endsection
