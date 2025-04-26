<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $items = AboutUs::all();
        return view('admin.about.index', compact('items'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:historia,mision,vision',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'type', 'content']);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('about_images', 'public');
        }

        AboutUs::create($data);

        return redirect()->route('about.index')->with('success', 'Contenido creado correctamente.');
    }

    public function edit(AboutUs $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, AboutUs $about)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:historia,mision,vision',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'type', 'content']);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('about_images', 'public');
        }

        $about->update($data);

        return redirect()->route('about.index')->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(AboutUs $about)
    {
        if ($about->image_url && Storage::disk('public')->exists($about->image_url)) {
            Storage::disk('public')->delete($about->image_url);
        }
        $about->delete();

        return redirect()->route('about.index')->with('success', 'Contenido eliminado correctamente.');
    }
}
