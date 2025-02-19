<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Админ-панель</title>

    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Отдельные стили и скрипты --}}
</head>
<body>
<header class="bg-gray-800 text-white p-4">
    <h1 class="text-xl">Админ-панель</h1>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="text-white">Главная</a>
        <a href="{{-- route('admin.orders') --}}" class="text-white">Заказы</a>
        <a href="{{ route('admin.products') }}" class="text-white">Меню</a>
        <a href="{{-- route('admin.users') --}}" class="text-white">Пользователи</a>
        <a href="{{ route('home') }}" class="text-red-500">Вернуться на сайт</a>
    </nav>
</header>

<main class="p-6">
    @yield('content')
</main>
</body>
</html>
