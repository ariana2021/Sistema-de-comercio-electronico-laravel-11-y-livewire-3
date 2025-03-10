<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartComponent extends Component
{
    public $cart = [];
    public $subtotal = 0;

    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        $this->updateCart();
    }

    public function updateCart()
    {
        $this->cart = Session::get('cart', []);
        $this->subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $this->cart));
    }

    public function removeFromCart($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);

            $this->dispatch('cartUpdated');
            $this->dispatch('showAlert', 'Producto eliminado del carrito', 'warning');
        }
    }


    public function render()
    {
        return view('livewire.cart-component');
    }
}
