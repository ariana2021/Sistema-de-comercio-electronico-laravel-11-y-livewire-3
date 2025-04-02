<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ShoppingCart extends Controller
{
    public function index()
    {
        return view('principal.cart.index');
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        $products = Product::where('name', 'LIKE', '%' . $term . '%')
        ->limit(10) 
        ->get(['name', 'slug']);

        return response()->json($products->map(function ($product) {
            return [
                'label' => $product->name,
                'value' => $product->name,
                'url' => route('product.detail', $product->slug)
            ];
        }));
    }


    public function wishlist()
    {
        return view('principal.cart.wishlist');
    }

    public function calculateShipping(Request $request)
    {
        $business = Business::first();

        // Dirección del usuario
        $userAddress = $request->input('user_address');

        if (!$userAddress) {
            return response()->json(['error' => 'Debe ingresar una dirección.'], 400);
        }

        // API Key de Google Maps (colócala en .env)
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        // Consulta a Google Maps Distance Matrix API
        $response = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json", [
            'origins'      => "{$business->latitude},{$business->longitude}",
            'destinations' => $userAddress,
            'key'          => $apiKey,
        ]);

        $data = $response->json();

        if (!isset($data['rows'][0]['elements'][0]['distance'])) {
            return response()->json(['error' => 'No se pudo calcular la distancia.'], 400);
        }

        // Distancia en km
        $distanceKm = $data['rows'][0]['elements'][0]['distance']['value'] / 1000;

        // Costo de envío
        $shippingCost = $business->base_shipping_cost + ($distanceKm * $business->cost_per_km);

        return response()->json(['distance' => $distanceKm, 'shipping_cost' => round($shippingCost, 2)]);
    }

    public function checkout()
    {
        return view('principal.cart.checkout');
    }
}
