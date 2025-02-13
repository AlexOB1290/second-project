@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Корзина</h2>

{{--        @if(count($cartItems) > 0)--}}
{{--            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">--}}
{{--                <!-- Список товаров -->--}}
{{--                <div class="md:col-span-2">--}}
{{--                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">--}}
{{--                        <div class="p-6 space-y-6">--}}
{{--                            @foreach($cartItems as $item)--}}
{{--                                <div class="flex items-center justify-between border-b border-gray-200 pb-6">--}}
{{--                                    <div class="flex items-center space-x-4">--}}
{{--                                        <img src="{{ $item->dish->image }}" alt="{{ $item->dish->name }}"--}}
{{--                                             class="w-24 h-24 object-cover rounded-lg">--}}
{{--                                        <div>--}}
{{--                                            <h3 class="text-lg font-medium text-gray-900">{{ $item->dish->name }}</h3>--}}
{{--                                            <p class="text-sm text-gray-500">{{ $item->dish->description }}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="flex items-center space-x-4">--}}
{{--                                        <div class="flex items-center border rounded-lg">--}}
{{--                                            <button class="px-3 py-1 text-gray-600 hover:text-red-600"--}}
{{--                                                    onclick="updateQuantity({{ $item->id }}, 'decrease')">-</button>--}}
{{--                                            <span class="px-3 py-1 border-x">{{ $item->quantity }}</span>--}}
{{--                                            <button class="px-3 py-1 text-gray-600 hover:text-red-600"--}}
{{--                                                    onclick="updateQuantity({{ $item->id }}, 'increase')">+</button>--}}
{{--                                        </div>--}}
{{--                                        <p class="font-medium">{{ number_format($item->dish->price * $item->quantity, 0, '.', ' ') }} ₽</p>--}}
{{--                                        <button onclick="removeFromCart({{ $item->id }})"--}}
{{--                                                class="text-gray-400 hover:text-red-600">--}}
{{--                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>--}}
{{--                                            </svg>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Оформление заказа -->--}}
{{--                <div class="bg-white shadow-lg rounded-lg overflow-hidden h-fit">--}}
{{--                    <div class="p-6">--}}
{{--                        <h3 class="text-lg font-medium text-gray-900 mb-4">Итого</h3>--}}
{{--                        <div class="space-y-4">--}}
{{--                            <div class="flex justify-between">--}}
{{--                                <span>Сумма</span>--}}
{{--                                <span>{{ number_format($total, 0, '.', ' ') }} ₽</span>--}}
{{--                            </div>--}}
{{--                            <div class="flex justify-between">--}}
{{--                                <span>Доставка</span>--}}
{{--                                <span>{{ $deliveryPrice }} ₽</span>--}}
{{--                            </div>--}}
{{--                            <div class="border-t pt-4">--}}
{{--                                <div class="flex justify-between font-medium">--}}
{{--                                    <span>Итого к оплате</span>--}}
{{--                                    <span>{{ number_format($total + $deliveryPrice, 0, '.', ' ') }} ₽</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <button onclick="window.location.href='{{ route('checkout') }}'"--}}
{{--                                    class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700">--}}
{{--                                Оформить заказ--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @else--}}
{{--            <div class="text-center py-12">--}}
{{--                <p class="text-gray-500 mb-4">Ваша корзина пуста</p>--}}
{{--                <a href="{{ route('menu') }}" class="inline-block bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700">--}}
{{--                    Перейти к меню--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        @endif--}}
    </div>

    @push('scripts')
        <script>
            function updateQuantity(itemId, action) {
                fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ action })
                }).then(() => window.location.reload());
            }

            function removeFromCart(itemId) {
                if (confirm('Удалить товар из корзины?')) {
                    fetch(`/cart/remove/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(() => window.location.reload());
                }
            }
        </script>
    @endpush
@endsection
