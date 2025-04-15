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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\MerchantOrder\MerchantOrderClient;
use MercadoPago\MercadoPagoConfig;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('principal.cart.payment');
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook recibido:', $request->all());

        $topic = $request->input('topic');
        $id = $request->input('id');

        if ($topic === 'merchant_order') {
            try {
                MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

                $client = new MerchantOrderClient();
                $merchantOrder = $client->get($id);

                // Validar referencia externa
                $external_reference = json_decode($merchantOrder->external_reference ?? '', true);
                $user_id = $external_reference['user_id'] ?? null;

                if (!$user_id) {
                    Log::warning('External reference inválido o sin user_id');
                    return response()->json(['error' => 'Referencia inválida'], 400);
                }

                // Prevenir duplicados
                if (Order::where('user_id', $user_id)->where('total', $merchantOrder->total_amount)->exists()) {
                    Log::info("Orden ya registrada anteriormente para el user_id $user_id");
                    return response()->json(['status' => 'orden duplicada ignorada'], 200);
                }

                // Mapear productos comprados
                $carts = [];
                foreach ($merchantOrder->items as $item) {
                    $product = Product::where('name', 'LIKE', '%' . $item->title . '%')->first();
                    $product_id = $product?->id;

                    $carts[] = [
                        'id' => $product_id,
                        'name' => $item->title,
                        'price' => $item->unit_price,
                        'quantity' => $item->quantity,
                    ];

                    Log::info("Producto comprado:", [
                        'title' => $item->title,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                    ]);
                }

                // Cálculos base
                $shippingCost = $external_reference['shipping_cost'] ?? 0;
                $shippingPlace = $external_reference['shipping_place'] ?? null;
                $discount = $external_reference['discount'] ?? 0;
                $applied_coupons = $external_reference['applied_coupons'] ?? [];
                $subtotal = collect($carts)->sum(fn($cart) => $cart['price'] * $cart['quantity']);

                // Validar cashback
                $cashbackDisponible = Cashback::where('user_id', $user_id)->where('status', 'available')->sum('amount');
                $cashbackUsado = min($external_reference['cashback_usado'] ?? 0, $cashbackDisponible);

                $total = ($subtotal - $discount - $cashbackUsado) + $shippingCost;
                $user = User::find($user_id);
                $billingDetails = $user?->billing_details ?? [];

                // Crear orden
                $order = Order::create([
                    'user_id' => $user_id,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'shipping_cost' => $shippingCost,
                    'shipping_place' => $shippingPlace,
                    'total' => $total,
                    'payment_method' => 'mercado_pago',
                    'status' => 'paid',
                    'billing_details' => $billingDetails
                ]);

                foreach ($carts as $item) {
                    // Ajustar inventario y ventas si se conoce el producto
                    if ($item['id']) {
                        $product = Product::find($item['id']);
                        if ($product) {
                            $product->decrement('stock', $item['quantity']);
                            $product->increment('sales_count', $item['quantity']);
                        }
                    }

                    $order->items()->create([
                        'product_id' => $item['id'],
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'total' => $item['price'] * $item['quantity'],
                    ]);
                }

                // Aplicar cupones
                if (!empty($applied_coupons)) {
                    foreach ($applied_coupons as $couponId) {
                        $coupon = Coupon::find($couponId);
                        if ($coupon && ($coupon->max_uses === null || $coupon->used_count < $coupon->max_uses)) {
                            $coupon->increment('used_count');

                            if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
                                $coupon->update(['active' => false]);
                            }
                        }
                    }
                }

                // Marcar cashback como usado
                if ($cashbackUsado > 0) {
                    $cashbacks = Cashback::where('user_id', $user_id)
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

                // Generar nuevo cashback
                $business = Business::first();
                $cashbackPercentage = $business?->cashback_percentage ?? 0;
                $cashbackAmount = ($subtotal * $cashbackPercentage) / 100;

                if ($cashbackAmount > 0) {
                    Cashback::create([
                        'user_id' => $user_id,
                        'order_id' => $order->id,
                        'amount' => $cashbackAmount,
                        'status' => 'pending',
                    ]);
                }

                // Vaciar carrito temporal
                $tempCart = TemporaryCart::where('user_id', $user_id)->first();
                if ($tempCart) {
                    $tempCart->update(['cart_data' => []]);
                }

                Log::info('Orden creada exitosamente desde webhook', ['order_id' => $order->id]);

                return response()->json(['status' => 'ok'], 200);
            } catch (\Exception $e) {
                Log::error('Error al procesar merchant_order:', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Error interno'], 500);
            }
        }

        return response()->json(['status' => 'ignorado'], 200);
    }



    public function checkoutSuccess()
    {
        return redirect()->route('checkout.thank-you')->with('success', 'Pago confirmado, tu pedido ha sido registrado.');

        // $external_reference = json_decode($request->input('external_reference'), true);

        // // Verifica si la conversión fue exitosa
        // if (!$external_reference || !isset($external_reference['user_id'])) {
        //     return redirect()->route('carts.index')->with('error', 'Datos de pago inválidos.');
        // }

        // // Buscar el carrito del usuario
        // $cart = TemporaryCart::where('user_id', $external_reference['user_id'])->first();

        // if (!$cart) {
        //     return redirect()->route('carts.index')->with('error', 'Tu carrito está vacío.');
        // }

        // $carts = $cart->cart_data;
        // $shippingCost = $external_reference['shipping_cost'];
        // $discount = $external_reference['discount'];
        // $user = User::find($external_reference['user_id']);
        // if ($user) {
        //     $billingDetails = $user->billing_details;
        // } else {
        //     $billingDetails = [];
        // }
        // $applied_coupons = $external_reference['applied_coupons'] ?? null;
        // $subtotal = collect($carts)->sum(fn($cart) => $cart['price'] * $cart['quantity']);
        // $cashbackUsado = min($external_reference['cashback_usado'] ?? 0, Cashback::where('user_id', $external_reference['user_id'])->where('status', 'available')->sum('amount'));
        // $total = ($subtotal - $discount - $cashbackUsado) + $shippingCost;

        // try {
        //     // ✅ Crear la orden en la base de datos
        //     $order = Order::create([
        //         'user_id' => $external_reference['user_id'],
        //         'subtotal' => $subtotal,
        //         'discount' => $discount,
        //         'shipping_cost' => $shippingCost,
        //         'total' => $total,
        //         'payment_method' => 'mercado_pago',
        //         'status' => 'paid',
        //         'billing_details' => $billingDetails
        //     ]);

        //     foreach ($carts as $item) {
        //         $product = Product::find($item['id']);
        //         if ($product) {
        //             // Restar stock
        //             $product->decrement('stock', $item['quantity']);

        //             // Sumar ventas
        //             $product->increment('sales_count', $item['quantity']);
        //         }
        //         $order->items()->create([
        //             'product_id' => $item['id'],
        //             'name' => $item['name'],
        //             'price' => $item['price'],
        //             'quantity' => $item['quantity'],
        //             'total' => $item['price'] * $item['quantity'],
        //         ]);
        //     }

        //     $cuponesIds = $applied_coupons ?? [];

        //     if (!empty($cuponesIds)) {
        //         foreach ($cuponesIds as $couponId) {
        //             $coupon = Coupon::find($couponId);
        //             if ($coupon && ($coupon->max_uses === null || $coupon->used_count < $coupon->max_uses)) {
        //                 $coupon->increment('used_count');

        //                 // Si el cupón alcanzó su límite, desactivarlo
        //                 if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
        //                     $coupon->update(['active' => false]);
        //                 }
        //             }
        //         }
        //     }

        //     if ($cashbackUsado > 0) {
        //         $cashbacks = Cashback::where('user_id', $external_reference['user_id'])
        //             ->where('status', 'available')
        //             ->orderBy('created_at')
        //             ->get();

        //         $montoRestante = $cashbackUsado;
        //         foreach ($cashbacks as $cashback) {
        //             if ($montoRestante <= 0) break;

        //             if ($cashback->amount <= $montoRestante) {
        //                 $montoRestante -= $cashback->amount;
        //                 $cashback->update(['status' => 'used']);
        //             } else {
        //                 $cashback->update(['amount' => $cashback->amount - $montoRestante]);
        //                 $montoRestante = 0;
        //             }
        //         }
        //     }
        //     $business = Business::first();
        //     $cashbackPercentage = $business ? $business->cashback_percentage : 0;

        //     $cashbackAmount = ($subtotal * $cashbackPercentage) / 100;

        //     if ($cashbackAmount > 0) {
        //         Cashback::create([
        //             'user_id' => $external_reference['user_id'],
        //             'order_id' => $order->id,
        //             'amount' => $cashbackAmount,
        //             'status' => 'pending',
        //         ]);
        //     }

        //     $cart->cart_data = [];
        //     $cart->save();

        //     return redirect()->route('checkout.thank-you')->with('success', 'Pago confirmado, tu pedido ha sido registrado.');
        // } catch (Exception $e) {
        //     return redirect()->route('checkout.failure')->with('error', 'Hubo un problema al procesar el pago.');
        // }
    }


    public function listHistory()
    {
        $response = Http::withToken(config('services.mercadopago.access_token'))
            ->get('https://api.mercadopago.com/v1/payments/search', [
                'sort' => 'date_created',
                'criteria' => 'desc',
                'limit' => 100,
            ]);

        $lists = $response->json();
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
