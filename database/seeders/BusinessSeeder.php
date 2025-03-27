<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        DB::table('businesses')->insert([
            'business_name'    => 'Mi Tienda Online',
            'email'            => 'contacto@mitienda.com',
            'phone'            => '123456789',
            'website'          => 'https://mitienda.com',
            'address'          => 'Av. Principal 123',
            'city'             => 'Ciudad Ejemplo',
            'state'            => 'Estado Ejemplo',
            'zip_code'         => '12345',
            'country'          => 'País Ejemplo',
            'latitude'         => '-12.0464',
            'longitude'        => '-77.0428',
            'cost_per_km'      => 0.50,
            'tax_percentage'   => 18.00,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}

