<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ваше Кафе') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<header class="header">
    <div class="header-content">
        <div class="header-left">
            <button id="mobile-menu-btn" class="mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a href="{{ route('home') }}" class="logo">Ваше Кафе</a>
        </div>
        <nav class="nav-links">
            @if(Auth::check() && Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}">Админ-панель</a>
            @endif
            <a href="{{-- route('menu') --}}">Меню</a>
            <a href="{{-- route('about') --}}">О нас</a>
            <a href="{{-- route('contacts') --}}">Контакты</a>
            <a href="{{-- route('booking') --}}">Бронирование</a>
            <a href="{{ route('cart.show') }}" class="relative flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                @if(isset($cartItemsCount) && $cartItemsCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $cartItemsCount }}
                    </span>
                @endif
            </a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Поиск по меню...">
            @guest
                <button class="login-btn" onclick="openModal()">Войти</button>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('profile') }}" class="text-gray-700 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="login-btn">Выйти</button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Меню</h3>
        <button class="close-sidebar">&times;</button>
    </div>
    <ul class="menu-list">
        <li><a href="{{ route('menu.promotions') }}">АКЦИИ ДНЯ</a></li>
        <li><a href="{{ route('menu.sets') }}">НАБОРЫ РОЛЛОВ</a></li>
        <li><a href="{{ route('menu.rolls') }}">РОЛЛЫ</a></li>
        <li><a href="{{ route('menu.pizza') }}">ПИЦЦА</a></li>
        <li><a href="{{ route('menu.snacks') }}">ЗАКУСКИ</a></li>
        <li><a href="{{ route('menu.hot') }}">ГОРЯЧЕЕ и WOK</a></li>
        <li><a href="{{ route('menu.soups') }}">СУПЫ</a></li>
        <li><a href="{{ route('menu.salads') }}">САЛАТЫ</a></li>
        <li><a href="{{ route('menu.desserts') }}">ДЕСЕРТЫ</a></li>
        <li><a href="{{ route('menu.drinks') }}">НАПИТКИ</a></li>
        <li><a href="{{ route('menu.sauces') }}">СОУСЫ</a></li>
    </ul>
</aside>

<main class="main-content">
    @yield('content')
</main>

<div class="info-bar">
    <div>Режим работы: 10:00 - 22:00</div>
    <div>Телефон: +7 (999) 123-45-67</div>
    <div>Адрес: ул. Примерная, д. 123</div>
</div>

@include('components.auth-modal')
</body>
</html>
