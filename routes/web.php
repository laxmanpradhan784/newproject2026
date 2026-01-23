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






/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


use App\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/all-admins', [AdminController::class, 'allAdmins'])->name('all_admins'); // optional
});


