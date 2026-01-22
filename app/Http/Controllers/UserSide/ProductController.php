<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    // Show all active categories
    public function categories()
    {
        $categories = Category::where('status', 'active')->get();
        return view('categories', compact('categories'));
    }

    // Show products by category id
    public function productsByCategory($id)
    {
        $category = Category::where('id', $id)
                            ->where('status', 'active')
                            ->firstOrFail();

        $products = Product::where('category_id', $id)
                           ->where('status', 'active')
                           ->get();

        return view('products', compact('category', 'products'));
    }

    // Show single product by id
    public function productDetail($id)
    {
        $product = Product::where('id', $id)
                          ->where('status', 'active')
                          ->firstOrFail();

        return view('product_detail', compact('product'));
    }
}
