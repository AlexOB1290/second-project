<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Авторизованный пользователь → считаем товары в БД
                $cartItemsCount = Auth::user()->cart()->sum('amount');
            } else {
                // Гость → считаем товары в сессии
                $cart = session()->get('cart', []);
                $cartItemsCount = array_sum(array_column($cart, 'amount'));
            }

            $view->with('cartItemsCount', $cartItemsCount);
        });
    }
}
