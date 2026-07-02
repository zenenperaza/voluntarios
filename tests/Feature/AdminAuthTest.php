<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_requires_authentication(): void
    {
        $response = $this->get('/admin/voluntarios');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_admin(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/voluntarios');

        $response->assertOk();
    }

    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'admin@asonacop.org',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@asonacop.org',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('voluntarios.listado'));
        $this->assertAuthenticated();
    }
}
