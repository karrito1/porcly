<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_guests_can_not_access_user_management(): void
    {
        $this->get('/usuarios')->assertRedirect(route('login'));
        $this->get('/usuarios/crear')->assertRedirect(route('login'));
        $this->post('/usuarios')->assertRedirect(route('login'));
    }

    public function test_authenticated_users_without_permission_can_not_create_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/usuarios')->assertForbidden();
        $this->actingAs($user)->get('/usuarios/crear')->assertForbidden();
        $this->actingAs($user)->post('/usuarios', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertForbidden();
    }

    public function test_authorized_users_can_create_users(): void
    {
        $admin = User::factory()->create();
        Permission::findOrCreate('users.create');
        $admin->givePermissionTo('users.create');

        $this->actingAs($admin)->get('/usuarios/crear')->assertOk();

        $response = $this->actingAs($admin)->post('/usuarios', [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('users.index'));

        $response->assertSessionHas('success', 'Usuario creado correctamente.');
        $this->assertDatabaseHas(User::class, [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
        ]);
    }
}
