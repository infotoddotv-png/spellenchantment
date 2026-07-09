<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminShopEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_shop_edit_page(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@spellenchantment.com',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $product = Product::create([
            'name' => 'Arcane Candle',
            'slug' => 'arcane-candle',
            'description' => 'Mystic fragrance',
            'price' => 24.99,
            'type' => 'physical',
            'in_stock' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.shop.edit', ['shop' => $product->id]));

        $response->assertStatus(200);
        $response->assertSee('Edit Product');
    }
}
