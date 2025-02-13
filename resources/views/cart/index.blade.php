@extends('layouts.app')

@section('content')
    <section class="py-16">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center">Ваша корзина</h1>

            @if (Auth::check())
                @if ($cart->count() > 0)
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        @foreach ($cart as $product)
                            <div class="flex items-center justify-between border-b pb-4 mb-4">
                                <div class="flex items-center gap-4">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded">
                                    @endif
                                    <div>
                                        <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                                        <p class="text-gray-600 text-sm">{{ $product->price }} ₽</p>
                                        <p class="text-gray-500 text-xs">Количество: {{ $product->pivot->amount }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500">Ваша корзина пуста.</p>
                @endif
            @endif
        </div>
    </section>
@endsection
