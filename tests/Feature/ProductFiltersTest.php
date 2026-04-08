<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ProductFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_returns_recent_products_and_filter_state_by_default(): void
    {
        $localizacionA = Localizacion::factory()->create();
        $localizacionB = Localizacion::factory()->create();

        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacionA->id,
        ]);

        $olderProduct = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacionA->id,
            'nombre' => 'Tomate antiguo',
            'created_at' => Carbon::parse('2026-04-01 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-01 10:00:00'),
        ]);

        $newerProduct = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacionB->id,
            'nombre' => 'Tomate reciente',
            'created_at' => Carbon::parse('2026-04-03 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-03 10:00:00'),
        ]);

        $response = $this->get(route('todos.productos'));

        $response->assertOk();
        $response->assertViewHas('localizaciones');
        $response->assertViewHas('filters', [
            'q' => null,
            'localizacion_id' => null,
            'precio_min' => null,
            'precio_max' => null,
            'disponibilidad' => 'all',
            'fecha_desde' => null,
            'fecha_hasta' => null,
            'sort' => 'recent',
            'invalid_ranges' => [],
        ]);

        $response->assertViewHas('products', function ($products) use ($newerProduct, $olderProduct) {
            return $products->pluck('id')->all() === [$newerProduct->id, $olderProduct->id];
        });
    }

    public function test_products_index_filters_by_search_text_in_nombre_and_variedad(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        $matchingByNombre = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Tomate pera',
            'variedad' => 'clasico',
            'created_at' => Carbon::parse('2026-04-01 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-01 10:00:00'),
        ]);

        $matchingByVariedad = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Lechuga',
            'variedad' => 'pera dulce',
            'created_at' => Carbon::parse('2026-04-02 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-02 10:00:00'),
        ]);

        $notMatching = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Trigo',
            'variedad' => 'duro',
            'created_at' => Carbon::parse('2026-04-03 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-03 10:00:00'),
        ]);

        $response = $this->get(route('todos.productos', ['q' => 'pera']));

        $response->assertOk();
        $response->assertViewHas('products', function ($products) use ($matchingByNombre, $matchingByVariedad, $notMatching) {
            return $products->pluck('id')->all() === [$matchingByVariedad->id, $matchingByNombre->id]
                && ! $products->pluck('id')->contains($notMatching->id);
        });
        $response->assertViewHas('filters', function (array $filters) {
            return $filters['q'] === 'pera';
        });
    }

    public function test_products_index_filters_by_localizacion_and_availability(): void
    {
        $localizacionA = Localizacion::factory()->create();
        $localizacionB = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacionA->id,
        ]);

        $matchingProduct = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacionA->id,
            'stock' => 8,
            'nombre' => 'Producto visible',
        ]);

        $sameLocationWithoutStock = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacionA->id,
            'stock' => 0,
            'nombre' => 'Sin stock',
        ]);

        $otherLocation = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacionB->id,
            'stock' => 15,
            'nombre' => 'Otra localizacion',
        ]);

        $response = $this->get(route('todos.productos', [
            'localizacion_id' => (string) $localizacionA->id,
            'disponibilidad' => 'available',
        ]));

        $response->assertOk();
        $response->assertViewHas('products', function ($products) use ($matchingProduct, $sameLocationWithoutStock, $otherLocation) {
            return $products->pluck('id')->all() === [$matchingProduct->id]
                && ! $products->pluck('id')->contains($sameLocationWithoutStock->id)
                && ! $products->pluck('id')->contains($otherLocation->id);
        });
        $response->assertViewHas('filters', function (array $filters) use ($localizacionA) {
            return $filters['localizacion_id'] === (string) $localizacionA->id
                && $filters['disponibilidad'] === 'available';
        });
    }

    public function test_products_index_applies_valid_price_and_date_ranges(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        $matchingProduct = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Producto dentro de rango',
            'precio' => 25.50,
            'fechaProduccion' => '2026-04-12',
        ]);

        $tooCheap = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Producto barato',
            'precio' => 10.00,
            'fechaProduccion' => '2026-04-12',
        ]);

        $tooLate = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Producto fuera de fecha',
            'precio' => 25.50,
            'fechaProduccion' => '2026-04-20',
        ]);

        $response = $this->get(route('todos.productos', [
            'precio_min' => '20',
            'precio_max' => '30',
            'fecha_desde' => '2026-04-10',
            'fecha_hasta' => '2026-04-15',
        ]));

        $response->assertOk();
        $response->assertViewHas('products', function ($products) use ($matchingProduct, $tooCheap, $tooLate) {
            return $products->pluck('id')->all() === [$matchingProduct->id]
                && ! $products->pluck('id')->contains($tooCheap->id)
                && ! $products->pluck('id')->contains($tooLate->id);
        });
        $response->assertViewHas('filters', function (array $filters) {
            return $filters['precio_min'] === '20'
                && $filters['precio_max'] === '30'
                && $filters['fecha_desde'] === '2026-04-10'
                && $filters['fecha_hasta'] === '2026-04-15'
                && $filters['invalid_ranges'] === [];
        });
    }

    public function test_products_index_ignores_invalid_ranges_without_breaking_the_page(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        $olderProduct = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Producto antiguo',
            'created_at' => Carbon::parse('2026-04-01 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-01 10:00:00'),
        ]);

        $newerProduct = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Producto reciente',
            'created_at' => Carbon::parse('2026-04-02 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-02 10:00:00'),
        ]);

        $response = $this->get(route('todos.productos', [
            'precio_min' => '50',
            'precio_max' => '10',
            'fecha_desde' => '2026-04-20',
            'fecha_hasta' => '2026-04-10',
        ]));

        $response->assertOk();
        $response->assertViewHas('products', function ($products) use ($newerProduct, $olderProduct) {
            return $products->pluck('id')->all() === [$newerProduct->id, $olderProduct->id];
        });
        $response->assertViewHas('filters', function (array $filters) {
            return $filters['invalid_ranges'] === ['precio', 'fecha'];
        });
    }

    public function test_products_index_applies_supported_sort_options_and_defaults_to_recent(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        $productoC = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Calabaza',
            'precio' => 20,
            'created_at' => Carbon::parse('2026-04-01 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-01 10:00:00'),
        ]);

        $productoA = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Acelga',
            'precio' => 10,
            'created_at' => Carbon::parse('2026-04-03 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-03 10:00:00'),
        ]);

        $productoB = Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Berenjena',
            'precio' => 30,
            'created_at' => Carbon::parse('2026-04-02 10:00:00'),
            'updated_at' => Carbon::parse('2026-04-02 10:00:00'),
        ]);

        $sortExpectations = [
            'recent' => [$productoA->id, $productoB->id, $productoC->id],
            'price_asc' => [$productoA->id, $productoC->id, $productoB->id],
            'price_desc' => [$productoB->id, $productoC->id, $productoA->id],
            'name_asc' => [$productoA->id, $productoB->id, $productoC->id],
            'unsupported' => [$productoA->id, $productoB->id, $productoC->id],
        ];

        foreach ($sortExpectations as $sort => $expectedOrder) {
            $response = $this->get(route('todos.productos', ['sort' => $sort]));

            $response->assertOk();
            $response->assertViewHas('products', function ($products) use ($expectedOrder) {
                return $products->pluck('id')->all() === $expectedOrder;
            });
        }
    }

    public function test_products_index_renders_filter_form_with_persisted_values(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Tomate rama',
            'variedad' => 'dulce',
            'stock' => 12,
        ]);

        $response = $this->get(route('todos.productos', [
            'q' => 'tomate',
            'localizacion_id' => (string) $localizacion->id,
            'precio_min' => '10',
            'precio_max' => '50',
            'disponibilidad' => 'available',
            'fecha_desde' => '2026-04-01',
            'fecha_hasta' => '2026-04-30',
            'sort' => 'price_desc',
        ]));

        $response->assertOk();
        $response->assertSee('Aplicar filtros');
        $response->assertSee('Limpiar');
        $response->assertSee('name="q"', false);
        $response->assertSee('value="tomate"', false);
        $response->assertSee('name="localizacion_id"', false);
        $response->assertSee('value="' . $localizacion->id . '" selected', false);
        $response->assertSee('name="precio_min"', false);
        $response->assertSee('value="10"', false);
        $response->assertSee('name="precio_max"', false);
        $response->assertSee('value="50"', false);
        $response->assertSee('name="fecha_desde"', false);
        $response->assertSee('value="2026-04-01"', false);
        $response->assertSee('name="fecha_hasta"', false);
        $response->assertSee('value="2026-04-30"', false);
        $response->assertSee('value="available" selected', false);
        $response->assertSee('value="price_desc" selected', false);
    }

    public function test_products_index_shows_empty_state_and_clear_action_when_no_results_match(): void
    {
        $localizacion = Localizacion::factory()->create();
        $vendedor = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);

        Producto::factory()->create([
            'user_id' => $vendedor->id,
            'localizacion_id' => $localizacion->id,
            'nombre' => 'Tomate rama',
            'variedad' => 'dulce',
        ]);

        $response = $this->get(route('todos.productos', ['q' => 'pepino']));

        $response->assertOk();
        $response->assertSee('No hemos encontrado productos');
        $response->assertSee('Limpiar filtros');
        $response->assertSee('href="' . route('todos.productos') . '"', false);
        $response->assertDontSee('Tomate rama');
    }
}
