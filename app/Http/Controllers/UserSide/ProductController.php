<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Show ALL products
    // Show all products
    public function allProducts()
    {
        $products = Product::where('status', 'active')->get();
        return view('products', compact('products'));
    }

    // Show products by category slug
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('status', 'active')
            ->get();

        return view('products', compact('category', 'products'));
    }
}
