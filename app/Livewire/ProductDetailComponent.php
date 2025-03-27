<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Rating;
use App\Traits\CartTrait;
use App\Traits\ModalTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetailComponent extends Component
{
    use CartTrait, ModalTrait;
    public $product;
    public $relatedProducts = [];

    public $qualification = 0;
    public $comment;
    public $name;
    public $email;
    public $editingRatingId = null;

    protected $rules = [
        'qualification' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ];

    public function mount($productId)
    {
        $this->product = Product::with('category', 'images')->findOrFail($productId);
        $this->relatedProducts = Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $this->name = Auth::check() ? Auth::user()->name : '';
        $this->email = Auth::check() ? Auth::user()->email : '';
    }


    public function setRating($value)
    {
        $this->qualification = (int) $value;
        $this->dispatch('refreshComponent');
    }

    public function submit()
    {
        $this->validate();

        // Verificar si el usuario ya calificó este producto
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($existingRating) {
            // Actualizar la calificación existente
            $existingRating->update([
                'rating' => $this->qualification,
                'comment' => $this->comment,
            ]);
        } else {
            // Crear nueva calificación si no existe
            Rating::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'rating' => $this->qualification,
                'comment' => $this->comment,
            ]);
        }

        session()->flash('message', '¡Tu reseña ha sido guardada correctamente!');
        $this->reset(['qualification', 'comment', 'editingRatingId']);
    }


    public function editRating($id)
    {
        $rating = Rating::find($id);
        if ($rating && $rating->user_id == Auth::id()) {
            $this->editingRatingId = $id;
            $this->qualification = $rating->rating;
            $this->comment = $rating->comment;
        }
    }

    public function deleteRating($id)
    {
        $rating = Rating::find($id);
        if ($rating && $rating->user_id == Auth::id()) {
            $rating->delete();
            $this->product->getAverageRatingAttribute();
            $this->dispatch('refreshComponent');
        }
    }

    public function getRatingPercentages()
    {
        $totalRatings = $this->product->ratings()->count();

        $percentages = [];

        for ($i = 5; $i >= 1; $i--) {
            $count = $this->product->ratings()->where('rating', $i)->count();
            $percentages[$i] = $totalRatings > 0 ? round(($count / $totalRatings) * 100) : 0;
        }

        return $percentages;
    }

    public function render()
    {
        $ratings = $this->product->ratings()->latest()->get();
        return view('livewire.product-detail-component', compact('ratings'));
    }
}
