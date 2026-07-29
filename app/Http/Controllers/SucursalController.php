<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    private function reglas(): array
    {
        return [
            'nombre'    => 'required|string|max:100',
            'direccion' => 'required|string|max:200',
            'telefono'  => 'nullable|string|max:20',
            'zona'      => 'nullable|string|max:100',
            'latitud'   => 'nullable|numeric|between:-90,90',
            'longitud'  => 'nullable|numeric|between:-180,180',
        ];
    }

    public function index()
    {
        $sucursales = Sucursal::orderBy('nombre')->get();

        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->reglas());

        Sucursal::create($data);

        return redirect()
            ->route('sucursales.index')
            ->with('success', 'Sucursal registrada correctamente.');
    }

    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id);

        return view('sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $data = $request->validate($this->reglas());

        $sucursal->update($data);

        return redirect()
            ->route('sucursales.index')
            ->with('success', 'Sucursal actualizada correctamente.');
    }

    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);

        try {
            $sucursal->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('sucursales.index')
                ->with('error', 'No se puede eliminar: esta sucursal tiene usuarios, mecánicos u órdenes asociadas.');
        }

        return redirect()
            ->route('sucursales.index')
            ->with('success', 'Sucursal eliminada correctamente.');
    }
}
