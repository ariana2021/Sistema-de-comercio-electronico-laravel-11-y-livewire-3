<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class WishlistComponent extends Component
{
    public function removeFromWishlist($productId)
    {
        $wishlist = Session::get('wishlist', []);

        // Filtramos y reindexamos la lista de deseos
        $wishlist = array_values(array_filter($wishlist, fn($item) => $item['id'] != $productId));

        Session::put('wishlist', $wishlist);
        $this->dispatch('wishlistUpdated'); // Dispara evento Livewire
    }

    public function moveToCart($productId)
    {
        $wishlist = Session::get('wishlist', []);
        $cart = Session::get('cart', []);

        $product = collect($wishlist)->firstWhere('id', (int) $productId);

        if ($product) {
            $productDB = Product::find($productId);

            if (!$productDB || $productDB->stock <= 0) {
                $this->dispatch('showAlert', 'El producto no tiene stock disponible', 'warning');
                return;
            }

            $product['quantity'] = isset($product['quantity']) ? min($product['quantity'], $productDB->stock) : 1;

            if (!isset($cart[$productId])) {
                $cart[$productId] = $product;
                Session::put('cart', $cart);
                $this->dispatch('cartUpdated');
                $this->dispatch('showAlert', 'Producto agregado al carrito', 'success');
            }

            $this->removeFromWishlist($productId);
        }
    }



    public function render()
    {
        $wishlists = Session::get('wishlist', []);
        return view('livewire.wishlist-component', compact('wishlists'));
    }
}
