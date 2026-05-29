<?php

namespace Tests\Unit;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_valid_returns_true_for_active_coupon()
    {
        $coupon = Coupon::create([
            'code' => 'VALID',
            'name' => 'Valid Coupon',
            'type' => 'fixed',
            'value' => 10000,
            'is_active' => true,
        ]);

        $this->assertTrue($coupon->isValid());
    }

    public function test_is_valid_returns_false_for_inactive_coupon()
    {
        $coupon = Coupon::create([
            'code' => 'INACTIVE',
            'name' => 'Inactive',
            'type' => 'fixed',
            'value' => 10000,
            'is_active' => false,
        ]);

        $this->assertFalse($coupon->isValid());
    }

    public function test_is_valid_returns_false_for_expired_coupon()
    {
        $coupon = Coupon::create([
            'code' => 'EXPIRED',
            'name' => 'Expired',
            'type' => 'fixed',
            'value' => 10000,
            'is_active' => true,
            'expires_at' => Carbon::now()->subDay(),
        ]);

        $this->assertFalse($coupon->isValid());
    }

    public function test_is_valid_returns_false_when_max_uses_reached()
    {
        $coupon = Coupon::create([
            'code' => 'MAXED',
            'name' => 'Maxed Out',
            'type' => 'fixed',
            'value' => 10000,
            'is_active' => true,
            'max_uses' => 5,
            'used_count' => 5,
        ]);

        $this->assertFalse($coupon->isValid());
    }

    public function test_calculate_percentage_discount()
    {
        $coupon = Coupon::create([
            'code' => 'PCT10',
            'name' => '10% Off',
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
        ]);

        $discount = $coupon->calculateDiscount(100000);

        $this->assertEquals(10000, $discount);
    }

    public function test_calculate_fixed_discount()
    {
        $coupon = Coupon::create([
            'code' => 'FIXED20',
            'name' => 'Rp20.000 Off',
            'type' => 'fixed',
            'value' => 20000,
            'is_active' => true,
        ]);

        $discount = $coupon->calculateDiscount(100000);

        $this->assertEquals(20000, $discount);
    }

    public function test_fixed_discount_does_not_exceed_subtotal()
    {
        $coupon = Coupon::create([
            'code' => 'BIGFIXED',
            'name' => 'Big Fixed',
            'type' => 'fixed',
            'value' => 50000,
            'is_active' => true,
        ]);

        $discount = $coupon->calculateDiscount(30000);

        $this->assertEquals(30000, $discount);
    }

    public function test_calculate_discount_returns_zero_when_below_min_order()
    {
        $coupon = Coupon::create([
            'code' => 'MINORDER',
            'name' => 'Min Order',
            'type' => 'fixed',
            'value' => 10000,
            'is_active' => true,
            'min_order_amount' => 50000,
        ]);

        $discount = $coupon->calculateDiscount(30000);

        $this->assertEquals(0, $discount);
    }
}
