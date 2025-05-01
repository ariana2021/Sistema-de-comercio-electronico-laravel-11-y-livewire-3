<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'price',
        'discount_price',
        'stock',
        'sales_count',
        'sku',
        'status',
        'image',
        'category_id',
        'brand_id'
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

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating'), 1) ?? 0;
    }
}
