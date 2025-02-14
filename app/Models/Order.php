<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'phone',
        'address_id',
        'delivery_type',
        'total_price',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    // Связь с таблицей addresses
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
