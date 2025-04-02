<?php

namespace App\Livewire;

use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SliderComponent extends Component
{
    public $sliders = [];

    public function mount()
    {
        $today = Carbon::now();

        $this->sliders = Slider::with('product')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();
    }

    public function addToCart($slider_id)
    {
        $slider = Slider::with('product')->findOrFail($slider_id);
        $cart = Session::get('cart', []);

        $precioOriginal = $slider->product->price;
        $descuento = $slider->discount ?? 0;
        $precioFinal = $precioOriginal - ($precioOriginal * ($descuento / 100));

        if (isset($cart[$slider->product_id])) {
            // Si ya está en el carrito, actualizamos el precio y aumentamos la cantidad
            $cart[$slider->product_id]['price'] = $precioFinal;
            $cart[$slider->product_id]['quantity'] += 1;
        } else {
            // Si el producto no está en el carrito, lo agregamos con cantidad 1
            $cart[$slider->product_id] = [
                'id' => $slider->product_id,
                'slug' => $slider->product->slug,
                'name' => $slider->product->name,
                'price' => $precioFinal,
                'image' => $slider->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        $this->dispatch('cartUpdated');
        $this->dispatch('showAlert', 'Producto agregado al carrito con descuento', 'success');

        $this->skipRender();
    }


    public function render()
    {
        return view('livewire.slider-component');
    }
}
