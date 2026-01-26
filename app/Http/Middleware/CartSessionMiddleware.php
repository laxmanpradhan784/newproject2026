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