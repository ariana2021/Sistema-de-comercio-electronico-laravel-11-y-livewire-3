<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        AboutUs::create([
            'title' => 'Nuestra Historia',
            'content' => 'Aquí va el contenido sobre nuestra historia.',
            'image_url' => 'https://example.com/imagen-historia.jpg',
            'type' => 'historia',
        ]);

        AboutUs::create([
            'title' => 'Nuestra Misión',
            'content' => 'Aquí va el contenido sobre nuestra misión.',
            'image_url' => 'https://example.com/imagen-mision.jpg',
            'type' => 'mision',
        ]);

        AboutUs::create([
            'title' => 'Nuestra Visión',
            'content' => 'Aquí va el contenido sobre nuestra visión.',
            'image_url' => 'https://example.com/imagen-vision.jpg',
            'type' => 'vision',
        ]);

        // Puedes agregar más registros si es necesario
    }
}
