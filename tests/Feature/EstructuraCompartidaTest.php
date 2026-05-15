<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstructuraCompartidaTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_the_shared_header_signature(): void
    {
        foreach ([
            route('inicio'),
            route('login'),
            route('register'),
            route('todos.productos'),
        ] as $url) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee('sitio-marca-acento', false);
            $response->assertSee('lg:hidden', false);
            $response->assertSee('Registrarse');
        }
    }

    public function test_public_pages_share_the_editorial_design_shell(): void
    {
        foreach ([
            route('inicio'),
            route('login'),
            route('register'),
            route('todos.productos'),
        ] as $url) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee('sitio-contenedor', false);
            $response->assertSee('sitio-nav', false);
            $response->assertSee('sitio-pie', false);
            $response->assertSee('Playfair+Display', false);
        }
    }

    public function test_seller_navigation_uses_add_product_label_in_shared_header(): void
    {
        $location = Localizacion::factory()->create();
        $seller = User::factory()->create([
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $location->id,
        ]);

        $response = $this->actingAs($seller)->get(route('carrito.all'));

        $response->assertOk();
        $response->assertSee('Añadir producto');
        $response->assertDontSee('>Vender<', false);
    }

    public function test_admin_navigation_uses_management_label_in_shared_header(): void
    {
        $location = Localizacion::factory()->create();
        $admin = User::factory()->create([
            'tipoCliente' => 'admin',
            'localizacion_id' => $location->id,
        ]);

        $response = $this->actingAs($admin)->get(route('carrito.all'));

        $response->assertOk();
        $response->assertSee('Gestión usuarios');
        $response->assertDontSee('>Usuarios<', false);
    }

    public function test_authenticated_pages_share_the_editorial_design_shell(): void
    {
        $location = Localizacion::factory()->create();
        $user = User::factory()->create([
            'tipoCliente' => 'comprador',
            'localizacion_id' => $location->id,
        ]);

        foreach ([
            route('perfil.editar'),
            route('pedidos.usuario'),
        ] as $url) {
            $response = $this->actingAs($user)->get($url);

            $response->assertOk();
            $response->assertSee('sitio-contenedor', false);
            $response->assertSee('sitio-nav', false);
            $response->assertSee('sitio-pie', false);
            $response->assertSee('Playfair+Display', false);
        }
    }
}
