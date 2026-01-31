<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'user_id',
        'order_id',
        'discount_amount',
        'original_total',
        'final_total',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'original_total' => 'decimal:2',
        'final_total' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    public $timestamps = false;

    // Relationships
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}