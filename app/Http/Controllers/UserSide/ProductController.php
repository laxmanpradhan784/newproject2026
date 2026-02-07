<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    // Show all products with pagination
    public function allProducts()
    {
        $products = Product::with('category')
            ->where('status', 'active') // product must be active
            ->whereHas('category', function ($query) {
                $query->where('status', 'active'); // category must be active
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('products', compact('products'));
    }


    // Search products with pagination
    public function search(Request $request)
    {
        $query = $request->q;

        $products = Product::with('category')
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->orWhereHas('category', function ($cat) use ($query) {
                        $cat->where('name', 'LIKE', "%$query%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products', compact('products'))
            ->with('search', $query);
    }

    // Show single product detail
    public function show($id)
    {
        $product = Product::with(['category', 'images', 'reviews' => function ($query) {
            $query->where('status', 'approved');
        }, 'reviews.user'])
            ->withCount(['reviews' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->findOrFail($id);

        $category = $product->category;

        // Calculate average rating
        $avgRating = $product->reviews->avg('rating') ?? 0;
        $totalReviews = $product->reviews->count();

        // Get related products (same category, excluding current product)
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Check if user has already reviewed this product
        $existingReview = null;
        if (auth()->check()) {
            $existingReview = \App\Models\Review::where('product_id', $id)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('product_detail', compact(
            'product',
            'category',
            'relatedProducts',
            'avgRating',
            'totalReviews',
            'existingReview'
        ));
    }

    // Show products by category with pagination
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('products', compact('category', 'products'));
    }
}
