<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'shipping_cost',
        'shipping_place',
        'total',
        'payment_method',
        'status',
        'billing_details',
    ];

    protected $casts = [
        'billing_details' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistory() {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'asc');
    }
    
}
