@extends('layouts.app')

@section('content')
    <section class="py-16">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-4 text-center">Ваши заказы</h1>

            @if ($orders->isEmpty())
                <p class="text-center text-gray-500">У вас пока нет заказов.</p>
            @else
                <div class="bg-white shadow-lg rounded-lg p-4">
                    @foreach ($orders as $order)
                        <div class="border-b pb-4 mb-4">
                            <h2 class="text-lg font-semibold">Заказ #{{ $order->order_number }}</h2>
                            <p class="text-gray-600 text-sm">Дата: {{ $order->created_at->format('d.m.Y H:i') }}</p>
                            <p class="text-gray-600 text-sm">Сумма: <span class="text-red-500">{{ number_format($order->total_price, 2, ',', ' ') }} ₽</span></p>
                            <p class="text-gray-600 text-sm">Адрес: {{ optional($order->address)->full_address ?? 'Не указан' }}</p>
                            <p class="text-gray-600 text-sm">Тип доставки: {{ $order->delivery_type }}</p>
                            <p class="text-gray-600 text-sm">Статус: <span class="font-semibold">{{ $order->status }}</span></p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
