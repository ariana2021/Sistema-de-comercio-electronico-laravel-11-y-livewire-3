<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Traits\CartTrait;
use App\Traits\ModalTrait;

class ShoppingCart extends Component
{
    use CartTrait, ModalTrait;

    public $categories;

    public function mount()
    {
        $this->categories = Category::with(['products' => function ($query) {
            $query->latest()->take(4);
        }])->orderBy('id', 'desc')->get();        
    }

    public function buyNow($productId)
    {
        $this->addToCart($productId);

        // Redirige al checkout
        return redirect()->route('carts.checkout');
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
