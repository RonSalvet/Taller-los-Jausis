<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /** Muestra el formulario de login */
    public function showLogin()
    {
        if (session('usuario_id')) {
            return redirect()->route('dashboard.index');
        }

        return view('auth.login');
    }

    /** Procesa el intento de inicio de sesión */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $request->email)
            ->where('estado', true)
            ->first();

        if (! $usuario || ! Hash::check($request->password, $usuario->password_hash)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Correo o contraseña incorrectos.');
        }

        $request->session()->regenerate();
        session([
            'usuario_id'     => $usuario->id_usuario,
            'usuario_nombre' => $usuario->nombre_completo,
            'usuario_rol'    => $usuario->rol->nombre ?? null,
        ]);

        $destino = session('url_intencion', route('dashboard.index'));
        session()->forget('url_intencion');

        return redirect($destino)->with('success', 'Bienvenido, ' . $usuario->nombre_completo . '.');
    }

    /** Cierra la sesión */
    public function logout(Request $request)
    {
        session()->forget(['usuario_id', 'usuario_nombre', 'usuario_rol']);
        $request->session()->regenerate();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    /** Muestra el formulario para pedir el correo de recuperación */
    public function showForgot()
    {
        return view('auth.forgot');
    }

    /**
     * Genera un token de recuperación.
     *
     * NOTA: como el proyecto no tiene un servidor de correo configurado,
     * en vez de enviar un email, mostramos el enlace directamente en pantalla.
     * Cuando se configure Mail (config/mail.php), reemplazar esta parte por
     * Mail::to($usuario->email)->send(new ResetPasswordMail($token)).
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuario,email',
        ]);

        $token = Str::random(40);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        $enlace = route('password.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);

        return back()->with('enlace_recuperacion', $enlace);
    }

    /** Muestra el formulario para definir la nueva contraseña */
    public function showReset(Request $request)
    {
        return view('auth.reset', [
            'token' => $request->query('token'),
            'email' => $request->query('email'),
        ]);
    }

    /** Guarda la nueva contraseña si el token es válido */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:usuario,email',
            'token'    => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $registro = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        $valido = $registro
            && Hash::check($request->token, $registro->token)
            && now()->diffInMinutes($registro->created_at) <= 60;

        if (! $valido) {
            return back()->with('error', 'El enlace de recuperación es inválido o ya expiró.');
        }

        Usuario::where('email', $request->email)
            ->update(['password_hash' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Contraseña actualizada. Ya puedes iniciar sesión.');
    }
}
