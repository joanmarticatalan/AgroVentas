<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('inicio');
});
Route::get('/carro',[CarritoController::class,'all']);

Route::get('/products',[ProductoController::class,'index'])->name('todos.productos');
Route::get('/pedidos',[PedidosController::class,'index'])->name('todos.pedidos');


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
