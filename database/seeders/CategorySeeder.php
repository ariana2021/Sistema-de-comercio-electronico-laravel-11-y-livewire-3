<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = [
            'Herramientas',
            'Materiales de Construcción',
            'Fontanería',
            'Electricidad',
            'Pinturas y Acabados',
            'Ferretería General',
            'Seguridad Industrial',
            'Jardinería',
            'Automotriz',
            'Hogar y Menaje',
        ];

        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'name' => $category,
                'slug' => Str::slug($category),
                'image' => 'https://picsum.photos/300/300?random=' . rand(1, 1000)
            ];
        }

        DB::table('categories')->insert($data);
    }
}