<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnReason extends Model
{
    use HasFactory;
    
    protected $table = 'return_reasons';
    
    protected $fillable = [
        'reason',
        'description',
        'requires_image',
        'requires_description',
        'refund_type',
        'priority',
        'status',
    ];
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('priority')->orderBy('reason');
    }
}