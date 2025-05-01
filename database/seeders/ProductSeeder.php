<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $brands = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $products = [];
        $existingSlugs = DB::table('products')->pluck('slug')->toArray(); // Obtener slugs existentes

        if (Storage::exists('public/products')) {
            Storage::deleteDirectory('public/products');
        }
        Storage::makeDirectory('public/products');

        $productNames = [
            "Taladro Eléctrico Profesional 500W con Percusión",
            "Martillo de Carpintero con Mango de Fibra de Vidrio",
            "Llave Inglesa Ajustable de 12 Pulgadas en Acero Forjado",
            "Sierra Circular con Disco de Carburo para Corte Preciso",
            "Pintura Acrílica Lavable para Interiores y Exteriores",
            "Cemento Rápido de Secado Ultra Resistente para Construcción",
            "Tubería de PVC de Alta Presión para Instalaciones Hidráulicas",
            "Cable Eléctrico de Cobre Flexible 10m para Instalaciones",
            "Destornillador Eléctrico con Batería de Litio y Accesorios",
            "Set de Brocas para Madera y Metal con Estuche Organizador",
            "Nivel Láser de Alta Precisión para Construcción y Carpintería",
            "Escalera de Aluminio Extensible hasta 4 Metros",
            "Guantes de Seguridad con Protección Anticorte Nivel 5",
            "Taladro Percutor con Kit de Accesorios para Construcción",
            "Compresor de Aire Portátil para Herramientas Neumáticas",
            "Llave de Impacto Neumática con Torque Ajustable",
            "Multímetro Digital Profesional con Funciones Avanzadas",
            "Sierra Caladora con Velocidad Variable para Cortes Precisos",
            "Cerradura Inteligente con Huella Digital y Control Remoto",
            "Soldadora Inverter con Electrodo Revestido de Alta Potencia"
        ];

        for ($i = 0; $i < 50; $i++) {
            $name = $faker->randomElement($productNames) . ' - ' . $faker->unique()->word;

            // Generar slug único sin hacer consultas repetidas a la BD
            $slug = Str::slug($name);
            $originalSlug = $slug;
            $counter = 1;

            while (in_array($slug, $existingSlugs)) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $existingSlugs[] = $slug; // Añadir al array para evitar futuros duplicados en este seeder

            // Descargar imagen y guardar en storage local
            $imageUrl = 'https://picsum.photos/300/300?random=' . rand(1, 1000);
            $response = Http::get($imageUrl);
            $fileName = 'products/' . Str::uuid() . '.jpg';
            Storage::disk('public')->put($fileName, $response->body());

            $price = $faker->randomFloat(2, 10, 100);
            $discount_price = $faker->randomFloat(2, 5, $price);

            $products[] = [
                'name' => $name,
                'slug' => $slug,
                'description' => $faker->paragraph(3),
                'price' => $price,
                'discount_price' => $discount_price,
                'stock' => $faker->numberBetween(10, 200),
                'sku' => strtoupper($faker->lexify('??????')),
                'status' => 1,
                'image' => $fileName,
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->randomElement($brands),
            ];
        }

        DB::table('products')->insert($products);
    }
}
