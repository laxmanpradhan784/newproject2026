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

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function allReviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Update rating statistics for the product.
     */
    public function updateRatingStats(): void
    {
        $approvedReviews = $this->reviews()->approved();

        $this->rating = (float) $approvedReviews->avg('rating') ?? 0.0;
        $this->review_count = $approvedReviews->count();
        $this->save();
    }

    /**
     * Get the average rating attribute.
     */
    public function getAverageRatingAttribute(): float
    {
        return (float) $this->reviews()->avg('rating') ?? 0.0;
    }

    /**
     * Get the total reviews count attribute.
     */
    public function getTotalReviewsAttribute(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Get the rating distribution.
     */
    public function getRatingDistributionAttribute(): array
    {
        return Review::ratingDistributionForProduct($this->id);
    }
}
