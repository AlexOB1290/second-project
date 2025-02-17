<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function createOrder($request, $user, $cart)
    {
        DB::beginTransaction();

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

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
