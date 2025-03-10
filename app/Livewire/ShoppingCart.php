<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class ShoppingCart extends Component
{
    public $products = [];
    public $cart = [];

    public function mount()
    {
        $this->products = Product::orderBy('created_at', 'desc')->limit(12)->get();
        $this->cart = Session::get('cart', []);
    }

    public function addToCart($productId)
{
    $cart = Session::get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += 1;
    } else {
        $product = Product::find($productId);
        $cart[$productId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->discount_price ?? $product->price,
            'image' => $product->image,
            'quantity' => 1,
        ];
    }

    Session::put('cart', $cart);
    
    // Emitir evento para actualizar el carrito y mostrar SweetAlert
    $this->dispatch('cartUpdated');
    $this->dispatch('showAlert', 'Producto agregado al carrito', 'success');
}

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
