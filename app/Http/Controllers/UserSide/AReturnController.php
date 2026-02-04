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

        return view('returns.index', compact('returns', 'returnPolicy'));
    }

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

        // Get user's return statistics
        $returns = ReturnRequest::where('user_id', auth()->id())
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending')
            ->selectRaw('COUNT(CASE WHEN status = "approved" THEN 1 END) as approved')
            ->selectRaw('COUNT(CASE WHEN status = "processing" THEN 1 END) as processing')
            ->first();

        return view('returns.create', compact('order', 'returnReasons', 'returnPolicy', 'returns'));
    }

    // Store new return request
    public function store(Request $request, $orderId)
    {
        try {
            $order = Order::with(['order_items'])
                ->where('user_id', auth()->id())
                ->where('id', $orderId)
                ->firstOrFail();

            // Check if order can be returned
            if (!$order->canBeReturned()) {
                return redirect()->route('orders')
                    ->with('error', 'This order is not eligible for returns.');
            }

            // Validate
            $request->validate([
                'order_item_id' => 'required|exists:order_items,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'return_type' => 'required|in:refund,replacement,store_credit',
                'reason' => 'required|string',
                'description' => 'required|string|min:10|max:1000',
                'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'terms' => 'required|accepted',
            ]);

            // Check if item belongs to order
            $orderItem = $order->order_items()
                ->where('id', $request->order_item_id)
                ->where('product_id', $request->product_id)
                ->firstOrFail();

            // Check quantity
            if ($request->quantity > $orderItem->quantity) {
                return redirect()->back()
                    ->with('error', 'Return quantity cannot exceed ordered quantity.')
                    ->withInput();
            }

            // Check if item already has pending/approved return
            $existingReturn = ReturnRequest::where('order_item_id', $orderItem->id)
                ->whereIn('status', ['pending', 'approved', 'processing'])
                ->first();

            if ($existingReturn) {
                return redirect()->back()
                    ->with('error', 'This item already has an active return request.')
                    ->withInput();
            }

            DB::beginTransaction();

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
            $return->return_number = $this->generateReturnNumber();

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
                'updated_at' => now(),
            ]);

            DB::commit();

            // Send notification (optional)
            // $this->sendReturnConfirmation($return);

            return redirect()->route('returns.show', $return->id)
                ->with('success', 'Return request submitted successfully! We will review it within 24-48 hours. Return ID: ' . $return->return_number);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('orders')
                ->with('error', 'Order or item not found.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Return store error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to submit return request. Please try again.')
                ->withInput();
        }
    }

    // Show return details
    public function show($id)
    {
        try {
            $return = ReturnRequest::with(['order', 'product', 'statusLogs' => function ($query) {
                $query->latest();
            }])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

            $policy = ReturnPolicy::where('status', 'active')->first();

            return view('returns.show', compact('return', 'policy'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('returns.index')
                ->with('error', 'Return request not found or you do not have permission to view it.');
        }
    }

    // Cancel return request
    public function cancel($id)
    {
        try {
            $return = ReturnRequest::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->findOrFail($id);

            DB::beginTransaction();

            $return->status = 'cancelled';
            $return->cancelled_at = now();
            $return->save();

            // Log status change
            DB::table('return_status_logs')->insert([
                'return_id' => $return->id,
                'from_status' => 'pending',
                'to_status' => 'cancelled',
                'notes' => 'Cancelled by customer',
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('returns.index')
                ->with('success', 'Return request cancelled successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('returns.index')
                ->with('error', 'Return request not found or cannot be cancelled.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Return cancel error: ' . $e->getMessage());
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
            $policy->conditions = 'Items must be in original condition with all tags attached.';
            $policy->refund_process = 'Refunds are processed within 5-7 business days after we receive and inspect the returned item.';
        }

        return view('returns.policy', compact('policy'));
    }

    // Check if order is eligible for return
    public function checkEligibility($orderId)
    {
        try {
            $order = Order::with(['order_items.product'])
                ->where('user_id', auth()->id())
                ->findOrFail($orderId);

            $returnPolicy = ReturnPolicy::where('status', 'active')->first();
            $returnWindow = $returnPolicy ? $returnPolicy->return_window_days : 30;

            $eligible = $order->canBeReturned();
            $remainingDays = 0;

            if ($eligible) {
                $returnDeadline = $order->created_at->addDays($returnWindow);
                $remainingDays = max(0, now()->diffInDays($returnDeadline, false));
            }

            return response()->json([
                'success' => true,
                'eligible' => $eligible,
                'remaining_days' => $remainingDays,
                'return_window' => $returnWindow,
                'items' => $order->order_items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'total' => $item->total,
                        'can_return' => $item->product->is_returnable ?? true,
                    ];
                }),
                'order_status' => $order->status,
                'order_date' => $order->created_at->format('Y-m-d'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to check eligibility. Order not found.',
            ], 404);
        }
    }

    /**
     * Generate unique return number
     */
    private function generateReturnNumber()
    {
        do {
            $date = now()->format('ymd');    // Year, Month, Date
            $time = now()->format('His');    // Hour, Minute, Second
            $random = mt_rand(1000, 9999);   // 4 random digits
            $returnNumber = "RET-{$date}-{$time}-{$random}";
        } while (ReturnRequest::where('return_number', $returnNumber)->exists());

        return $returnNumber;
    }
}
