<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'showHomePage'])->name('home');

// Меню promotions.daily
Route::get('/menu/promotions-daily', [MenuController::class, 'promotionsDaily'])->name('menu.promotions');
Route::get('/menu/roll-sets', [MenuController::class, 'rollSets'])->name('menu.sets');
Route::get('/menu/rolls', [MenuController::class, 'rolls'])->name('menu.rolls');
Route::get('/menu/pizza', [MenuController::class, 'pizza'])->name('menu.pizza');
Route::get('/menu/appetizers', [MenuController::class, 'appetizers'])->name('menu.snacks');
Route::get('/menu/hot', [MenuController::class, 'hot'])->name('menu.hot');
Route::get('/menu/soups', [MenuController::class, 'soups'])->name('menu.soups');
Route::get('/menu/salads', [MenuController::class, 'salads'])->name('menu.salads');
Route::get('/menu/desserts', [MenuController::class, 'desserts'])->name('menu.desserts');
Route::get('/menu/drinks', [MenuController::class, 'drinks'])->name('menu.drinks');
Route::get('/menu/sauces', [MenuController::class, 'sauces'])->name('menu.sauces');

// Логин
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Регистрация
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Профиль
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfilePage'])->name('profile');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});

// Корзина
Route::get('/cart', [CartController::class, 'showCartPage'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Бронирование
Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store']);

// Поиск
Route::get('/search', [MenuController::class, 'search'])->name('search');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/category/{category}', [MenuController::class, 'category'])->name('menu.category');
Route::get('/menu/item/{item}', [MenuController::class, 'show'])->name('menu.item');

// Акции
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions');
Route::get('/promotions/{promotion}', [PromotionController::class, 'show'])->name('promotions.show');

// Контакты
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::post('/contacts/message', [ContactController::class, 'sendMessage'])->name('contacts.message');

// Бронирование
Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});

// Добавление продуктов в БД
Route::middleware(['auth'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});
Route::get('/', [ProductController::class, 'getAll'])->name('home');
