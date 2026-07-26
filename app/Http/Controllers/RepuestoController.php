<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use App\Models\Inventario;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    private function reglas(): array
    {
        return [
            'codigo'        => 'required|string|max:30',
            'nombre'        => 'required|string|max:120',
            'descripcion'   => 'nullable|string|max:255',
            'marca'         => 'nullable|string|max:60',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta'  => 'required|numeric|min:0',
            'id_sucursal'   => 'required|exists:sucursal,id_sucursal',
            'stock_actual'  => 'required|integer|min:0',
            'stock_minimo'  => 'required|integer|min:0',
            'ubicacion'     => 'nullable|string|max:60',
        ];
    }

    public function index()
    {
        $repuestos = Repuesto::with('inventarios.sucursal')
            ->orderBy('nombre')
            ->paginate(10);

        // KPIs para las tarjetas superiores
        $todos = Repuesto::with('inventarios')->get();

        $totalItems = $todos->count();
        $sinStock   = $todos->filter(fn ($r) => $r->inventarios->sum('stock_actual') == 0)->count();
        $stockBajo  = $todos->filter(function ($r) {
            $stock = $r->inventarios->sum('stock_actual');
            $minimo = $r->inventarios->min('stock_minimo') ?? 0;
            return $stock > 0 && $stock <= $minimo;
        })->count();
        $valorInventario = $todos->sum(fn ($r) => $r->inventarios->sum('stock_actual') * $r->precio_venta);

        return view('repuestos.index', compact(
            'repuestos', 'totalItems', 'sinStock', 'stockBajo', 'valorInventario'
        ));
    }

    public function create()
    {
        $sucursales = Sucursal::orderBy('nombre')->get();

        return view('repuestos.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->reglas());

        $repuesto = Repuesto::create([
            'codigo'        => $data['codigo'],
            'nombre'        => $data['nombre'],
            'descripcion'   => $data['descripcion'] ?? null,
            'marca'         => $data['marca'] ?? null,
            'precio_compra' => $data['precio_compra'] ?? 0,
            'precio_venta'  => $data['precio_venta'],
        ]);

        Inventario::create([
            'id_repuesto'  => $repuesto->id_repuesto,
            'id_sucursal'  => $data['id_sucursal'],
            'stock_actual' => $data['stock_actual'],
            'stock_minimo' => $data['stock_minimo'],
            'ubicacion'    => $data['ubicacion'] ?? null,
        ]);

        return redirect()
            ->route('repuestos.index')
            ->with('success', 'Repuesto registrado correctamente.');
    }

    public function edit($id)
    {
        $repuesto   = Repuesto::findOrFail($id);
        $inventario = $repuesto->inventarios()->first(); // stock actual (primera sucursal registrada)
        $sucursales = Sucursal::orderBy('nombre')->get();

        return view('repuestos.edit', compact('repuesto', 'inventario', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $repuesto = Repuesto::findOrFail($id);
        $data = $request->validate($this->reglas());

        $repuesto->update([
            'codigo'        => $data['codigo'],
            'nombre'        => $data['nombre'],
            'descripcion'   => $data['descripcion'] ?? null,
            'marca'         => $data['marca'] ?? null,
            'precio_compra' => $data['precio_compra'] ?? 0,
            'precio_venta'  => $data['precio_venta'],
        ]);

        // Actualiza el inventario de la sucursal elegida, o lo crea si no existía
        $inventario = Inventario::where('id_repuesto', $repuesto->id_repuesto)
            ->where('id_sucursal', $data['id_sucursal'])
            ->first();

        $valoresStock = [
            'stock_actual' => $data['stock_actual'],
            'stock_minimo' => $data['stock_minimo'],
            'ubicacion'    => $data['ubicacion'] ?? null,
        ];

        if ($inventario) {
            $inventario->update($valoresStock);
        } else {
            Inventario::create(array_merge($valoresStock, [
                'id_repuesto' => $repuesto->id_repuesto,
                'id_sucursal' => $data['id_sucursal'],
            ]));
        }

        return redirect()
            ->route('repuestos.index')
            ->with('success', 'Repuesto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $repuesto = Repuesto::findOrFail($id);

        // Elimina primero sus registros de inventario para evitar error de llave foránea
        $repuesto->inventarios()->delete();
        $repuesto->delete();

        return redirect()
            ->route('repuestos.index')
            ->with('success', 'Repuesto eliminado correctamente.');
    }
}
