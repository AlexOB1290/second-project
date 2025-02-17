@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Личный кабинет</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Личные данные -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Личные данные</h3>
                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Имя</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Телефон</label>
                                <input type="tel" name="phone" value="{{ auth()->user()->phone }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                            <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700">
                                Сохранить изменения
                            </button>
                        </form>
                    </div>

                    <!-- История заказов -->
                    <div class="md:col-span-2 bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">История заказов</h3>
                        <div class="space-y-4">
                            @forelse($orders as $order)
                                <div class="border-b border-gray-200 pb-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">Заказ № {{ $order->order_number }}</p>
                                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                                            <p class="text-sm">Статус: <span class="font-medium">{{ $order->status }}</span></p>
                                        </div>
                                        <p class="font-medium">{{ number_format($order->total_price, 2, '.', ' ') }} ₽</p>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('orders', $order) }}" class="text-red-600 hover:text-red-500 text-sm">
                                            Подробнее →
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">У вас пока нет заказов</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
