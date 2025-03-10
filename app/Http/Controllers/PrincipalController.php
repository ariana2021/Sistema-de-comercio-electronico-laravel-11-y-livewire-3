<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('principal.home.index', compact('categories'));
    }
}
