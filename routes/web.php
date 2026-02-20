<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('inicio');
});
Route::get('/carro',[CarritoController::class,'all']);

Route::get('/products',[ProductoController::class,'index'])->name('todos.productos');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/infoProducto/{id}',[ProductoController::class,'verinfo'])->name('ver.producto');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'add'])->name('add.carrito');
Route::get('/carrito/borrarTodo',[CarritoController::class,'deleteAll'])->name('borrartodo.carrito');
Route::post('/carrito/borrar/{id}',[CarritoController::class,'deleteOne'])->name('delete.carrito');

Route::get('/nuevoProducto',[ProductoController::class,'verNuevoProducto'])->name('pg.anadir.producto');
Route::post('/anadirProducto',[ProductoController::class,'store'])->name('subir.producto');
Route::put('/productos/{id}/editar',[ProductoController::class,'update'])->name('editar.producto');
Route::delete('/products/{id}/borrar',[ProductoController::class,'destroy'])->name('borrar.producto');

Route::get('/gestionUsuario',[UserController::class,'gestion'])->name('gestion.usuarios');

Route::get('/misPedidos/{id}',[PedidoController::class,'index'])->name('pedidos.usuario');