@extends('layouts.app')

@section('titulo', 'Reportes')

@section('content')

    <h2 class="mb-4">Reportes</h2>

    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="{{ route('reportes.reparaciones') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-primary">
                    <div class="card-body text-center py-5">
                        <div class="fs-1 mb-2">🔧</div>
                        <h4 class="text-dark">Reporte de Reparaciones</h4>
                        <p class="text-muted mb-0">
                            KPIs, tendencia mensual, top mecánicos y detalle de órdenes de trabajo.
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('reportes.diagnosticos') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-info">
                    <div class="card-body text-center py-5">
                        <div class="fs-1 mb-2">🩺</div>
                        <h4 class="text-dark">Reporte de Diagnósticos</h4>
                        <p class="text-muted mb-0">
                            Distribución de resultados y tiempo promedio de atención por marca.
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection
