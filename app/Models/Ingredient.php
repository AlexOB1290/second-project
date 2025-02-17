<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'measure',
        'weight',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(ProductIngredient::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredients');
    }
}
