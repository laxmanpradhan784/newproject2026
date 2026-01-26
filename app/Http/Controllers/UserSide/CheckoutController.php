<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            // Store intended URL for redirect after login
            session(['url.intended' => route('checkout')]);
            return redirect()->route('login')->with('info', 'Please login to proceed with checkout.');
        }

        $user = Auth::user();
        
        // Use Cart model method to get items (handles merged carts)
        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_guest', false)
            ->with('product')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty! Please add items before checkout.');
        }
        
        // Check stock availability for all items
        $outOfStockItems = [];
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                $outOfStockItems[] = $item->product->name;
            }
        }
        
        if (!empty($outOfStockItems)) {
            return redirect()->route('cart')->with('error', 
                'Some items in your cart are out of stock: ' . implode(', ', $outOfStockItems));
        }
        
        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        $shipping = $subtotal > 1000 ? 0 : 50;
        $tax = $subtotal * 0.18;
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact('user', 'cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_guest', false)
            ->with('product')
            ->get();

        // Validate cart is not empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Validate request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,card,upi',
        ]);

        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
            
            $shipping = $subtotal > 1000 ? 0 : 50;
            $tax = $subtotal * 0.18;
            $total = $subtotal + $shipping + $tax;

            // Create order (you'll need to adjust this based on your Order model)
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method == 'cod' ? 'pending' : 'paid',
                'shipping_address' => json_encode([
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country ?? 'India',
                ]),
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->price * $cartItem->quantity,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Clear user's cart after order
            Cart::where('user_id', $user->id)->delete();

            // If you have a notification system
            // $user->notify(new OrderPlaced($order));

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully! Order #' . $order->order_number);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error placing order: ' . $e->getMessage());
        }
    }

    // Optional: Add a method to handle guest checkout redirection
    public function guestCheckoutRedirect()
    {
        if (Auth::check()) {
            return redirect()->route('checkout');
        }

        // Get guest cart count
        $guestCartCount = Cart::where('session_id', session()->getId())
            ->orWhere('guest_token', session('guest_token'))
            ->where('is_guest', true)
            ->sum('quantity');

        if ($guestCartCount == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Store intended URL and show login prompt
        session(['url.intended' => route('checkout')]);
        
        return redirect()->route('login')->with('info', 
            'You have ' . $guestCartCount . ' items in your cart. Please login to checkout.');
    }
}