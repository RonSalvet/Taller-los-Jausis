<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Sucursal;
use App\Models\Usuario;
use App\Models\Mecanico;
use Illuminate\Http\Request;

class OrdenTrabajoController extends Controller
{
    private function reglas(): array
    {
        return [
            'id_cliente'             => 'required|exists:cliente,id_cliente',
            'id_vehiculo'            => 'required|exists:vehiculo,id_vehiculo',
            'id_sucursal'            => 'required|exists:sucursal,id_sucursal',
            'id_usuario_registro'    => 'required|exists:usuario,id_usuario',
            'fecha_entrega_estimada' => 'nullable|date',
            'estado'                 => 'required|in:RECIBIDA,EN_PROCESO,FINALIZADA,ENTREGADA,ANULADA',
            'diagnostico'            => 'nullable|string',
            'observaciones'          => 'nullable|string',
            'mecanicos'              => 'nullable|array',
            'mecanicos.*'            => 'exists:mecanico,id_mecanico',
        ];
    }

    /** Datos comunes para los <select> de los formularios */
    private function datosFormulario(): array
    {
        return [
            'clientes'  => Cliente::orderBy('nombre')->get(),
            'vehiculos' => Vehiculo::with('cliente')->get(),
            'sucursales'=> Sucursal::orderBy('nombre')->get(),
            'usuarios'  => Usuario::orderBy('nombre_completo')->get(),
            'mecanicos' => Mecanico::where('disponibilidad', true)->orderBy('nombre')->get(),
        ];
    }

    public function index()
    {
        $ordenes = OrdenTrabajo::with(['cliente', 'vehiculo'])
            ->orderBy('id_orden', 'desc')
            ->paginate(10);

        return view('ordenes.index', compact('ordenes'));
    }

    public function create()
    {
        return view('ordenes.create', $this->datosFormulario());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->reglas());
        $mecanicosSeleccionados = $data['mecanicos'] ?? [];
        unset($data['mecanicos']);

        $orden = OrdenTrabajo::create($data);

        // Asigna los mecánicos seleccionados a la orden (tabla orden_mecanico)
        $orden->mecanicos()->sync($mecanicosSeleccionados);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden de trabajo #' . $orden->id_orden . ' registrada correctamente.');
    }

    public function edit($id)
    {
        $orden = OrdenTrabajo::with('mecanicos')->findOrFail($id);

        return view('ordenes.edit', array_merge(
            ['orden' => $orden],
            $this->datosFormulario()
        ));
    }

    public function update(Request $request, $id)
    {
        $orden = OrdenTrabajo::findOrFail($id);

        $data = $request->validate($this->reglas());
        $mecanicosSeleccionados = $data['mecanicos'] ?? [];
        unset($data['mecanicos']);

        $orden->update($data);
        $orden->mecanicos()->sync($mecanicosSeleccionados);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden de trabajo #' . $orden->id_orden . ' actualizada correctamente.');
    }

    public function destroy($id)
    {
        $orden = OrdenTrabajo::findOrFail($id);
        $orden->delete();

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden de trabajo eliminada correctamente.');
    }
}
