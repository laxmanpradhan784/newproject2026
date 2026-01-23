<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // <-- import Auth

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

        // Get logged-in user, if any
       $user = Auth::user();

        // Pass all data to the view
        return view('home', compact('categories', 'products', 'user'));
    }
}
