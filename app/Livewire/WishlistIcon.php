<?php

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class WishlistIcon extends Component
{
    public $wishlistTotal = 0;

    protected $listeners = ['wishlistUpdated' => 'updateWishlistTotal'];

    public function mount()
    {
        $this->updateWishlistTotal();
    }

    public function updateWishlistTotal()
    {
        $wishlist = Session::get('wishlist', []);
        $this->wishlistTotal = count($wishlist);
    }

    public function render()
    {
        return view('livewire.wishlist-icon');
    }
}