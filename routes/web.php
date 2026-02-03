<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserSide\HomeController;
use App\Http\Controllers\UserSide\ContactController;
use App\Http\Controllers\UserSide\ProductController;
use App\Http\Controllers\UserSide\UserController;
use App\Http\Controllers\UserSide\UserReviewController;
use App\Http\Controllers\UserSide\CheckoutController;
use App\Http\Controllers\UserSide\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AProductController;
use App\Http\Controllers\Admin\ASliderController;
use App\Http\Controllers\Admin\AContactController;
use App\Http\Controllers\Admin\AUserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;

/*
|--------------------------------------------------------------------------
| User Side Routes
|--------------------------------------------------------------------------
*/
// Wishlist Routes
// Individual wishlist routes
Route::get('wishlist/index', [\App\Http\Controllers\UserSide\WishlistController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/add', [\App\Http\Controllers\UserSide\WishlistController::class, 'store'])->name('wishlist.store');
Route::post('wishlist/toggle', [\App\Http\Controllers\UserSide\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::delete('wishlist/remove/{id}', [\App\Http\Controllers\UserSide\WishlistController::class, 'destroy'])->name('wishlist.destroy');
Route::delete('wishlist/remove-product/{productId}', [\App\Http\Controllers\UserSide\WishlistController::class, 'removeByProduct'])->name('wishlist.remove-by-product');
Route::get('wishlist/count', [\App\Http\Controllers\UserSide\WishlistController::class, 'count'])->name('wishlist.count');
Route::post('wishlist/clear', [\App\Http\Controllers\UserSide\WishlistController::class, 'clear'])->name('wishlist.clear');
Route::post('wishlist/move-to-cart/{id}', [\App\Http\Controllers\UserSide\WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

// Coupon Routes
Route::middleware(['web'])->group(function () {
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::get('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');

    // For modal coupons
    Route::get('/coupons/available', [CartController::class, 'getAvailableCoupons'])->name('coupons.available');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Product Routes
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('category.products');
Route::get('/products', [ProductController::class, 'allProducts'])->name('products');

// Cart Routes (Public)
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/increase/{product}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::post('/product/quick-add/{id}', [ProductController::class, 'quickAdd'])->name('product.quick-add');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google Authentication
Route::get('/auth/google', [AuthController::class, 'googleRedirect']);
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::post('/update', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::post('/avatar/update', [UserController::class, 'updateAvatar'])->name('profile.avatar.update');
        Route::delete('/avatar/remove', [UserController::class, 'removeAvatar'])->name('profile.avatar.remove');
        Route::post('/password/update', [UserController::class, 'updatePassword'])->name('profile.password.update');
        Route::post('/resend-verification', [UserController::class, 'resendVerificationEmail'])->name('verification.resend');
        Route::delete('/delete', [UserController::class, 'deleteAccount'])->name('profile.delete');
    });

    // Review Routes
    Route::prefix('reviews')->group(function () {
        Route::get('/create/{product}', [UserReviewController::class, 'create'])->name('reviews.create');
        Route::post('/', [UserReviewController::class, 'store'])->name('reviews.store');
        Route::get('/{review}/edit', [UserReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/{review}', [UserReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/{review}', [UserReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/my-reviews', [UserReviewController::class, 'myReviews'])->name('reviews.my');
        Route::post('/vote', [UserReviewController::class, 'vote'])->name('reviews.vote');
    });

    // Checkout & Orders Routes
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/guest', [CheckoutController::class, 'guest'])->name('checkout.guest');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [CheckoutController::class, 'orders'])->name('orders');
        Route::get('/{orderNumber}', [CheckoutController::class, 'show'])->name('order-details');
        Route::get('/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
    });

    // Payment Routes
    Route::prefix('payment')->group(function () {
        Route::get('/razorpay', [CheckoutController::class, 'razorpayPayment'])->name('payment.razorpay');
        Route::post('/razorpay/callback', [CheckoutController::class, 'razorpayCallback'])->name('checkout.razorpay.callback');
        Route::get('/failed', [CheckoutController::class, 'paymentFailed'])->name('payment.failed');
    });

    // Pages (for authenticated users)
    Route::get('/wishlist', function () {
        return view('wishlist');
    })->name('wishlist');

    Route::get('/deals', function () {
        return view('deals');
    })->name('deals');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/profile/change-password', [AdminController::class, 'changePassword'])->name('admin.profile.change-password');

    // Admin Management
    Route::get('/admins', [AdminController::class, 'allAdmins'])->name('admin.all-admins');

    // Site Settings
    Route::get('/site-settings', [SiteController::class, 'index'])->name('admin.site-settings');
    Route::put('/site-settings', [SiteController::class, 'update'])->name('admin.site.update');

    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/update', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
        Route::put('/{category}/status', [CategoryController::class, 'updateStatus'])->name('category.update-status');
    });

    // Products
    Route::prefix('products')->group(function () {
        Route::get('/', [AProductController::class, 'index'])->name('admin.products');
        Route::post('/store', [AProductController::class, 'store'])->name('admin.products.store');
        Route::put('/update', [AProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/delete/{id}', [AProductController::class, 'delete'])->name('admin.products.delete');
        Route::put('/{product}/status', [AProductController::class, 'updateStatus'])->name('product.update-status');
    });

    // Sliders
    Route::prefix('sliders')->group(function () {
        Route::get('/', [ASliderController::class, 'index'])->name('admin.sliders');
        Route::post('/store', [ASliderController::class, 'store'])->name('admin.sliders.store');
        Route::put('/update', [ASliderController::class, 'update'])->name('admin.sliders.update');
        Route::delete('/delete/{id}', [ASliderController::class, 'delete'])->name('admin.sliders.delete');
        Route::put('/{slider}/status', [ASliderController::class, 'updateStatus'])->name('slider.update-status');
    });

    // Contacts
    Route::prefix('contacts')->group(function () {
        Route::get('/', [AContactController::class, 'index'])->name('admin.contacts');
        Route::get('/delete/{id}', [AContactController::class, 'delete'])->name('admin.contacts.delete');
    });

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [AUserController::class, 'index'])->name('admin.users');
        Route::post('/update-role', [AUserController::class, 'updateRole'])->name('admin.users.update-role');
        Route::get('/delete/{id}', [AUserController::class, 'delete'])->name('admin.users.delete');
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders');
        Route::get('/{id}', [OrderController::class, 'show'])->name('admin.order.details');
        Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.order.status.update');
        Route::post('/{id}/notify', [OrderController::class, 'sendNotification'])->name('admin.order.notify');
        Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('admin.order.invoice');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::get('/{id}/export', [OrderController::class, 'export'])->name('admin.order.export');
    });

    // Reviews
    Route::prefix('reviews')->name('admin.reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [ReviewController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/response', [ReviewController::class, 'addResponse'])->name('add-response');
        Route::post('/bulk', [ReviewController::class, 'bulkAction'])->name('bulk');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});


use App\Http\Controllers\Admin\CouponController;

// Admin Routes Group
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Coupon Management Routes
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}', [CouponController::class, 'show'])->name('coupons.show');
    Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');

    // Additional coupon routes
    Route::get('/coupons/generate-code', [CouponController::class, 'generateCode'])->name('coupons.generate-code');
    Route::post('/coupons/{coupon}/status', [CouponController::class, 'updateStatus'])->name('coupons.status');
    Route::post('/coupons/update-expired', [CouponController::class, 'updateExpired'])->name('coupons.update-expired');
});
