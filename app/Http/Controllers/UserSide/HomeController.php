<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    // Home page
    public function index()
    {
        // Fetch all active categories for menu/filter
        $categories = Category::where('status', 'active')->get();

        $sliders = Slider::where('status', 'active')->get();

        // Fetch latest active products (limit 8)
        $products = Product::where('status', 'active')
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->get();

        return view('home', compact('categories', 'sliders', 'products'));
    }
}
