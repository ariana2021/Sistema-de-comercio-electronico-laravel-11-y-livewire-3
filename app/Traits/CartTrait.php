<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\TemporaryCart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

trait CartTrait
{
    public $quantity = 1;

    public function setQuantity($value)
    {
        $this->quantity = max(1, (int) $value);
    }

    public function addToWishlist($productId)
    {
        $wishlist = Session::get('wishlist', []);

        if (!isset($wishlist[$productId])) {
            $product = Product::find($productId);
            if ($product) {
                $wishlist[$productId] = [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'name' => $product->name,
                    'price' => $product->discount_price ?? $product->price,
                    'image' => $product->image,
                ];

                Session::put('wishlist', $wishlist);
                if (Auth::check()) {
                    $this->updateDatabase();
                }

                $this->dispatch('wishlistUpdated');
                $this->dispatch('showAlert', 'Producto agregado a la lista de deseos', 'success');
                $this->skipRender();
            }
        } else {
            $this->dispatch('showAlert', 'El producto ya está en la lista de deseos', 'warning');
        }
    }

    public function addToCart($productId)
    {
        $cart = Session::get('cart', []);
        $product = Product::find($productId);

        if (!$product) {
            $this->dispatch('showAlert', 'El producto no existe.', 'error');
            return;
        }

        // Verificar stock disponible
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] + 1 > $product->stock) {
                $this->dispatch('showAlert', 'No hay suficiente stock disponible.', 'warning');
                return;
            }
            $cart[$productId]['quantity'] += 1;
        } else {
            if ($this->quantity > $product->stock) {
                $this->dispatch('showAlert', 'No hay suficiente stock disponible.', 'warning');
                return;
            }
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->discount_price ?? $product->price,
                'image' => $product->image,
                'quantity' => $this->quantity,
            ];
        }

        Session::put('cart', $cart);

        if (Auth::check()) {
            $this->updateDatabase();
        }
        
        $this->dispatch('cartUpdated');
        $this->dispatch('showAlert', 'Producto agregado al carrito', 'success');
        $this->skipRender();
    }

    private function updateDatabase()
    {
        $userId = Auth::id();
        $cartData = Session::get('cart', []);
        $wishlistData = Session::get('wishlist', []);

        TemporaryCart::updateOrCreate(
            ['user_id' => $userId],
            ['cart_data' => $cartData, 'wishlist_data' => $wishlistData]
        );
    }
}

