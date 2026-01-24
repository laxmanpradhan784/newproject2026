<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'description',
        'price',
        'stock',
        'status'
    ];

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Check if product is in user's cart
    public function inCart($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }

        if (!$userId) return false;

        return $this->carts()->where('user_id', $userId)->exists();
    }

    // Get cart quantity for current user
    public function cartQuantity($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }

        if (!$userId) return 0;

        $cart = $this->carts()->where('user_id', $userId)->first();

        return $cart ? $cart->quantity : 0;
    }
}