<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Collection;

class CouponService
{
    public function validate(Coupon $coupon, User $user, Collection $cartItems): array
    {
        $cartTotal = $cartItems->sum('total');
        
        // Check basic validity
        if (!$coupon->is_active) {
            return ['valid' => false, 'message' => 'Coupon is not active.'];
        }
        
        if ($coupon->is_expired) {
            return ['valid' => false, 'message' => 'Coupon has expired.'];
        }
        
        if ($cartTotal < $coupon->min_order_amount) {
            $minAmount = number_format($coupon->min_order_amount, 2);
            return ['valid' => false, 'message' => "Minimum order amount is ₹{$minAmount}."];
        }
        
        // Check user scope
        if (!$coupon->canBeUsedBy($user)) {
            return ['valid' => false, 'message' => 'Coupon not available for this user.'];
        }
        
        // Check category/product scope
        if (!$coupon->isValidForCart($cartItems->toArray())) {
            return ['valid' => false, 'message' => 'Coupon not valid for selected items.'];
        }
        
        // Check usage limits
        $userUsage = $coupon->usages()->where('user_id', $user->id)->count();
        if ($userUsage >= $coupon->usage_limit_per_user) {
            return ['valid' => false, 'message' => 'You have already used this coupon.'];
        }
        
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return ['valid' => false, 'message' => 'Coupon usage limit reached.'];
        }
        
        // Calculate discount
        $discount = $coupon->calculateDiscount($cartTotal);
        
        return [
            'valid' => true,
            'coupon' => $coupon,
            'discount' => $discount,
            'message' => 'Coupon applied successfully.',
        ];
    }
    
    public function apply(Coupon $coupon, User $user, float $cartTotal): float
    {
        return $coupon->calculateDiscount($cartTotal);
    }
    
    public function recordUsage(Coupon $coupon, User $user, $orderId, float $originalTotal, float $discount): void
    {
        $coupon->usages()->create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'discount_amount' => $discount,
            'original_total' => $originalTotal,
            'final_total' => $originalTotal - $discount,
            'used_at' => now(),
        ]);
    }
    
    public function updateExpiredCoupons(): int
    {
        $expired = Coupon::where('end_date', '<', now())
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);
            
        return $expired;
    }
}