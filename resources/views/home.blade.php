@extends('layouts.app')

@section('content')
    <section class="hero py-16 bg-gray-100 flex justify-center items-center">
        <div class="hero-content text-center max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold mb-6">Добро пожаловать в {{ config('app.name') }}</h1>
            <p class="text-lg text-gray-700 mb-6">
                Окунитесь в атмосферу уюта и насладитесь изысканной кухней
            </p>
            <a href="{{ route('menu') }}"
               class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-base hover:bg-red-700 transition mt-4">
                Посмотреть меню
            </a>
        </div>
    </section>

    <section class="featured mt-10">
        <h2 class="text-2xl font-bold text-center mb-6">Популярные блюда</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-center">
            @foreach ($products as $product)
                <div class="bg-white border rounded-lg p-4 shadow-lg flex flex-col items-center text-center max-w-xs mx-auto">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded">
                    @endif
                    <h2 class="text-lg font-semibold mt-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 mt-1 text-sm">{{ $product->description }}</p>
                    <p class="text-red-500 font-bold mt-2">{{ $product->price }} ₽</p>
                    <a href="{{ route('menu') }}" class="block text-center mt-3 bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Заказать
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection

