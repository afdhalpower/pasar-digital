<?php

namespace Tests\Unit;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_order_number_has_correct_format()
    {
        $orderNumber = Order::generateOrderNumber();

        $this->assertStringStartsWith('PD-', $orderNumber);
        $this->assertEquals(18, strlen($orderNumber));
    }

    public function test_generate_unique_code_is_between_1_and_999()
    {
        $code = Order::generateUniqueCode();

        $this->assertGreaterThanOrEqual(1, $code);
        $this->assertLessThanOrEqual(999, $code);
    }

    public function test_total_transfer_includes_unique_code()
    {
        $order = new Order([
            'total' => 100000,
            'unique_code' => 123,
        ]);

        $this->assertEquals(100123, $order->total_transfer);
    }

    public function test_discounted_subtotal()
    {
        $order = new Order([
            'subtotal' => 100000,
            'discount' => 15000,
        ]);

        $this->assertEquals(85000, $order->discounted_subtotal);
    }
}
