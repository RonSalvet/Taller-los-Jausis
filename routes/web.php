<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\RepuestoController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Rutas web — TallerPro
|--------------------------------------------------------------------------
*/

// --- Seguridad: Login / Logout / Recuperación de contraseña (públicas) ---
Route::get('/login',            [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',           [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout',          [AuthController::class, 'logout'])->name('logout');

Route::get('/recuperar',            [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/recuperar',           [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/recuperar/restablecer',[AuthController::class, 'showReset'])->name('password.reset');
Route::post('/recuperar/restablecer',[AuthController::class, 'resetPassword'])->name('password.update');

// La raíz del sitio: si hay sesión va al dashboard, si no, al login
Route::get('/', function () {
    return redirect(session('usuario_id') ? route('dashboard.index') : route('login'));
});

// --- Todo lo demás requiere sesión iniciada ---
Route::middleware('auth.usuario')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Clientes
    Route::get('/clientes',              [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear',        [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes',             [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}/editar',  [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}',         [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/clientes/{id}',      [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // Vehículos
    Route::get('/vehiculos',              [VehiculoController::class, 'index'])->name('vehiculos.index');
    Route::get('/vehiculos/crear',        [VehiculoController::class, 'create'])->name('vehiculos.create');
    Route::post('/vehiculos',             [VehiculoController::class, 'store'])->name('vehiculos.store');
    Route::get('/vehiculos/{id}/editar',  [VehiculoController::class, 'edit'])->name('vehiculos.edit');
    Route::put('/vehiculos/{id}',         [VehiculoController::class, 'update'])->name('vehiculos.update');
    Route::delete('/vehiculos/{id}',      [VehiculoController::class, 'destroy'])->name('vehiculos.destroy');

    // Órdenes de Trabajo
    Route::get('/ordenes',              [OrdenTrabajoController::class, 'index'])->name('ordenes.index');
    Route::get('/ordenes/crear',        [OrdenTrabajoController::class, 'create'])->name('ordenes.create');
    Route::post('/ordenes',             [OrdenTrabajoController::class, 'store'])->name('ordenes.store');
    Route::get('/ordenes/{id}/editar',  [OrdenTrabajoController::class, 'edit'])->name('ordenes.edit');
    Route::put('/ordenes/{id}',         [OrdenTrabajoController::class, 'update'])->name('ordenes.update');
    Route::delete('/ordenes/{id}',      [OrdenTrabajoController::class, 'destroy'])->name('ordenes.destroy');

    // Repuestos / Inventario
    Route::get('/repuestos',              [RepuestoController::class, 'index'])->name('repuestos.index');
    Route::get('/repuestos/crear',        [RepuestoController::class, 'create'])->name('repuestos.create');
    Route::post('/repuestos',             [RepuestoController::class, 'store'])->name('repuestos.store');
    Route::get('/repuestos/{id}/editar',  [RepuestoController::class, 'edit'])->name('repuestos.edit');
    Route::put('/repuestos/{id}',         [RepuestoController::class, 'update'])->name('repuestos.update');
    Route::delete('/repuestos/{id}',      [RepuestoController::class, 'destroy'])->name('repuestos.destroy');

    // Usuarios (Administración)
    Route::get('/usuarios',              [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear',        [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios',             [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/editar',  [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}',         [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}',      [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

});
