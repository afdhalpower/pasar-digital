<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/tentang-kami', 'pages.about')->name('about');
Route::view('/karir', 'pages.careers')->name('careers');
Route::view('/blog', 'pages.blog')->name('blog');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/kontak', 'pages.contact')->name('contact');
Route::view('/kebijakan-privasi', 'pages.privacy')->name('privacy');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::post('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{conversation}', [ChatController::class, 'show'])->name('show');
        Route::get('/start/{product}', [ChatController::class, 'start'])->name('start');
        Route::post('/{conversation}/send', [ChatController::class, 'send'])->name('send');
    });

    Route::prefix('dashboard')->name('buyer.')->group(function () {
        Route::get('/', [BuyerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [BuyerDashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [BuyerDashboardController::class, 'orderDetail'])->name('order.detail');
        Route::get('/orders/{order}/confirmation', [BuyerDashboardController::class, 'orderConfirmation'])->name('order.confirmation');
        Route::get('/downloads', [BuyerDashboardController::class, 'downloads'])->name('downloads');
        Route::get('/downloads/{product}', [BuyerDashboardController::class, 'downloadFile'])->name('download-file');
        Route::get('/favorit', [BuyerDashboardController::class, 'wishlist'])->name('wishlist');
        Route::get('/profile', [BuyerDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [BuyerDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/logout', [LoginController::class, 'logout']);
    });

    Route::post('/wishlist/toggle/{product}', [BuyerDashboardController::class, 'wishlistToggle'])->name('wishlist.toggle');
    Route::post('/ulasan/{product}', [BuyerDashboardController::class, 'storeReview'])->name('review.store');
});

// TODO: send email notification pas status berubah
// TODO: implement export pesanan
// TODO: handle refund flow
