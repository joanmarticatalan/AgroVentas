<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Localizacion;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Linea;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos 10 localizaciones
        $localizaciones = Localizacion::factory(10)->create();

        // 2. CREAR USUARIOS
        
        // Creamos un Admin
        User::factory()->create([
            'name' => 'Admin Agro',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'tipoCliente' => 'admin',
            'localizacion_id' => $localizaciones->random()->id,
        ]);

        // Creamos 5 Vendedores (Siempre con localización)
        $vendedores = User::factory(5)->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => fn() => $localizaciones->random()->id,
        ]);

        // Creamos 10 Compradores (30% sin localización)
        $compradores = User::factory(10)->create([
            'tipoCliente' => 'comprador',
            'localizacion_id' => fn() => fake()->boolean(70) 
                ? $localizaciones->random()->id 
                : null,
        ]);

        // 3. CREAR PRODUCTOS
        $vendedores->each(function ($vendedor) {
            Producto::factory(rand(2, 5))->create([
                'user_id' => $vendedor->id,
                'localizacion_id' => $vendedor->localizacion_id, 
            ]);
        });

        $todosLosProductos = Producto::all();

        // 4. CREAR PEDIDOS Y SUS LÍNEAS
        $compradores->each(function ($comprador) use ($todosLosProductos, $localizaciones) {
            
            // CORRECCIÓN: Si el comprador no tiene localización, asignamos una al azar 
            // para evitar el error de Integrity Constraint en la tabla pedidos.
            $pedido = Pedido::factory()->create([
                'user_id' => $comprador->id,
                'localizacion_id' => $comprador->localizacion_id ?? $localizaciones->random()->id,
                'precio_total' => 0, 
            ]);

            $productosParaPedido = $todosLosProductos->random(rand(1, 4));
            $acumuladoTotal = 0;

            foreach ($productosParaPedido as $producto) {
                $linea = Linea::factory()->create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                ]);

                $acumuladoTotal += ($linea->cantidad * $linea->precio_unitario);
            }

            $pedido->update(['precio_total' => $acumuladoTotal]);
        });
    }
}