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

    // Add relationship to reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
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

    // Check if user has purchased this product
    public function hasUserPurchased($userId)
    {
        return OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereIn('status', ['delivered', 'completed']);
        })
            ->where('product_id', $this->id)
            ->exists();
    }

    // Get purchase date for user
    public function getPurchaseDate($userId)
    {
        $orderItem = OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereIn('status', ['delivered', 'completed']);
        })
            ->where('product_id', $this->id)
            ->first();

        return $orderItem ? $orderItem->created_at : null;
    }

    // Check if user has already reviewed this product
    public function hasUserReviewed($userId)
    {
        return $this->reviews()->where('user_id', $userId)->exists();
    }

    // Get user's review for this product
    public function getUserReview($userId)
    {
        return $this->reviews()->where('user_id', $userId)->first();
    }

    // Update product rating when new review is added
    public function updateRating()
    {
        $approvedReviews = $this->reviews()->where('status', 'approved');

        $avgRating = $approvedReviews->avg('rating');
        $reviewCount = $approvedReviews->count();

        $this->update([
            'rating' => $avgRating ?? 0,
            'review_count' => $reviewCount
        ]);
    }

    // In app/Models/Product.php
    public function isInWishlist()
    {
        if (!auth()->check()) {
            return false;
        }

        return \App\Models\Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->id)
            ->exists();
    }

    /**
     * Get all images for the product
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    /**
     * Get the primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', 1);
    }
}
