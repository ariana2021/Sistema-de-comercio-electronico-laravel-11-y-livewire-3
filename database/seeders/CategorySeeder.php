<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
            // Generar slug único
            $slug = Str::slug($category);
            $originalSlug = $slug;
            $counter = 1;

            while (DB::table('categories')->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Descargar imagen
            $imageUrl = 'https://picsum.photos/300/300?random=' . rand(1, 1000);
            $response = Http::get($imageUrl);
            $fileName = 'categories/' . Str::uuid() . '.jpg';
            Storage::disk('public')->put($fileName, $response->body());

            $data[] = [
                'name' => $category,
                'slug' => $slug,
                'image' => $fileName
            ];
        }

        DB::table('categories')->insert($data);
    }
}
