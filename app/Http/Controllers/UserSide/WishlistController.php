<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Cart;
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
            ->paginate(8);

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
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

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

        if (request()->ajax() || request()->wantsJson()) {
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

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

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

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared successfully',
                'count' => 0
            ]);
        }

        return redirect()->route('wishlist.index')
            ->with('success', 'Wishlist cleared successfully');
    }

    /**
     * Move wishlist item to cart
     */
    public function moveToCart($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Check if product exists and is in stock
        $product = Product::find($wishlist->product_id);
        
        if (!$product) {
            return redirect()->route('wishlist.index')
                ->with('error', 'Product not found or has been removed.');
        }

        if ($product->stock <= 0) {
            return redirect()->route('wishlist.index')
                ->with('error', 'Product is out of stock.');
        }

        // Check if product already in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $wishlist->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity if already in cart
            $cartItem->increment('quantity');
        } else {
            // Add to cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $wishlist->product_id,
                'quantity' => 1,
                'price' => $product->price
            ]);
        }

        // Remove from wishlist
        $wishlist->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Product moved to cart successfully!');
    }

    /**
     * Move all wishlist items to cart
     */
    public function moveAllToCart()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $addedCount = 0;
        $outOfStockCount = 0;
        $removedCount = 0;

        foreach ($wishlists as $wishlist) {
            if (!$wishlist->product) {
                // Product no longer exists
                $wishlist->delete();
                $removedCount++;
                continue;
            }

            if ($wishlist->product->stock > 0) {
                // Check if product already in cart
                $cartItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $wishlist->product_id)
                    ->first();

                if ($cartItem) {
                    // Update quantity if already in cart
                    $cartItem->increment('quantity');
                } else {
                    // Add to cart
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $wishlist->product_id,
                        'quantity' => 1,
                        'price' => $wishlist->product->price
                    ]);
                }
                $addedCount++;
            } else {
                $outOfStockCount++;
            }

            // Remove from wishlist
            $wishlist->delete();
        }

        $message = "{$addedCount} item(s) moved to cart.";
        
        if ($outOfStockCount > 0) {
            $message .= " {$outOfStockCount} item(s) were out of stock.";
        }
        
        if ($removedCount > 0) {
            $message .= " {$removedCount} item(s) were removed as products no longer exist.";
        }

        return redirect()->route('cart.index')
            ->with('success', $message);
    }

    /**
     * Check if product is in wishlist
     */
    public function check($productId)
    {
        $inWishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'in_wishlist' => $inWishlist
        ]);
    }

    /**
     * Get wishlist items summary (for sidebar/mini-wishlist)
     */
    public function summary()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'items' => $wishlists,
            'count' => Wishlist::where('user_id', Auth::id())->count()
        ]);
    }
}