@extends('layouts.app')

@section('titulo', 'Clientes')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">+ Nuevo Cliente</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>CI / NIT</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id_cliente }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->ci_nit }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email ?? '—' }}</td>
                            <td>
                                @if ($cliente->estado)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('clientes.edit', $cliente->id_cliente) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>

                                <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar a {{ $cliente->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay clientes registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $clientes->links() }}
    </div>

@endsection
