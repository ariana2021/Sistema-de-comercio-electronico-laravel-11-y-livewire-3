<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function edit($slug)
    {
        // Si no existe, lo crea con valores por defecto
        $page = Page::firstOrCreate(
            ['slug' => $slug],
            [
                'title' => ucfirst($slug),
                'content' => ''
            ]
        );

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string'
        ]);

        $page->update($request->only('title', 'content'));

        return redirect()->back()->with('success', 'Página actualizada correctamente.');
    }
}
