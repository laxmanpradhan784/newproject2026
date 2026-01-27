<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderPlacedAdminMail;
use App\Mail\OrderPlacedUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            session(['url.intended' => route('checkout')]);
            return redirect()->route('login')->with('info', 'Please login to proceed with checkout.');
        }

        $user = Auth::user();

        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_guest', false)
            ->with('product.category')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty! Please add items before checkout.');
        }

        // Check stock
        $outOfStockItems = [];
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                $outOfStockItems[] = $item->product->name;
            }
        }

        if (!empty($outOfStockItems)) {
            return redirect()->route('cart')->with(
                'error',
                'Some items in your cart are out of stock: ' . implode(', ', $outOfStockItems)
            );
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
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
            ->with('product.category')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Validate request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,card,upi',
            'shipping_method' => 'required|in:standard,express',
        ]);

        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $shipping = $request->shipping_method == 'express' ? 150 : ($subtotal > 1000 ? 0 : 50);
            $tax = $subtotal * 0.18;
            $total = $subtotal + $shipping + $tax;

            // Generate order number
            $orderNumber = Order::generateUniqueOrderNumber($user->id);

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method == 'cod' ? 'pending' : 'paid',
                'shipping_name' => $request->first_name . ' ' . $request->last_name,
                'shipping_email' => $request->email,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_zip' => $request->zip_code,
                'shipping_country' => $request->country,
                'shipping_method' => $request->shipping_method,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->price * $cartItem->quantity,
                    'category_id' => $cartItem->product->category_id,
                    'category_name' => $cartItem->product->category->name,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }



            try {
                // Send email to Admin
                Mail::to(config('mail.from.address'))
                    ->send(new OrderPlacedAdminMail($order));

                // Send email to User
                Mail::to($order->shipping_email)
                    ->send(new OrderPlacedUserMail($order));
            } catch (\Exception $e) {
                \Log::error('Order email sending failed: ' . $e->getMessage());
            }
            // -----------------------

            // Clear user's cart after order
            Cart::where('user_id', $user->id)->delete();

            // Redirect to order confirmation
            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error placing order: ' . $e->getMessage());
        }
    }


    public function guestCheckoutRedirect()
    {
        if (Auth::check()) {
            return redirect()->route('checkout');
        }

        $guestCartCount = Cart::where('session_id', session()->getId())
            ->orWhere('guest_token', session('guest_token'))
            ->where('is_guest', true)
            ->sum('quantity');

        if ($guestCartCount == 0) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        session(['url.intended' => route('checkout')]);

        return redirect()->route('login')->with(
            'info',
            'You have ' . $guestCartCount . ' items in your cart. Please login to checkout.'
        );
    }

    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        return view('order-confirmation', compact('order'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('my-orders', compact('orders'));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('order-details', compact('order'));
    }
}
