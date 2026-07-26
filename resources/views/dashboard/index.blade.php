@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('content')

    <h2 class="mb-3">Dashboard</h2>

    {{-- KPIs --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-primary h-100">
                <div class="card-body">
                    <div class="text-muted small">Clientes</div>
                    <div class="fs-2 fw-bold text-primary">{{ $totalClientes }}</div>
                    <div class="text-muted small">Clientes registrados</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-success h-100">
                <div class="card-body">
                    <div class="text-muted small">Vehículos</div>
                    <div class="fs-2 fw-bold text-success">{{ $totalVehiculos }}</div>
                    <div class="text-muted small">Vehículos registrados</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card shadow-sm border-warning h-100">
                <div class="card-body">
                    <div class="text-muted small">Órdenes de Servicio</div>
                    <div class="fs-2 fw-bold text-warning">{{ $ordenesEnProceso }}</div>
                    <div class="text-muted small">En proceso</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-info h-100">
                <div class="card-body">
                    <div class="text-muted small">Servicios Completados</div>
                    <div class="fs-2 fw-bold text-info">{{ $serviciosCompletadosMes }}</div>
                    <div class="text-muted small">Este mes</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row mb-4">
        <div class="col-md-5 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Órdenes de Servicio por Estado</h6>
                    @if ($porEstado->isEmpty())
                        <p class="text-muted text-center py-5">Aún no hay órdenes registradas.</p>
                    @else
                        <canvas id="graficoEstados" height="220"></canvas>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Servicios Completados (Últimos 6 meses)</h6>
                    <canvas id="graficoTendencia" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tablas --}}
    <div class="row">
        <div class="col-md-7 mb-3 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Últimas Órdenes de Servicio</h6>
                    <table class="table table-sm align-middle m-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimasOrdenes as $orden)
                                @php
                                    $colores = [
                                        'RECIBIDA'   => 'secondary',
                                        'EN_PROCESO' => 'warning text-dark',
                                        'FINALIZADA' => 'info text-dark',
                                        'ENTREGADA'  => 'success',
                                        'ANULADA'    => 'danger',
                                    ];
                                @endphp
                                <tr>
                                    <td>#{{ str_pad($orden->id_orden, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $orden->cliente->nombre ?? '—' }}</td>
                                    <td>{{ $orden->vehiculo->placa ?? '—' }}</td>
                                    <td>{{ optional($orden->fecha_ingreso)->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-{{ $colores[$orden->estado] ?? 'secondary' }}">{{ $orden->estado }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Sin órdenes todavía.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <a href="{{ route('ordenes.index') }}" class="small">Ver todas las órdenes →</a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-3">⚠ Repuestos con stock bajo</h6>
                    <table class="table table-sm align-middle m-0">
                        <thead>
                            <tr>
                                <th>Repuesto</th>
                                <th>Stock</th>
                                <th>Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($repuestosStockBajo as $repuesto)
                                <tr>
                                    <td>{{ $repuesto->nombre }}</td>
                                    <td class="text-danger fw-bold">{{ $repuesto->inventarios->sum('stock_actual') }}</td>
                                    <td>{{ $repuesto->inventarios->min('stock_minimo') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">Todo el stock está en orden ✅</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <a href="{{ route('repuestos.index') }}" class="small">Ir a almacén →</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        @if ($porEstado->isNotEmpty())
        new Chart(document.getElementById('graficoEstados'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($porEstado->keys()) !!},
                datasets: [{
                    data: {!! json_encode($porEstado->values()) !!},
                    backgroundColor: ['#6c757d', '#ffc107', '#0dcaf0', '#198754', '#dc3545'],
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
        @endif

        new Chart(document.getElementById('graficoTendencia'), {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsMeses) !!},
                datasets: [{
                    label: 'Servicios completados',
                    data: {!! json_encode($datosMeses) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.15)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    </script>

@endsection
