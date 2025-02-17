<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Личный кабинет
    public function showProfilePage()
    {
        $user = Auth::user();
        $orders = $user->orders;
        return view('user.profile', compact('user', 'orders'));
    }
}
