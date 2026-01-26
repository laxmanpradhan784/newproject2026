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
        
        $orders = $query->paginate(20);
        
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
        
        $order->status = $request->status;
        
        if ($request->status == 'delivered') {
            $order->delivered_at = now();
        } elseif ($request->status == 'cancelled') {
            $order->cancelled_at = now();
            // Restore product stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }
        
        $order->save();
        
        return response()->json(['success' => true]);
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