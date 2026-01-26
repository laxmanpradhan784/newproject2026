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
     * Display cart page
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart.');
        }

        $cartItems = Auth::user()->cartItems()->with('product.category')->get();
        $subtotal = 0;
        $cartCount = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
            $cartCount += $item->quantity;
        }

        // Shipping and tax calculations
        $shipping = $subtotal > 999 ? 0 : 50; // Free shipping above ₹999
        $tax = $subtotal * 0.18; // 18% GST
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'cartCount'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to add items to cart.',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add items to cart.');
        }

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

        // Check if product already in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $quantity;
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
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
            $message = 'Product added to cart successfully!';
        }

        if ($request->ajax() || $request->wantsJson()) {
            $cartCount = Auth::user()->cartItems()->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cartCount
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // Check authorization
        if (Auth::id() !== $cart->user_id) {
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

        $cart->quantity = $request->quantity;
        $cart->save();

        // Recalculate totals
        $subtotal = $cart->price * $cart->quantity;
        $totalCartItems = Auth::user()->cartItems()->sum('quantity');
        $cartTotal = Auth::user()->cartItems()->get()->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'quantity' => $cart->quantity,
                'subtotal' => $subtotal,
                'cart_count' => $totalCartItems,
                'cart_total' => $cartTotal
            ]);
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove(Cart $cart)
    {
        // Check authorization
        if (Auth::id() !== $cart->user_id) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $productName = $cart->product->name;
        $cart->delete();

        // Recalculate cart count
       $totalCartItems = Auth::user()->cartItems()->count(); // count products
        $cartTotal = Auth::user()->cartItems()->get()->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '"' . $productName . '" removed from cart',
                'cart_id' => $cart->id,
                'cart_count' => $totalCartItems,
                'cart_total' => $cartTotal
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        if (!Auth::check()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to manage cart.'
                ], 401);
            }
            return redirect()->route('login');
        }

        Cart::where('user_id', Auth::id())->delete();

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
     * Get cart count for navbar
     */
    public function getCartCount()
    {
        $count = 0;
        if (Auth::check()) {
            $count = Auth::user()->cartItems()->sum('quantity');
        }

        return response()->json(['count' => $count]);
    }

    /**
     * Increase quantity of a product in cart (using product ID)
     */
    public function increase($productId)
    {
        if (!Auth::check()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to update cart.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to update cart.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$cart) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart.'
                ], 404);
            }
            return back()->with('error', 'Product not found in cart.');
        }

        // Check if enough stock is available
        if ($cart->quantity < $cart->product->stock) {
            $cart->increment('quantity');
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quantity increased successfully.',
                    'quantity' => $cart->quantity
                ]);
            }
            return back()->with('success', 'Quantity increased successfully.');
        } else {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum stock limit reached.'
                ], 422);
            }
            return back()->with('error', 'Maximum stock limit reached.');
        }
    }

    /**
     * Decrease quantity of a product in cart (using product ID)
     */
    public function decrease($productId)
    {
        if (!Auth::check()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please login to update cart.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to update cart.');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

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
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quantity decreased successfully.',
                    'quantity' => $cart->quantity
                ]);
            }
            return back()->with('success', 'Quantity decreased successfully.');
        } else {
            // If quantity is 1, remove the item from cart
            $cart->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart.',
                    'removed' => true
                ]);
            }
            return back()->with('success', 'Product removed from cart.');
        }
    }
}