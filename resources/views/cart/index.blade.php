@extends('layouts.app')

@section('content')
    <section class="py-16">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-4 text-center">Ваша корзина</h1>

            @php
                // Вычисление общего количества товаров и общей суммы корзины
                $totalItems = 0;
                $totalPrice = 0;

                // Для авторизованных пользователей (если корзина является коллекцией)
                if (Auth::check()) {
                    $totalItems = $cart->sum('pivot.amount');
                    $totalPrice = $cart->sum(fn($product) => $product->price * $product->pivot->amount);
                } else {
                    // Для неавторизованных пользователей (сессия)
                    $totalItems = array_sum(array_column($cart, 'amount'));
                    $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['amount'], $cart));
                }
            @endphp

            <div class="bg-white shadow-lg rounded-lg p-4 text-center mb-6">
                <p class="text-lg font-semibold">Всего товаров: <span class="text-red-500">{{ $totalItems }}</span></p>
                <p class="text-lg font-semibold">Общая сумма: <span class="text-red-500">{{ number_format($totalPrice, 2, ',', ' ') }} ₽</span></p>
            </div>

            <!-- Отображаем корзину, если она не пуста -->
            @if ($totalItems > 0)
                <div class="bg-white shadow-lg rounded-lg p-4">
                    @foreach ($cart as $product)
                        <div class="flex items-center justify-between border-b pb-3 mb-3 text-sm">
                            <div class="flex items-center gap-3">
                                @if (is_array($product)) <!-- Для неавторизованных пользователей -->
                                @if (isset($product['image'])) <!-- Для неавторизованных пользователей, сессия -->
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-12 h-12 rounded">
                                @endif
                                <div>
                                    <h2 class="font-semibold">{{ $product['name'] }}</h2>
                                    <p class="text-gray-600">{{ number_format($product['price'], 2, ',', ' ') }} ₽</p>
                                    <p class="text-gray-500 text-xs">Количество: {{ $product['amount'] }}</p>
                                </div>
                                <form action="{{ route('cart.remove', $product['product_id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700">
                                        Удалить
                                    </button>
                                </form>
                                @else <!-- Для авторизованных пользователей, объекты -->
                                @if (isset($product->image)) <!-- Если изображение существует -->
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded">
                                @endif
                                <div>
                                    <h2 class="font-semibold">{{ $product->name }}</h2>
                                    <p class="text-gray-600">{{ number_format($product->price, 2, ',', ' ') }} ₽</p>
                                    <p class="text-gray-500 text-xs">Количество: {{ $product->pivot->amount }}</p>
                                </div>
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700">
                                        Удалить
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                        <div class="text-right mt-6">
                            @if (Auth::check()) <!-- Если пользователь авторизован -->
                            <a href="{{ route('order.create') }}" class=" bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition">
                                Оформить заказ
                            </a>
                            @else <!-- Если пользователь не авторизован -->
                            <p class="text-sm text-gray-500">Войдите в аккаунт, чтобы начать оформление заказа.</p>
                            @endif
                        </div>
                </div>

            @else
                <p class="text-center text-gray-500">Ваша корзина пуста.</p>
            @endif
        </div>

    </section>
@endsection
