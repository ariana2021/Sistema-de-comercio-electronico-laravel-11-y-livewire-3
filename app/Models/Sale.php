<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'date',
        'status',
        'paid_with',
        'use_cashback',
        'payment_method_id',
        'user_id',
        'client_id',
    ];

    /**
     * Relación con el modelo PaymentMethod.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Relación con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}