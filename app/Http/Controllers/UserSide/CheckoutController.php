<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $cartItems = $user->cartItems;
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        $subtotal = $user->cartTotal();
        $shipping = $subtotal > 1000 ? 0 : 50;
        $tax = $subtotal * 0.18;
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact('user', 'cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function store(Request $request)
    {
        // Handle checkout logic here
        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}