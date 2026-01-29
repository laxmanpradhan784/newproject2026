<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'title',
        'comment',
        'status',
        'is_verified_purchase',
        'helpful_yes',
        'helpful_no',
        'report_count',
        'admin_response',
        'response_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'helpful_yes' => 'integer',
        'helpful_no' => 'integer',
        'report_count' => 'integer',
        'response_date' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add any hidden attributes if needed
    ];

    /**
     * Get the user that wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was reviewed.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order associated with the review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending reviews.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include reviews for a specific product.
     */
    public function scopeForProduct(Builder $query, $productId): Builder
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope a query to only include reviews by a specific user.
     */
    public function scopeByUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include reviews with a minimum rating.
     */
    public function scopeWithRating(Builder $query, $minRating): Builder
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope a query to only include verified purchases.
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Scope a query to only include recent reviews.
     */
    public function scopeRecent(Builder $query, $days = 30): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get the average rating for a product.
     */
    public static function averageRatingForProduct($productId): float
    {
        return (float) self::where('product_id', $productId)
            ->approved()
            ->avg('rating') ?? 0.0;
    }

    /**
     * Get the total number of reviews for a product.
     */
    public static function totalReviewsForProduct($productId): int
    {
        return self::where('product_id', $productId)
            ->approved()
            ->count();
    }

    /**
     * Get the rating distribution for a product.
     */
    public static function ratingDistributionForProduct($productId): array
    {
        $distribution = [
            5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0
        ];

        $reviews = self::where('product_id', $productId)
            ->approved()
            ->select('rating', \DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->get();

        foreach ($reviews as $review) {
            if (isset($distribution[$review->rating])) {
                $distribution[$review->rating] = $review->count;
            }
        }

        return $distribution;
    }

    /**
     * Calculate the percentage of helpful reviews.
     */
    public function helpfulPercentage(): float
    {
        $totalVotes = $this->helpful_yes + $this->helpful_no;
        
        if ($totalVotes === 0) {
            return 0.0;
        }

        return round(($this->helpful_yes / $totalVotes) * 100, 1);
    }

    /**
     * Mark review as helpful.
     */
    public function markAsHelpful(): self
    {
        $this->increment('helpful_yes');
        return $this;
    }

    /**
     * Mark review as not helpful.
     */
    public function markAsNotHelpful(): self
    {
        $this->increment('helpful_no');
        return $this;
    }

    /**
     * Report the review.
     */
    public function report(): self
    {
        $this->increment('report_count');
        return $this;
    }

    /**
     * Check if the review is verified.
     */
    public function isVerified(): bool
    {
        return $this->is_verified_purchase;
    }

    /**
     * Check if the review has admin response.
     */
    public function hasAdminResponse(): bool
    {
        return !empty($this->admin_response);
    }

    /**
     * Get the star rating as HTML.
     */
    public function getStarRatingHtml(): string
    {
        $html = '<div class="star-rating">';
        
        for ($i = 1; $i <= 5; $i++) {
            $class = $i <= $this->rating ? 'fas fa-star text-warning' : 'far fa-star text-light';
            $html .= '<i class="' . $class . '"></i>';
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeHtml(): string
    {
        $badgeClasses = [
            'pending' => 'badge-warning',
            'approved' => 'badge-success',
            'rejected' => 'badge-danger',
            'spam' => 'badge-secondary'
        ];

        $statusText = ucfirst($this->status);
        $badgeClass = $badgeClasses[$this->status] ?? 'badge-secondary';

        return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
    }

    /**
     * Get the formatted date.
     */
    public function getFormattedDate(): string
    {
        return $this->created_at->format('F j, Y');
    }

    /**
     * Get the time ago string.
     */
    public function getTimeAgo(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get the truncated comment.
     */
    public function getTruncatedComment($length = 150): string
    {
        if (strlen($this->comment) <= $length) {
            return $this->comment;
        }

        return substr($this->comment, 0, $length) . '...';
    }

    /**
     * Check if user can edit review.
     */
    public function canEdit($userId): bool
    {
        return $this->user_id === $userId && $this->status === 'pending';
    }

    /**
     * Check if user can delete review.
     */
    public function canDelete($userId, $isAdmin = false): bool
    {
        if ($isAdmin) {
            return true;
        }

        return $this->user_id === $userId && $this->status !== 'approved';
    }

    /**
     * Boot method for model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Update product rating when review is approved
        static::updated(function ($review) {
            if ($review->isDirty('status') && $review->status === 'approved') {
                $review->updateProductRating();
            }
        });

        // Update product rating when review is deleted
        static::deleted(function ($review) {
            if ($review->status === 'approved') {
                $review->product->updateRatingStats();
            }
        });
    }

    /**
     * Update product rating statistics.
     */
    public function updateProductRating(): void
    {
        $product = $this->product;
        if ($product) {
            $product->updateRatingStats();
        }
    }
}