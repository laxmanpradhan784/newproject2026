<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnRequest extends Model
{
    use HasFactory;
    
    protected $table = 'returns';
    
    protected $fillable = [
        'return_number',
        'order_id',
        'order_item_id',
        'user_id',
        'product_id',
        'quantity',
        'return_type',
        'reason',
        'description',
        'status',
        'amount',
        'refund_amount',
        'refund_method',
        'refund_status',
        'pickup_address',
        'pickup_scheduled_date',
        'pickup_date',
        'admin_notes',
        'user_notes',
        'image1',
        'image2',
        'image3',
    ];
    
    protected $casts = [
        'pickup_scheduled_date' => 'date',
        'pickup_date' => 'date',
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($return) {
            $return->return_number = self::generateReturnNumber();
        });
    }
    
    public static function generateReturnNumber()
    {
        $date = date('Ymd');
        $lastReturn = self::where('return_number', 'LIKE', "RET-{$date}-%")
            ->orderBy('return_number', 'desc')
            ->first();
        
        if ($lastReturn) {
            $lastNumber = intval(substr($lastReturn->return_number, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }
        
        return "RET-{$date}-{$nextNumber}";
    }
    
    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function statusLogs()
    {
        return $this->hasMany(ReturnStatusLog::class, 'return_id');
    }
    
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['refunded', 'replaced', 'completed']);
    }
    
    // Accessors
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'pickup_scheduled' => 'primary',
            'picked_up' => 'success',
            'processing' => 'info',
            'refunded' => 'success',
            'replaced' => 'success',
            'completed' => 'success',
            'cancelled' => 'secondary',
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }
    
    public function getStatusTextAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }
    
    public function getDaysSinceCreatedAttribute()
    {
        return $this->created_at->diffInDays(now());
    }
    
    public function isEligibleForReturn()
    {
        $policy = ReturnPolicy::where('status', 'active')->first();
        if (!$policy) return false;
        
        // Check if within return window
        if ($this->days_since_created > $policy->return_window_days) {
            return false;
        }
        
        // Check order status
        if (!in_array($this->order->status, ['delivered', 'shipped'])) {
            return false;
        }
        
        return true;
    }
}