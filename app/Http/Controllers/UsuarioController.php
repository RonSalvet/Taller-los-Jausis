<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class UsuarioController extends Controller
{
    private function reglas(?int $idUsuario = null): array
    {
        return [
            'id_rol'      => 'required|exists:rol,id_rol',
            'id_sucursal' => 'required|exists:sucursal,id_sucursal',
            'nombre_completo' => 'required|string|max:150',
            'email' => [
                'required', 'email', 'max:120',
                Rule::unique('usuario', 'email')->ignore($idUsuario, 'id_usuario'),
            ],
            'telefono' => 'nullable|string|max:20',
            // La contraseña es obligatoria al crear; opcional al editar (se deja en blanco para no cambiarla)
            'password' => ($idUsuario ? 'nullable' : 'required') . '|string|min:6|confirmed',
        ];
    }

    private function datosFormulario(): array
    {
        return [
            'roles'      => Rol::orderBy('nombre')->get(),
            'sucursales' => Sucursal::orderBy('nombre')->get(),
        ];
    }

    public function index()
    {
        $usuarios = Usuario::with(['rol', 'sucursal'])
            ->orderBy('nombre_completo')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create', $this->datosFormulario());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->reglas());

        Usuario::create([
            'id_rol'          => $data['id_rol'],
            'id_sucursal'     => $data['id_sucursal'],
            'nombre_completo' => $data['nombre_completo'],
            'email'           => $data['email'],
            'password_hash'   => Hash::make($data['password']),
            'telefono'        => $data['telefono'] ?? null,
            'estado'          => $request->has('estado'),
            'fecha_creacion'  => now(),
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);

        return view('usuarios.edit', array_merge(
            ['usuario' => $usuario],
            $this->datosFormulario()
        ));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $data = $request->validate($this->reglas($usuario->id_usuario));

        $usuario->id_rol          = $data['id_rol'];
        $usuario->id_sucursal     = $data['id_sucursal'];
        $usuario->nombre_completo = $data['nombre_completo'];
        $usuario->email           = $data['email'];
        $usuario->telefono        = $data['telefono'] ?? null;
        $usuario->estado          = $request->has('estado');

        // Solo actualiza la contraseña si se escribió una nueva
        if (! empty($data['password'])) {
            $usuario->password_hash = Hash::make($data['password']);
        }

        $usuario->save();

        // Si el usuario editó su propio nombre, refresca el que se ve en la navbar
        if (session('usuario_id') == $usuario->id_usuario) {
            session(['usuario_nombre' => $usuario->nombre_completo]);
        }

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        if (session('usuario_id') == $id) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario mientras tienes la sesión iniciada.');
        }

        $usuario = Usuario::findOrFail($id);

        try {
            $usuario->delete();
        } catch (QueryException $e) {
            // El usuario tiene registros relacionados (órdenes, pagos, etc.)
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No se puede eliminar: este usuario tiene órdenes u otros registros asociados. Puedes desactivarlo en su lugar.');
        }

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
