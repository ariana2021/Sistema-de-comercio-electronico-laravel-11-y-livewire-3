<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // IDs de categorías existentes
        $brands = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // IDs de marcas existentes

        $products = [];

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->word . ' ' . $faker->randomElement(['Taladro', 'Martillo', 'Llave', 'Sierra', 'Pintura', 'Cemento', 'Tubería', 'Cable']);
            
            $products[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $faker->sentence(),
                'price' => $faker->randomFloat(2, 10, 500),
                'discount_price' => $faker->optional()->randomFloat(2, 5, 400),
                'stock' => $faker->numberBetween(10, 200),
                'sku' => strtoupper($faker->lexify('??????')),
                'status' => 1,
                'image' => 'https://picsum.photos/300/300?random=' . rand(1, 1000),
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->randomElement($brands),
            ];
        }

        DB::table('products')->insert($products);
    }
}