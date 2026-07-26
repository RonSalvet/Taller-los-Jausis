<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Reglas de validación reutilizadas en store() y update().
     */
    private function reglas(): array
    {
        return [
            'nombre'         => 'required|string|max:150',
            'ci_nit'         => 'required|string|max:20',
            'telefono'       => 'required|string|max:20',
            'email'          => 'nullable|email|max:120',
            'direccion'      => 'nullable|string|max:200',
            'fecha_registro' => 'required|date',
        ];
    }

    /** Listado de clientes */
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    /** Formulario de creación */
    public function create()
    {
        return view('clientes.create');
    }

    /** Guardar nuevo cliente */
    public function store(Request $request)
    {
        $data = $request->validate($this->reglas());
        $data['estado'] = $request->has('estado'); // checkbox: activo/inactivo

        Cliente::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    /** Formulario de edición */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', compact('cliente'));
    }

    /** Actualizar cliente existente */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $data = $request->validate($this->reglas());
        $data['estado'] = $request->has('estado');

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /** Eliminar cliente */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
