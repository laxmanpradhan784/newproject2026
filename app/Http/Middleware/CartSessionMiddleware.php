<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartSessionMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // ADD THIS: Skip middleware for admin routes
        if ($this->isAdminRoute($request)) {
            return $next($request);
        }

        // Generate guest token if not exists for non-logged in users
        if (!Auth::check() && !session()->has('guest_token')) {
            session(['guest_token' => \Illuminate\Support\Str::random(32)]);
        }

        // Store pre-login cart count for merge notification
        if (!Auth::check() && Cart::getCartCount() > 0) {
            session(['pre_login_cart_count' => Cart::getCartCount()]);
        }

        // Merge guest cart to user when they login
        if (Auth::check() && session()->has('guest_token')) {
            $this->mergeGuestCartToUser();
        }

        return $next($request);
    }

    /**
     * Check if the current route is an admin route
     */
    protected function isAdminRoute(Request $request): bool
    {
        $path = $request->path();
        
        // Check if path starts with 'admin/'
        if (str_starts_with($path, 'admin/')) {
            return true;
        }
        
        // Check if path is exactly 'admin'
        if ($path === 'admin') {
            return true;
        }
        
        // Check if the route name contains 'admin.'
        $route = $request->route();
        if ($route && str_contains($route->getName() ?? '', 'admin.')) {
            return true;
        }
        
        return false;
    }

    /**
     * Merge guest cart items to user's cart after login
     */
    protected function mergeGuestCartToUser()
    {
        $userId = Auth::id();
        $guestToken = session('guest_token');
        $sessionId = session()->getId();
        
        // Get all guest cart items
        $guestCartItems = Cart::where(function($query) use ($guestToken, $sessionId) {
                $query->where('guest_token', $guestToken)
                      ->orWhere('session_id', $sessionId);
            })
            ->where('is_guest', true)
            ->with('product')
            ->get();

        if ($guestCartItems->isNotEmpty()) {
            $mergedItems = 0;
            
            foreach ($guestCartItems as $guestItem) {
                // Check if user already has this product in their cart
                $existingUserItem = Cart::where('user_id', $userId)
                    ->where('product_id', $guestItem->product_id)
                    ->where('is_guest', false)
                    ->first();

                if ($existingUserItem) {
                    // Update quantity (combine guest and user items)
                    $newQuantity = $existingUserItem->quantity + $guestItem->quantity;
                    
                    // Check stock availability
                    if ($guestItem->product && $guestItem->product->stock >= $guestItem->quantity) {
                        $existingUserItem->update(['quantity' => $newQuantity]);
                        $mergedItems += $guestItem->quantity;
                        
                        // Restore stock from guest item (since it's being merged)
                        $guestItem->product->increment('stock', $guestItem->quantity);
                    }
                    
                    // Delete the guest cart item
                    $guestItem->delete();
                } else {
                    // Convert guest cart item to user cart item
                    if ($guestItem->product && $guestItem->product->stock >= $guestItem->quantity) {
                        $guestItem->update([
                            'user_id' => $userId,
                            'session_id' => null,
                            'guest_token' => null,
                            'is_guest' => false
                        ]);
                        $mergedItems += $guestItem->quantity;
                    }
                }
            }
            
            // Store merge info for showing notification
            if ($mergedItems > 0) {
                session(['cart_merged_items' => $mergedItems]);
                session(['cart_merged_message' => "Successfully merged {$mergedItems} items from your guest cart!"]);
            }
            
            // Clear guest token from session
            session()->forget('guest_token');
            session()->forget('pre_login_cart_count');
        }
    }
}