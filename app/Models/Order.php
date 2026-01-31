<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_method',
        'coupon_id',
        'coupon_code',
        'discount_amount',
    ];

    // Add relationship
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    // Add accessor for discounted total
    public function getDiscountedTotalAttribute(): float
    {
        return $this->total + $this->discount_amount;
    }

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate order number with timestamp and user ID
    public static function generateOrderNumber($userId = null)
    {
        // Format: ORD-YYMMDD-HHmmss-XXXX
        // Example: ORD-250126-153045-7891

        $date = now()->format('ymd');    // Year, Month, Date (yymmdd)
        $time = now()->format('His');    // Hour, Minute, Second (HHmmss)
        $random = mt_rand(1000, 9999);   // 4 random digits

        if ($userId) {
            // Include last 3 digits of user ID (padded to 3 digits)
            $userPart = str_pad($userId % 1000, 3, '0', STR_PAD_LEFT);
            return "ORD-{$date}-{$time}-{$userPart}{$random}";
        }

        // If no user ID provided (for guest orders or fallback)
        return "ORD-{$date}-{$time}-{$random}";
    }

    // Generate unique order number (prevents duplicates)
    public static function generateUniqueOrderNumber($userId = null)
    {
        do {
            $orderNumber = self::generateOrderNumber($userId);
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // Helper method to get order date in readable format
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M, Y');
    }

    // Helper method to get order time in readable format
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('h:i A');
    }

    // Helper method to get payment status badge color
    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info'
        ];

        return $badges[$this->payment_status] ?? 'secondary';
    }
}
