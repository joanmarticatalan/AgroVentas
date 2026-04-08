<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Rutas públicas
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::get('/products', [ProductoController::class, 'index'])->name('todos.productos');
Route::get('/infoProducto/{id}', [ProductoController::class, 'verinfo'])->name('ver.producto');


// Autenticación
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 

// Carrito (puede ser público o con auth, según tu lógica)
Route::get('/carro', [CarritoController::class, 'all'])->name('carrito.all');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'add'])->name('add.carrito');
Route::get('/carrito/borrarTodo', [CarritoController::class, 'deleteAll'])->name('borrartodo.carrito');
Route::post('/carrito/borrar/{id}', [CarritoController::class, 'deleteOne'])->name('delete.carrito');

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    // Perfil del usuario autenticado
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('perfil.editar');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('perfil.update');

    // Pedidos del usuario autenticado (sin parámetro ID, se obtiene del Auth)
    Route::get('/mis-pedidos', [PedidoController::class, 'index'])->name('pedidos.usuario');

    //Pedidos del vendedor
    Route::get('/pedidosVendedor', [PedidoController::class, 'pedidosVendedor'])->name('pedidos.vendedor');
    
    // Checkout
    Route::get('/checkout', [PedidoController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [PedidoController::class, 'validateOrder'])->name('checkout.confirm');

    // Gestión de productos (crear, editar, borrar) - posiblemente restrinjas por roles
    Route::get('/nuevoProducto', [ProductoController::class, 'verNuevoProducto'])->name('pg.anadir.producto');
    Route::post('/anadirProducto', [ProductoController::class, 'store'])->name('subir.producto');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}/editar', [ProductoController::class, 'update'])->name('editar.producto');
    Route::delete('/products/{id}/borrar', [ProductoController::class, 'destroy'])->name('borrar.producto');
    Route::get('/misProductos', [ProductoController::class, 'verMisProductos'])->name('mis.productos');
});

// Rutas de administración de usuarios (solo para admin)
Route::middleware(['auth', 'admin'])->prefix('usuarios')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');       
    Route::get('/crear', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/editar', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

