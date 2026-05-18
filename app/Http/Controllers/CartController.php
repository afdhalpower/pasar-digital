<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
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
        $total = $subtotal + $tax;
        $uniqueCode = \App\Models\Order::generateUniqueCode();

        $order = $user->orders()->create([
            'order_number' => \App\Models\Order::generateOrderNumber(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'unique_code' => $uniqueCode,
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
