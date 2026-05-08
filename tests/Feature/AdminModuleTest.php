<?php

namespace Tests\Feature;

use App\Models\Localizacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_admin_user_index(): void
    {
        $user = User::factory()->create([
            'tipoCliente' => 'comprador',
        ]);

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_admin_user_can_view_admin_user_index_with_summary_and_users(): void
    {
        $admin = User::factory()->create([
            'tipoCliente' => 'admin',
        ]);
        $managedUser = User::factory()->create([
            'name' => 'Marina Torres',
            'tipoCliente' => 'vendedor',
        ]);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertOk();
        $response->assertSee('Panel de administración');
        $response->assertSee('Gestión de usuarios');
        $response->assertSee('Marina Torres');
        $response->assertSee('vendedor');
    }

    public function test_admin_can_create_a_user_from_admin_module(): void
    {
        $admin = User::factory()->create([
            'tipoCliente' => 'admin',
        ]);
        $localizacion = Localizacion::factory()->create();

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Nuevo Gestor',
            'email' => 'gestor@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'telefono' => '600123123',
            'tipoCliente' => 'compraventa',
            'localizacion_id' => $localizacion->id,
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Nuevo Gestor',
            'email' => 'gestor@example.com',
            'tipoCliente' => 'compraventa',
            'localizacion_id' => $localizacion->id,
        ]);
    }

    public function test_admin_can_update_a_user_from_admin_module(): void
    {
        $admin = User::factory()->create([
            'tipoCliente' => 'admin',
        ]);
        $user = User::factory()->create([
            'tipoCliente' => 'comprador',
        ]);
        $localizacion = Localizacion::factory()->create();

        $response = $this->actingAs($admin)->put(route('users.update', $user), [
            'name' => 'Usuario Editado',
            'email' => $user->email,
            'telefono' => '611223344',
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Usuario Editado',
            'telefono' => '611223344',
            'tipoCliente' => 'vendedor',
            'localizacion_id' => $localizacion->id,
        ]);
    }

    public function test_non_admin_cannot_promote_themselves_via_profile_update(): void
    {
        $user = User::factory()->create([
            'tipoCliente' => 'comprador',
        ]);

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'telefono' => $user->telefono,
            'tipoCliente' => 'admin',
        ]);

        $response->assertRedirect(route('perfil.editar'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'tipoCliente' => 'comprador',
        ]);
    }
}
