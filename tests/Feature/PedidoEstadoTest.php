<?php

namespace Tests\Feature;

use App\Models\Linea;
use App\Models\Localizacion;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoEstadoTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_mark_home_delivery_order_as_sent_once(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $sellerLocation = Localizacion::factory()->create();

        $buyer = User::factory()->create([
            'tipoCliente' => 'comprador',
            'localizacion_id' => $buyerLocation->id,
        ]);
        $seller = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $sellerLocation->id,
        ]);

        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $sellerLocation->id,
        ]);

        $pedido = Pedido::factory()->create([
            'user_id' => $buyer->id,
            'localizacion_id' => $buyerLocation->id,
            'tipoEnvio' => 'EnvioCasa',
            'estado' => 'en_curso',
        ]);

        Linea::factory()->create([
            'pedido_id' => $pedido->id,
            'producto_id' => $product->id,
        ]);

        $this->actingAs($seller);

        $response = $this->patch(route('pedidos.estado.update', $pedido), [
            'estado' => 'enviado',
        ]);

        $response->assertRedirect(route('pedidos.vendedor'));

        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'estado' => 'enviado',
        ]);

        $secondResponse = $this->patch(route('pedidos.estado.update', $pedido), [
            'estado' => 'enviado',
        ]);

        $secondResponse->assertRedirect(route('pedidos.vendedor'));
        $secondResponse->assertSessionHas('error');
    }

    public function test_seller_cannot_update_order_that_does_not_belong_to_them(): void
    {
        $buyerLocation = Localizacion::factory()->create();
        $ownerLocation = Localizacion::factory()->create();
        $otherSellerLocation = Localizacion::factory()->create();

        $buyer = User::factory()->create([
            'tipoCliente' => 'comprador',
            'localizacion_id' => $buyerLocation->id,
        ]);
        $ownerSeller = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $ownerLocation->id,
        ]);
        $otherSeller = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $otherSellerLocation->id,
        ]);

        $product = Producto::factory()->create([
            'user_id' => $ownerSeller->id,
            'localizacion_id' => $ownerLocation->id,
        ]);

        $pedido = Pedido::factory()->create([
            'user_id' => $buyer->id,
            'localizacion_id' => $buyerLocation->id,
            'tipoEnvio' => 'A recoger',
            'estado' => 'en_curso',
        ]);

        Linea::factory()->create([
            'pedido_id' => $pedido->id,
            'producto_id' => $product->id,
        ]);

        $this->actingAs($otherSeller);

        $response = $this->patch(route('pedidos.estado.update', $pedido), [
            'estado' => 'listo_recoger',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'estado' => 'en_curso',
        ]);
    }
}
