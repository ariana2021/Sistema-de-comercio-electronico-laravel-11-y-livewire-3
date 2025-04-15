<?php

namespace App\Livewire;

use App\Models\Cashback;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class PaymentComponent extends Component
{
    public $first_name, $last_name, $email, $phone, $address, $city, $zip_code, $order_notes;
    public $carts = [];
    public $subtotal;
    public $shippingCost;
    public $total;
    public $coupon, $cashbackDisponible;
    public $discount = 0;
    public $cashback_usado = 0;
    public $preference_id;
    public $shippingPlace = '';

    public function mount()
    {
        $billingDetails = Auth::user()->billing_details ?? [];
        $this->first_name = $billingDetails['first_name'] ?? '';
        $this->last_name = $billingDetails['last_name'] ?? '';
        $this->email = $billingDetails['email'] ?? '';
        $this->phone = $billingDetails['phone'] ?? '';
        $this->address = $billingDetails['address'] ?? '';
        $this->city = $billingDetails['city'] ?? '';
        $this->zip_code = $billingDetails['zip_code'] ?? '';
        $this->order_notes = $billingDetails['order_notes'] ?? '';

        $this->cashbackDisponible = Cashback::where('user_id', Auth::id())
            ->where('status', 'available')
            ->sum('amount');

        $this->carts = Session::get('cart', []);

        if (empty($this->carts)) {
            return redirect()->to(route('carts.index'))->with('message', 'Tu carrito está vacío.');
        }

        $this->shippingCost = session('shipping_cost', 0.00);
        $this->shippingPlace = session('shipping_place', '');
        $this->cashback_usado = session('cashback_usado', 0.00);
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

            $totalDiscount = 0;

            if ($this->cashback_usado > 0) {
                $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->carts));
                $totalDiscount = $this->cashback_usado;
            }

            foreach ($this->carts as $item) {
                $precio_producto = (float) $item['price'];
                if ($totalDiscount > 0) {
                    $discountPerProduct = $totalDiscount / $totalPrice * $item['price'];
                    $precio_producto -= $discountPerProduct;
                }

                $items[] = [
                    "title" => $item['name'],
                    "quantity" => $item['quantity'],
                    "unit_price" => $precio_producto,
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
                "notification_url" => route('webhook.mercadopago', [], true),
                "auto_return" => "approved",
                "external_reference" => json_encode([
                    'user_id' => Auth::id(),
                    'shipping_cost' => session('shipping_cost', 0.00),
                    'shipping_place' => session('shipping_place', ''),
                    'applied_coupons' => session('applied_coupons', 0.00),
                    'discount' => session('discount', 0.00),
                    'cashback_usado' => $this->cashback_usado,
                ]),
            ]);

            $this->preference_id = $preference->id;
        } catch (MPApiException $e) {
            session()->flash('error', 'Error al generar la preferencia de pago.');
        }
    }

    public function calculateTotal()
    {
        $this->subtotal = array_sum(array_map(fn($cart) => $cart['price'] * $cart['quantity'], $this->carts));
        $this->total = ($this->subtotal - $this->discount - $this->cashback_usado) + $this->shippingCost;
    }

    public function render()
    {
        return view('livewire.payment-component');
    }
}
