<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'measure' => 'required|string|max:50',
            'weight' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products'); // Сохраняем в storage/app/public/products/
            $imagePath = str_replace('public/', 'storage/', $imagePath); // Преобразуем путь для доступа через asset()
        } else {
            $imagePath = null;
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'measure' => $request->measure,
            'weight' => $request->weight,
            'description' => $request->description,
            'image' => $imagePath ? str_replace('public/', 'storage/', $imagePath) : null,
        ]);

        return redirect()->route('products.create')->with('success', 'Продукт добавлен!');
    }

    public function getAll()
    {
        $products = Product::orderBy('id', 'desc')->limit(6)->get(); // Выводим 6 последних продуктов
        return view('home', compact('products'));
    }
}
