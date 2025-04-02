<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class PostComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $title, $slug, $content, $status = 1, $image, $category_id;
    public $post_id, $isOpen = false;

    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';
    public array $categories = [];
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:posts,title,' . $this->post_id,
            'slug' => 'required|string|max:255|unique:posts,slug,' . $this->post_id,
            'content' => 'nullable|string',
            'status' => 'required|in:1,0',
            'image' => 'nullable|image|max:1024',
            'category_id' => 'required|exists:categories,id'
        ];
    }

    public function mount()
    {
        $this->categories = Category::all()->toArray();
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->title);
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
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->status = 1;
        $this->image = null;
        $this->category_id = null;
        $this->post_id = null;
    }

    public function store()
    {
        $this->slug = Str::slug($this->title);
        $validatedData = $this->validate();

        if ($this->image) {
            $imagePath = $this->image->store('posts', 'public');
            $validatedData['image'] = $imagePath;
        } else {
            if ($this->post_id) {
                $existingProduct = Post::find($this->post_id);
                if ($existingProduct) {
                    $validatedData['image'] = $existingProduct->image;
                }
            }
        }

        $validatedData['user_id'] = Auth::id();

        Post::updateOrCreate(
            ['id' => $this->post_id],
            $validatedData
        );

        session()->flash('message', $this->post_id ? 'Entrada actualizado.' : 'Entrada creado.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;
        $this->status = $post->status;
        $this->category_id = $post->category_id;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Post::find($valor['id'])->delete();
        session()->flash('message', 'Entrada eliminado.');
    }
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $posts = Post::where('title', 'LIKE', $searchTerm)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('livewire.admin.post-component', compact('posts'))
            ->extends('admin.layouts.app');
    }
}
