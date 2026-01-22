<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    // Home page
    public function index()
    {
        $categories = Category::where('status', 'active')->get();

        $products = Product::where('status', 'active')
                           ->orderBy('id', 'DESC')
                           ->limit(8)
                           ->get();

        return view('home', compact('categories', 'products'));
    }
}
