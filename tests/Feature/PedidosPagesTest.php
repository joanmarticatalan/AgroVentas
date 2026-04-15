<?php

namespace Tests\Feature;

use App\Models\Linea;
use App\Models\Localizacion;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidosPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_orders_page_shows_summary_and_order_cards(): void
    {
        $location = Localizacion::factory()->create();
        $buyer = User::factory()->create([
            'tipoCliente' => 'comprador',
            'localizacion_id' => $location->id,
        ]);
        $seller = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $location->id,
        ]);
        $product = Producto::factory()->create([
            'user_id' => $seller->id,
            'localizacion_id' => $location->id,
            'nombre' => 'Tomate pera',
        ]);
        $pedido = Pedido::factory()->create([
            'user_id' => $buyer->id,
            'localizacion_id' => $location->id,
            'tipoEnvio' => 'EnvioCasa',
            'estado' => Pedido::ESTADO_EN_CURSO,
            'precio_total' => 42.50,
        ]);

        Linea::factory()->create([
            'pedido_id' => $pedido->id,
            'producto_id' => $product->id,
            'cantidad' => 3,
            'precio_unitario' => 14.17,
        ]);

        $response = $this->actingAs($buyer)->get(route('pedidos.usuario'));

        $response->assertOk();
        $response->assertSee('Resumen de compras');
        $response->assertSee('Importe acumulado');
        $response->assertSee('Pedido #'.$pedido->id);
        $response->assertSee('Tomate pera');
    }

    public function test_seller_orders_page_shows_metrics_and_action_button(): void
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
            'nombre' => 'Calabaza',
        ]);
        $pedido = Pedido::factory()->create([
            'user_id' => $buyer->id,
            'localizacion_id' => $buyerLocation->id,
            'tipoEnvio' => 'EnvioCasa',
            'estado' => Pedido::ESTADO_EN_CURSO,
            'precio_total' => 68.90,
        ]);

        Linea::factory()->create([
            'pedido_id' => $pedido->id,
            'producto_id' => $product->id,
            'cantidad' => 2,
            'precio_unitario' => 34.45,
        ]);

        $response = $this->actingAs($seller)->get(route('pedidos.vendedor'));

        $response->assertOk();
        $response->assertSee('Pedidos recibidos');
        $response->assertSee('Pendientes de gestionar');
        $response->assertSee('Pedido #'.$pedido->id);
        $response->assertSee('Marcar como enviado');
        $response->assertSee('Calabaza');
    }
}
