@extends('layouts.app')

@section('content')
    <div class="pt-20 min-h-screen flex items-start justify-center px-4 sm:px-6 lg:px-8"> <!-- Изменил items-center на items-start и добавил pt-20 -->
        <div class="max-w-sm w-full space-y-10">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Регистрация
                </h2>
            </div>
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-8" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm space-y-6">
                    <div>
                        <label for="name" class="sr-only">Имя</label>
                        <input id="name" name="name" type="text" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Имя">
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Email">
                    </div>
                    <div>
                        <label for="phone" class="sr-only">Телефон</label>
                        <input id="phone" name="phone" type="tel" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Телефон">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Пароль</label>
                        <input id="password" name="password" type="password" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Пароль">
                    </div>
                    <div>
                        <label for="password_confirmation" class="sr-only">Подтвердите пароль</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Подтвердите пароль">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Зарегистрироваться
                    </button>
                </div>
            </form>

            <div class="text-center mt-8">
                <p class="text-sm text-gray-600">
                    Уже есть аккаунт?
                    <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                        Войти
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
