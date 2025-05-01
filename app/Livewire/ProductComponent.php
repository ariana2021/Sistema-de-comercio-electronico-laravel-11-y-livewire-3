<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Traits\CartTrait;
use App\Traits\ModalTrait;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use CartTrait, ModalTrait, WithPagination;
    public $search = '';
    public $categorySelected = '';
    public $brandSelected = '';
    public $sortBy = 'latest';
    public $viewMode = 'grid';
    public $categories;
    public $brands;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
    }

    public function buyNow($productId)
    {
        $this->addToCart($productId);

        // Redirige al checkout
        return redirect()->route('carts.checkout');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingBrand()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function setCategory($categoryId)
    {
        $this->categorySelected = $categoryId;
    }

    public function setBrand($brandId)
    {
        $this->brandSelected = $brandId;
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->categorySelected) {
            $this->resetPage();
            $query->where('category_id', $this->categorySelected);
        }

        if ($this->brandSelected) {
            $this->resetPage();
            $query->where('brand_id', $this->brandSelected);
        }

        if ($this->sortBy == 'low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sortBy == 'high_low') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(6);

        return view('livewire.product-component', [
            'products' => $products,
            'categories' => $this->categories,
            'brands' => $this->brands,
        ])->with('viewMode', $this->viewMode);
    }
}
