<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use App\Models\ReturnPolicy;
use App\Models\ReturnReason;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReturnController extends Controller
{
    // Display all return requests
    public function index(Request $request)
    {
        $query = ReturnRequest::with(['user', 'order', 'product'])
            ->latest();

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('return_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('order', function ($q) use ($search) {
                        $q->where('order_number', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Check if date_from has a valid value
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Check if date_to has a valid value
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $returns = $query->paginate(20);

        $stats = [
            'total' => ReturnRequest::count(),
            'pending' => ReturnRequest::where('status', 'pending')->count(),
            'approved' => ReturnRequest::where('status', 'approved')->count(),
            'processing' => ReturnRequest::whereIn('status', ['pickup_scheduled', 'picked_up', 'processing'])->count(),
            'completed' => ReturnRequest::whereIn('status', ['refunded', 'replaced', 'completed'])->count(),
            'rejected' => ReturnRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.returns.index', compact('returns', 'stats'));
    }

    // Show return request details
    public function show($id)
    {
        $return = ReturnRequest::with(['user', 'order', 'order.orderItems', 'product', 'statusLogs' => function ($query) {
            $query->with('admin')->latest();
        }])->findOrFail($id);

        $policy = ReturnPolicy::where('status', 'active')->first();

        return view('admin.returns.show', compact('return', 'policy'));
    }

    // Update return status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,pickup_scheduled,picked_up,processing,refunded,replaced,completed,cancelled',
            'notes' => 'nullable|string|max:500',
            'refund_amount' => 'nullable|numeric|min:0',
            'refund_method' => 'nullable|in:original,wallet,bank_transfer,credit_card',
            'pickup_date' => 'nullable|date|after:today',
        ]);

        $return = ReturnRequest::findOrFail($id);
        $oldStatus = $return->status;

        DB::beginTransaction();
        try {
            // Update return status
            $return->status = $request->status;

            // Update additional fields based on status
            if ($request->status == 'approved') {
                $return->refund_amount = $request->refund_amount ?? $return->amount;
                $return->refund_method = $request->refund_method ?? 'original';

                if ($request->has('pickup_date')) {
                    $return->pickup_scheduled_date = $request->pickup_date;
                    $return->status = 'pickup_scheduled';
                }
            }

            if ($request->status == 'refunded') {
                $return->refund_status = 'completed';
                $return->refunded_at = now();

                // Restock the product
                $this->restockProduct($return);
            }

            if ($request->status == 'rejected') {
                $return->admin_notes = $request->notes;
            }

            $return->save();

            // Log status change
            $return->statusLogs()->create([
                'from_status' => $oldStatus,
                'to_status' => $request->status,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Return status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    // Process refund
    public function processRefund(Request $request, $id)
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:0',
            'refund_method' => 'required|in:original,wallet,bank_transfer,credit_card',
            'transaction_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $return = ReturnRequest::findOrFail($id);

        if ($return->status != 'picked_up' && $return->status != 'approved') {
            return redirect()->back()
                ->with('error', 'Cannot process refund. Return not ready for refund.');
        }

        DB::beginTransaction();
        try {
            $return->refund_amount = $request->refund_amount;
            $return->refund_method = $request->refund_method;
            $return->refund_status = 'completed';
            $return->status = 'refunded';
            $return->refunded_at = now();

            if ($request->transaction_id) {
                $return->admin_notes = "Transaction ID: {$request->transaction_id}. " . ($return->admin_notes ?? '');
            }

            $return->save();

            // Log status
            $return->statusLogs()->create([
                'from_status' => $return->status,
                'to_status' => 'refunded',
                'notes' => "Refund processed via {$request->refund_method}. Amount: ₹{$request->refund_amount}. " . $request->notes,
                'created_by' => auth()->id(),
            ]);

            // Restock product
            $this->restockProduct($return);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Refund processed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }

    // Manage return policies
    public function policies()
    {
        $policies = ReturnPolicy::latest()->paginate(10);
        return view('admin.returns.policies', compact('policies'));
    }

    public function createPolicy()
    {
        return view('admin.returns.create-policy');
    }

    public function storePolicy(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'return_window_days' => 'required|integer|min:1|max:365',
            'restocking_fee_percentage' => 'required|numeric|min:0|max:100',
            'return_shipping_paid_by' => 'required|in:customer,seller',
            'status' => 'required|in:active,inactive',
        ]);

        ReturnPolicy::create([
            'name' => $request->name,
            'description' => $request->description,
            'return_window_days' => $request->return_window_days,
            'refund_methods' => json_encode($request->refund_methods ?? ['original', 'wallet']),
            'restocking_fee_percentage' => $request->restocking_fee_percentage,
            'return_shipping_paid_by' => $request->return_shipping_paid_by,
            'conditions' => json_encode([
                'items_must_be_unused' => $request->has('items_must_be_unused'),
                'original_packaging' => $request->has('original_packaging'),
                'tags_attached' => $request->has('tags_attached'),
                'invoice_required' => $request->has('invoice_required'),
            ]),
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.returns.policies')
            ->with('success', 'Return policy created successfully.');
    }

    public function editPolicy($id)
    {
        $policy = ReturnPolicy::findOrFail($id);
        return view('admin.returns.edit-policy', compact('policy'));
    }

    public function updatePolicy(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'return_window_days' => 'required|integer|min:1|max:365',
            'restocking_fee_percentage' => 'required|numeric|min:0|max:100',
            'return_shipping_paid_by' => 'required|in:customer,seller',
            'status' => 'required|in:active,inactive',
        ]);

        $policy = ReturnPolicy::findOrFail($id);

        $policy->update([
            'name' => $request->name,
            'description' => $request->description,
            'return_window_days' => $request->return_window_days,
            'refund_methods' => json_encode($request->refund_methods ?? ['original', 'wallet']),
            'restocking_fee_percentage' => $request->restocking_fee_percentage,
            'return_shipping_paid_by' => $request->return_shipping_paid_by,
            'conditions' => json_encode([
                'items_must_be_unused' => $request->has('items_must_be_unused'),
                'original_packaging' => $request->has('original_packaging'),
                'tags_attached' => $request->has('tags_attached'),
                'invoice_required' => $request->has('invoice_required'),
            ]),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.returns.policies')
            ->with('success', 'Return policy updated successfully.');
    }

    // Manage return reasons
    public function reasons()
    {
        $reasons = ReturnReason::orderBy('priority')->paginate(10);
        return view('admin.returns.reasons', compact('reasons'));
    }

    public function createReason()
    {
        return view('admin.returns.create-reason');
    }

    public function storeReason(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:return_reasons',
            'description' => 'nullable|string',
            'requires_image' => 'boolean',
            'requires_description' => 'boolean',
            'refund_type' => 'required|in:full,partial,none',
            'priority' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        ReturnReason::create([
            'reason' => $request->reason,
            'description' => $request->description,
            'requires_image' => $request->has('requires_image'),
            'requires_description' => $request->has('requires_description'),
            'refund_type' => $request->refund_type,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.returns.reasons')
            ->with('success', 'Return reason created successfully.');
    }

    public function editReason($id)
    {
        $reason = ReturnReason::findOrFail($id);
        return view('admin.returns.edit-reason', compact('reason'));
    }

    public function updateReason(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:return_reasons,reason,' . $id,
            'description' => 'nullable|string',
            'requires_image' => 'boolean',
            'requires_description' => 'boolean',
            'refund_type' => 'required|in:full,partial,none',
            'priority' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $reason = ReturnReason::findOrFail($id);
        $reason->update([
            'reason' => $request->reason,
            'description' => $request->description,
            'requires_image' => $request->has('requires_image'),
            'requires_description' => $request->has('requires_description'),
            'refund_type' => $request->refund_type,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.returns.reasons')
            ->with('success', 'Return reason updated successfully.');
    }

    public function updateReasonStatus(Request $request, $id)
    {
        $reason = ReturnReason::findOrFail($id);
        $reason->status = $request->status;
        $reason->save();

        return response()->json(['success' => true]);
    }

    // Reports and analytics
    public function reports()
    {
        $returns = ReturnRequest::selectRaw('
                DATE(created_at) as date,
                COUNT(*) as total_returns,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status IN ("refunded", "completed") THEN 1 ELSE 0 END) as completed,
                SUM(refund_amount) as total_refunds
            ')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topReasons = ReturnRequest::selectRaw('reason, COUNT(*) as count')
            ->groupBy('reason')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'total_returns' => ReturnRequest::count(),
            'total_refund_amount' => ReturnRequest::where('refund_status', 'completed')->sum('refund_amount'),
            'avg_processing_time' => $this->calculateAvgProcessingTime(),
            'approval_rate' => ReturnRequest::where('status', '!=', 'pending')->count() > 0
                ? round((ReturnRequest::where('status', 'approved')->count() / ReturnRequest::where('status', '!=', 'pending')->count()) * 100, 2)
                : 0,
        ];

        return view('admin.returns.reports', compact('returns', 'topReasons', 'stats'));
    }

    // Delete return request
    public function destroy($id)
    {
        $return = ReturnRequest::findOrFail($id);

        // Delete images if they exist
        foreach (['image1', 'image2', 'image3'] as $imageField) {
            if ($return->$imageField && Storage::exists('public/returns/' . basename($return->$imageField))) {
                Storage::delete('public/returns/' . basename($return->$imageField));
            }
        }

        $return->delete();

        return redirect()->route('admin.returns.index')
            ->with('success', 'Return request deleted successfully.');
    }

    // Private helper methods
    private function restockProduct($return)
    {
        $product = $return->product;
        $product->stock += $return->quantity;
        $product->save();

        // Here you would typically log inventory change
        // $product->inventoryLogs()->create([...]);
    }

    private function calculateAvgProcessingTime()
    {
        $completedReturns = ReturnRequest::where('status', 'refunded')
            ->whereNotNull('refunded_at')
            ->get();

        if ($completedReturns->isEmpty()) return 0;

        $totalDays = 0;
        foreach ($completedReturns as $return) {
            $totalDays += $return->created_at->diffInDays($return->refunded_at);
        }

        return round($totalDays / $completedReturns->count(), 1);
    }
}
