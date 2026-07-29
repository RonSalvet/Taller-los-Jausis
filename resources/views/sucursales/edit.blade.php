@extends('layouts.app')

@section('titulo', 'Editar Sucursal')

@section('content')

    <h2 class="mb-3">Editar Sucursal</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sucursales.update', $sucursal->id_sucursal) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control"
                               value="{{ old('nombre', $sucursal->nombre) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" name="telefono" class="form-control"
                               value="{{ old('telefono', $sucursal->telefono) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control"
                               value="{{ old('direccion', $sucursal->direccion) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Zona (opcional)</label>
                        <input type="text" name="zona" class="form-control"
                               value="{{ old('zona', $sucursal->zona) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Ubicación en el mapa
                        <span class="text-muted small">(haz clic para mover el marcador)</span>
                    </label>
                    <div id="mapa-picker" style="height: 350px; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <input type="text" id="latitud-display" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="longitud-display" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud', $sucursal->latitud) }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud', $sucursal->longitud) }}">
                </div>

                <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
            </form>

        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Centro: la ubicación actual de la sucursal, o Santa Cruz de la Sierra por defecto
        const latInicial = {{ $sucursal->latitud ?? -17.7833 }};
        const lngInicial = {{ $sucursal->longitud ?? -63.1821 }};
        const centro = [latInicial, lngInicial];

        const mapa = L.map('mapa-picker').setView(centro, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapa);

        let marcador = L.marker(centro).addTo(mapa);
        document.getElementById('latitud-display').value = latInicial.toFixed(7);
        document.getElementById('longitud-display').value = lngInicial.toFixed(7);

        mapa.on('click', function (e) {
            const { lat, lng } = e.latlng;
            marcador.setLatLng(e.latlng);

            document.getElementById('latitud').value = lat.toFixed(7);
            document.getElementById('longitud').value = lng.toFixed(7);
            document.getElementById('latitud-display').value = lat.toFixed(7);
            document.getElementById('longitud-display').value = lng.toFixed(7);
        });
    </script>

@endsection
