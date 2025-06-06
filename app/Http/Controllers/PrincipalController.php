<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Business;
use App\Models\Category;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Service;
use App\Models\TemporaryCart;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PrincipalController extends Controller
{

    public function index()
    {
        $ratings = Rating::with('user')
            ->where('featured', true)
            ->latest()
            ->take(10)
            ->get();
        $business = Business::first();

        $services = Service::all();

        return view('principal.home.index', compact('ratings', 'business', 'services'));
    }

    public function us()
    {
        $historia = AboutUs::where('type', 'historia')->first();
        $mision = AboutUs::where('type', 'mision')->first();
        $vision = AboutUs::where('type', 'vision')->first();
        $users = User::whereHas('roles')->get();
        return view('principal.us', compact('historia', 'mision', 'vision', 'users'));
    }

    public function terminos()
    {
        $page = Page::where('slug', 'terminos')->firstOrFail();
        return view('legales.terminos', compact('page'));
    }

    public function privacidad()
    {
        $page = Page::where('slug', 'privacidad')->firstOrFail();
        return view('legales.privacidad', compact('page'));
    }


    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();

        return view('principal.home.categories', compact('category'));
    }

    public function products()
    {
        return view('principal.home.products');
    }

    public function product($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->first();
        return view('principal.home.product-detail', compact('product'));
    }

    public function profile()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)->orderBy('id', 'desc')->get();
        $ordersCount = $orders->count();

        $wishlistData = TemporaryCart::where('user_id', $userId)->first();

        $wishlist = $wishlistData ? $wishlistData->wishlist_data : [];
        $wishlistCount = count($wishlist);

        $availableCashback = Auth::user()->cashbacks()
            ->where('status', 'available')
            ->sum('amount');

        return view('principal.home.profile', compact('orders', 'ordersCount', 'wishlist', 'wishlistCount', 'availableCashback'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validaciones
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'website' => 'nullable|url',
            'phone' => 'required|regex:/^\d{9,15}$/',
            'address' => 'required|string|min:5|max:255',
        ]);

        // Actualizar usuario
        $user->update($validated);

        return response()->json(['message' => 'Perfil actualizado con éxito'], 200);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Eliminar foto anterior si existe
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        // Guardar nueva foto
        $path = $request->file('image')->store('avatars', 'public');

        // Actualizar en la BD
        $user->update(['avatar' => $path]);

        return response()->json([
            'success' => true,
            'image_url' => Storage::url($path)
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'La contraseña actual es incorrecta.'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada con éxito.']);
    }

    public function showStatus($id)
    {
        try {
            $orderId = Crypt::decrypt($id);
            $order = Order::with('items.product')->findOrFail($orderId);

            return view('principal.orders.status', compact('order'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }
    }

    public function generateTicket($encryptedId)
    {
        try {
            $orderId = Crypt::decrypt($encryptedId);
            $order = Order::with('items.product')->findOrFail($orderId);
            $business = Business::first();

            $pdf = Pdf::loadView('principal.orders.ticket-pdf', compact('order', 'business'))
                ->setPaper([0, 0, 226.77, 1000]); // 80mm en puntos = 226.77px

            return $pdf->stream('Factura_' . $order->id . '.pdf');
        } catch (\Exception $e) {
            abort(404, 'Factura no encontrada.');
        }
    }
}
