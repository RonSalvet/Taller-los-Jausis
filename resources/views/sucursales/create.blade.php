@extends('layouts.app')

@section('titulo', 'Nueva Sucursal')

@section('content')

    <h2 class="mb-3">Nueva Sucursal</h2>

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

            <form action="{{ route('sucursales.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono (opcional)</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                               value="{{ old('direccion') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Zona (opcional)</label>
                        <input type="text" name="zona" class="form-control" value="{{ old('zona') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Ubicación en el mapa
                        <span class="text-muted small">(haz clic en el mapa para marcar el punto exacto del taller)</span>
                    </label>
                    <div id="mapa-picker" style="height: 350px; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <input type="text" id="latitud-display" class="form-control form-control-sm" readonly placeholder="Latitud (clic en el mapa)">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="longitud-display" class="form-control form-control-sm" readonly placeholder="Longitud (clic en el mapa)">
                        </div>
                    </div>
                    <input type="hidden" name="latitud" id="latitud" value="{{ old('latitud') }}">
                    <input type="hidden" name="longitud" id="longitud" value="{{ old('longitud') }}">
                </div>

                <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Sucursal</button>
            </form>

        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Centro por defecto: Santa Cruz de la Sierra, Bolivia
        const centro = [-17.7833, -63.1821];
        const mapa = L.map('mapa-picker').setView(centro, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(mapa);

        let marcador = null;

        mapa.on('click', function (e) {
            const { lat, lng } = e.latlng;

            if (marcador) {
                marcador.setLatLng(e.latlng);
            } else {
                marcador = L.marker(e.latlng).addTo(mapa);
            }

            document.getElementById('latitud').value = lat.toFixed(7);
            document.getElementById('longitud').value = lng.toFixed(7);
            document.getElementById('latitud-display').value = lat.toFixed(7);
            document.getElementById('longitud-display').value = lng.toFixed(7);
        });
    </script>

@endsection
