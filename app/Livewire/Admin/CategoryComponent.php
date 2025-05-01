<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CategoryComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $name, $slug, $image, $category_id;
    public $isOpen = false;

    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category_id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->category_id,
            'image' => 'nullable|image|max:1024'
        ];
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $categories = Category::where('name', 'LIKE', $searchTerm)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('livewire.admin.category-component', compact('categories'))
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
        $this->image = null;
        $this->category_id = null;
    }

    public function store()
    {
        $this->slug = Str::slug($this->name);
        $validatedData = $this->validate();

        if ($this->image) {
            $imagePath = $this->image->store('categories', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            if ($this->category_id) {
                $existingProduct = Category::find($this->category_id);
                if ($existingProduct) {
                    $validatedData['image'] = $existingProduct->image;
                }
            }
        }
    
        Category::updateOrCreate(
            ['id' => $this->category_id],
            $validatedData
        );

        session()->flash('message', $this->category_id ? 'Categoria actualizado.' : 'Categoria creado.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Category::find($valor['id'])->delete();
        session()->flash('message', 'Categoria eliminado.');
    }
}
