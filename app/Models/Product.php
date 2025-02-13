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
}
