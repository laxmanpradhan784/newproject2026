<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReturnPolicy;
use App\Models\ReturnReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AReturnController extends Controller
{
    // Display user's return requests
    public function index(Request $request)
    {
        $returns = ReturnRequest::with(['order', 'product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        $returnPolicy = ReturnPolicy::where('status', 'active')->first();
        
        return view('user.returns.index', compact('returns', 'returnPolicy'));
    }
    
    // Show create return form
    public function create($orderId)
    {
        $order = Order::with('order_items.product')
            ->where('user_id', auth()->id())
            ->where('id', $orderId)
            ->firstOrFail();
            
        // Check if order can be returned
        if (!$order->canBeReturned()) {
            return redirect()->route('orders')
                ->with('error', 'This order is not eligible for returns.');
        }
        
        $returnReasons = ReturnReason::active()->ordered()->get();
        $returnPolicy = ReturnPolicy::where('status', 'active')->first();
        
        return view('user.returns.create', compact('order', 'returnReasons', 'returnPolicy'));
    }
    
    // Store new return request
    public function store(Request $request, $orderId)
    {
        $order = Order::with('order_items')
            ->where('user_id', auth()->id())
            ->where('id', $orderId)
            ->firstOrFail();
            
        // Validate
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'return_type' => 'required|in:refund,replacement,store_credit',
            'reason' => 'required|string',
            'description' => 'required|string|min:10|max:1000',
            'image1' => 'nullable|image|max:2048',
            'image2' => 'nullable|image|max:2048',
            'image3' => 'nullable|image|max:2048',
        ]);
        
        // Check if item belongs to order
        $orderItem = $order->order_items()
            ->where('id', $request->order_item_id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();
            
        // Check quantity
        if ($request->quantity > $orderItem->quantity) {
            return redirect()->back()
                ->with('error', 'Return quantity cannot exceed ordered quantity.');
        }
        
        DB::beginTransaction();
        try {
            // Create return request
            $return = new ReturnRequest();
            $return->order_id = $order->id;
            $return->order_item_id = $orderItem->id;
            $return->user_id = auth()->id();
            $return->product_id = $request->product_id;
            $return->quantity = $request->quantity;
            $return->return_type = $request->return_type;
            $return->reason = $request->reason;
            $return->description = $request->description;
            $return->amount = $orderItem->total;
            $return->status = 'pending';
            
            // Handle image uploads
            if ($request->hasFile('image1')) {
                $return->image1 = $request->file('image1')->store('returns', 'public');
            }
            if ($request->hasFile('image2')) {
                $return->image2 = $request->file('image2')->store('returns', 'public');
            }
            if ($request->hasFile('image3')) {
                $return->image3 = $request->file('image3')->store('returns', 'public');
            }
            
            $return->save();
            
            // Create initial status log
            DB::table('return_status_logs')->insert([
                'return_id' => $return->id,
                'from_status' => null,
                'to_status' => 'pending',
                'notes' => 'Return request submitted by customer',
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
            
            DB::commit();
            
            // Send notification (optional)
            // $this->sendReturnConfirmation($return);
            
            return redirect()->route('user.returns.show', $return->id)
                ->with('success', 'Return request submitted successfully! We will review it within 24-48 hours.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to submit return request: ' . $e->getMessage());
        }
    }
    
    // Show return details
    public function show($id)
    {
        $return = ReturnRequest::with(['order', 'product', 'statusLogs' => function($query) {
            $query->latest();
        }])
        ->where('user_id', auth()->id())
        ->findOrFail($id);
        
        $policy = ReturnPolicy::where('status', 'active')->first();
        
        return view('user.returns.show', compact('return', 'policy'));
    }
    
    // Cancel return request
    public function cancel($id)
    {
        $return = ReturnRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);
            
        DB::beginTransaction();
        try {
            $return->status = 'cancelled';
            $return->save();
            
            // Log status change
            DB::table('return_status_logs')->insert([
                'return_id' => $return->id,
                'from_status' => 'pending',
                'to_status' => 'cancelled',
                'notes' => 'Cancelled by customer',
                'created_by' => auth()->id(),
                'created_at' => now(),
            ]);
            
            DB::commit();
            
            return redirect()->route('user.returns.index')
                ->with('success', 'Return request cancelled successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to cancel return request.');
        }
    }
    
    // Get return policy page
    public function policy()
    {
        $policy = ReturnPolicy::where('status', 'active')->first();
        
        if (!$policy) {
            $policy = new ReturnPolicy();
            $policy->name = 'Default Return Policy';
            $policy->description = 'Please contact customer support for return policy details.';
            $policy->return_window_days = 30;
        }
        
        return view('user.returns.policy', compact('policy'));
    }
    
    // Check if order is eligible for return
    public function checkEligibility($orderId)
    {
        $order = Order::with('order_items.product')
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);
            
        return response()->json([
            'eligible' => $order->canBeReturned(),
            'items' => $order->order_items->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ];
            }),
            'return_window' => 30, // Default window
        ]);
    }
}