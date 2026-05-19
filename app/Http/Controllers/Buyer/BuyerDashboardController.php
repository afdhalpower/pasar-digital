<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
    use App\Models\Order;
    use App\Models\OrderItem;
    use App\Models\Product;
    use App\Models\Review;
    use App\Notifications\OrderStatusChanged;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\Rules\Password;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Total spent
        $totalSpent = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total');

        // 2. Active orders count
        $activeOrdersCount = Order::where('user_id', $user->id)
            ->whereIn('status', array('pending', 'processing'))
            ->count();

        // 3. Paid items (downloads) count
        $paidOrderIds = Order::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('payment_status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->pluck('id');

        $totalDownloadsCount = OrderItem::whereIn('order_id', $paidOrderIds)
            ->distinct('product_id')
            ->count();

        // 4. Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // 5. Recent downloads
        $recentDownloads = OrderItem::with('product')
            ->whereIn('order_id', $paidOrderIds)
            ->latest()
            ->take(4)
            ->get();

        return view('buyer.dashboard', compact(
            'totalSpent',
            'activeOrdersCount',
            'totalDownloadsCount',
            'recentOrders',
            'recentDownloads'
        ));
    }

    public function orders(Request $request)
    {
        $query = Auth::user()->orders()->with('items.product');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment')) {
            $query->where('payment_status', $request->payment);
        }

        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(10);

        return view('buyer.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('buyer.order-detail', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product', 'user');

        return view('buyer.invoice', compact('order'));
    }

    public function orderConfirmation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('buyer.confirmation', compact('order'));
    }

    public function downloads(Request $request)
    {
        $user = Auth::user();
        
        $paidOrderIds = Order::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('payment_status', 'paid')
                    ->orWhere('status', 'completed');
            })
            ->pluck('id');

        $downloadsQuery = OrderItem::with(['product.category', 'order', 'licenses'])
            ->whereIn('order_id', $paidOrderIds);

        // Search by product name
        if ($request->filled('search')) {
            $search = $request->search;
            $downloadsQuery->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $downloads = $downloadsQuery->latest()->paginate(12);

        return view('buyer.downloads', compact('downloads'));
    }

    public function downloadFile(Product $product)
    {
        $user = Auth::user();

        // Check if user has paid for this product
        $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhere('status', 'completed');
                });
        })->where('product_id', $product->id)->exists();

        if (!$hasPurchased) {
            abort(403, 'Anda belum membeli produk ini atau pembayaran Anda belum diverifikasi.');
        }

        // Serve actual file from Media Library, with fallback to legacy file_path
        $filePath = $product->getFileDownloadPath();

        if (!$filePath || !file_exists($filePath)) {
            abort(404, 'File produk tidak ditemukan.');
        }

        $media = $product->getFirstMedia('file');
        $fileName = $media ? $media->file_name : basename($filePath);

        $product->increment('download_count');

        return response()->download($filePath, $fileName);
    }

    public function profile()
    {
        return view('buyer.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini salah.',
                ]);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function wishlist()
    {
        $products = Auth::user()->wishlistProducts()->with('category')->paginate(12);
        return view('buyer.wishlist', compact('products'));
    }

    public function wishlistToggle(Product $product)
    {
        $user = Auth::user();

        if ($user->wishlistProducts()->where('product_id', $product->id)->exists()) {
            $user->wishlistProducts()->detach($product->id);
            $wishlisted = false;
        } else {
            $user->wishlistProducts()->attach($product->id);
            $wishlisted = true;
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['wishlisted' => $wishlisted]);
        }

        return back()->with('success', $wishlisted ? 'Produk ditambahkan ke Favorit.' : 'Produk dihapus dari Favorit.');
    }

    public function cancelOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }

        $oldStatus = $order->status;
        $order->update([
            'status' => 'cancelled',
            'payment_status' => $order->payment_status === 'paid' ? 'refunded' : $order->payment_status,
        ]);

        $order->user->notify(new OrderStatusChanged($order, $oldStatus, 'cancelled'));

        return redirect()->route('buyer.orders')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function storeReview(Request $request, Product $product)
    {
        $user = Auth::user();

        $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user, $product) {
            $query->where('user_id', $user->id)
                ->where(function ($q) {
                    $q->where('payment_status', 'paid')
                        ->orWhere('status', 'completed');
                });
        })->where('product_id', $product->id)->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['review' => 'Anda harus membeli produk ini terlebih dahulu untuk memberikan ulasan.']);
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);

        $existing = Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
        } else {
            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
        }

        // Update product aggregate rating
        $product->load('reviews');
        $product->rating = $product->reviews->avg('rating');
        $product->review_count = $product->reviews->count();
        $product->save();

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }
}
