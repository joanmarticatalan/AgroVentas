<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarritoTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart_uses_selected_quantity_and_stores_spanish_keys(): void
    {
        $localizacion = Localizacion::factory()->create();
        $usuario = User::factory()->create([
            'localizacion_id' => $localizacion->id,
        ]);
        $producto = Producto::factory()->create([
            'user_id' => $usuario->id,
            'localizacion_id' => $localizacion->id,
            'stock' => 12,
            'precio' => 4.75,
        ]);

        $response = $this->from(route('ver.producto', $producto->id))->post(route('add.carrito', $producto->id), [
            'cantidad' => 3,
        ]);

        $response->assertRedirect(route('ver.producto', $producto->id));
        $response->assertSessionHas('carrito.'.$producto->id, [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'cantidad' => 3,
            'precio' => 4.75,
        ]);
    }

    public function test_add_to_cart_rejects_quantity_greater_than_available_stock(): void
    {
        $localizacion = Localizacion::factory()->create();
        $usuario = User::factory()->create([
            'localizacion_id' => $localizacion->id,
        ]);
        $producto = Producto::factory()->create([
            'user_id' => $usuario->id,
            'localizacion_id' => $localizacion->id,
            'stock' => 2,
        ]);

        $response = $this->from(route('ver.producto', $producto->id))->post(route('add.carrito', $producto->id), [
            'cantidad' => 3,
        ]);

        $response->assertRedirect(route('ver.producto', $producto->id));
        $response->assertSessionHasErrors('cantidad');
        $this->assertNull(session('carrito'));
    }
}
