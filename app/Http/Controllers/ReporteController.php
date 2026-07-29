<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\Mecanico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /** Pantalla de selección entre los dos reportes */
    public function index()
    {
        return view('reportes.index');
    }

    /** Reporte de Reparaciones */
    public function reparaciones(Request $request)
    {
        $desde = $request->input('desde', now()->subMonths(5)->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());
        $idMecanico = $request->input('id_mecanico');
        $estado = $request->input('estado');

        $query = OrdenTrabajo::with(['cliente', 'vehiculo', 'mecanicos'])
            ->whereDate('fecha_ingreso', '>=', $desde)
            ->whereDate('fecha_ingreso', '<=', $hasta);

        if ($idMecanico) {
            $query->whereHas('mecanicos', fn ($q) => $q->where('mecanico.id_mecanico', $idMecanico));
        }
        if ($estado) {
            $query->where('estado', $estado);
        }

        $ordenesFiltradas = (clone $query)->get();

        // KPIs
        $totalReparaciones = $ordenesFiltradas->count();
        $completadas = $ordenesFiltradas->whereIn('estado', ['FINALIZADA', 'ENTREGADA'])->count();
        $enProceso = $ordenesFiltradas->where('estado', 'EN_PROCESO')->count();
        $ingresos = $ordenesFiltradas->whereIn('estado', ['FINALIZADA', 'ENTREGADA'])->sum('total');

        // Gráfico: reparaciones por mes dentro del rango filtrado
        $porMes = $ordenesFiltradas
            ->groupBy(fn ($o) => \Carbon\Carbon::parse($o->fecha_ingreso)->format('Y-m'))
            ->map(fn ($grupo) => $grupo->count())
            ->sortKeys();

        $nombresMeses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labelsMeses = $porMes->keys()->map(function ($ym) use ($nombresMeses) {
            [$anio, $mes] = explode('-', $ym);
            return $nombresMeses[(int) $mes - 1] . ' ' . substr($anio, 2);
        })->values();
        $datosMeses = $porMes->values();

        // Top mecánicos (por cantidad de órdenes en el rango filtrado)
        $topMecanicos = Mecanico::withCount(['ordenesTrabajo' => function ($q) use ($desde, $hasta) {
                $q->whereDate('fecha_ingreso', '>=', $desde)->whereDate('fecha_ingreso', '<=', $hasta);
            }])
            ->orderByDesc('ordenes_trabajo_count')
            ->take(5)
            ->get()
            ->filter(fn ($m) => $m->ordenes_trabajo_count > 0);

        // Tabla detalle (paginada, mismos filtros)
        $detalle = $query->orderByDesc('fecha_ingreso')->paginate(10)->withQueryString();

        $mecanicosLista = Mecanico::orderBy('nombre')->get();

        return view('reportes.reparaciones', compact(
            'desde', 'hasta', 'idMecanico', 'estado', 'mecanicosLista',
            'totalReparaciones', 'completadas', 'enProceso', 'ingresos',
            'labelsMeses', 'datosMeses', 'topMecanicos', 'detalle'
        ));
    }

    /** Reporte de Diagnósticos */
    public function diagnosticos(Request $request)
    {
        $desde = $request->input('desde', now()->subMonths(2)->startOfMonth()->toDateString());
        $hasta = $request->input('hasta', now()->toDateString());
        $resultado = $request->input('resultado');

        $query = OrdenTrabajo::with(['cliente', 'vehiculo.modelo.marca'])
            ->whereNotNull('resultado_diagnostico')
            ->whereDate('fecha_ingreso', '>=', $desde)
            ->whereDate('fecha_ingreso', '<=', $hasta);

        if ($resultado) {
            $query->where('resultado_diagnostico', $resultado);
        }

        $diagnosticados = (clone $query)->get();

        // Gráfico de dona: distribución por resultado
        $etiquetas = [
            'REPARABLE'          => 'Reparable',
            'REQUIERE_REPUESTO'  => 'Requiere repuesto',
            'NO_REPARABLE'       => 'No reparable',
        ];
        $porResultado = $diagnosticados->groupBy('resultado_diagnostico')
            ->map(fn ($g) => $g->count());

        $labelsDona = collect($etiquetas)->only($porResultado->keys())->values();
        $datosDona  = $porResultado->values();
        $totalDiagnosticados = $diagnosticados->count();

        // Tiempo promedio en taller (días), agrupado por marca de vehículo
        $tiempoPorMarca = $diagnosticados
            ->filter(fn ($o) => $o->fecha_entrega_estimada)
            ->groupBy(fn ($o) => $o->vehiculo->modelo->marca->nombre ?? 'Otros')
            ->map(function ($grupo) {
                $promedioDias = $grupo->avg(function ($o) {
                    return \Carbon\Carbon::parse($o->fecha_ingreso)
                        ->diffInDays(\Carbon\Carbon::parse($o->fecha_entrega_estimada));
                });
                return round($promedioDias, 1);
            })
            ->sortDesc()
            ->take(6);

        // Tabla detalle (paginada, mismos filtros)
        $detalle = $query->orderByDesc('fecha_ingreso')->paginate(10)->withQueryString();

        return view('reportes.diagnosticos', compact(
            'desde', 'hasta', 'resultado', 'etiquetas',
            'labelsDona', 'datosDona', 'totalDiagnosticados', 'tiempoPorMarca', 'detalle'
        ));
    }
}
