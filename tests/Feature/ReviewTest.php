<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_review_without_purchase()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('review.store', $product), [
            'rating' => 5,
            'review' => 'Great product!',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_buyer_can_submit_review()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => Order::generateOrderNumber(),
            'subtotal' => $product->price,
            'total' => $product->price,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => 1,
            'total' => $product->price,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('review.store', $product), [
            'rating' => 4,
            'review' => 'Bagus banget!',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 4,
        ]);
    }

    public function test_review_rating_must_be_between_1_and_5()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active' => true,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => Order::generateOrderNumber(),
            'subtotal' => $product->price,
            'total' => $product->price,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => 1,
            'total' => $product->price,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('review.store', $product), [
            'rating' => 6,
            'review' => 'Test',
        ]);

        $response->assertSessionHasErrors(['rating']);
    }
}
