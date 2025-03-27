<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class CheckoutComponent extends Component
{
    public $first_name, $last_name, $company, $country, $address, $apartment, $city, $state, $postcode, $phone, $email, $order_notes;
    public $carts = [];
    public $subtotal;
    public $shippingCost;
    public $total;
    public $coupon;
    public $discount = 0;
    public $preference_id;
    public $isConfirmed = false;

    public function mount()
    {
        $this->carts = Session::get('cart', []);

        if (empty($this->carts)) {
            return redirect()->to(route('carts.index'))->with('message', 'Tu carrito está vacío.');
        }

        $this->shippingCost = session('shipping_cost', 0.00);
        $this->subtotal = array_sum(array_map(fn($cart) => $cart['price'] * $cart['quantity'], $this->carts));
        $this->calculateTotal();
        $this->createMercadoPagoPreference();
    }

    public function createMercadoPagoPreference()
    {
        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

            $client = new PreferenceClient();
            $items = [];

            foreach ($this->carts as $item) {
                $items[] = [
                    "title" => $item['name'],
                    "quantity" => $item['quantity'],
                    "unit_price" => (float) $item['price'],
                    "currency_id" => "PEN"
                ];
            }

            if ($this->shippingCost > 0) {
                $items[] = [
                    "title" => "Costo de Envío",
                    "quantity" => 1,
                    "unit_price" => (float) $this->shippingCost,
                    "currency_id" => "PEN"
                ];
            }

            $preference = $client->create([
                "items" => $items,
                "back_urls" => [
                    "success" => route('checkout.success', [], true),
                    "failure" => route('checkout.failure', [], true),
                    "pending" => route('checkout.pending', [], true)
                ],
                "auto_return" => "approved",
                "external_reference" => json_encode([
                    'user_id' => Auth::id(),
                    'shipping_cost' => session('shipping_cost', 0.00),
                    'applied_coupons' => session('applied_coupons', 0.00),
                    'discount' => session('discount', 0.00),
                    'billing_details' => session('billing_details', [])
                ]),
            ]);

            $this->preference_id = $preference->id;
        } catch (MPApiException $e) {
            session()->flash('error', 'Error al generar la preferencia de pago.');
        }
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

    public function render()
    {
        return view('livewire.checkout-component');
    }
}
