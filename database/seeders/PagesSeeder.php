<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        Page::create([
            'title' => 'Términos y condiciones',
            'slug' => 'terminos',
            'content' => 'Contenido de los términos y condiciones de la tienda.',
        ]);

        Page::create([
            'title' => 'Política de privacidad',
            'slug' => 'privacidad',
            'content' => 'Contenido de la política de privacidad de la tienda.',
        ]);
        
        // Puedes agregar más páginas si lo deseas
    }
}
