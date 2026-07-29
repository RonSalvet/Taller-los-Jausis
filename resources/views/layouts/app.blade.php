<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Taller Los Jausis')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.index') }}">🔧 Taller Los Jausis</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vehiculos.index') }}">Vehículos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ordenes.index') }}">Órdenes de Trabajo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('repuestos.index') }}">Repuestos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuarios.index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reportes.index') }}">Reportes</a>
                    </li>
                </ul>

                @if (session('usuario_nombre'))
                    <ul class="navbar-nav">
                        <li class="nav-item d-flex align-items-center">
                            <span class="text-white-50 small me-3">
                                👤 {{ session('usuario_nombre') }}
                                @if (session('usuario_rol'))
                                    <span class="badge bg-secondary ms-1">{{ session('usuario_rol') }}</span>
                                @endif
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light">Salir</button>
                            </form>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
