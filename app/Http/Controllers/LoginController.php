<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService; // Инъекция зависимости
    }
    //Показать форму логина
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //Обработка входа
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $this->cartService->mergeCart();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
        ])->withInput($request->only('email', 'remember'));
    }

    //Обработка выхода
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
