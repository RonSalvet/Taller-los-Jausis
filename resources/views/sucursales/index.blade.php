@extends('layouts.app')

@section('titulo', 'Sucursales')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Sucursales</h2>
        <a href="{{ route('sucursales.create') }}" class="btn btn-primary">+ Nueva Sucursal</a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Mapa con todas las sucursales que tienen ubicación --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h6 class="text-muted mb-3">Mapa de sucursales</h6>
            <div id="mapa" style="height: 350px; border-radius: 8px;"></div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Zona</th>
                        <th>Ubicación</th><th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sucursales as $sucursal)
                        <tr>
                            <td class="fw-bold">{{ $sucursal->nombre }}</td>
                            <td>{{ $sucursal->direccion }}</td>
                            <td>{{ $sucursal->telefono ?? '—' }}</td>
                            <td>{{ $sucursal->zona ?? '—' }}</td>
                            <td>
                                @if ($sucursal->tieneUbicacion())
                                    <span class="badge bg-success">📍 En el mapa</span>
                                @else
                                    <span class="badge bg-secondary">Sin definir</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('sucursales.edit', $sucursal->id_sucursal) }}"
                                   class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('sucursales.destroy', $sucursal->id_sucursal) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar la sucursal {{ $sucursal->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay sucursales registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const sucursales = {!! json_encode($sucursales->filter->tieneUbicacion()->map(fn($s) => [
            'nombre' => $s->nombre,
            'direccion' => $s->direccion,
            'lat' => (float) $s->latitud,
            'lng' => (float) $s->longitud,
        ])->values()) !!};

        // Centro por defecto: Santa Cruz de la Sierra, Bolivia
        const centro = sucursales.length ? [sucursales[0].lat, sucursales[0].lng] : [-17.7833, -63.1821];
        const mapa = L.map('mapa').setView(centro, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapa);

        sucursales.forEach(s => {
            L.marker([s.lat, s.lng]).addTo(mapa)
                .bindPopup(`<strong>${s.nombre}</strong><br>${s.direccion}`);
        });

        if (sucursales.length === 0) {
            L.marker(centro).addTo(mapa).bindPopup('Aún no hay sucursales con ubicación definida.').openPopup();
        }
    </script>

@endsection
