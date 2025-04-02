<?php

namespace App\Livewire;

use App\Models\Cashback;
use Livewire\Component;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutComponent extends Component
{
    public $first_name, $last_name, $email, $phone, $address, $city, $zip_code, $order_notes;
    public $isConfirmed = false;

    public $carts = [];
    public $subtotal;
    public $shippingCost;
    public $total;
    public $coupon, $cashbackDisponible;
    public $discount = 0;
    public $cashback_usado = 0;

    public function mount()
    {
        $this->first_name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->address = Auth::user()->address;
        $this->cashbackDisponible = Cashback::where('user_id', Auth::id())
            ->where('status', 'available')
            ->sum('amount');
        $this->carts = Session::get('cart', []);

        if (empty($this->carts)) {
            return redirect()->to(route('carts.index'))->with('message', 'Tu carrito está vacío.');
        }

        $this->shippingCost = session('shipping_cost', 0.00);
        $this->subtotal = array_sum(array_map(fn($cart) => $cart['price'] * $cart['quantity'], $this->carts));
        $this->calculateTotal();
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon)->where('active', true)->first();

        if (!$coupon) {
            session()->flash('error', 'Cupón no válido o expirado.');
            return;
        }

        $cart = Session::get('cart', []);
        $appliedCoupons = Session::get('applied_coupons', []);

        if (in_array($coupon->id, $appliedCoupons)) {
            session()->flash('error', 'Este cupón ya ha sido aplicado.');
            return;
        }

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product && $product->coupons()->where('coupons.id', $coupon->id)->exists()) {
                if ($coupon->discount_type == 'fixed') {
                    $cart[$id]['price'] -= $coupon->discount_value;
                } elseif ($coupon->discount_type == 'percent') {
                    $cart[$id]['price'] -= ($cart[$id]['price'] * $coupon->discount_value / 100);
                }
                $cart[$id]['price'] = max(0, $cart[$id]['price']);
            }
        }

        $appliedCoupons[] = $coupon->id;
        Session::put('cart', $cart);
        Session::put('applied_coupons', $appliedCoupons);

        $this->carts = $cart;
        $this->calculateTotal();

        session()->flash('success', 'Cupón aplicado correctamente.');
    }

    public function calculateTotal()
    {
        $this->subtotal = array_sum(array_map(fn($cart) => $cart['price'] * $cart['quantity'], $this->carts));
        $this->total = ($this->subtotal - $this->discount) + $this->shippingCost;
    }

    public function checkoutSuccess()
    {
        // Validación de los campos
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:9|max:15',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'order_notes' => 'nullable|string|max:500', // Si tienes notas opcionales
            'isConfirmed' => 'accepted', // Asegúrate de que la orden esté confirmada (checkbox)
        ], [
            // Personalización de mensajes de error (opcional)
            'first_name.required' => 'El nombre es obligatorio.',
            'email.email' => 'Por favor ingresa un correo electrónico válido.',
            'phone.min' => 'El teléfono debe tener al menos 10 caracteres.',
            'isConfirmed.accepted' => 'Debes confirmar que la información es correcta.',
        ]);

        // Si pasa la validación, continúas con el proceso
        try {
            session()->put('cashback_usado', $this->cashback_usado);

            session()->put('billing_details', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'zip_code' => $this->zip_code,
                'order_notes' => $this->order_notes,
            ]);

            return redirect()->route('payment.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al procesar tu compra.');
        }
    }

    public function render()
    {
        return view('livewire.checkout-component');
    }
}
