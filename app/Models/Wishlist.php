<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';
    protected $fillable = ['user_id', 'product_id'];

    /**
     * Get the user that owns the wishlist item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that belongs to the wishlist item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if a product is in user's wishlist
     */
    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * Get wishlist items for a user with product details
     */
    public static function getUserWishlist($userId)
    {
        return self::with(['product.category'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }
}
