<?php

namespace App\Livewire\Admin;

use App\Models\Rating;
use Livewire\Component;
use Livewire\WithPagination;

class RatingComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleFeatured($ratingId)
    {
        $rating = Rating::find($ratingId);
        if ($rating) {
            $rating->featured = !$rating->featured;
            $rating->save();
        }
    }
    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Rating::find($valor['id'])->delete();
        session()->flash('message', 'Calificación eliminado.');
    }

    public function render()
    {
        $ratings = Rating::with(['user', 'product'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orWhereHas('product', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.rating-component', [
            'ratings' => $ratings,
        ])->extends('admin.layouts.app');
    }
}
