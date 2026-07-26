<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\OrdenTrabajo;
use App\Models\Repuesto;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Tarjetas KPI ---
        $totalClientes  = Cliente::count();
        $totalVehiculos = Vehiculo::count();
        $ordenesEnProceso = OrdenTrabajo::where('estado', 'EN_PROCESO')->count();

        $serviciosCompletadosMes = OrdenTrabajo::whereIn('estado', ['FINALIZADA', 'ENTREGADA'])
            ->whereMonth('fecha_ingreso', now()->month)
            ->whereYear('fecha_ingreso', now()->year)
            ->count();

        // --- Gráfico de dona: órdenes por estado ---
        $estados = ['RECIBIDA', 'EN_PROCESO', 'FINALIZADA', 'ENTREGADA', 'ANULADA'];
        $porEstadoRaw = OrdenTrabajo::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $porEstado = collect($estados)
            ->mapWithKeys(fn ($e) => [$e => $porEstadoRaw[$e] ?? 0])
            ->filter(fn ($v) => $v > 0);

        // --- Gráfico de línea: servicios completados en los últimos 6 meses ---
        $nombresMeses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $labelsMeses = [];
        $datosMeses = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $labelsMeses[] = $nombresMeses[$mes->month - 1];
            $datosMeses[] = OrdenTrabajo::whereIn('estado', ['FINALIZADA', 'ENTREGADA'])
                ->whereMonth('fecha_ingreso', $mes->month)
                ->whereYear('fecha_ingreso', $mes->year)
                ->count();
        }

        // --- Últimas órdenes de servicio ---
        $ultimasOrdenes = OrdenTrabajo::with(['cliente', 'vehiculo'])
            ->orderBy('id_orden', 'desc')
            ->limit(5)
            ->get();

        // --- Repuestos con stock bajo ---
        $repuestosStockBajo = Repuesto::with('inventarios')
            ->get()
            ->filter(function ($r) {
                $stock = $r->inventarios->sum('stock_actual');
                $minimo = $r->inventarios->min('stock_minimo') ?? 0;
                return $stock <= $minimo;
            })
            ->take(5);

        return view('dashboard.index', compact(
            'totalClientes', 'totalVehiculos', 'ordenesEnProceso', 'serviciosCompletadosMes',
            'porEstado', 'labelsMeses', 'datosMeses', 'ultimasOrdenes', 'repuestosStockBajo'
        ));
    }
}
