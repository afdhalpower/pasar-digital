<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/tentang-kami', 'pages.about')->name('about');
Route::view('/karir', 'pages.careers')->name('careers');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/kontak', 'pages.contact')->name('contact');
Route::view('/kebijakan-privasi', 'pages.privacy')->name('privacy');
Route::view('/syarat-ketentuan', 'pages.terms')->name('terms');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', fn () => response()->view('robots')->header('Content-Type', 'text/plain'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:3,60');

    Route::get('/lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:3,60');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update')->middleware('throttle:5,60');
});

Route::middleware('auth')->group(function () {
    Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/bundles', [CatalogController::class, 'bundles'])->name('catalog.bundles');
    Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::post('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('throttle:5,10');
        Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
        Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
    });

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
        Route::get('/start/{product}', [ChatController::class, 'start'])->name('start');
        Route::post('/{conversation}/send', [ChatController::class, 'send'])->name('send')->middleware('throttle:30,1');
    });

    Route::prefix('dashboard')->name('buyer.')->group(function () {
        Route::get('/', [BuyerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [BuyerDashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [BuyerDashboardController::class, 'orderDetail'])->name('order.detail');
        Route::get('/orders/{order}/confirmation', [BuyerDashboardController::class, 'orderConfirmation'])->name('order.confirmation');
        Route::post('/orders/{order}/cancel', [BuyerDashboardController::class, 'cancelOrder'])->name('order.cancel');
        Route::get('/orders/{order}/invoice', [BuyerDashboardController::class, 'invoice'])->name('order.invoice');
        Route::get('/downloads', [BuyerDashboardController::class, 'downloads'])->name('downloads');
        Route::get('/downloads/{product}', [BuyerDashboardController::class, 'downloadFile'])->name('download-file')->middleware('signed');
        Route::get('/favorit', [BuyerDashboardController::class, 'wishlist'])->name('wishlist');
        Route::get('/profile', [BuyerDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [BuyerDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/logout', [LoginController::class, 'logout']);
    });

    Route::post('/wishlist/toggle/{product}', [BuyerDashboardController::class, 'wishlistToggle'])->name('wishlist.toggle');
    Route::post('/ulasan/{product}', [BuyerDashboardController::class, 'storeReview'])->name('review.store');
});

// fitur export pesanan, refund, dll sudah diimplementasikan
