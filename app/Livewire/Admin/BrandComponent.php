<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $slug;
    public $brand_id, $isOpen = false;

    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name,' . $this->brand_id,
            'slug' => 'required|string|max:255|unique:brands,slug,' . $this->brand_id,
        ];
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $brands = Brand::where('name', 'LIKE', $searchTerm)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('livewire.admin.brand-component', compact('brands'))
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
        $this->brand_id = null;
    }

    public function store()
    {
        $this->slug = Str::slug($this->name);
        $validatedData = $this->validate();

        Brand::updateOrCreate(
            ['id' => $this->brand_id],
            $validatedData
        );

        session()->flash('message', $this->brand_id ? 'Marca actualizada.' : 'Marca creada.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brand_id = $id;
        $this->name = $brand->name;
        $this->slug = $brand->slug;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Brand::find($valor['id'])->delete();
        session()->flash('message', 'Marca eliminada.');
    }
}

