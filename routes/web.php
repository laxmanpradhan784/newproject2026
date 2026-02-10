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
use App\Http\Controllers\UserSide\WishlistController;
use App\Http\Controllers\UserSide\AReturnController;
use App\Http\Controllers\UserSide\PaymentController;

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
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\APaymentController;
use App\Http\Controllers\Admin\ProductImageController;

/*
|--------------------------------------------------------------------------
| User Side Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Product Routes
Route::get('/search', [ProductController::class, 'search'])->name('product.search');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('category.products');
Route::get('/products', [ProductController::class, 'allProducts'])->name('products');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/increase/{product}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::post('/product/quick-add/{id}', [ProductController::class, 'quickAdd'])->name('product.quick-add');

// Coupon Routes
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
Route::get('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');
Route::get('/coupons/available', [CartController::class, 'getAvailableCoupons'])->name('coupons.available');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/google', [AuthController::class, 'googleRedirect'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

// Return Request Routes
Route::prefix('returns')->name('returns.')->group(function () {
    Route::get('/', [AReturnController::class, 'index'])->name('index');
    Route::get('/policy', [AReturnController::class, 'policy'])->name('policy');
    Route::get('/create/{order}', [AReturnController::class, 'create'])->name('create');
    Route::post('/store/{order}', [AReturnController::class, 'store'])->name('store');
    Route::get('/{id}', [AReturnController::class, 'show'])->where('id', '[0-9]+')->name('show');
    Route::post('/{id}/cancel', [AReturnController::class, 'cancel'])->where('id', '[0-9]+')->name('cancel');
    Route::get('/check-eligibility/{order}', [AReturnController::class, 'checkEligibility'])->name('check-eligibility');
});

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

    // Checkout Routes
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/guest', [CheckoutController::class, 'guest'])->name('checkout.guest');
    });

    // Order Routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [CheckoutController::class, 'orders'])->name('orders');
        Route::get('/{orderNumber}', [CheckoutController::class, 'show'])->name('order-details');
        Route::get('/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
        Route::post('/confirmation/clear-session', [CheckoutController::class, 'clearConfirmationSession'])->name('order.confirmation.clear');
    });

    // Payment Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
    });

    // Razorpay Payment Routes
    Route::post('/checkout/razorpay', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/razorpay/callback', [CheckoutController::class, 'razorpayCallback'])->name('razorpay.callback');
    Route::get('/razorpay/failed', [CheckoutController::class, 'razorpayFailed'])->name('razorpay.failed');

    // Wishlist Routes
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::get('/count', [WishlistController::class, 'count'])->name('count');
        Route::get('/summary', [WishlistController::class, 'summary'])->name('summary');
        Route::post('/store', [WishlistController::class, 'store'])->name('store');
        Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
        Route::post('/clear', [WishlistController::class, 'clear'])->name('clear');
        Route::post('/move-all-to-cart', [WishlistController::class, 'moveAllToCart'])->name('move-all-to-cart');
        Route::post('/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
        Route::delete('/{id}', [WishlistController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AdminController::class, 'changePassword'])->name('profile.change-password');

    // Admin Management
    Route::get('/admins', [AdminController::class, 'allAdmins'])->name('all-admins');

    // Site Settings
    Route::get('/site-settings', [SiteController::class, 'index'])->name('site-settings');
    Route::put('/site-settings', [SiteController::class, 'update'])->name('site.update');

    // Categories Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::put('/{category}/status', [CategoryController::class, 'updateStatus'])->name('category.update-status');
    });

    // Products Management
    Route::prefix('products')->group(function () {
        Route::get('/', [AProductController::class, 'index'])->name('products');
        Route::post('/store', [AProductController::class, 'store'])->name('products.store');
        Route::put('/update', [AProductController::class, 'update'])->name('products.update');
        Route::delete('/delete/{id}', [AProductController::class, 'delete'])->name('products.delete');
        Route::put('/{product}/status', [AProductController::class, 'updateStatus'])->name('product.update-status');
    });

    // Product Images Management
    Route::prefix('product-images')->group(function () {
        Route::get('/manager', [ProductImageController::class, 'manager'])->name('product.image.manager');
        Route::post('/store', [ProductImageController::class, 'store'])->name('product.images.store');
        Route::post('/{image}/delete', [ProductImageController::class, 'destroy'])->name('product.images.delete');
    });

    // Sliders Management
    Route::prefix('sliders')->group(function () {
        Route::get('/', [ASliderController::class, 'index'])->name('sliders');
        Route::post('/store', [ASliderController::class, 'store'])->name('sliders.store');
        Route::put('/update', [ASliderController::class, 'update'])->name('sliders.update');
        Route::delete('/delete/{id}', [ASliderController::class, 'delete'])->name('sliders.delete');
        Route::put('/{slider}/status', [ASliderController::class, 'updateStatus'])->name('slider.update-status');
    });

    // Contacts Management
    Route::prefix('contacts')->group(function () {
        Route::get('/', [AContactController::class, 'index'])->name('contacts');
        Route::get('/delete/{id}', [AContactController::class, 'delete'])->name('contacts.delete');
    });

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [AUserController::class, 'index'])->name('users');
        Route::post('/update-role', [AUserController::class, 'updateRole'])->name('users.update-role');
        Route::get('/delete/{id}', [AUserController::class, 'delete'])->name('users.delete');
    });

    // Orders Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders');
        Route::get('/{id}', [OrderController::class, 'show'])->name('order.details');
        Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('order.status.update');
        Route::post('/{id}/notify', [OrderController::class, 'sendNotification'])->name('order.notify');
        Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/{id}/export', [OrderController::class, 'export'])->name('order.export');
    });

    // Reviews Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [ReviewController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/response', [ReviewController::class, 'addResponse'])->name('add-response');
        Route::post('/bulk', [ReviewController::class, 'bulkAction'])->name('bulk');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // Coupons Management
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupon}', [CouponController::class, 'show'])->name('show');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{coupon}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('destroy');
        Route::get('/generate-code', [CouponController::class, 'generateCode'])->name('generate-code');
        Route::post('/{coupon}/status', [CouponController::class, 'updateStatus'])->name('status');
        Route::post('/update-expired', [CouponController::class, 'updateExpired'])->name('update-expired');
    });

    // Returns Management
    Route::prefix('returns')->name('returns.')->group(function () {
        Route::get('/', [ReturnController::class, 'index'])->name('index');
        Route::get('/{id}', [ReturnController::class, 'show'])->name('show');
        Route::put('/{id}/status', [ReturnController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/refund', [ReturnController::class, 'processRefund'])->name('process-refund');
        Route::delete('/{id}', [ReturnController::class, 'destroy'])->name('destroy');
        Route::get('/policies', [ReturnController::class, 'policies'])->name('policies');
        Route::get('/policies/create', [ReturnController::class, 'createPolicy'])->name('policies.create');
        Route::post('/policies', [ReturnController::class, 'storePolicy'])->name('policies.store');
        Route::get('/policies/{id}/edit', [ReturnController::class, 'editPolicy'])->name('policies.edit');
        Route::put('/policies/{id}', [ReturnController::class, 'updatePolicy'])->name('policies.update');
        Route::get('/reasons', [ReturnController::class, 'reasons'])->name('reasons');
        Route::get('/reasons/create', [ReturnController::class, 'createReason'])->name('reasons.create');
        Route::post('/reasons', [ReturnController::class, 'storeReason'])->name('reasons.store');
        Route::get('/reasons/{id}/edit', [ReturnController::class, 'editReason'])->name('reasons.edit');
        Route::put('/reasons/{id}', [ReturnController::class, 'updateReason'])->name('reasons.update');
        Route::post('/reasons/{id}/status', [ReturnController::class, 'updateReasonStatus'])->name('reasons.status');
        Route::get('/reports', [ReturnController::class, 'reports'])->name('reports');
    });

    // Payments Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [APaymentController::class, 'index'])->name('index');
        Route::get('/dashboard', [APaymentController::class, 'dashboard'])->name('dashboard');
        Route::get('/summary', [APaymentController::class, 'summary'])->name('summary');
        Route::get('/{payment}', [APaymentController::class, 'show'])->name('show');
        Route::get('/customer/{user}/profile', [APaymentController::class, 'customerProfile'])->name('customer.profile');
        Route::post('/{payment}/refund', [APaymentController::class, 'processRefund'])->name('refund');
        Route::post('/{id}/mark-cod-paid', [APaymentController::class, 'markCODPaid'])->name('payments.mark-cod-paid');
        Route::delete('/{payment}', [APaymentController::class, 'destroy'])->name('destroy');
        Route::get('/export', [APaymentController::class, 'export'])->name('export');
    });
});