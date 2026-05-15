<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_links_checkout_cta_to_checkout_route(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'precio' => 8.25,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => 8.25,
                'cantidad' => 1,
            ],
        ]);

        $response = $this->get(route('carrito.all'));

        $response->assertOk();
        $response->assertSee('action="'.route('checkout').'"', false);
        $response->assertDontSee('action="'.route('todos.productos').'"', false);
    }

    public function test_checkout_rejects_cart_with_missing_product(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            9999 => [
                'id' => 9999,
                'nombre' => 'Producto eliminado',
                'precio' => 12.50,
                'cantidad' => 2,
            ],
        ]);

        $response = $this->from(route('checkout'))->post(route('checkout.confirm'), [
            'tipoEnvio' => 'EnvioCasa',
            'direccion_opcion' => 'actual',
            'localizacion_id' => $buyerLocation->id,
        ]);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHas('error', 'Uno o más productos de tu carrito ya no están disponibles.');
        $this->assertDatabaseCount('pedidos', 0);
    }

    public function test_checkout_reuses_current_location_without_creating_duplicates(): void
    {
        $buyerLocation = Localizacion::factory()->create([
            'provincia' => 'Valencia',
            'codigoPostal' => '46001',
            'nombreCalle' => 'Calle Mayor',
            'numero' => '12',
            'puerta' => '2A',
        ]);
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'stock' => 10,
            'precio' => 4.50,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => 4.50,
                'cantidad' => 3,
            ],
        ]);

        $response = $this->post(route('checkout.confirm'), [
            'tipoEnvio' => 'EnvioCasa',
            'direccion_opcion' => 'actual',
            'localizacion_id' => $buyerLocation->id,
            'nueva_nombreCalle' => $buyerLocation->nombreCalle,
            'nueva_numero' => $buyerLocation->numero,
            'nueva_puerta' => $buyerLocation->puerta,
            'nueva_codigoPostal' => $buyerLocation->codigoPostal,
            'nueva_provincia' => $buyerLocation->provincia,
        ]);

        $response->assertRedirect(route('pedidos.usuario'));
        $this->assertDatabaseCount('localizaciones', 2);
        $this->assertDatabaseHas('pedidos', [
            'user_id' => $buyer->id,
            'localizacion_id' => $buyerLocation->id,
            'tipoEnvio' => 'EnvioCasa',
            'estado' => 'en_curso',
            'precio_total' => 13.50,
        ]);
    }

    public function test_successful_checkout_shows_success_message_on_orders_page(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'stock' => 10,
            'precio' => 6.00,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => 6.00,
                'cantidad' => 1,
            ],
        ]);

        $response = $this->followingRedirects()->post(route('checkout.confirm'), [
            'tipoEnvio' => 'EnvioCasa',
            'direccion_opcion' => 'actual',
            'localizacion_id' => $buyerLocation->id,
        ]);

        $response->assertOk();
        $response->assertSee('¡Compra realizada con éxito!');
    }

    public function test_checkout_creates_new_location_only_when_explicitly_requested(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'stock' => 5,
            'precio' => 7.00,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => 7.00,
                'cantidad' => 2,
            ],
        ]);

        $response = $this->post(route('checkout.confirm'), [
            'tipoEnvio' => 'EnvioCasa',
            'direccion_opcion' => 'nueva',
            'localizacion_id' => $buyerLocation->id,
            'nueva_nombreCalle' => 'Avenida del Mercado',
            'nueva_numero' => '48',
            'nueva_puerta' => 'B',
            'nueva_codigoPostal' => '41001',
            'nueva_provincia' => 'Sevilla',
        ]);

        $response->assertRedirect(route('pedidos.usuario'));
        $this->assertDatabaseCount('localizaciones', 3);

        $newLocation = Localizacion::where('nombreCalle', 'Avenida del Mercado')->first();

        $this->assertNotNull($newLocation);
        $this->assertDatabaseHas('pedidos', [
            'user_id' => $buyer->id,
            'localizacion_id' => $newLocation->id,
            'precio_total' => 14.00,
        ]);
    }

    public function test_checkout_rejects_insufficient_stock_without_creating_orders(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'stock' => 1,
            'precio' => 3.25,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => 3.25,
                'cantidad' => 2,
            ],
        ]);

        $response = $this->from(route('checkout'))->post(route('checkout.confirm'), [
            'tipoEnvio' => 'EnvioCasa',
            'direccion_opcion' => 'actual',
            'localizacion_id' => $buyerLocation->id,
        ]);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHas('error', 'No hay suficiente stock de: '.$product->nombre);
        $this->assertDatabaseCount('pedidos', 0);
        $this->assertDatabaseHas('productos', [
            'id' => $product->id,
            'stock' => 1,
        ]);
    }

    public function test_checkout_shows_stock_error_message_on_the_page_after_redirect(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'stock' => 1,
            'precio' => 5.25,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => 5.25,
                'cantidad' => 2,
            ],
        ]);

        $response = $this->followingRedirects()->from(route('checkout'))->post(route('checkout.confirm'), [
            'tipoEnvio' => 'A recoger',
            'direccion_opcion' => 'actual',
            'localizacion_id' => $buyerLocation->id,
        ]);

        $response->assertOk();
        $response->assertSee('No hay suficiente stock de: '.$product->nombre);
        $response->assertSee('value="A recoger" checked', false);
    }

    public function test_checkout_shows_validation_errors_when_new_address_is_incomplete(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'localizacion_id' => $sellerLocation->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
            'stock' => 5,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $product->id => [
                'id' => $product->id,
                'nombre' => $product->nombre,
                'precio' => (float) $product->precio,
                'cantidad' => 1,
            ],
        ]);

        $response = $this->followingRedirects()->from(route('checkout'))->post(route('checkout.confirm'), [
            'tipoEnvio' => 'A recoger',
            'direccion_opcion' => 'nueva',
            'localizacion_id' => $buyerLocation->id,
            'nueva_nombreCalle' => '',
            'nueva_numero' => '',
            'nueva_codigoPostal' => '12',
            'nueva_provincia' => '',
        ]);

        $response->assertOk();
        $response->assertSeeText('Revisa los campos marcados para completar el pedido.');
        $response->assertSeeText('El campo calle es obligatorio.');
        $response->assertSeeText('El campo número es obligatorio.');
        $response->assertSeeText('El campo código postal debe tener exactamente 5 dígitos.');
        $response->assertSeeText('El campo provincia es obligatorio.');
        $response->assertSee('value="A recoger" checked', false);
        $response->assertSeeInOrder([
            'id="direccion-nueva"',
            'name="direccion_opcion"',
            'value="nueva"',
            'checked',
        ], false);
    }

    public function test_checkout_page_receives_prepared_summary_data(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'localizacion_id' => $buyerLocation->id,
        ]);

        $sellerOneLocation = Localizacion::factory()->create();
        $sellerTwoLocation = Localizacion::factory()->create();
        $sellerOne = User::factory()->create(['localizacion_id' => $sellerOneLocation->id]);
        $sellerTwo = User::factory()->create(['localizacion_id' => $sellerTwoLocation->id]);

        $productOne = Producto::factory()->create([
            'user_id' => $sellerOne->id,
            'localizacion_id' => $sellerOneLocation->id,
            'precio' => 2.50,
        ]);
        $productTwo = Producto::factory()->create([
            'user_id' => $sellerTwo->id,
            'localizacion_id' => $sellerTwoLocation->id,
            'precio' => 5.00,
        ]);

        $this->actingAs($buyer);
        session()->put('carrito', [
            $productOne->id => [
                'id' => $productOne->id,
                'nombre' => $productOne->nombre,
                'precio' => 2.50,
                'cantidad' => 2,
            ],
            $productTwo->id => [
                'id' => $productTwo->id,
                'nombre' => $productTwo->nombre,
                'precio' => 5.00,
                'cantidad' => 1,
            ],
        ]);

        $response = $this->get(route('checkout'));

        $response->assertOk();
        $response->assertViewHas('sellerCount', 2);
        $response->assertViewHas('orderTotal', 10.00);
        $response->assertSee('2 vendedores distintos');
        $response->assertSee('10.00');
    }
}
