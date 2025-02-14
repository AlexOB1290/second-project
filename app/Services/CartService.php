<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
class CartService
{
    /**
     * Create a new class instance.
     */

    // ✅ Перенос корзины из сессии в БД после логина
    public function mergeCart()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();
        $sessionCart = collect(session()->get('cart', [])); // Преобразуем сессию в коллекцию

        foreach ($sessionCart as $id => $cartItem) {
            $existing = $user->cart()->where('product_id', $id)->first();

            if ($existing) {
                $user->cart()->updateExistingPivot($id, ['amount' => $existing->pivot->amount + $cartItem['amount']]);
            } else {
                $user->cart()->attach($id, ['amount' => $cartItem['amount']]);
            }
        }

        session()->forget('cart');
    }
}
