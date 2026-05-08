<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductViewsImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_renders_public_storage_image_url(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        $producto = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'imagen' => 'productos/pimiento-rojo.jpg',
        ]);

        $response = $this->get(route('todos.productos'));

        $response->assertOk();
        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML($response->getContent());
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new \DOMXPath($dom);
        $images = $xpath->query('//img[@src="' . asset('storage/' . $producto->imagen) . '"]');

        self::assertGreaterThan(0, $images->length, 'Expected an image with the product storage URL.');
        self::assertSame($producto->nombre, $images->item(0)?->getAttribute('alt'));
        $response->assertSee($producto->nombre);
    }

    public function test_product_detail_renders_public_storage_image_url(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        $producto = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'imagen' => 'productos/calabacin.jpg',
        ]);

        $response = $this->get(route('ver.producto', $producto->id));

        $response->assertOk();

        $dom = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML($response->getContent());
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new \DOMXPath($dom);
        $images = $xpath->query('//img[@src="' . asset('storage/' . $producto->imagen) . '"]');

        self::assertGreaterThan(0, $images->length, 'Expected an image with the product storage URL.');
        self::assertSame($producto->nombre, $images->item(0)?->getAttribute('alt'));
        $response->assertSee($producto->nombre);
    }
}
