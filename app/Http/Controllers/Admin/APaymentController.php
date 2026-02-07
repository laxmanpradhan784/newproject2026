<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class APaymentController extends Controller
{
    /**
     * Display all payments with filters
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order', 'user']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                  ->orWhereHas('order', function($q) use ($search) {
                      $q->where('order_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get filter options
        $paymentMethods = Payment::distinct()->pluck('payment_method')->filter();
        $statuses = Payment::distinct()->pluck('status')->filter();

        // Get statistics
        $stats = $this->getPaymentStatistics();

        return view('admin.payments.index', compact('payments', 'paymentMethods', 'statuses', 'stats'));
    }

    /**
     * Show payment details
     */
    public function show($id)
    {
        $payment = Payment::with(['order.items.product', 'user'])->findOrFail($id);
        
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Get payment statistics
     */
    private function getPaymentStatistics()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'today' => [
                'count' => Payment::whereDate('created_at', $today)->count(),
                'amount' => Payment::whereDate('created_at', $today)->where('status', 'captured')->sum('amount'),
            ],
            'yesterday' => [
                'count' => Payment::whereDate('created_at', $yesterday)->count(),
                'amount' => Payment::whereDate('created_at', $yesterday)->where('status', 'captured')->sum('amount'),
            ],
            'this_month' => [
                'count' => Payment::whereDate('created_at', '>=', $thisMonth)->count(),
                'amount' => Payment::whereDate('created_at', '>=', $thisMonth)->where('status', 'captured')->sum('amount'),
            ],
            'all_time' => [
                'count' => Payment::count(),
                'amount' => Payment::where('status', 'captured')->sum('amount'),
            ],
            'status_counts' => DB::table('payments')
                ->select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status'),
            'method_counts' => DB::table('payments')
                ->select('payment_method', DB::raw('COUNT(*) as count'))
                ->whereNotNull('payment_method')
                ->groupBy('payment_method')
                ->get()
                ->pluck('count', 'payment_method'),
        ];
    }

    /**
     * Process refund
     */
    public function processRefund(Request $request, $id)
    {
        $request->validate([
            'refund_amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $payment = Payment::with(['order'])->findOrFail($id);

        // Check if payment is eligible for refund
        if ($payment->status !== 'captured') {
            return back()->with('error', 'Only captured payments can be refunded.');
        }

        if ($payment->refund_amount && $payment->refund_amount >= $payment->amount) {
            return back()->with('error', 'Payment already fully refunded.');
        }

        if ($request->refund_amount > $payment->amount - ($payment->refund_amount ?? 0)) {
            return back()->with('error', 'Refund amount cannot exceed remaining amount.');
        }

        try {
            // Here you would integrate with Razorpay refund API
            // For now, we'll just update the database
            
            $refundId = 'REF_' . strtoupper(uniqid());
            
            $payment->update([
                'refund_amount' => ($payment->refund_amount ?? 0) + $request->refund_amount,
                'refund_id' => $refundId,
                'refund_status' => 'processed',
                'refunded_at' => now(),
                'status' => $request->refund_amount == $payment->amount ? 'refunded' : 'partially_refunded',
            ]);

            // Update order status if needed
            if ($payment->order) {
                if ($request->refund_amount == $payment->amount) {
                    $payment->order->update([
                        'payment_status' => 'refunded',
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ]);
                }
            }

            // Log refund action
            activity()
                ->causedBy(auth()->user())
                ->performedOn($payment)
                ->withProperties([
                    'refund_amount' => $request->refund_amount,
                    'reason' => $request->reason,
                    'refund_id' => $refundId,
                ])
                ->log('processed_refund');

            return back()->with('success', 'Refund processed successfully. Refund ID: ' . $refundId);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }

    /**
     * Export payments to CSV
     */
    public function export(Request $request)
    {
        $payments = Payment::with(['order', 'user'])
            ->when($request->filled('date_from'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payments_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Order Number',
                'Customer Name',
                'Customer Email',
                'Amount',
                'Currency',
                'Payment Method',
                'Status',
                'Razorpay Payment ID',
                'Date',
                'Bank',
                'Card Type',
                'Wallet',
                'UPI ID',
                'Refund Amount',
                'Refund Status'
            ]);

            // Add data rows
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->order ? $payment->order->order_number : 'N/A',
                    $payment->user ? $payment->user->name : 'N/A',
                    $payment->user ? $payment->user->email : 'N/A',
                    $payment->amount,
                    $payment->currency,
                    $payment->payment_method ?? 'N/A',
                    $payment->status,
                    $payment->razorpay_payment_id,
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->bank ?? 'N/A',
                    $payment->card_type ?? 'N/A',
                    $payment->wallet ?? 'N/A',
                    $payment->vpa ?? 'N/A',
                    $payment->refund_amount ?? '0',
                    $payment->refund_status ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show dashboard with payment analytics
     */
    public function dashboard()
    {
        // Daily payment data for chart (last 30 days)
        $dailyData = Payment::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as amount')
            )
            ->where('status', 'captured')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Payment methods distribution
        $methodDistribution = Payment::select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as amount')
            )
            ->whereNotNull('payment_method')
            ->where('status', 'captured')
            ->groupBy('payment_method')
            ->get();

        // Recent payments
        $recentPayments = Payment::with(['order', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $stats = $this->getPaymentStatistics();

        return view('admin.payments.dashboard', compact(
            'dailyData', 
            'methodDistribution', 
            'recentPayments', 
            'stats'
        ));
    }

    /**
     * Delete payment (only if failed/not captured)
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        // Only allow deletion of failed payments
        if ($payment->status === 'captured') {
            return back()->with('error', 'Cannot delete successful payments.');
        }

        $payment->delete();

        return back()->with('success', 'Payment record deleted successfully.');
    }

    /**
     * Get payment summary for dashboard widget
     */
    public function summary()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $data = [
            'today' => [
                'count' => Payment::whereDate('created_at', $today)->count(),
                'amount' => Payment::whereDate('created_at', $today)->where('status', 'captured')->sum('amount'),
            ],
            'yesterday' => [
                'count' => Payment::whereDate('created_at', $yesterday)->count(),
                'amount' => Payment::whereDate('created_at', $yesterday)->where('status', 'captured')->sum('amount'),
            ],
            'month' => [
                'count' => Payment::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count(),
                'amount' => Payment::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status', 'captured')->sum('amount'),
            ],
        ];

        return response()->json($data);
    }
}