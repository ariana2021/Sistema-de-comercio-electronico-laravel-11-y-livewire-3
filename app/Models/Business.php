<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'legal_name',
        'tax_id',
        'email',
        'phone',
        'cashback_percentage',
        'website',
        'logo',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
        'shipping_enabled',
        'cost_per_km',
        'tax_percentage',
        'tax_included',
        'invoice_series',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
    ];

    protected $casts = [
        'shipping_enabled' => 'boolean',
    ];
}
