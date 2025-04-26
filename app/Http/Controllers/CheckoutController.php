<?php

namespace App\Http\Controllers;

use App\Mail\VentaConfirmadaMail;
use App\Models\Business;
use App\Models\Cashback;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\TemporaryCart;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use MercadoPago\Client\MerchantOrder\MerchantOrderClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class CheckoutController extends Controller
{

    public function index()
    {
        $billingDetails = Auth::user()->billing_details ?? [];

        $first_name = $billingDetails['first_name'] ?? '';
        $last_name = $billingDetails['last_name'] ?? '';
        $email = $billingDetails['email'] ?? '';
        $phone = $billingDetails['phone'] ?? '';
        $address = $billingDetails['address'] ?? '';
        $city = $billingDetails['city'] ?? '';
        $zip_code = $billingDetails['zip_code'] ?? '';
        $order_notes = $billingDetails['order_notes'] ?? '';

        $cashbackDisponible = Cashback::where('user_id', Auth::id())
            ->where('status', 'available')
            ->sum('amount');

        $carts = Session::get('cart', []);
        if (empty($carts)) {
            return redirect()->to(route('carts.index'))->with('message', 'Tu carrito está vacío.');
        }

        $shippingCost = session('shipping_cost', 0.00);
        $shippingPlace = session('shipping_place', '');
        $cashback_usado = session('cashback_usado', 0.00);

        $subtotal = array_sum(array_map(fn($cart) => $cart['price'] * $cart['quantity'], $carts));
        $discount = session('discount', 0.00);
        $total = ($subtotal - $discount - $cashback_usado) + $shippingCost;
        // Creamos preferencia con Mercado Pago
        $preference_id = $this->createMercadoPagoPreference($carts, $shippingCost, $shippingPlace, $discount, $cashback_usado);

        $access_session = $this->generateAccessTokenNubiz();
        $session_token = $this->generateSessionTokenNubiz($access_session, $total);
        return view('principal.cart.payment', compact(
            'session_token',
            'first_name',
            'last_name',
            'email',
            'phone',
            'address',
            'city',
            'zip_code',
            'order_notes',
            'cashbackDisponible',
            'carts',
            'subtotal',
            'shippingCost',
            'shippingPlace',
            'cashback_usado',
            'discount',
            'total',
            'preference_id'
        ));
    }

    public function createMercadoPagoPreference($carts, $shippingCost, $shippingPlace, $discount, $cashback_usado)
    {
        try {
            if (empty($carts)) {
                session()->flash('error', 'El carrito está vacío.');
                return null;
            }

            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

            $client = new PreferenceClient();
            $items = [];

            $totalDiscount = $cashback_usado + $discount;
            $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $carts));

            foreach ($carts as $item) {
                $itemTotal = $item['price'] * $item['quantity'];

                if ($totalDiscount > 0 && $totalPrice > 0) {
                    $discountPerUnit = ($totalDiscount * $itemTotal / $totalPrice) / $item['quantity'];
                } else {
                    $discountPerUnit = 0;
                }

                $precio_producto = max(0.01, round($item['price'] - $discountPerUnit, 2));

                $items[] = [
                    "title" => $item['name'],
                    "quantity" => $item['quantity'],
                    "unit_price" => $precio_producto,
                    "currency_id" => "PEN"
                ];
            }

            if ($shippingCost > 0) {
                $items[] = [
                    "title" => "Costo de Envío",
                    "quantity" => 1,
                    "unit_price" => (float) $shippingCost,
                    "currency_id" => "PEN"
                ];
            }
            $back_url = [
                "success" => route('checkout.success', [], true),
                "failure" => route('checkout.failure', [], true),
                "pending" => route('checkout.pending', [], true)
            ];

            $preference = $client->create([
                "items" => $items,
                "back_urls" => $back_url,
                "notification_url" => route('webhook.mercadopago', [], true),
                "external_reference" => json_encode([
                    'user_id' => Auth::id(),
                    'shipping_cost' => $shippingCost,
                    'shipping_place' => $shippingPlace,
                    'applied_coupons' => session('applied_coupons', []),
                    'discount' => $discount,
                    'cashback_usado' => $cashback_usado,
                ]),
            ]);

            return $preference->id;
        }catch (MPApiException $e) {
            $apiResponse = $e->getApiResponse();
        
            Log::error('Error al generar la preferencia de pago', [
                'message' => $e->getMessage(),
                'status' => $apiResponse->getStatusCode(),
                'body' => $apiResponse->getContent(),
            ]);
        
            session()->flash('error', 'Error al generar la preferencia de pago.');
            return null;
        }
        
        
    }

    // public function handleWebhook(Request $request)
    // {
    //     $topic = $request->input('topic');
    //     $id = $request->input('id');

    //     if ($topic === 'merchant_order') {
    //         try {
    //             MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

    //             $client = new MerchantOrderClient();
    //             $merchantOrder = $client->get($id);

    //             // Validar referencia externa
    //             $external_reference = json_decode($merchantOrder->external_reference ?? '', true);
    //             $user_id = $external_reference['user_id'] ?? null;

    //             if (!$user_id) {
    //                 return response()->json(['error' => 'Referencia inválida'], 400);
    //             }

    //             // Prevenir duplicados
    //             if (Order::where('user_id', $user_id)->where('total', $merchantOrder->total_amount)->exists()) {
    //                 return response()->json(['status' => 'orden duplicada ignorada'], 200);
    //             }

    //             // Mapear productos comprados
    //             $carts = [];
    //             foreach ($merchantOrder->items as $item) {
    //                 $product = Product::where('name', 'LIKE', '%' . $item->title . '%')->first();
    //                 $product_id = $product?->id;

    //                 $carts[] = [
    //                     'id' => $product_id,
    //                     'name' => $item->title,
    //                     'price' => $item->unit_price,
    //                     'quantity' => $item->quantity,
    //                 ];
    //             }

    //             // Cálculos base
    //             $shippingCost = $external_reference['shipping_cost'] ?? 0;
    //             $shippingPlace = $external_reference['shipping_place'] ?? null;
    //             $discount = $external_reference['discount'] ?? 0;
    //             $applied_coupons = $external_reference['applied_coupons'] ?? [];
    //             $subtotal = collect($carts)->sum(fn($cart) => $cart['price'] * $cart['quantity']);

    //             // Validar cashback
    //             $cashbackDisponible = Cashback::where('user_id', $user_id)->where('status', 'available')->sum('amount');
    //             $cashbackUsado = min($external_reference['cashback_usado'] ?? 0, $cashbackDisponible);

    //             $total = ($subtotal - $discount - $cashbackUsado) + $shippingCost;
    //             $user = User::find($user_id);
    //             $billingDetails = $user?->billing_details ?? [];

    //             // Crear orden
    //             $order = Order::create([
    //                 'user_id' => $user_id,
    //                 'subtotal' => $subtotal,
    //                 'discount' => $discount,
    //                 'shipping_cost' => $shippingCost,
    //                 'shipping_place' => $shippingPlace,
    //                 'total' => $total,
    //                 'payment_method' => 'mercado_pago',
    //                 'status' => 'paid',
    //                 'billing_details' => $billingDetails
    //             ]);

    //             foreach ($carts as $item) {
    //                 // Ajustar inventario y ventas si se conoce el producto
    //                 if ($item['id']) {
    //                     $product = Product::find($item['id']);
    //                     if ($product) {
    //                         $product->decrement('stock', $item['quantity']);
    //                         $product->increment('sales_count', $item['quantity']);
    //                     }
    //                 }

    //                 $order->items()->create([
    //                     'product_id' => $item['id'],
    //                     'name' => $item['name'],
    //                     'price' => $item['price'],
    //                     'quantity' => $item['quantity'],
    //                     'total' => $item['price'] * $item['quantity'],
    //                 ]);
    //             }

    //             // Aplicar cupones
    //             if (!empty($applied_coupons)) {
    //                 foreach ($applied_coupons as $couponId) {
    //                     $coupon = Coupon::find($couponId);
    //                     if ($coupon && ($coupon->max_uses === null || $coupon->used_count < $coupon->max_uses)) {
    //                         $coupon->increment('used_count');

    //                         if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
    //                             $coupon->update(['active' => false]);
    //                         }
    //                     }
    //                 }
    //             }

    //             // Marcar cashback como usado
    //             if ($cashbackUsado > 0) {
    //                 $cashbacks = Cashback::where('user_id', $user_id)
    //                     ->where('status', 'available')
    //                     ->orderBy('created_at')
    //                     ->get();

    //                 $montoRestante = $cashbackUsado;
    //                 foreach ($cashbacks as $cashback) {
    //                     if ($montoRestante <= 0) break;

    //                     if ($cashback->amount <= $montoRestante) {
    //                         $montoRestante -= $cashback->amount;
    //                         $cashback->update(['status' => 'used']);
    //                     } else {
    //                         $cashback->update(['amount' => $cashback->amount - $montoRestante]);
    //                         $montoRestante = 0;
    //                     }
    //                 }
    //             }

    //             // Generar nuevo cashback
    //             $business = Business::first();
    //             $cashbackConfig = $business?->cashback_config;
    //             if ($cashbackConfig === null || empty($cashbackConfig['cashbacks'])) {
    //                 $cashbackPercentage = 0;
    //             } else {
    //                 $cashbackPercentage = 0;
    //                 foreach ($cashbackConfig['cashbacks'] as $cashback) {
    //                     if ($subtotal - $discount >= $cashback['min_amount']) {
    //                         $cashbackPercentage = $cashback['percentage'];
    //                     }
    //                 }
    //             }
    //             $cashbackAmount = (($subtotal - $discount) * $cashbackPercentage) / 100;

    //             if ($cashbackAmount > 0) {
    //                 Cashback::create([
    //                     'user_id' => $user_id,
    //                     'order_id' => $order->id,
    //                     'amount' => $cashbackAmount,
    //                     'status' => 'pending',
    //                 ]);
    //             }

    //             try {
    //                 Mail::to($user->email)->send(new VentaConfirmadaMail($order));
    //             } catch (\Exception $e) {
    //                 Log::error('Error al enviar correo: ' . $e->getMessage());
    //             }


    //             // Vaciar carrito temporal
    //             $tempCart = TemporaryCart::where('user_id', $user_id)->first();
    //             if ($tempCart) {
    //                 $tempCart->update(['cart_data' => []]);
    //             }

    //             return response()->json(['status' => 'ok'], 200);
    //         } catch (\Exception $e) {
    //             return response()->json(['error' => 'Error interno'], 500);
    //         }
    //     }

    //     return response()->json(['status' => 'ignorado'], 200);
    // }

    public function handleWebhook(Request $request)
    {
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
                    return response()->json(['error' => 'Referencia inválida'], 400);
                }

                // Prevenir duplicados
                if (Order::where('user_id', $user_id)->where('total', $merchantOrder->total_amount)->exists()) {
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
                }

                // Cálculos base
                $shippingCost = $external_reference['shipping_cost'] ?? 0;
                $shippingPlace = $external_reference['shipping_place'] ?? null;
                $discount = $external_reference['discount'] ?? 0;
                $applied_coupons = $external_reference['applied_coupons'] ?? [];
                $subtotal = collect($carts)->sum(fn($cart) => $cart['price'] * $cart['quantity']);
                $cashbackDisponible = Cashback::where('user_id', $user_id)->where('status', 'available')->sum('amount');
                $cashbackUsado = min($external_reference['cashback_usado'] ?? 0, $cashbackDisponible);

                $this->procesarPago($shippingCost, $shippingPlace, $discount, $applied_coupons, $subtotal, $user_id, 'Mercado Pago', $carts, $cashbackUsado);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error interno'], 500);
            }
        }

        return response()->json(['status' => 'ignorado'], 200);
    }

    private function procesarPago($shippingCost, $shippingPlace, $discount, $applied_coupons, $subtotal, $user_id, $payment_method, $carts, $cashbackUsado)
    {
        try {
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
                'payment_method' => $payment_method,
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
            $cashbackConfig = $business?->cashback_config;
            if ($cashbackConfig === null || empty($cashbackConfig['cashbacks'])) {
                $cashbackPercentage = 0;
            } else {
                $cashbackPercentage = 0;
                foreach ($cashbackConfig['cashbacks'] as $cashback) {
                    if ($subtotal - $discount >= $cashback['min_amount']) {
                        $cashbackPercentage = $cashback['percentage'];
                    }
                }
            }
            $cashbackAmount = (($subtotal - $discount) * $cashbackPercentage) / 100;

            if ($cashbackAmount > 0) {
                Cashback::create([
                    'user_id' => $user_id,
                    'order_id' => $order->id,
                    'amount' => $cashbackAmount,
                    'status' => 'pending',
                ]);
            }

            try {
                Mail::to($user->email)->send(new VentaConfirmadaMail($order));
                //Mail::to($user->email)->queue(new VentaConfirmadaMail($order));
            } catch (\Exception $e) {
                Log::error('Error al enviar correo: ' . $e->getMessage());
            }


            // Vaciar carrito temporal
            $tempCart = TemporaryCart::where('user_id', $user_id)->first();
            if ($tempCart) {
                $tempCart->update(['cart_data' => []]);
            }

            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno'], 500);
        }
    }

    public function paidNiubiz(Request $request)
    {
        $access_session = $this->generateAccessTokenNubiz();
        $merchantId = config('services.niubiz.merchantId');
        $url_api = config('services.niubiz.url_api') . "/api.authorization/v3/authorization/ecommerce/{$merchantId}";
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $access_session
        ])->post($url_api, [
            'channel' => 'web',
            'captureType' => 'manual',
            'countable' => true,
            'order' => [
                'tokenId' => $request->transactionToken,
                'purchaseNumber' => $request->purchaseNumber,
                'amount' => $request->amount,
                'currency' => 'PEN',
            ]
        ])->json();
        session()->flash('niubiz', [
            'response' => $response,
            'purchaseNumber' => $request->purchaseNumber,
        ]);
        if (isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] == "000") {
            $carts = Session::get('cart', []);
            $user_id = Auth::id();
            $shippingCost = session('shipping_cost', 0.00);
            $shippingPlace = session('shipping_place', '');
            $cashback_usado = session('cashback_usado', 0.00);
            $applied_coupons = session('applied_coupons', []);
            $cashbackDisponible = Cashback::where('user_id', $user_id)->where('status', 'available')->sum('amount');
            $cashbackUsado = min($cashback_usado ?? 0, $cashbackDisponible);
            $subtotal = array_sum(array_map(fn($cart) => $cart['price'] * $cart['quantity'], $carts));
            $discount = session('discount', 0.00);
            $this->procesarPago($shippingCost, $shippingPlace, $discount, $applied_coupons, $subtotal, $user_id, 'Niubiz', $carts, $cashbackUsado);
            return to_route('checkout.thank-you');
        }

        return to_route('checkout.failure');
    }

    public function success()
    {
        return redirect()->route('checkout.thank-you')->with('success', 'Pago confirmado, tu pedido ha sido registrado.');
    }

    public function generateAccessTokenNubiz()
    {
        $url_api = config('services.niubiz.url_api') . '/api.security/v1/security';
        $user = config('services.niubiz.user');
        $password = config('services.niubiz.password');

        $auth = base64_encode($user . ':' . $password);
        return Http::withHeaders([
            'Authorization' => 'Basic ' . $auth
        ])->get($url_api)->body();
    }

    public function generateSessionTokenNubiz($access_token, $total)
    {
        $merchantId = config('services.niubiz.merchantId');
        $url_api = config('services.niubiz.url_api') . "/api.ecommerce/v2/ecommerce/token/session/{$merchantId}";
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $access_token
        ])->post($url_api, [
            'channel' => 'web',
            'amount' => $total,
            'antifraud' => [
                'clientIp' => request()->ip(),
                "merchantDefineData" => [
                    "MDD4" => "integraciones@niubiz.com.pe",
                    "MDD32" => "JD1892639123",
                    "MDD75" => "Registrado",
                    "MDD77" => 458
                ]
            ]
        ])->json();

        return $response['sessionKey'];
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
