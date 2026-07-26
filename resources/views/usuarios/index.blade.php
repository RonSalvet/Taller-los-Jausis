@extends('layouts.app')

@section('titulo', 'Usuarios')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Usuarios</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo Usuario</a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id_usuario }}</td>
                            <td>
                                {{ $usuario->nombre_completo }}
                                @if (session('usuario_id') == $usuario->id_usuario)
                                    <span class="badge bg-primary">Tú</span>
                                @endif
                            </td>
                            <td>{{ $usuario->email }}</td>
                            <td><span class="badge bg-secondary">{{ $usuario->rol->nombre ?? '—' }}</span></td>
                            <td>{{ $usuario->sucursal->nombre ?? '—' }}</td>
                            <td>
                                @if ($usuario->estado)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>

                                @if (session('usuario_id') != $usuario->id_usuario)
                                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Eliminar a {{ $usuario->nombre_completo }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay usuarios registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $usuarios->links() }}
    </div>

@endsection
