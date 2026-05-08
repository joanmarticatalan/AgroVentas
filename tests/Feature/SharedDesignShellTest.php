<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SharedDesignShellTest extends TestCase
{
    use RefreshDatabase;

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
            $response->assertSee('site-shell', false);
            $response->assertSee('site-nav', false);
            $response->assertSee('site-footer', false);
            $response->assertSee('Playfair+Display', false);
        }
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
            $response->assertSee('site-shell', false);
            $response->assertSee('site-nav', false);
            $response->assertSee('site-footer', false);
            $response->assertSee('Playfair+Display', false);
        }
    }
}
