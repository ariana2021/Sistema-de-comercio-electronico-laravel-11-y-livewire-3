<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SliderSeeder extends Seeder
{
    public function run()
    {
        $products = Product::pluck('id')->toArray();

        $sliderData = [
            [
                'title' => 'Oferta en herramientas eléctricas',
                'description' => 'Descuento especial en taladros y sierras.',
                'discount' => 20,
            ],
            [
                'title' => 'Promoción en tornillería',
                'description' => 'Compra en grandes cantidades y ahorra más.',
                'discount' => 15,
            ],
            [
                'title' => 'Descuentos en pintura',
                'description' => 'Renueva tu hogar con los mejores colores.',
                'discount' => 10,
            ],
            [
                'title' => 'Especial de construcción',
                'description' => 'Materiales resistentes al mejor precio.',
                'discount' => 25,
            ],
        ];

        // ✅ Eliminar carpeta si ya existe y volver a crearla
        if (Storage::exists('public/sliders')) {
            Storage::deleteDirectory('public/sliders');
        }
        Storage::makeDirectory('public/sliders');

        foreach ($sliderData as $index => $data) {
            // ✅ Obtener imagen de Picsum
            $imageUrl = 'https://picsum.photos/800/400?random=' . rand(1, 1000);
            $imageContent = Http::get($imageUrl)->body();
            $imageName = 'slider_' . Str::random(10) . '.jpg';
            Storage::put('public/sliders/' . $imageName, $imageContent);

            // ✅ Guardar en la base de datos
            Slider::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => 'sliders/' . $imageName, // Ruta en storage
                'product_id' => $products[array_rand($products)],
                'discount' => $data['discount'],
                'status' => 1,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ]);
        }
    }
}
