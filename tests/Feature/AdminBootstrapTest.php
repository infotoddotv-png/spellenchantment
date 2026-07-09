<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminBootstrapTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_view_dashboard_after_login(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@spellenchantment.com',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_registered_user_can_login(): void
    {
        $response = $this->post('/register', [
            'name' => 'New Buyer',
            'email' => 'buyer@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => 'buyer@example.com']);
    }
}
