<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create()
    {
        $user = Auth::user();  // Получаем авторизованного пользователя

        if ($user) {
            // Получаем все сохранённые адреса пользователя
            $addresses = $user->addresses;
            // Получаем корзину товаров
            $cart = $user->cart()->get();

            $phone = $user->phone;

            // Передаём данные в представление
            return view('order.create', compact('cart', 'addresses', 'phone'));
        } else {
            // Если пользователь не авторизован, перенаправляем на страницу входа
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему');
        }
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Войдите в аккаунт или зарегистрируйтесь');
        }
        //dd($request->all());

        $validationRules = [
            'delivery_type' => 'required|in:delivery,pickup,local',
            'phone' => 'required|string|max:255',
        ];

        // Условия для валидации нового адреса
        if ($request->delivery_type == 'delivery') {
            $validationRules = array_merge($validationRules, [
                'address_option' => 'required|in:new,saved', // Выбор нового или сохраненного адреса
                'country' => 'nullable|string|max:255|required_if:address_option,new',
                'region' => 'nullable|string|max:255|required_if:address_option,new',
                'district' => 'nullable|string|max:255|required_if:address_option,new',
                'locality' => 'nullable|string|max:255|required_if:address_option,new',
                'street' => 'nullable|string|max:255|required_if:address_option,new',
                'building_number' => 'nullable|string|max:255|required_if:address_option,new',
                'flat_number' => 'nullable|string|max:255|required_if:address_option,new',
                'address_id' => 'nullable|exists:addresses,id|required_if:address_option,saved',
            ]);
        }

        $user = Auth::user();
        $cart = $user->cart()->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Ваша корзина пуста.');
        }

        \DB::beginTransaction();
        try {
            // Создание нового адреса (если выбран новый адрес)
            if ($request->delivery_type == 'delivery') {
                if ($request->address_option === 'new' && $request->has('country')) {
                    $existingAddress = $user->addresses()->where('country', $request->country)
                        ->where('region', $request->region)
                        ->where('district', $request->district)
                        ->where('locality', $request->locality)
                        ->where('street', $request->street)
                        ->where('building_number', $request->building_number)
                        ->where('flat_number', $request->flat_number)
                        ->first();

                    if ($existingAddress) {
                        return redirect()->back()->with('error', 'Этот адрес уже существует в вашем списке адресов.');
                    }

                    // Если адрес не существует, создаем новый
                    $address = $user->addresses()->create([
                        'country' => $request->country,
                        'region' => $request->region,
                        'district' => $request->district,
                        'locality' => $request->locality,
                        'street' => $request->street,
                        'building_number' => $request->building_number,
                        'flat_number' => $request->flat_number,
                    ]);
                    $address_id = $address->id;
                } else {
                    $address_id = $request->address_id;  // Используем существующий адрес
                }
            } else {
                $address_id = null;  // Для pickup и local адрес не требуется
            }

            // Создаём заказ
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address_id' => $address_id,
                'delivery_type' => $request->delivery_type,
                'total_price' => $cart->sum(fn($p) => $p->price * $p->pivot->amount),
                'status' => 'pending',
            ]);

            // Переносим товары из корзины в order_products
            foreach ($cart as $product) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'amount' => $product->pivot->amount,
                    'price' => $product->price,
                ]);
            }

            // Очищаем корзину
            $user->cart()->detach();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->back()->with('error', 'Произошла ошибка при оформлении заказа');
        }

        return redirect()->route('home')->with('success', 'Заказ успешно оформлен!');
    }
}
