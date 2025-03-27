<?php

namespace App\Livewire;

use App\Models\Category;
use App\Traits\CartTrait;
use App\Traits\ModalTrait;
use Livewire\Component;

class CategoryProductComponent extends Component
{
    use CartTrait, ModalTrait;

    public $category;

    public function mount($categoryId)
    {
        $this->category = Category::with('products')->findOrFail($categoryId);
    }

    public function render()
    {
        return view('livewire.category-product-component');
    }
}

