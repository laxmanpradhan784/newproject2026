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

use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('dashboard', [DashboardController::class,'index'])->name('admin.dashboard');
});



use App\Http\Controllers\Admin\AdminController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/all-admins', [AdminController::class, 'allAdmins'])->name('all_admins'); // optional
});


use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
});

use App\Http\Controllers\Admin\aProductController;

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::get('products', [AProductController::class,'index'])->name('admin.products');
    Route::post('products/store', [AProductController::class,'store'])->name('admin.products.store');
    Route::post('products/update', [AProductController::class,'update'])->name('admin.products.update');
    Route::get('products/delete/{id}', [AProductController::class,'delete'])->name('admin.products.delete');
});

use App\Http\Controllers\Admin\ASliderController;

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::get('sliders', [ASliderController::class,'index'])->name('admin.sliders');
    Route::post('sliders/store', [ASliderController::class,'store'])->name('admin.sliders.store');
    Route::post('sliders/update', [ASliderController::class,'update'])->name('admin.sliders.update');
    Route::get('sliders/delete/{id}', [ASliderController::class,'delete'])->name('admin.sliders.delete');
});


use App\Http\Controllers\Admin\AContactController;


Route::prefix('admin')->middleware('auth')->group(function(){
    Route::get('contacts', [AContactController::class,'index'])->name('admin.contacts');
    Route::get('contacts/delete/{id}', [AContactController::class,'delete'])->name('admin.contacts.delete');
});

use App\Http\Controllers\Admin\AUserController;

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::get('users', [AUserController::class,'index'])->name('admin.users');
    Route::get('users/delete/{id}', [AUserController::class,'delete'])->name('admin.users.delete');
});







