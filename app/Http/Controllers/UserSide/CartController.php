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

        $cartItems = Auth::user()->cartItems;
        $subtotal = 0;
        $cartCount = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
            $cartCount += $item->quantity;
        }

        // Shipping and tax calculations
        $shipping = $subtotal > 1000 ? 0 : 50; // Free shipping above ₹1000
        $tax = $subtotal * 0.18; // 18% GST
        $total = $subtotal + $shipping + $tax;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'cartCount'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $product = Product::findOrFail($productId);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add items to cart.');
        }

        $quantity = $request->quantity ?? 1;

        // Check if product already in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            // Update quantity
            $existingCart->quantity += $quantity;
            $existingCart->save();

            $message = 'Product quantity updated in cart!';
        } else {
            // Add new item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            $message = 'Product added to cart successfully!';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => Auth::user()->cartCount()
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->quantity = $request->quantity;
        $cart->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'subtotal' => $cart->subtotal,
                'cart_count' => Auth::user()->cartCount(),
                'cart_total' => Auth::user()->cartTotal()
            ]);
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => Auth::user()->cartCount(),
                'cart_total' => Auth::user()->cartTotal()
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        if (request()->ajax()) {
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
            $count = Auth::user()->cartCount();
        }

        return response()->json(['count' => $count]);
    }


    // Increase quantity of a product in cart
    public function increase(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update cart.');
        }

        $userId = Auth::id();

        // Get cart item for this user and product
        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            // Check if enough stock is available
            if ($cart->quantity < $product->stock) {
                $cart->increment('quantity');
                return back()->with('success', 'Quantity increased successfully.');
            } else {
                return back()->with('error', 'Maximum stock limit reached.');
            }
        }

        return back()->with('error', 'Product not found in cart.');
    }

    // Decrease quantity of a product in cart
    public function decrease(Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to update cart.');
        }

        $userId = Auth::id();

        // Get cart item for this user and product
        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
                return back()->with('success', 'Quantity decreased successfully.');
            } else {
                // If quantity is 1, remove the item from cart
                $cart->delete();
                return back()->with('success', 'Product removed from cart.');
            }
        }

        return back()->with('error', 'Product not found in cart.');
    }
}
