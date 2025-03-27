<?php

namespace App\Traits;

use App\Models\Product;

trait ModalTrait
{
    public $isOpen = false;
    public $productView;
    public $images = [];
    public $quantity = 1;

    public function openModal($product_id)
    {
        $this->productView = Product::with('images')->find($product_id);

        if ($this->productView) {
            $this->images = $this->productView->images->pluck('url')->toArray();
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->productView = null;
        $this->images = [];
        $this->quantity = 1;
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }
}