<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::pluck('id')->toArray();
        $posts = Post::pluck('id')->toArray();
        
        if (empty($users) || empty($posts)) {
            return; // No hay usuarios o posts disponibles
        }

        $comments = [];

        // Generar comentarios principales
        for ($i = 0; $i < 50; $i++) {
            $comments[] = [
                'post_id' => $posts[array_rand($posts)],
                'user_id' => $users[array_rand($users)],
                'parent_id' => null, // Comentario principal
                'content' => fake()->sentence(12),
                'likes_count' => rand(0, 50),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now(),
            ];
        }

        // Insertar comentarios principales
        Comment::insert($comments);

        // Generar respuestas a comentarios
        $allComments = Comment::pluck('id')->toArray();
        $replies = [];

        for ($i = 0; $i < 30; $i++) {
            $replies[] = [
                'post_id' => $posts[array_rand($posts)],
                'user_id' => $users[array_rand($users)],
                'parent_id' => $allComments[array_rand($allComments)], // Respuesta a un comentario
                'content' => fake()->sentence(10),
                'likes_count' => rand(0, 30),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ];
        }

        // Insertar respuestas
        Comment::insert($replies);
    }
}