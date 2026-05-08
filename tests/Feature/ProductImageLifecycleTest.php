<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_requires_an_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'tipoCliente' => 'vendedor',
        ]);
        $localizacion = Localizacion::factory()->create();

        $response = $this->actingAs($user)->post(route('subir.producto'), [
            'nombre' => 'Tomate pera',
            'variedad' => 'Pera',
            'stock' => 12,
            'precio' => 2.45,
            'fecha' => '2026-04-09',
            'localizacion_id' => $localizacion->id,
        ]);

        $response->assertSessionHasErrors('imagen');
    }

    public function test_store_persists_image_path_and_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'tipoCliente' => 'vendedor',
        ]);
        $localizacion = Localizacion::factory()->create();
        $image = UploadedFile::fake()->image('tomate.jpg');

        $response = $this->actingAs($user)->post(route('subir.producto'), [
            'nombre' => 'Tomate pera',
            'variedad' => 'Pera',
            'stock' => 12,
            'precio' => 2.45,
            'fecha' => '2026-04-09',
            'localizacion_id' => $localizacion->id,
            'imagen' => $image,
        ]);

        $response->assertRedirect(route('todos.productos'));

        $producto = Producto::query()
            ->where('nombre', 'Tomate pera')
            ->firstOrFail();

        $this->assertNotNull($producto->imagen);
        Storage::disk('public')->assertExists($producto->imagen);
    }

    public function test_destroy_removes_stored_image_and_product_row(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'tipoCliente' => 'vendedor',
        ]);
        $localizacion = Localizacion::factory()->create();
        $path = UploadedFile::fake()->image('cebolla.jpg')->store('productos', 'public');

        $producto = Producto::query()->create([
            'user_id' => $user->id,
            'nombre' => 'Cebolla dulce',
            'variedad' => 'Dulce',
            'stock' => 8,
            'precio' => 1.95,
            'fechaProduccion' => '2026-04-09',
            'localizacion_id' => $localizacion->id,
            'imagen' => $path,
        ]);

        $response = $this->actingAs($user)->delete(route('borrar.producto', $producto->id));

        $response->assertRedirect(route('todos.productos'));
        $this->assertDatabaseMissing('productos', [
            'id' => $producto->id,
        ]);
        Storage::disk('public')->assertMissing($path);
    }
}
