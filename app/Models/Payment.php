<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'user_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount',
        'currency',
        'payment_method',
        'payment_gateway',
        'bank',
        'card_type',
        'wallet',
        'vpa',
        'status',
        'gateway_response',
        'error_code',
        'error_description',
        'refund_amount',
        'refund_id',
        'refund_status',
        'refunded_at',
        'payment_type' // Add this: 'online' or 'offline'
    ];

    protected $casts = [
        'gateway_response' => 'array',
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
    ];

    // Add these scopes
    public function scopeOnline($query)
    {
        return $query->where('payment_type', 'online')->orWhereNotNull('razorpay_payment_id');
    }

    public function scopeOffline($query)
    {
        return $query->where('payment_type', 'offline')->orWhere('payment_method', 'cod');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}