<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnStatusLog extends Model
{
    protected $table = 'return_status_logs';
    
    protected $fillable = [
        'return_id',
        'from_status',
        'to_status',
        'notes',
        'created_by',
    ];
    
    // Relationships
    public function return()
    {
        return $this->belongsTo(ReturnRequest::class, 'return_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}