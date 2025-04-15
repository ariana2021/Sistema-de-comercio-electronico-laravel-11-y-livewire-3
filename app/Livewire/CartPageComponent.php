<?php

namespace App\Livewire;

use App\Models\Business;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\TemporaryCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartPageComponent extends Component
{
    public $carts = [];
    public $subtotal = 0;
    public $total = 0;
    public $shippingCost = 0;
    public $couponCode;
    public $business;

    public $listeners = ['updateShipping'];

    public function mount()
    {
        $this->business = Business::first();
    }

    public function updateQuantity($id, $change)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $change;

            if ($cart[$id]['quantity'] < 1) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
            $this->carts = $cart;
            $this->calculateTotals();
        }
    }


    public function removeItem($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);

            $this->dispatch('cartUpdated');
            $this->calculateTotals();
        }

        if (Auth::check()) {
            $this->updateDatabase();
        }
    }

    private function updateDatabase()
    {
        $userId = Auth::id();
        $cartData = Session::get('cart', []);
        $wishlistData = Session::get('wishlist', []);

        TemporaryCart::updateOrCreate(
            ['user_id' => $userId],
            ['cart_data' => $cartData, 'wishlist_data' => $wishlistData]
        );
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->couponCode)
            ->where('active', true)
            ->where(function ($query) {
                $query->whereNull('expiration_date')
                    ->orWhere('expiration_date', '>', now());
            })
            ->first();

        if (!$coupon) {
            session()->flash('error', 'Cupón no válido o expirado.');
            return;
        }

        // Verificar si aún tiene usos disponibles
        if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
            session()->flash('error', 'Este cupón ha alcanzado su límite de usos.');
            return;
        }

        $cart = Session::get('cart', []);
        $appliedCoupons = Session::get('applied_coupons', []);

        if (in_array($coupon->id, $appliedCoupons)) {
            session()->flash('error', 'Este cupón ya ha sido aplicado.');
            return;
        }

        // Aplicar el cupón solo a los productos relacionados
        foreach ($cart as $id => &$item) {
            $product = Product::find($id);
            if ($product && $product->coupons()->where('coupons.id', $coupon->id)->exists()) {
                if ($coupon->discount_type == 'fixed') {
                    $item['price'] -= $coupon->discount_value;
                } elseif ($coupon->discount_type == 'percentage') {
                    $item['price'] -= ($item['price'] * $coupon->discount_value / 100);
                }
                $item['price'] = max(0, $item['price']);
            }
        }

        // Guardar el cupón en la sesión
        $appliedCoupons[] = $coupon->id;
        Session::put('cart', $cart);
        Session::put('applied_coupons', $appliedCoupons);

        $this->carts = $cart;
        $this->calculateTotals();

        session()->flash('success', 'Cupón aplicado correctamente.');
    }


    public function updateShipping($cost, $lugar)
    {
        $this->shippingCost = $cost;
        session(['shipping_cost' => $cost]);
        session(['shipping_place' => $lugar]);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->carts)->sum(fn($cart) => $cart['price'] * $cart['quantity']);
        $this->total = $this->subtotal + $this->shippingCost;
    }

    public function render()
    {
        $this->carts = Session::get('cart', []);
        $this->calculateTotals();
        return view('livewire.cart-page-component', [
            'business' => $this->business
        ]);
    }
}
