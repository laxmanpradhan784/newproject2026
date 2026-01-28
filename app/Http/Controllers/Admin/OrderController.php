<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items')->latest();

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;

            $query->where(function ($q) use ($searchTerm) {
                // Search by order number
                $q->where('order_number', 'LIKE', "%{$searchTerm}%")
                    // Search by payment method
                    ->orWhere('payment_method', 'LIKE', "%{$searchTerm}%")
                    // Search by user name (through relationship)
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
                    })
                    // Search by shipping name/email/phone
                    ->orWhere('shipping_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('shipping_email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('shipping_phone', 'LIKE', "%{$searchTerm}%")
                    // Search by date (format: YYYY-MM-DD)
                    ->orWhereDate('created_at', 'LIKE', "%{$searchTerm}%");
            });
        }

        $orders = $query->paginate(20);

        // Add search parameter to pagination links
        if ($request->has('search')) {
            $orders->appends(['search' => $request->search]);
        }

        // Stats
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');

        return view('admin.orders', compact('orders', 'totalOrders', 'todayOrders', 'pendingOrders', 'totalRevenue'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.order-details', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;

        if ($request->status == 'delivered') {
            $order->delivered_at = now();
            // Reset cancelled_at if previously cancelled
            $order->cancelled_at = null;

            // Notify user about delivery
            $this->sendOrderStatusNotification($order, 'delivered');
        } elseif ($request->status == 'cancelled') {
            $order->cancelled_at = now();
            // Reset delivered_at if previously delivered
            $order->delivered_at = null;

            // Restore product stock only if coming from non-cancelled status
            if ($oldStatus != 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            // Notify user about cancellation
            $this->sendOrderStatusNotification($order, 'cancelled');
        } elseif ($request->status == 'shipped') {
            // Notify user about shipping
            $this->sendOrderStatusNotification($order, 'shipped');
        } elseif ($request->status == 'processing') {
            // Notify user about processing
            $this->sendOrderStatusNotification($order, 'processing');
        }

        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    private function sendOrderStatusNotification($order, $status)
    {
        // Send email notification to user
        if ($order->shipping_email) {
            // You can implement email sending here
            // Mail::to($order->shipping_email)->send(new OrderStatusUpdated($order, $status));

            // For now, just log it
            \Log::info("Order #{$order->order_number} status changed to {$status}. Email sent to: {$order->shipping_email}");
        }
    }

    public function sendNotification(Request $request, $id)
    {
        // Send email notification logic here
        return response()->json(['success' => true]);
    }

    public function invoice($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);

        // Return PDF or view
        return view('admin.invoice', compact('order'));
    }
}
