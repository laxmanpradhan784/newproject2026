<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart page (works for both guest and logged in)
     */
    public function index()
    {
        // Get cart items using the model helper
        $cartItems = Cart::getCartItems();
        $cartCount = $cartItems->sum('quantity');
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        // Shipping and tax calculations
        $shipping = $subtotal > 999 ? 0 : 50; // Free shipping above ₹999
        $tax = $subtotal * 0.18; // 18% GST
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'cartCount'));
    }

    /**
     * Add product to cart (works for both guest and logged in)
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $quantity = $request->quantity ?? 1;

        // Check stock availability
        if ($quantity > $product->stock) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $product->stock . ' items available in stock.'
                ], 422);
            }
            return back()->with('error', 'Only ' . $product->stock . ' items available in stock.');
        }

        $identifier = Cart::getCartIdentifier();
        
        // Check if product already in cart
        $existingCart = null;
        
        if (Auth::check()) {
            $existingCart = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->where('is_guest', false)
                ->first();
        } else {
            $existingCart = Cart::where(function($query) use ($identifier) {
                    $query->where('session_id', $identifier['session_id'])
                          ->orWhere('guest_token', $identifier['guest_token']);
                })
                ->where('product_id', $product->id)
                ->where('is_guest', true)
                ->first();
        }

        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $quantity;
            
            // Check if new quantity exceeds max limit
            if ($newQuantity > 10) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum 10 items allowed per product.'
                    ], 422);
                }
                return back()->with('error', 'Maximum 10 items allowed per product.');
            }
            
            // Check stock availability for new quantity
            if ($newQuantity > $product->stock) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more than available stock.'
                    ], 422);
                }
                return back()->with('error', 'Cannot add more than available stock.');
            }
            
            $existingCart->quantity = $newQuantity;
            $existingCart->save();
            $message = 'Product quantity updated in cart!';
        } else {
            // Add new item
            $cartData = array_merge([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ], $identifier);

            Cart::create($cartData);
            $message = 'Product added to cart successfully!';
        }

        // Update product stock
        $product->decrement('stock', $quantity);

        // Get updated cart count
        $cartCount = Cart::getCartCount();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Update cart item quantity (works for both)
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // Check authorization
        if (!$cart->belongsToCurrentSession()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        // Check stock availability
        if ($request->quantity > $cart->product->stock) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $cart->product->stock . ' items available in stock.'
                ], 422);
            }
            return back()->with('error', 'Only ' . $cart->product->stock . ' items available in stock.');
        }

        $oldQuantity = $cart->quantity;
        $cart->quantity = $request->quantity;
        $cart->save();

        // Update product stock
        $quantityDifference = $request->quantity - $oldQuantity;
        if ($quantityDifference != 0) {
            $cart->product->decrement('stock', $quantityDifference);
        }

        // Recalculate totals
        $cartItems = Cart::getCartItems();
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $cartCount = $cartItems->sum('quantity');
        $itemSubtotal = $cart->price * $cart->quantity;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'quantity' => $cart->quantity,
                'item_subtotal' => $itemSubtotal,
                'cart_count' => $cartCount,
                'cart_total' => $subtotal
            ]);
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart (works for both)
     */
    public function remove(Cart $cart)
    {
        // Check authorization
        if (!$cart->belongsToCurrentSession()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $productName = $cart->product->name;
        
        // Restore product stock
        $cart->product->increment('stock', $cart->quantity);
        
        // Delete cart item
        $cart->delete();

        // Get updated cart info
        $cartItems = Cart::getCartItems();
        $cartCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '"' . $productName . '" removed from cart',
                'cart_id' => $cart->id,
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart (works for both)
     */
    public function clear()
    {
        $cartItems = Cart::getCartItems();
        
        // Restore all product stocks
        foreach ($cartItems as $item) {
            $item->product->increment('stock', $item->quantity);
        }
        
        // Delete all cart items
        $cartItems->each->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0
            ]);
        }

        return redirect()->route('cart')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for navbar (works for both)
     */
    public function getCartCount()
    {
        $count = Cart::getCartCount();
        return response()->json(['count' => $count]);
    }

    /**
     * Increase quantity of a product in cart (works for both)
     */
    public function increase($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Find the cart item
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('is_guest', false)
                ->first();
        } else {
            $identifier = Cart::getCartIdentifier();
            $cart = Cart::where(function($query) use ($identifier) {
                    $query->where('session_id', $identifier['session_id'])
                          ->orWhere('guest_token', $identifier['guest_token']);
                })
                ->where('product_id', $productId)
                ->where('is_guest', true)
                ->first();
        }

        if (!$cart) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart.'
                ], 404);
            }
            return back()->with('error', 'Product not found in cart.');
        }

        // Check if enough stock is available and max limit
        if ($cart->quantity < 10 && $cart->quantity < $product->stock) {
            $cart->increment('quantity');
            
            // Update product stock
            $product->decrement('stock', 1);
            
            if (request()->ajax() || request()->wantsJson()) {
                $cartCount = Cart::getCartCount();
                return response()->json([
                    'success' => true,
                    'message' => 'Quantity increased successfully.',
                    'quantity' => $cart->quantity,
                    'cart_count' => $cartCount
                ]);
            }
            return back()->with('success', 'Quantity increased successfully.');
        } else {
            $message = $cart->quantity >= 10 ? 'Maximum 10 items allowed.' : 'Maximum stock limit reached.';
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }
            return back()->with('error', $message);
        }
    }

    /**
     * Decrease quantity of a product in cart (works for both)
     */
    public function decrease($productId)
    {
        // Find the cart item
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('is_guest', false)
                ->first();
        } else {
            $identifier = Cart::getCartIdentifier();
            $cart = Cart::where(function($query) use ($identifier) {
                    $query->where('session_id', $identifier['session_id'])
                          ->orWhere('guest_token', $identifier['guest_token']);
                })
                ->where('product_id', $productId)
                ->where('is_guest', true)
                ->first();
        }

        if (!$cart) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart.'
                ], 404);
            }
            return back()->with('error', 'Product not found in cart.');
        }

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
            
            // Update product stock
            $cart->product->increment('stock', 1);
            
            if (request()->ajax() || request()->wantsJson()) {
                $cartCount = Cart::getCartCount();
                return response()->json([
                    'success' => true,
                    'message' => 'Quantity decreased successfully.',
                    'quantity' => $cart->quantity,
                    'cart_count' => $cartCount
                ]);
            }
            return back()->with('success', 'Quantity decreased successfully.');
        } else {
            // If quantity is 1, remove the item from cart
            $cart->product->increment('stock', 1);
            $cart->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                $cartCount = Cart::getCartCount();
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart.',
                    'removed' => true,
                    'cart_count' => $cartCount
                ]);
            }
            return back()->with('success', 'Product removed from cart.');
        }
    }
}