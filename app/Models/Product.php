<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'discount_price', 'stock',
        'sku', 'status', 'image', 'category_id', 'brand_id'
    ];

    // Relación con Categoría (Muchos a Uno)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación con Marca (Muchos a Uno)
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
