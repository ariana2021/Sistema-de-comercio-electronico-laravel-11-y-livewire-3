<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryCart extends Model
{
    protected $fillable = ['user_id', 'cart_data', 'wishlist_data'];

    protected $casts = [
        'cart_data' => 'array',
        'wishlist_data' => 'array',
    ];
}
