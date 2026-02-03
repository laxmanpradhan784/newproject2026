<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnPolicy extends Model
{
    use HasFactory;
    
    protected $table = 'return_policies';
    
    protected $fillable = [
        'name',
        'description',
        'return_window_days',
        'refund_methods',
        'restocking_fee_percentage',
        'return_shipping_paid_by',
        'conditions',
        'status',
        'created_by',
    ];
    
    protected $casts = [
        'refund_methods' => 'array',
        'conditions' => 'array',
        'restocking_fee_percentage' => 'decimal:2',
    ];
    
    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}