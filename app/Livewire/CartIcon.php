<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class CartIcon extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cart = Session::get('cart', []);
        $this->cartCount = array_sum(array_column($cart, 'quantity'));
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}