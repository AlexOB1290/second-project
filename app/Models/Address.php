<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'region',
        'district',
        'locality',
        'street',
        'building_number',
        'flat_number'
    ];

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->country}, {$this->region}, {$this->district}, {$this->locality},
                {$this->street}, д. {$this->building_number}, кв. {$this->flat_number}";
    }
}
