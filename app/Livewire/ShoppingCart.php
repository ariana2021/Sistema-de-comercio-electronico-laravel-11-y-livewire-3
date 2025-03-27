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
        $this->categories = Category::orderBy('id', 'desc')->get();

        // Obtener 8 productos recientes por cada categoría
        $this->categories->each(function ($category) {
            $category->setRelation('products', $category->products()->latest()->take(8)->get());
        });
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
