<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_limit_per_user',
        'user_scope',
        'category_scope',
        'product_scope',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
    ];

    // Relationships
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_users');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'coupon_categories');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'coupon_products');
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere('end_date', '<', now());
    }

    // Accessors
    public function getUsedCountAttribute(): int
    {
        return $this->usages()->count();
    }

    public function getUsagePercentageAttribute(): float
    {
        if (!$this->usage_limit) {
            return 0;
        }
        return min(100, ($this->used_count / $this->usage_limit) * 100);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->end_date < now() || $this->status === 'expired';
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }

    // Methods
    public function canBeUsedBy(User $user): bool
    {
        if ($this->user_scope === 'specific') {
            return $this->users()->where('user_id', $user->id)->exists();
        }
        return true;
    }

    public function isValidForCart(array $cartItems): bool
    {
        $cartTotal = collect($cartItems)->sum('total');
        
        if ($cartTotal < $this->min_order_amount) {
            return false;
        }

        if ($this->category_scope === 'specific') {
            $cartCategoryIds = collect($cartItems)->pluck('category_id')->unique();
            $validCategories = $this->categories()->pluck('category_id');
            return $cartCategoryIds->intersect($validCategories)->isNotEmpty();
        }

        if ($this->product_scope === 'specific') {
            $cartProductIds = collect($cartItems)->pluck('product_id')->unique();
            $validProducts = $this->products()->pluck('product_id');
            return $cartProductIds->intersect($validProducts)->isNotEmpty();
        }

        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($amount * $this->discount_value) / 100;
            if ($this->max_discount_amount) {
                return min($discount, $this->max_discount_amount);
            }
            return $discount;
        }

        return min($this->discount_value, $amount);
    }

    public function markAsExpired(): void
    {
        if ($this->status !== 'expired') {
            $this->update(['status' => 'expired']);
        }
    }
}