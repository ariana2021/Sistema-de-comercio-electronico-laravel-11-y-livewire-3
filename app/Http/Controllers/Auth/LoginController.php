<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TemporaryCart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        // Obtener datos actuales de la sesión con IDs de productos como claves
        $cartSession = Session::get('cart', []);
        $wishlistSession = Session::get('wishlist', []);

        // Recuperar o crear el registro en la tabla temporary_carts
        $temporaryCart = TemporaryCart::firstOrNew(['user_id' => $user->id]);

        // Asegurar que los datos sean arrays y fusionarlos manteniendo los IDs como claves
        $temporaryCart->cart_data = is_array($temporaryCart->cart_data) ? ($temporaryCart->cart_data + $cartSession) : $cartSession;
        $temporaryCart->wishlist_data = is_array($temporaryCart->wishlist_data) ? ($temporaryCart->wishlist_data + $wishlistSession) : $wishlistSession;

        // Guardar en la base de datos
        $temporaryCart->save();

        // Restaurar los datos en la sesión manteniendo los IDs de productos como claves
        Session::put('cart', $temporaryCart->cart_data);
        Session::put('wishlist', $temporaryCart->wishlist_data);

        if ($user->roles->isEmpty()) {
            return redirect()->route('profile.index');
        }

        return redirect()->route('home');
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
