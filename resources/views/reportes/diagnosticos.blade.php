@extends('layouts.app')

@section('titulo', 'Reporte de Diagnósticos')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Reporte de Diagnósticos</h2>
        <button onclick="window.print()" class="btn btn-outline-danger btn-sm">⬇ Imprimir / PDF</button>
    </div>

    {{-- Filtros --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('reportes.diagnosticos') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Desde</label>
                    <input type="date" name="desde" class="form-control" value="{{ $desde }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Hasta</label>
                    <input type="date" name="hasta" class="form-control" value="{{ $hasta }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Resultado</label>
                    <select name="resultado" class="form-select">
                        <option value="">Todos</option>
                        <option value="REPARABLE" {{ $resultado == 'REPARABLE' ? 'selected' : '' }}>Reparable</option>
                        <option value="REQUIERE_REPUESTO" {{ $resultado == 'REQUIERE_REPUESTO' ? 'selected' : '' }}>Requiere repuesto</option>
                        <option value="NO_REPARABLE" {{ $resultado == 'NO_REPARABLE' ? 'selected' : '' }}>No reparable</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-5 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Diagnósticos por resultado</h6>
                    @if ($totalDiagnosticados == 0)
                        <p class="text-muted text-center py-5">
                            No hay órdenes con diagnóstico registrado en este rango.<br>
                            <span class="small">Recuerda seleccionar un "Resultado del diagnóstico" al editar una orden de trabajo.</span>
                        </p>
                    @else
                        <canvas id="graficoDona" height="220"></canvas>
                        <p class="text-center text-muted small mt-2">{{ $totalDiagnosticados }} diagnósticos en total</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Tiempo promedio en taller (días) por marca</h6>
                    @forelse ($tiempoPorMarca as $marca => $dias)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $marca }}</span>
                            <div class="flex-grow-1 mx-2">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary"
                                         style="width: {{ $tiempoPorMarca->max() ? ($dias / $tiempoPorMarca->max() * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            <span class="fw-bold">{{ $dias }} d</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Sin datos suficientes en el rango seleccionado.</p>
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
                        <th>Orden</th><th>Cliente</th><th>Vehículo</th><th>Diagnóstico</th>
                        <th>Resultado</th><th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detalle as $orden)
                        @php
                            $coloresRes = ['REPARABLE'=>['Reparable','success'],'REQUIERE_REPUESTO'=>['Requiere repuesto','warning text-dark'],'NO_REPARABLE'=>['No reparable','danger']];
                            [$label, $color] = $coloresRes[$orden->resultado_diagnostico] ?? ['—','secondary'];
                        @endphp
                        <tr>
                            <td>#{{ str_pad($orden->id_orden, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $orden->cliente->nombre ?? '—' }}</td>
                            <td>{{ $orden->vehiculo->placa ?? '—' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($orden->diagnostico, 40) ?: '—' }}</td>
                            <td><span class="badge bg-{{ $color }}">{{ $label }}</span></td>
                            <td>{{ optional($orden->fecha_ingreso)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Sin resultados en el rango seleccionado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $detalle->links() }}</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        @if ($totalDiagnosticados > 0)
        new Chart(document.getElementById('graficoDona'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labelsDona) !!},
                datasets: [{
                    data: {!! json_encode($datosDona) !!},
                    backgroundColor: ['#16A34A', '#F2A104', '#DC2626'],
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
        @endif
    </script>

@endsection
