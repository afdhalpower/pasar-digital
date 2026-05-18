<?php

namespace App\Providers;

use App\Http\Controllers\CartController;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('cartCount', CartController::count());
        });

        View::composer('*', function ($view) {
            $user = Auth::user();
            $unread = 0;
            if ($user) {
                if ($user->isAdmin()) {
                    $unread = Conversation::totalUnreadForAdmin();
                } else {
                    $unread = Conversation::where('buyer_id', $user->id)
                        ->get()
                        ->sum(fn ($c) => $c->unreadForBuyer());
                }
            }
            $view->with('unreadCount', $unread);
        });
    }
}
