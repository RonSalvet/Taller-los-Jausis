<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Cliente;
use App\Models\ModeloVehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    private function reglas(): array
    {
        return [
            'id_cliente'  => 'required|exists:cliente,id_cliente',
            'id_modelo'   => 'required|exists:modelo_vehiculo,id_modelo',
            'placa'       => 'required|string|max:10',
            'anio'        => 'nullable|integer|min:1950|max:' . (date('Y') + 1),
            'color'       => 'nullable|string|max:30',
            'nro_chasis'  => 'nullable|string|max:30',
            'kilometraje' => 'nullable|integer|min:0',
        ];
    }

    /** Datos comunes para los <select> de los formularios */
    private function datosFormulario(): array
    {
        return [
            'clientes' => Cliente::orderBy('nombre')->get(),
            'modelos'  => ModeloVehiculo::with('marca')->get(),
        ];
    }

    public function index()
    {
        $vehiculos = Vehiculo::with(['cliente', 'modelo.marca'])
            ->orderBy('id_vehiculo', 'desc')
            ->paginate(10);

        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('vehiculos.create', $this->datosFormulario());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->reglas());

        Vehiculo::create($data);

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo registrado correctamente.');
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        return view('vehiculos.edit', array_merge(
            ['vehiculo' => $vehiculo],
            $this->datosFormulario()
        ));
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $data = $request->validate($this->reglas());

        $vehiculo->update($data);

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}
