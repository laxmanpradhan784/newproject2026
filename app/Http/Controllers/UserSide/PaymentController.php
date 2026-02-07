<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display user's payment history
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $payments = Payment::where('user_id', $user->id)
            ->with(['order' => function($query) {
                $query->select('id', 'order_number');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Summary statistics
        $summary = [
            'total_payments' => Payment::where('user_id', $user->id)->count(),
            'total_amount' => Payment::where('user_id', $user->id)->where('status', 'captured')->sum('amount'),
            'successful_payments' => Payment::where('user_id', $user->id)->where('status', 'captured')->count(),
            'failed_payments' => Payment::where('user_id', $user->id)->where('status', 'failed')->count(),
        ];
        
        return view('payments.index', compact('payments', 'summary'));
    }
    
    /**
     * Show payment details
     */
    public function show($id)
    {
        $payment = Payment::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['order.items', 'user'])
            ->firstOrFail();
            
        return view('payments.show', compact('payment'));
    }
}