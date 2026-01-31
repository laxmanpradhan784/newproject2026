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

        // Fetch active sliders
        $sliders = Slider::where('status', 'active')->get();

        // Fetch latest products where BOTH product and category are active
        $products = Product::with('category')
            ->where('status', 'active') // product active
            ->whereHas('category', function ($query) {
                $query->where('status', 'active'); // category active
            })
            ->orderBy('created_at', 'DESC')
            ->limit(8)
            ->get();

        return view('home', compact('categories', 'sliders', 'products'));
    }
}
