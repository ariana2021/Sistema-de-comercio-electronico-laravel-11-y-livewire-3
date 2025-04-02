<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        $posts = [
            "Herramientas esenciales para el hogar",
            "Cómo elegir el mejor taladro para tus proyectos",
            "Beneficios de usar tornillos de acero inoxidable",
            "Consejos para pintar paredes como un profesional",
            "Cuidados básicos para mantener tus herramientas en buen estado",
            "La importancia de usar guantes de seguridad en la construcción",
            "Diferencias entre martillos de goma y metálicos",
            "Los mejores materiales para impermeabilizar tu casa",
            "Cómo instalar una cerradura de seguridad fácilmente",
            "Errores comunes al medir y cortar madera"
        ];

        // ✅ Eliminar carpeta si ya existe y volver a crearla
        if (Storage::exists('public/posts')) {
            Storage::deleteDirectory('public/posts');
        }
        Storage::makeDirectory('public/posts');

        foreach ($posts as $index => $title) {
            $slug = Str::slug($title);
            $content = "Este es un artículo sobre $title. Aprende más sobre cómo mejorar tus proyectos de construcción y ferretería con nuestros consejos.";

            // ✅ Obtener imagen de Picsum
            $imageUrl = 'https://picsum.photos/800/400?random=' . rand(1, 1000);
            $imageContent = Http::get($imageUrl)->body();
            $imageName = 'post_' . Str::random(10) . '.jpg';
            Storage::put('public/posts/' . $imageName, $imageContent);

            // ✅ Guardar en la base de datos
            Post::create([
                'user_id' => $users[array_rand($users)],
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'status' => 1,
                'image' => 'posts/' . $imageName, // Ruta en storage
                'category_id' => $categories[array_rand($categories)],
            ]);
        }
    }
}
