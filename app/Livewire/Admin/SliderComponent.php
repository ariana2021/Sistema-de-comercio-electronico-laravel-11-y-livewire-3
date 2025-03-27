<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class SliderComponent extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $description, $image, $product_id, $discount, $button_url, $status = 1;
    public $start_date, $end_date;
    public $searchProducts = '';
    public $searchSliders = '';
    public $sliderId, $oldImage;
    public $isUploading = false;
    protected $paginationTheme = 'bootstrap';
    
    protected $rules = [
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'product_id' => 'required|exists:products,id',
        'discount' => 'nullable|numeric|min:0',
        'button_url' => 'nullable|url',
        'status' => 'boolean',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function updatedImage()
    {
        $this->isUploading = true;
    }

    public function selectProduct($productId)
    {
        $this->product_id = $productId;
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $this->sliderId = $slider->id;
        $this->title = $slider->title;
        $this->description = $slider->description;
        $this->product_id = $slider->product_id;
        $this->discount = $slider->discount;
        $this->button_url = $slider->button_url;
        $this->status = $slider->status;
        $this->start_date = $slider->start_date;
        $this->end_date = $slider->end_date;
        $this->oldImage = $slider->image;

        $this->dispatch('show-modal');
    }

    public function save()
    {
        $this->validate();

        $imagePath = $this->oldImage;
        if ($this->image) {
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->image->store('sliders', 'public');
            $this->isUploading = false;
        }

        Slider::updateOrCreate(
            ['id' => $this->sliderId],
            [
                'title' => $this->title,
                'description' => $this->description,
                'image' => $imagePath,
                'product_id' => $this->product_id,
                'discount' => $this->discount,
                'button_url' => $this->button_url,
                'status' => $this->status,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]
        );

        session()->flash('message', 'Slider saved successfully!');
        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        $slider = Slider::findOrFail($id);
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        session()->flash('message', 'Slider deleted successfully!');
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'image', 'product_id', 'discount', 'button_url', 'status', 'start_date', 'end_date', 'searchProducts', 'searchSliders', 'sliderId', 'oldImage', 'isUploading']);
    }

    public function render()
    {
        return view('livewire.admin.slider-component', [
            'products' => Product::where('name', 'like', "%{$this->searchProducts}%")->paginate(5),
            'sliders' => Slider::where('title', 'like', "%{$this->searchSliders}%")->paginate(5),
        ])->extends('admin.layouts.app');
    }
}
