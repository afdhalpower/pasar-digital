<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\License;
use App\Models\Product;
use App\Notifications\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn ($item) => $item->product->effective_price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'integer|min:1|max:99']);

        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $existing = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity ?? 1);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeOwnership($cartItem);

        $request->validate(['quantity' => 'required|integer|min:1|max:99']);
        $cartItem->update(array('quantity' => $request->quantity));

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeOwnership($cartItem);
        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string|max:50']);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('error', 'Kode kupon tidak valid atau sudah tidak berlaku.');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->effective_price * $item->quantity);

        if ($subtotal < $coupon->min_order_amount) {
            $min = number_format($coupon->min_order_amount, 0, ',', '.');
            return back()->with('error', "Minimal pesanan Rp {$min} untuk menggunakan kupon ini.");
        }

        session(['applied_coupon' => $coupon->id]);

        return back()->with('success', 'Kupon berhasil diterapkan!');
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return back()->with('success', 'Kupon berhasil dihapus.');
    }

    public function checkout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang belanja kosong.');
        }

        $user = Auth::user();
        $subtotal = $cartItems->sum(fn ($item) => $item->product->effective_price * $item->quantity);
        $tax = 0;

        $discount = 0;
        $couponId = null;
        if (session()->has('applied_coupon')) {
            $coupon = Coupon::find(session('applied_coupon'));
            if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_order_amount) {
                $discount = $coupon->calculateDiscount($subtotal);
                $couponId = $coupon->id;
                $coupon->increment('used_count');
            }
            session()->forget('applied_coupon');
        }

        $total = $subtotal - $discount;
        if ($total < 0) $total = 0;

        $uniqueCode = \App\Models\Order::generateUniqueCode();

        $order = $user->orders()->create([
            'order_number' => \App\Models\Order::generateOrderNumber(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
            'unique_code' => $uniqueCode,
            'coupon_id' => $couponId,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'notes' => null,
        ]);

        foreach ($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->product->effective_price,
                'quantity' => $cartItem->quantity,
                'total' => $cartItem->product->effective_price * $cartItem->quantity,
            ]);
        }

        CartItem::where('user_id', Auth::id())->delete();

        $user->notify(new OrderConfirmation($order));

        return redirect()->route('buyer.order.confirmation', $order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public static function count(): int
    {
        if (!Auth::check()) return 0;
        return CartItem::where('user_id', Auth::id())->sum('quantity');
    }

    private function authorizeOwnership(CartItem $cartItem): void
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
