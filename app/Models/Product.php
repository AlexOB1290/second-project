<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Указываем таблицу в БД

    protected $fillable = [
        'name',
        'price',
        'measure',
        'weight',
        'description',
        'image',
    ];

    // Автоматически кастим цену в float
    protected $casts = [
        'price' => 'float',
        'amount' => 'integer',
    ];

    // Добавляем связи "многие ко многим" между пользователями и продуктами.
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_products')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredients');
    }
}
