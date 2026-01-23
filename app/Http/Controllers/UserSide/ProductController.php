<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    // Show all products
    public function allProducts()
    {
        $products = Product::where('status', 'active')->get();
        return view('products', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->q;

        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhereHas('category', function ($cat) use ($query) {
                        $cat->where('name', 'LIKE', "%$query%");
                    });
            })
            ->get();

        return view('products', compact('products'))
            ->with('search', $query);
    }


    public function show($id)
    {
        $product = Product::findOrFail($id); // Fetch product by ID

        // Optional: fetch category too
        $category = $product->category;

        return view('product_detail', compact('product', 'category'));
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
