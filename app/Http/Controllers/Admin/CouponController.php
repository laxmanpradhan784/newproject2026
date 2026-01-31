<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $query = Coupon::query();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }
        
        $coupons = $query->withCount('usages')->latest()->paginate(20);
        
        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::where('status', 'active')->count(),
            'inactive' => Coupon::where('status', 'inactive')->count(),
            'expired' => Coupon::where('status', 'expired')->count(),
        ];
        
        return view('admin.coupons.index', compact('coupons', 'stats'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get(['id', 'name', 'email']);
        $categories = Category::where('status', 'active')->get(['id', 'name']);
        $products = Product::where('status', 'active')->get(['id', 'name']);
        
        return view('admin.coupons.create', compact('users', 'categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'user_scope' => 'required|in:all,specific',
            'category_scope' => 'required|in:all,specific',
            'product_scope' => 'required|in:all,specific',
            'status' => 'required|in:active,inactive,expired',
            'users' => 'required_if:user_scope,specific|array',
            'users.*' => 'exists:users,id',
            'categories' => 'required_if:category_scope,specific|array',
            'categories.*' => 'exists:categories,id',
            'products' => 'required_if:product_scope,specific|array',
            'products.*' => 'exists:products,id',
        ]);

        $coupon = Coupon::create($request->only([
            'code', 'name', 'description', 'discount_type', 'discount_value',
            'min_order_amount', 'max_discount_amount', 'start_date', 'end_date',
            'usage_limit', 'usage_limit_per_user', 'user_scope', 'category_scope',
            'product_scope', 'status'
        ]));

        // Attach specific users
        if ($request->user_scope === 'specific' && $request->filled('users')) {
            $coupon->users()->attach($request->users);
        }

        // Attach specific categories
        if ($request->category_scope === 'specific' && $request->filled('categories')) {
            $coupon->categories()->attach($request->categories);
        }

        // Attach specific products
        if ($request->product_scope === 'specific' && $request->filled('products')) {
            $coupon->products()->attach($request->products);
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['users', 'categories', 'products', 'usages.user', 'usages.order']);
        $usageStats = $coupon->usages()
            ->selectRaw('DATE(used_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
        
        return view('admin.coupons.show', compact('coupon', 'usageStats'));
    }

    public function edit(Coupon $coupon)
    {
        $users = User::where('role', 'user')->get(['id', 'name', 'email']);
        $categories = Category::where('status', 'active')->get(['id', 'name']);
        $products = Product::where('status', 'active')->get(['id', 'name']);
        
        $coupon->load(['users', 'categories', 'products']);
        
        return view('admin.coupons.edit', compact('coupon', 'users', 'categories', 'products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons')->ignore($coupon->id)
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'user_scope' => 'required|in:all,specific',
            'category_scope' => 'required|in:all,specific',
            'product_scope' => 'required|in:all,specific',
            'status' => 'required|in:active,inactive,expired',
            'users' => 'required_if:user_scope,specific|array',
            'users.*' => 'exists:users,id',
            'categories' => 'required_if:category_scope,specific|array',
            'categories.*' => 'exists:categories,id',
            'products' => 'required_if:product_scope,specific|array',
            'products.*' => 'exists:products,id',
        ]);

        $coupon->update($request->only([
            'code', 'name', 'description', 'discount_type', 'discount_value',
            'min_order_amount', 'max_discount_amount', 'start_date', 'end_date',
            'usage_limit', 'usage_limit_per_user', 'user_scope', 'category_scope',
            'product_scope', 'status'
        ]));

        // Sync specific users
        if ($request->user_scope === 'specific') {
            $coupon->users()->sync($request->users ?? []);
        } else {
            $coupon->users()->detach();
        }

        // Sync specific categories
        if ($request->category_scope === 'specific') {
            $coupon->categories()->sync($request->categories ?? []);
        } else {
            $coupon->categories()->detach();
        }

        // Sync specific products
        if ($request->product_scope === 'specific') {
            $coupon->products()->sync($request->products ?? []);
        } else {
            $coupon->products()->detach();
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        // Check if coupon has been used
        if ($coupon->usages()->exists()) {
            return redirect()->route('admin.coupons.index')
                ->with('error', 'Cannot delete coupon that has been used.');
        }

        $coupon->delete();
        
        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    public function generateCode(Request $request)
    {
        $prefix = strtoupper($request->prefix ?? 'COUPON');
        $code = $prefix . '_' . strtoupper(Str::random(8));
        
        // Ensure uniqueness
        while (Coupon::where('code', $code)->exists()) {
            $code = $prefix . '_' . strtoupper(Str::random(8));
        }
        
        return response()->json(['code' => $code]);
    }

    public function updateStatus(Coupon $coupon, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,expired'
        ]);
        
        $coupon->update(['status' => $request->status]);
        
        return response()->json([
            'success' => true,
            'message' => 'Coupon status updated.'
        ]);
    }

    public function updateExpired()
    {
        $updated = $this->couponService->updateExpiredCoupons();
        
        return response()->json([
            'success' => true,
            'updated' => $updated,
            'message' => 'Expired coupons updated successfully.'
        ]);
    }
}