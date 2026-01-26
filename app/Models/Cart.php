<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'session_id',      // ADD THIS
        'guest_token',     // ADD THIS  
        'is_guest'         // ADD THIS
    ];

    protected $casts = [
        'is_guest' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calculate subtotal for single item
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    // ✅ NEW: Get current cart identifier (works for both guest and logged-in)
    public static function getCartIdentifier()
    {
        if (auth()->check()) {
            return [
                'user_id' => auth()->id(),
                'is_guest' => false
            ];
        } else {
            // Generate guest token if not exists
            if (!session()->has('guest_token')) {
                session(['guest_token' => Str::random(32)]);
            }
            
            return [
                'session_id' => session()->getId(),
                'guest_token' => session('guest_token'),
                'is_guest' => true
            ];
        }
    }

    // ✅ NEW: Get cart items for current session/user
    public static function getCartItems()
    {
        $identifier = self::getCartIdentifier();
        
        if (auth()->check()) {
            return self::with('product.category')
                ->where('user_id', auth()->id())
                ->where('is_guest', false)
                ->get();
        } else {
            return self::with('product.category')
                ->where(function($query) use ($identifier) {
                    $query->where('session_id', $identifier['session_id'])
                          ->orWhere('guest_token', $identifier['guest_token']);
                })
                ->where('is_guest', true)
                ->get();
        }
    }

    // ✅ NEW: Get cart count
    public static function getCartCount()
    {
        $items = self::getCartItems();
        return $items->sum('quantity');
    }

    // ✅ NEW: Check if cart item belongs to current user/session
    public function belongsToCurrentSession()
    {
        $identifier = self::getCartIdentifier();
        
        if (auth()->check()) {
            return $this->user_id == auth()->id() && !$this->is_guest;
        } else {
            return $this->is_guest && 
                   ($this->session_id == $identifier['session_id'] || 
                    $this->guest_token == $identifier['guest_token']);
        }
    }
    public static function getCartProductCount()
    {
        $identifier = self::getCartIdentifier();
        
        if (auth()->check()) {
            return self::where('user_id', auth()->id())
                ->where('is_guest', false)
                ->count();
        } else {
            return self::where(function($query) use ($identifier) {
                    $query->where('session_id', $identifier['session_id'])
                          ->orWhere('guest_token', $identifier['guest_token']);
                })
                ->where('is_guest', true)
                ->count();
        }
    }
}