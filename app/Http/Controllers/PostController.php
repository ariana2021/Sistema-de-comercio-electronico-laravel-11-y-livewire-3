<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // Búsqueda por título o contenido
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Filtrado por categoría solo si existe en la BD
        if ($request->filled('category') && Category::where('slug', $request->category)->exists()) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        return view('principal.blogs.index', [
            'posts' => $query->latest()->paginate(6),
            'latestPosts' => Post::latest()->limit(3)->get(),
            'categories' => Category::withCount('posts')->orderByDesc('posts_count')->get(),
        ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with([
                'comments' => function ($query) {
                    $query->whereNull('parent_id')->latest()->with(['replies.user', 'user']);
                }
            ])
            ->firstOrFail();

        return view('principal.blogs.show', [
            'post' => $post,
            'latestPosts' => Post::latest()->limit(3)->get(),
            'categories' => Category::withCount('posts')->orderByDesc('posts_count')->get(),
        ]);
    }
}
