<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function gallery(Product $product)
    {
        return view('admin.products.gallery', ['product' => $product]);
    }
    public function upload(Request $request, Product $product)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $path = $request->file('file')->store('product-images', 'public');

        $image = ProductImage::create([
            'product_id' => $product->id,
            'url' => $path,
        ]);

        return response()->json(['id' => $image->id, 'url' => asset("storage/$path")]);
    }

    public function delete($id)
    {
        $image = ProductImage::findOrFail($id);

        // Elimina la imagen del almacenamiento
        Storage::disk('public')->delete($image->url);

        // Elimina la imagen de la base de datos
        $image->delete();

        // Retorna un JSON con success: true
        return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente']);
    }
}
