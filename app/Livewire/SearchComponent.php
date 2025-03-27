<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchComponent extends Component
{
    public $search = '';
    public $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->results = Product::where('name', 'like', '%' . $this->search . '%')
                ->limit(5)
                ->get();
        } else {
            $this->results = [];
        }
    }
    public function render()
    {
        return view('livewire.search-component');
    }
}
