<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use App\Mail\OrderPlacedAdminMail;
use App\Mail\OrderPlacedUserMail;
use App\Services\RazorpayService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $razorpayService;

    public function __construct()
    {
        $this->razorpayService = new RazorpayService();
    }

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

        // Get applied coupon from session
        $appliedCoupon = session('applied_coupon');
        $discountAmount = session('cart_discount', 0);

        // Apply discount if coupon is valid
        $discountedSubtotal = $subtotal;
        if ($appliedCoupon && $discountAmount > 0) {
            // Re-validate coupon before checkout
            $cartController = new CartController();
            $validation = $cartController->validateCoupon(
                $appliedCoupon['code'],
                $user->id,
                $subtotal
            );

            if (!$validation['valid']) {
                // Remove invalid coupon
                session()->forget(['applied_coupon', 'applied_coupon_code', 'cart_discount']);
                $discountAmount = 0;
            } else {
                // Recalculate discount to ensure it's correct
                $discountAmount = $cartController->calculateDiscount($validation['coupon'], $subtotal);
                session(['cart_discount' => $discountAmount]);
                $discountedSubtotal = $subtotal - $discountAmount;
            }
        }

        $shipping = $discountedSubtotal > 1000 ? 0 : 50;
        $tax = $discountedSubtotal * 0.18;
        $total = $discountedSubtotal + $shipping + $tax;

        // Get available coupons for modal
        $cartController = new CartController();
        $availableCoupons = $cartController->getAvailableCoupons();

        return view('checkout', compact(
            'user',
            'cartItems',
            'subtotal',
            'discountedSubtotal',
            'discountAmount',
            'shipping',
            'tax',
            'total',
            'availableCoupons'
        ));
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

        // Validate request - add 'razorpay' to payment_method options
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
            'payment_method' => 'required|in:cod,card,upi,razorpay',
            'shipping_method' => 'required|in:standard,express',
        ]);

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Get coupon details from session
        $appliedCoupon = session('applied_coupon');
        $discountAmount = session('cart_discount', 0);
        $couponCode = session('applied_coupon_code');
        $couponId = session('applied_coupon.id') ?? null;

        // Apply discount
        $discountedSubtotal = $subtotal;
        if ($appliedCoupon && $discountAmount > 0) {
            $discountedSubtotal = $subtotal - $discountAmount;
        }

        $shipping = $request->shipping_method == 'express' ? 150 : ($discountedSubtotal > 1000 ? 0 : 50);
        $tax = $discountedSubtotal * 0.18;
        $total = $discountedSubtotal + $shipping + $tax;

        // If payment method is Razorpay, return JSON response for frontend
        if ($request->payment_method === 'razorpay') {
            return $this->handleRazorpayPayment($request, $user, $cartItems, [
                'subtotal' => $subtotal,
                'discountedSubtotal' => $discountedSubtotal,
                'discountAmount' => $discountAmount,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'couponId' => $couponId,
                'couponCode' => $couponCode,
                'appliedCoupon' => $appliedCoupon,
            ]);
        }

        // For COD, Card, UPI - use existing logic
        return $this->processNonRazorpayOrder($request, $user, $cartItems, [
            'subtotal' => $subtotal,
            'discountedSubtotal' => $discountedSubtotal,
            'discountAmount' => $discountAmount,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'couponId' => $couponId,
            'couponCode' => $couponCode,
            'appliedCoupon' => $appliedCoupon,
        ]);
    }

    /**
     * Handle Razorpay Payment - Create order and return Razorpay data
     */
    private function handleRazorpayPayment($request, $user, $cartItems, $totals)
    {
        try {
            // Create order record in database with pending status
            $orderNumber = Order::generateUniqueOrderNumber($user->id);

            $orderData = [
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
                'status' => 'pending',
                'payment_method' => 'razorpay',
                'payment_status' => 'pending',
                'shipping_name' => $request->first_name . ' ' . $request->last_name,
                'shipping_email' => $request->email,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_state' => $request->state,
                'shipping_zip' => $request->zip_code,
                'shipping_country' => $request->country,
                'shipping_method' => $request->shipping_method,
            ];

            // Add coupon details if applied
            if ($totals['appliedCoupon'] && $totals['couponId']) {
                $orderData['coupon_id'] = $totals['couponId'];
                $orderData['coupon_code'] = $totals['couponCode'];
                $orderData['discount_amount'] = $totals['discountAmount'];
            }

            $order = Order::create($orderData);

            // Create Razorpay order
            $razorpayOrder = $this->razorpayService->createOrder(
                $totals['total'],
                $orderNumber,
                [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'customer_name' => $request->first_name . ' ' . $request->last_name,
                    'customer_email' => $request->email,
                    'customer_phone' => $request->phone,
                ]
            );

            // Update order with Razorpay order ID
            $order->update([
                'razorpay_order_id' => $razorpayOrder->id,
            ]);

            // Store order ID in session for verification
            session(['pending_razorpay_order' => $order->id]);

            // Return Razorpay checkout data to frontend
            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $totals['total'] * 100, // In paise
                'currency' => 'INR',
                'key' => config('razorpay.key'),
                'name' => config('app.name', 'E-Shop'),
                'description' => 'Order #' . $orderNumber,
                'prefill' => [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'contact' => $request->phone,
                ],
                'order_id' => $order->id,
                'callback_url' => route('razorpay.callback'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Razorpay order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process non-Razorpay orders (COD, Card, UPI)
     */
    private function processNonRazorpayOrder($request, $user, $cartItems, $totals)
    {
        try {
            $orderNumber = Order::generateUniqueOrderNumber($user->id);

            $orderData = [
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
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
            ];

            if ($totals['appliedCoupon'] && $totals['couponId']) {
                $orderData['coupon_id'] = $totals['couponId'];
                $orderData['coupon_code'] = $totals['couponCode'];
                $orderData['discount_amount'] = $totals['discountAmount'];
            }

            $order = Order::create($orderData);

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

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Record coupon usage
            if ($totals['appliedCoupon'] && $totals['couponId']) {
                CouponUsage::create([
                    'coupon_id' => $totals['couponId'],
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_amount' => $totals['discountAmount'],
                    'original_total' => $totals['subtotal'],
                    'final_total' => $totals['total'],
                ]);
            }

            // Send emails
            try {
                Mail::to(config('mail.from.address'))
                    ->send(new OrderPlacedAdminMail($order));

                Mail::to($order->shipping_email)
                    ->send(new OrderPlacedUserMail($order));
            } catch (\Exception $e) {
                \Log::error('Order email sending failed: ' . $e->getMessage());
            }

            // Clear cart and coupon session
            Cart::where('user_id', $user->id)->delete();
            session()->forget(['applied_coupon', 'applied_coupon_code', 'cart_discount']);

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error placing order: ' . $e->getMessage());
        }
    }

    /**
     * Razorpay Payment Callback/Verification
     */
    public function razorpayCallback(Request $request)
    {
        try {
            $paymentId = $request->razorpay_payment_id;
            $orderId = $request->razorpay_order_id;
            $signature = $request->razorpay_signature;
            $orderIdFromSession = session('pending_razorpay_order');

            if (!$orderIdFromSession) {
                return redirect()->route('checkout')->with('error', 'Session expired. Please try again.');
            }

            // Fetch the order
            $order = Order::findOrFail($orderIdFromSession);

            // Verify payment signature
            $isValid = $this->razorpayService->verifySignature($orderId, $paymentId, $signature);

            if (!$isValid) {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);

                // Save failed payment record
                $this->savePaymentRecord($order, [
                    'razorpay_payment_id' => $paymentId,
                    'status' => 'failed',
                    'error_description' => 'Payment signature verification failed'
                ]);

                session()->forget('pending_razorpay_order');
                return redirect()->route('checkout')->with('error', 'Payment verification failed!');
            }

            // Get payment details from Razorpay
            $razorpayPayment = $this->razorpayService->getPaymentDetails($paymentId);

            // Update order with payment details
            $order->update([
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'payment_status' => 'paid',
                'status' => 'processing',
                'transaction_id' => $paymentId,
            ]);

            // SAVE PAYMENT TO PAYMENTS TABLE
            $this->savePaymentRecord($order, [
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $orderId,
                'razorpay_signature' => $signature,
                'status' => 'captured',
                'payment_method' => $razorpayPayment->method ?? null,
                'bank' => $razorpayPayment->bank ?? null,
                'card_type' => $razorpayPayment->card_type ?? null,
                'wallet' => $razorpayPayment->wallet ?? null,
                'vpa' => $razorpayPayment->vpa ?? null,
                'gateway_response' => json_encode($razorpayPayment),
            ]);

            // Get user and cart items
            $user = Auth::user();
            $cartItems = Cart::where('user_id', $user->id)
                ->where('is_guest', false)
                ->with('product.category')
                ->get();

            // Create order items from cart
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

                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Record coupon usage if applied
            $appliedCoupon = session('applied_coupon');
            if ($appliedCoupon && isset($appliedCoupon['id'])) {
                CouponUsage::create([
                    'coupon_id' => $appliedCoupon['id'],
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_amount' => session('cart_discount', 0),
                    'original_total' => $order->subtotal,
                    'final_total' => $order->total,
                ]);
            }

            // Send emails
            try {
                Mail::to(config('mail.from.address'))
                    ->send(new OrderPlacedAdminMail($order));

                Mail::to($order->shipping_email)
                    ->send(new OrderPlacedUserMail($order));
            } catch (\Exception $e) {
                \Log::error('Order email sending failed: ' . $e->getMessage());
            }

            // Clear cart and session
            Cart::where('user_id', $user->id)->delete();
            session()->forget([
                'pending_razorpay_order',
                'applied_coupon',
                'applied_coupon_code',
                'cart_discount'
            ]);

            return redirect()->route('order.confirmation', $order->order_number)
                ->with('success', 'Payment successful! Order placed successfully.');
        } catch (\Exception $e) {
            \Log::error('Razorpay callback error: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Razorpay Payment Failed/Cancelled
     */
    public function razorpayFailed()
    {
        $orderId = session('pending_razorpay_order');

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);

                // Save failed payment record
                $this->savePaymentRecord($order, [
                    'status' => 'failed',
                    'error_description' => 'Payment cancelled by user'
                ]);
            }
            session()->forget('pending_razorpay_order');
        }

        return redirect()->route('checkout')
            ->with('error', 'Payment was cancelled or failed. Please try again.');
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

    /**
     * Show order confirmation page (one-time view with auto-redirect)
     */
    public function confirmation($orderNumber)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view order confirmation.');
        }

        // Find the order
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        // Check if user has already viewed this confirmation
        $viewedKey = 'viewed_order_' . $orderNumber;

        if (session()->has($viewedKey)) {
            // Already viewed, redirect immediately to orders page
            return redirect()->route('orders')->with('info', 'You can view your order details in your orders page.');
        }

        // Mark this confirmation as viewed (store in session)
        session([$viewedKey => true]);

        // Also store the timestamp for reference
        session(['order_confirmation_time_' . $orderNumber => now()]);

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

    /**
     * Save Payment Record to Payments Table
     */
    private function savePaymentRecord($order, $paymentData)
    {
        try {
            Payment::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'razorpay_order_id' => $paymentData['razorpay_order_id'] ?? $order->razorpay_order_id,
                'razorpay_payment_id' => $paymentData['razorpay_payment_id'] ?? null,
                'razorpay_signature' => $paymentData['razorpay_signature'] ?? null,
                'amount' => $order->total,
                'currency' => 'INR',
                'payment_method' => $paymentData['payment_method'] ?? null,
                'payment_gateway' => 'razorpay',
                'bank' => $paymentData['bank'] ?? null,
                'card_type' => $paymentData['card_type'] ?? null,
                'wallet' => $paymentData['wallet'] ?? null,
                'vpa' => $paymentData['vpa'] ?? null,
                'status' => $paymentData['status'] ?? 'created',
                'gateway_response' => $paymentData['gateway_response'] ?? null,
                'error_code' => $paymentData['error_code'] ?? null,
                'error_description' => $paymentData['error_description'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to save payment record: ' . $e->getMessage());
        }
    }

    /**
     * Clear order confirmation session (optional)
     */
    public function clearConfirmationSession(Request $request)
    {
        // Clear all order confirmation sessions
        $sessionKeys = array_keys(session()->all());

        foreach ($sessionKeys as $key) {
            if (str_starts_with($key, 'viewed_order_') || str_starts_with($key, 'order_confirmation_time_')) {
                session()->forget($key);
            }
        }

        return response()->json(['success' => true]);
    }
}
