<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ReporteController;

Route::get('/', fn() => redirect()->route('login'));

// Rutas de cliente 
Route::middleware(['auth'])->group(function () {

    // Catálogo
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');

    // Carrito
    Route::get('/carrito',                  [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar',         [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar',      [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::post('/carrito/eliminar/{id}',   [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/finalizar',       [CarritoController::class, 'finalizar'])->name('carrito.finalizar');

    // Perfil y pedidos
    Route::get('/perfil',            [PerfilController::class, 'index'])->name('perfil');
    Route::post('/perfil/actualizar',[PerfilController::class, 'actualizar'])->name('perfil.actualizar');
    Route::get('/pedidos',           [PerfilController::class, 'pedidos'])->name('pedidos');

    // Perfil de Breeze 
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rutas de administrador
Route::middleware(['auth', 'es.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',    [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/productos',             [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear',       [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos',            [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}',        [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}',     [ProductoController::class, 'destroy'])->name('productos.destroy');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
});

require __DIR__.'/auth.php';
