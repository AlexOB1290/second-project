@extends('layouts.app')

@section('content')
    <div class="pt-20 min-h-screen flex items-start justify-center px-4 sm:px-6 lg:px-8"> <!-- Изменил items-center на items-start и добавил pt-20 -->
        <div class="max-w-sm w-full space-y-10"> <!-- Изменил max-w-md на max-w-sm и space-y-8 на space-y-10 -->
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Вход в аккаунт
                </h2>
            </div>

            <form class="mt-8 space-y-8" action="{{ route('login') }}" method="POST"> <!-- Изменил space-y-6 на space-y-8 -->
                @csrf
                <div class="rounded-md shadow-sm space-y-6"> <!-- Изменил space-y-4 на space-y-6 -->
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Email">
                        @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="sr-only">Пароль</label>
                        <input id="password" name="password" type="password" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 focus:z-10 sm:text-sm"
                               placeholder="Пароль">
                        @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Запомнить меня
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{-- route('password.request') --}}" class="font-medium text-red-600 hover:text-red-500">
                            Забыли пароль?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Войти
                    </button>
                </div>
            </form>

            <div class="text-center mt-8"> <!-- Добавил mt-8 -->
                <p class="text-sm text-gray-600">
                    Нет аккаунта?
                    <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                        Зарегистрироваться
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
