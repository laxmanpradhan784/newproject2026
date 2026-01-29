<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserSide\HomeController;
use App\Http\Controllers\UserSide\ContactController;
use App\Http\Controllers\UserSide\ProductController;
use App\Http\Controllers\UserSide\UserController;

Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [UserController::class, 'profile'])->name('profile');
    Route::post('/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/avatar/update', [UserController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/avatar/remove', [UserController::class, 'removeAvatar'])->name('profile.avatar.remove');
    Route::post('/password/update', [UserController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/resend-verification', [UserController::class, 'resendVerificationEmail'])->name('verification.resend');
    Route::delete('/delete', [UserController::class, 'deleteAccount'])->name('profile.delete');
});



Route::get('/search', [ProductController::class, 'search'])->name('product.search');

// Product details
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


// Show products by category slug
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('category.products');

// Optional: Show all products
Route::get('/products', [ProductController::class, 'allProducts'])->name('products');



Route::get('/auth/google', [AuthController::class, 'googleRedirect']);
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);



/*
|--------------------------------------------------------------------------
| User Side Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');


// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/about', function () {
    return view('about');
})->name('about');




// Cart Page
Route::get('/cart', function () {
    return view('cart');
})->name('cart');


// Orders Page
Route::get('/orders', function () {
    return view('orders');
})->name('orders');

// Wishlist Page
Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

// Deals Page (if you create one)
Route::get('/deals', function () {
    return view('deals');
})->name('deals');



// Quick add to cart (AJAX)
Route::post('/product/quick-add/{id}', [ProductController::class, 'quickAdd'])->name('product.quick-add');


// routes/web.php

use App\Http\Controllers\UserSide\CheckoutController;
use App\Http\Controllers\UserSide\CartController;

// Cart Routes (PUBLIC - No auth middleware needed)
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/increase/{product}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])->name('cart.decrease');

// Payment Routes
Route::middleware(['auth'])->group(function () {
    // Razorpay Routes
    Route::get('/payment/razorpay', [CheckoutController::class, 'razorpayPayment'])->name('payment.razorpay');
    Route::post('/payment/razorpay/callback', [CheckoutController::class, 'razorpayCallback'])->name('checkout.razorpay.callback');
    Route::get('/payment/failed', [CheckoutController::class, 'paymentFailed'])->name('payment.failed');

    // Existing routes...
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('orders');
    Route::get('/orders/{orderNumber}', [CheckoutController::class, 'show'])->name('order-details');
    Route::get('/checkout/guest', [CheckoutController::class, 'guest'])
    ->name('checkout.guest');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});



use App\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('profile/change-password', [AdminController::class, 'changePassword'])->name('admin.profile.change-password');
    Route::get('admins', [AdminController::class, 'allAdmins'])->name('admin.all-admins');
});


// routes/web.php
use App\Http\Controllers\Admin\SiteController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('site-settings', [SiteController::class, 'index'])->name('admin.site-settings');
    Route::put('site-settings', [SiteController::class, 'update'])->name('admin.site.update');
});


use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('categories/update', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
    Route::put('/categories/{category}/status', [CategoryController::class, 'updateStatus'])
        ->name('category.update-status');
});

use App\Http\Controllers\Admin\aProductController;

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('products', [AProductController::class, 'index'])->name('admin.products');
    Route::post('products/store', [AProductController::class, 'store'])->name('admin.products.store');
    Route::put('products/update', [AProductController::class, 'update'])->name('admin.products.update');
    Route::delete('products/delete/{id}', [AProductController::class, 'delete'])->name('admin.products.delete');
    Route::put('/products/{product}/status', [AProductController::class, 'updateStatus'])
        ->name('product.update-status');
});

use App\Http\Controllers\Admin\ASliderController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('sliders', [ASliderController::class, 'index'])->name('admin.sliders');
    Route::post('sliders/store', [ASliderController::class, 'store'])->name('admin.sliders.store');
    Route::put('sliders/update', [ASliderController::class, 'update'])->name('admin.sliders.update');
    Route::put('/sliders/{slider}/status', [ASliderController::class, 'updateStatus'])
        ->name('slider.update-status');

    // Change this to DELETE method
    Route::delete('sliders/delete/{id}', [ASliderController::class, 'delete'])->name('admin.sliders.delete');
});


use App\Http\Controllers\Admin\AContactController;


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('contacts', [AContactController::class, 'index'])->name('admin.contacts');
    Route::get('contacts/delete/{id}', [AContactController::class, 'delete'])->name('admin.contacts.delete');
});

use App\Http\Controllers\Admin\AUserController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('users', [AUserController::class, 'index'])->name('admin.users');
    Route::post('users/update-role', [AUserController::class, 'updateRole'])->name('admin.users.update-role');
    Route::get('users/delete/{id}', [AUserController::class, 'delete'])->name('admin.users.delete');
});

use App\Http\Controllers\Admin\OrderController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.details');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('order.status.update');
    Route::post('/orders/{id}/notify', [OrderController::class, 'sendNotification'])->name('order.notify');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');
    // In web.php or admin routes
Route::get('/admin/orders/{id}/export', [OrderController::class, 'export'])
    ->name('order.export');
});

use App\Http\Controllers\Admin\ReviewController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ... existing admin routes ...
    
    // Admin Review Routes
    Route::prefix('reviews')->name('admin.reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [ReviewController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/response', [ReviewController::class, 'addResponse'])->name('add-response');
        Route::post('/bulk', [ReviewController::class, 'bulkAction'])->name('bulk');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});
