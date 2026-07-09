<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminShopDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_product(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@spellenchantment.com',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $product = Product::create([
            'name' => 'Test Spell',
            'slug' => 'test-spell',
            'description' => 'A test product',
            'price' => 15.00,
            'type' => 'physical',
            'in_stock' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.shop.destroy', ['shop' => $product->id]));

        $response->assertRedirect(route('admin.shop.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
