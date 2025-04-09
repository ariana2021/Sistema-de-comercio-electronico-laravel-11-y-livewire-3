<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Cashback;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\TemporaryCart;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('principal.cart.payment');
    }

    public function checkoutSuccess(Request $request)
    {
        $external_reference = json_decode($request->input('external_reference'), true);

        // Verifica si la conversión fue exitosa
        if (!$external_reference || !isset($external_reference['user_id'])) {
            return redirect()->route('carts.index')->with('error', 'Datos de pago inválidos.');
        }

        // Buscar el carrito del usuario
        $cart = TemporaryCart::where('user_id', $external_reference['user_id'])->first();

        if (!$cart) {
            return redirect()->route('carts.index')->with('error', 'Tu carrito está vacío.');
        }

        $carts = $cart->cart_data;
        $shippingCost = $external_reference['shipping_cost'];
        $discount = $external_reference['discount'];
        $user = User::find($external_reference['user_id']);
        if ($user) {
            $billingDetails = $user->billing_details;
        } else {
            $billingDetails = [];
        }
        $applied_coupons = $external_reference['applied_coupons'] ?? null;
        $subtotal = collect($carts)->sum(fn($cart) => $cart['price'] * $cart['quantity']);
        $cashbackUsado = min($external_reference['cashback_usado'] ?? 0, Cashback::where('user_id', $external_reference['user_id'])->where('status', 'available')->sum('amount'));
        $total = ($subtotal - $discount - $cashbackUsado) + $shippingCost;

        try {
            // ✅ Crear la orden en la base de datos
            $order = Order::create([
                'user_id' => $external_reference['user_id'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'payment_method' => 'mercado_pago',
                'status' => 'paid',
                'billing_details' => $billingDetails
            ]);

            foreach ($carts as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    // Restar stock
                    $product->decrement('stock', $item['quantity']);

                    // Sumar ventas
                    $product->increment('sales_count', $item['quantity']);
                }
                $order->items()->create([
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            $cuponesIds = $applied_coupons ?? [];

            if (!empty($cuponesIds)) {
                foreach ($cuponesIds as $couponId) {
                    $coupon = Coupon::find($couponId);
                    if ($coupon && ($coupon->max_uses === null || $coupon->used_count < $coupon->max_uses)) {
                        $coupon->increment('used_count');

                        // Si el cupón alcanzó su límite, desactivarlo
                        if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
                            $coupon->update(['active' => false]);
                        }
                    }
                }
            }

            if ($cashbackUsado > 0) {
                $cashbacks = Cashback::where('user_id', $external_reference['user_id'])
                    ->where('status', 'available')
                    ->orderBy('created_at')
                    ->get();

                $montoRestante = $cashbackUsado;
                foreach ($cashbacks as $cashback) {
                    if ($montoRestante <= 0) break;

                    if ($cashback->amount <= $montoRestante) {
                        $montoRestante -= $cashback->amount;
                        $cashback->update(['status' => 'used']);
                    } else {
                        $cashback->update(['amount' => $cashback->amount - $montoRestante]);
                        $montoRestante = 0;
                    }
                }
            }
            $business = Business::first();
            $cashbackPercentage = $business ? $business->cashback_percentage : 0;

            $cashbackAmount = ($subtotal * $cashbackPercentage) / 100;

            if ($cashbackAmount > 0) {
                Cashback::create([
                    'user_id' => $external_reference['user_id'],
                    'order_id' => $order->id,
                    'amount' => $cashbackAmount,
                    'status' => 'pending',
                ]);
            }

            $cart->cart_data = [];
            $cart->save();

            return redirect()->route('checkout.thank-you')->with('success', 'Pago confirmado, tu pedido ha sido registrado.');
        } catch (Exception $e) {
            return redirect()->route('checkout.failure')->with('error', 'Hubo un problema al procesar el pago.');
        }
    }


    public function failure()
    {
        return view('principal.cart.failure');
    }

    public function pending()
    {
        return view('principal.cart.pending');
    }

    public function thankyou()
    {
        // ✅ Limpiar la sesión aquí
        session()->forget(['cart', 'discount', 'shipping_cost', 'billing_details']);
        session()->save();
        session()->regenerate();

        return view('principal.cart.thank-you');
    }
}
