<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Truper', 'slug' => Str::slug('Truper')],
            ['name' => 'Stanley', 'slug' => Str::slug('Stanley')],
            ['name' => 'Makita', 'slug' => Str::slug('Makita')],
            ['name' => 'Bosch', 'slug' => Str::slug('Bosch')],
            ['name' => 'Dewalt', 'slug' => Str::slug('Dewalt')],
            ['name' => 'Black & Decker', 'slug' => Str::slug('Black & Decker')],
            ['name' => '3M', 'slug' => Str::slug('3M')],
            ['name' => 'Hilti', 'slug' => Str::slug('Hilti')],
            ['name' => 'Klein Tools', 'slug' => Str::slug('Klein Tools')],
            ['name' => 'Fischer', 'slug' => Str::slug('Fischer')],
        ];

        DB::table('brands')->insert($brands);
    }
}