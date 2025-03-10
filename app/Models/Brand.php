<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'slug'];

    // Relación con Productos (Uno a Muchos)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
