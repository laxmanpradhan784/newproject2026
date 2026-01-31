<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Get applied coupon from session
        $appliedCoupon = session('applied_coupon');
        $discountAmount = session('cart_discount', 0);
        
        // Apply discount if coupon is valid
        $discountedSubtotal = $subtotal;
        if ($appliedCoupon && $discountAmount > 0) {
            // Re-validate coupon before showing cart
            $validation = $this->validateCoupon(
                $appliedCoupon['code'], 
                Auth::id(), 
                $subtotal
            );
            
            if (!$validation['valid']) {
                // Remove invalid coupon
                session()->forget(['applied_coupon', 'applied_coupon_code', 'cart_discount']);
                $discountAmount = 0;
            } else {
                // Recalculate discount to ensure it's correct
                $discountAmount = $this->calculateDiscount($validation['coupon'], $subtotal);
                session(['cart_discount' => $discountAmount]);
                $discountedSubtotal = $subtotal - $discountAmount;
            }
        }

        // Shipping and tax calculations
        $shipping = $discountedSubtotal > 999 ? 0 : 50; // Free shipping above ₹999 (on discounted amount)
        $tax = $discountedSubtotal * 0.18; // 18% GST on discounted amount
        $total = $discountedSubtotal + $shipping + $tax;

        // Get available coupons for modal
        $availableCoupons = $this->getAvailableCoupons();

        return view('cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'discountedSubtotal' => $discountedSubtotal,
            'discountAmount' => $discountAmount,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'cartCount' => $cartCount,
            'availableCoupons' => $availableCoupons,
            'appliedCoupon' => $appliedCoupon
        ]);
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
            $existingCart = Cart::where(function ($query) use ($identifier) {
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
        $subtotal = $cartItems->sum(function ($item) {
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
        $cartTotal = $cartItems->sum(function ($item) {
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

        return back()->with('success', '');
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

        // Clear coupon from session
        session()->forget(['applied_coupon', 'applied_coupon_code', 'cart_discount']);

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
            $cart = Cart::where(function ($query) use ($identifier) {
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
            $cart = Cart::where(function ($query) use ($identifier) {
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

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);
        
        $couponCode = $request->coupon_code;
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $sessionId = session()->getId();
        
        // Get cart total
        $cartTotal = $this->calculateCartTotal($userId, $sessionId);
        
        if ($cartTotal <= 0) {
            return redirect()->back()->with('coupon_error', 'Your cart is empty');
        }
        
        // Validate coupon
        $validation = $this->validateCoupon($couponCode, $userId, $cartTotal);
        
        if (!$validation['valid']) {
            return redirect()->back()->with('coupon_error', $validation['message']);
        }
        
        $coupon = $validation['coupon'];
        
        // Calculate discount
        $discount = $this->calculateDiscount($coupon, $cartTotal);
        
        // Store coupon in session
        session([
            'applied_coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
                'discount_amount' => $discount,
                'max_discount' => $coupon->max_discount_amount,
                'min_order' => $coupon->min_order_amount
            ],
            'applied_coupon_code' => $coupon->code,
            'cart_discount' => $discount
        ]);
        
        return redirect()->back()->with('coupon_success', 'Coupon applied successfully!');
    }
    
    /**
     * Remove coupon from cart
     */
    public function removeCoupon()
    {
        session()->forget([
            'applied_coupon',
            'applied_coupon_code',
            'cart_discount'
        ]);
        
        return redirect()->back()->with('coupon_success', 'Coupon removed successfully');
    }
    
    /**
     * Validate coupon (PUBLIC METHOD)
     */
    public function validateCoupon($couponCode, $userId, $cartTotal)
    {
        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 'active')
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->first();
            
        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid or expired coupon'];
        }
        
        // Check minimum order amount
        if ($coupon->min_order_amount > 0 && $cartTotal < $coupon->min_order_amount) {
            return [
                'valid' => false, 
                'message' => 'Minimum order amount ₹' . $coupon->min_order_amount . ' required'
            ];
        }
        
        // Check usage limit
        if ($coupon->usage_limit) {
            $usedCount = CouponUsage::where('coupon_id', $coupon->id)->count();
            if ($usedCount >= $coupon->usage_limit) {
                return ['valid' => false, 'message' => 'Coupon usage limit reached'];
            }
        }
        
        // Check user-specific usage limit
        if ($userId && $coupon->usage_limit_per_user) {
            $userUsedCount = CouponUsage::where('coupon_id', $coupon->id)
                ->where('user_id', $userId)
                ->count();
            if ($userUsedCount >= $coupon->usage_limit_per_user) {
                return ['valid' => false, 'message' => 'You have already used this coupon'];
            }
        }
        
        // Check user scope
        if ($coupon->user_scope == 'specific' && $userId) {
            $allowed = DB::table('coupon_users')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $userId)
                ->exists();
            if (!$allowed) {
                return ['valid' => false, 'message' => 'This coupon is not available for your account'];
            }
        }
        
        // Check category scope
        if ($coupon->category_scope == 'specific') {
            // Get cart categories
            $cartCategories = $this->getCartCategories($userId, session()->getId());
            
            $allowedCategories = DB::table('coupon_categories')
                ->where('coupon_id', $coupon->id)
                ->pluck('category_id')
                ->toArray();
            
            if (!array_intersect($cartCategories, $allowedCategories)) {
                return ['valid' => false, 'message' => 'This coupon is not applicable to items in your cart'];
            }
        }
        
        // Check product scope
        if ($coupon->product_scope == 'specific') {
            // Get cart products
            $cartProducts = $this->getCartProducts($userId, session()->getId());
            
            $allowedProducts = DB::table('coupon_products')
                ->where('coupon_id', $coupon->id)
                ->pluck('product_id')
                ->toArray();
            
            if (!array_intersect($cartProducts, $allowedProducts)) {
                return ['valid' => false, 'message' => 'This coupon is not applicable to items in your cart'];
            }
        }
        
        return ['valid' => true, 'coupon' => $coupon, 'message' => 'Coupon is valid'];
    }
    
    /**
     * Calculate discount amount (PUBLIC METHOD)
     */
    public function calculateDiscount($coupon, $cartTotal)
    {
        if ($coupon->discount_type == 'percentage') {
            $discount = ($cartTotal * $coupon->discount_value) / 100;
            
            // Apply max discount limit
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }
        } else {
            $discount = min($coupon->discount_value, $cartTotal); // Can't discount more than cart total
        }
        
        return $discount;
    }
    
    /**
     * Calculate cart total (PUBLIC METHOD)
     */
    public function calculateCartTotal($userId, $sessionId)
    {
        $cartQuery = Cart::query();
        
        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }
        
        $cartItems = $cartQuery->with('product')->get();
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->price * $item->quantity;
        }
        
        return $total;
    }

    /**
     * Get cart categories for scope validation (PUBLIC METHOD)
     */
    public function getCartCategories($userId, $sessionId)
    {
        $cartQuery = Cart::query();
        
        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }
        
        return $cartQuery->with('product')
            ->get()
            ->pluck('product.category_id')
            ->unique()
            ->toArray();
    }

    /**
     * Get cart products for scope validation (PUBLIC METHOD)
     */
    public function getCartProducts($userId, $sessionId)
    {
        $cartQuery = Cart::query();
        
        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }
        
        return $cartQuery->pluck('product_id')
            ->unique()
            ->toArray();
    }
    
    /**
     * Get available coupons for modal (PUBLIC METHOD)
     */
    public function getAvailableCoupons()
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        
        $coupons = Coupon::where('status', 'active')
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->orderBy('discount_value', 'desc')
            ->get()
            ->filter(function($coupon) use ($userId) {
                // Check user scope
                if ($coupon->user_scope == 'specific' && $userId) {
                    return DB::table('coupon_users')
                        ->where('coupon_id', $coupon->id)
                        ->where('user_id', $userId)
                        ->exists();
                }
                return true;
            })
            ->map(function($coupon) use ($userId) {
                // Add cart validation info
                $cartTotal = $this->calculateCartTotal($userId, session()->getId());
                $coupon->is_applicable = $this->validateCoupon($coupon->code, $userId, $cartTotal)['valid'];
                return $coupon;
            });
            
        return $coupons;
    }
}