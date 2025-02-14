<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ✅ Добавление товара в корзину
    public function addToCart(Request $request, Product $product)
    {
        if (Auth::check()) {
            // 🟢 Авторизованный пользователь → храним в БД
            $user = Auth::user();
            $existing = $user->cart()->where('product_id', $product->id)->first();

            if ($existing) {
                $user->cart()->updateExistingPivot($product->id, ['amount' => $existing->pivot->amount + 1]);
            } else {
                $user->cart()->attach($product->id, ['amount' => 1]);
            }
        } else {
            // 🟠 Гость → храним в сессии
            $cart = session()->get('cart', []);
            if (isset($cart[$product->id])) {
                $cart[$product->id]['amount']++;
            } else {
                $cart[$product->id] = [
                    "product_id" => $product->id,
                    "name" => $product->name,
                    "price" => $product->price,
                    "amount" => 1,
                    "image" => $product->image
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    // ✅ Отображение корзины
    public function showCart()
    {
        if (Auth::check()) {
            // Для авторизованных пользователей корзина хранится в базе данных
            $cart = collect(Auth::user()->cart()->get()); // Преобразуем в коллекцию
        } else {
            // Для неавторизованных пользователей корзина хранится в сессии
            $cart = session()->get('cart', []); // Получаем массив из сессии, не преобразуем его в коллекцию
        }

        return view('cart.index', compact('cart'));
    }

    // ✅ Удаление товара из корзины
    public function removeFromCart(Product $product)
    {
        if (Auth::check()) {
            Auth::user()->cart()->detach($product->id);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$product->id])) {
                unset($cart[$product->id]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Товар удалён из корзины!');
    }
}
