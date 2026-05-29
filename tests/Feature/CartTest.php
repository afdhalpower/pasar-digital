<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::factory()->create(['is_active' => true]);
        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 50000,
            'is_active' => true,
        ]);
    }

    public function test_user_can_add_to_cart()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('cart.add', $this->product), ['quantity' => 1]);

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);
    }

    public function test_user_can_update_cart_quantity()
    {
        $this->actingAs($this->user);

        $cartItem = CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('cart.update', $cartItem), ['quantity' => 3]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 3,
        ]);
    }

    public function test_user_can_remove_from_cart()
    {
        $this->actingAs($this->user);

        $cartItem = CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('cart.remove', $cartItem));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
    }

    public function test_user_can_apply_valid_coupon()
    {
        $this->actingAs($this->user);

        Coupon::create([
            'code' => 'DISKON10',
            'name' => 'Diskon 10%',
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
        ]);

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response = $this->post(route('cart.coupon.apply'), ['code' => 'DISKON10']);

        $response->assertSessionHas('success');
        $this->assertEquals(session('applied_coupon'), Coupon::first()->id);
    }

    public function test_user_cannot_apply_expired_coupon()
    {
        $this->actingAs($this->user);

        Coupon::create([
            'code' => 'EXPIRED',
            'name' => 'Expired',
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
            'expires_at' => now()->subDay(),
        ]);

        $response = $this->post(route('cart.coupon.apply'), ['code' => 'EXPIRED']);

        $response->assertSessionHas('error');
    }
}
