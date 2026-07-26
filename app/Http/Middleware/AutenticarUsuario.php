<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutenticarUsuario
{
    /**
     * Verifica que haya un usuario en sesión. Si no, lo manda al login
     * y recuerda a dónde quería ir para redirigirlo después.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! session('usuario_id')) {
            return redirect()
                ->route('login')
                ->with('url_intencion', $request->fullUrl());
        }

        return $next($request);
    }
}
