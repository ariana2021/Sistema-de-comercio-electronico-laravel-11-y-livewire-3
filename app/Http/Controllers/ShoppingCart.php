<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShoppingCart extends Controller
{
    public function index()
    {
        $carts = Session::get('cart', []);
        return view('principal.cart.index', compact('carts'));
    }

    public function checkout() {
        return view('principal.cart.checkout');
    }
}
