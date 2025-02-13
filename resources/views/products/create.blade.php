@extends('layouts.app')

@section('content')
    <div class="pt-20 min-h-screen flex items-start justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-10">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Добавить продукт
                </h2>
            </div>

            @if (session('success'))
                <div class="bg-green-500 text-white p-2 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="rounded-md shadow-sm space-y-6">
                    <div>
                        <label for="name" class="sr-only">Название</label>
                        <input id="name" name="name" type="text" required
                               class="appearance-none rounded-lg block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               placeholder="Название">
                    </div>
                    <div>
                        <label for="price" class="sr-only">Цена</label>
                        <input id="price" name="price" type="number" step="0.01" required
                               class="appearance-none rounded-lg block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               placeholder="Цена">
                    </div>
                    <div>
                        <label for="measure" class="sr-only">Единица измерения</label>
                        <input id="measure" name="measure" type="text" required
                               class="appearance-none rounded-lg block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               placeholder="Единица измерения (кг, шт, л и т. д.)">
                    </div>
                    <div>
                        <label for="weight" class="sr-only">Количество</label>
                        <input id="weight" name="weight" type="number" required
                               class="appearance-none rounded-lg block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               placeholder="Вес">
                    </div>
                    <div>
                        <label for="description" class="sr-only">Описание</label>
                        <textarea id="description" name="description" rows="3"
                                  class="appearance-none rounded-lg block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                  placeholder="Описание (необязательно)"></textarea>
                    </div>
                    <div>
                        <label for="image" class="sr-only">Изображение</label>
                        <input id="image" name="image" type="file" accept="image/*"
                               class="appearance-none rounded-lg block w-full px-3 py-2 border border-gray-300 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Добавить продукт
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
