<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Models\Product;
use Livewire\WithFileUploads;

class ProductComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $name, $slug, $description, $price, $discount_price, $stock, $sku, $status = 1, $image, $category_id, $brand_id;
    public $product_id, $isOpen = false;

    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';
    public array $brands = [];
    public array $categories = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:products,name,' . $this->product_id,
            'slug' => 'required|string|max:255|unique:products,slug,' . $this->product_id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $this->product_id,
            'status' => 'required|in:1,0',
            'image' => 'nullable|image|max:1024',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ];
    }

    public function mount()
    {
        $this->brands = Brand::all()->toArray();
        $this->categories = Category::all()->toArray();
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $products = Product::where('name', 'LIKE', $searchTerm)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('livewire.admin.product-component', compact('products'))
            ->extends('admin.layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->resetValidation();
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->price = '';
        $this->discount_price = '';
        $this->stock = '';
        $this->sku = '';
        $this->status = 1;
        $this->image = null;
        $this->category_id = null;
        $this->brand_id = null;
        $this->product_id = null;
    }

    public function store()
    {
        $this->slug = Str::slug($this->name);
        $validatedData = $this->validate();

        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            if ($this->product_id) {
                $existingProduct = Product::find($this->product_id);
                if ($existingProduct) {
                    $validatedData['image'] = $existingProduct->image;
                }
            }
        }
    
        Product::updateOrCreate(
            ['id' => $this->product_id],
            $validatedData
        );

        session()->flash('message', $this->product_id ? 'Producto actualizado.' : 'Producto creado.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->discount_price = $product->discount_price;
        $this->stock = $product->stock;
        $this->sku = $product->sku;
        $this->status = $product->status;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Product::find($valor['id'])->delete();
        session()->flash('message', 'Producto eliminado.');
    }
}