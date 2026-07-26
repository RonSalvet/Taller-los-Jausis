<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Taller Los Jausis')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div style="width: 100%; max-width: 400px;">

        <div class="text-center mb-4">
            <span class="fs-2 fw-bold text-white">🔧 Taller Los Jausis</span>
            <div class="text-white-50 small">Gestión de Taller Automotriz</div>
        </div>

        <div class="card shadow">
            <div class="card-body p-4">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('content')

            </div>
        </div>

    </div>

</body>
</html>
