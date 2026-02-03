<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlists = Wishlist::with(['product.category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(8); // Show 8 items per page

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // Check if already in wishlist
        $exists = Wishlist::isInWishlist(Auth::id(), $request->product_id);

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ], 400);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'count' => Wishlist::where('user_id', Auth::id())->count()
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'count' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }

        return redirect()->route('wishlist.index')
            ->with('success', 'Product removed from wishlist');
    }

    /**
     * Remove product from wishlist by product ID
     */
    public function removeByProduct($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->firstOrFail();

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'count' => Wishlist::where('user_id', Auth::id())->count()
        ]);
    }

    /**
     * Toggle wishlist status (add/remove)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $exists = Wishlist::isInWishlist(Auth::id(), $request->product_id);

        if ($exists) {
            // Remove from wishlist
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

            $action = 'removed';
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'message' => "Product {$action} from wishlist",
            'count' => Wishlist::where('user_id', Auth::id())->count()
        ]);
    }

    /**
     * Get wishlist count
     */
    public function count()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Clear entire wishlist
     */
    public function clear()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return redirect()->route('wishlist.index')
            ->with('success', 'Wishlist cleared successfully');
    }

    /**
     * Move wishlist item to cart
     */
    public function moveToCart($id)
    {
        // You'll need to implement cart logic here
        // This is a placeholder method
        return redirect()->route('cart.index')
            ->with('info', 'Please implement cart logic');
    }
}
