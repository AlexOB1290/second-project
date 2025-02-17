<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
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

        try {
            $this->orderService->createOrder($request, $user, $cart);

            return redirect()->route('orders')->with('success', 'Заказ успешно оформлен!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Произошла ошибка при оформлении заказа');
        }
    }

    public function show(Order $order)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Войдите в аккаунт или зарегистрируйтесь');
        }

        $user = Auth::user();
        $orders = $user->orders()->with('address')->latest()->get(); // Загружаем адреса

        return view('order.index', compact('orders'));
    }
}
